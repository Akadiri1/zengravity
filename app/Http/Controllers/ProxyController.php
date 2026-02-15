<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Cookie;

class ProxyController extends Controller
{
    public function browse(Request $request)
    {
        $url = $request->query('url');

        if (!$url) return response('URL is required', 400);
        if (!filter_var($url, FILTER_VALIDATE_URL)) return response('Invalid URL', 400);

        try {
            $method = $request->method();
            $data = $request->all();
            unset($data['url']); // Remove the wrapper param

            // 1. FILTER COOKIES: Remove Laravel/Local cookies to prevent session pollution
            $cookieHeader = $request->header('Cookie');
            $filteredCookies = '';
            if ($cookieHeader) {
                $cookies = explode(';', $cookieHeader);
                $kept = [];
                foreach ($cookies as $c) {
                    $c = trim($c);
                    // Filter out Laravel specific cookies
                    if (!str_starts_with($c, 'laravel_session') && !str_starts_with($c, 'XSRF-TOKEN')) {
                        $kept[] = $c;
                    }
                }
                $filteredCookies = implode('; ', $kept);
            }

            // 2. FORWARD REQUEST: Increased timeouts to prevent cURL error 28
            $response = Http::withOptions([
                'verify' => false, // Bypass SSL for local dev
                'timeout' => 60,   // Increased total request time
                'connect_timeout' => 30, // Increased connection handshake time
            ])
            ->withHeaders([
                'User-Agent' => $request->header('User-Agent'),
                'Cookie' => $filteredCookies, 
                'Accept' => $request->header('Accept'),
                'Referer' => $url, // Spoof referer for internal navigation
            ])->send($method, $url, [
                'form_params' => $method === 'POST' ? $data : [],
                'allow_redirects' => false 
            ]);

            // DIAGNOSTICS: Log status and redirects
            Log::info("Proxy: $method $url -> " . $response->status());

            // 3. HANDLE REDIRECTS (3xx)
            if ($response->status() >= 300 && $response->status() < 400) {
                $location = $response->header('Location');
                
                // Convert relative paths from the portal into full URLs
                $resolvedLocation = $this->resolveUrl($url, $location);
                
                // Redirect the browser back to our proxy route with the new target URL
                $redirect = redirect()->to(route('proxy', ['url' => $resolvedLocation]));
                
                // Pass along all cookies sent during the redirect (Moodle often sets session here)
                foreach ($response->headers() as $name => $values) {
                    if (strtolower($name) === 'set-cookie') {
                        foreach ($values as $cookie) {
                            $this->addCookieToResponse($redirect, $cookie);
                        }
                    }
                }
                return $redirect;
            }

            $content = $response->body();
            $contentType = $response->header('Content-Type');

            // 4. REWRITE HTML CONTENT
            if (str_contains($contentType, 'text/html')) {
                $rootUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
                $content = $this->rewriteHtml($content, $rootUrl);
            }

            // 5. BUILD FINAL RESPONSE
            $proxyResponse = response($content)
                ->header('Content-Type', $contentType)
                ->header('X-Frame-Options', 'ALLOWALL')
                ->header('Content-Security-Policy', '')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');

            // Attach cookies to the final response
            foreach ($response->headers() as $name => $values) {
                if (strtolower($name) === 'set-cookie') {
                    foreach ($values as $cookie) {
                        $this->addCookieToResponse($proxyResponse, $cookie);
                    }
                }
            }

            return $proxyResponse;

        } catch (\Exception $e) {
            Log::error('Proxy Exception: ' . $e->getMessage());
            return response('Proxy Error: ' . $e->getMessage(), 500);
        }
    }

    public function fallback(Request $request)
    {
        $referer = $request->header('Referer');
        $rootUrl = 'https://elearn.nou.edu.ng'; // Default fallback
        
        if ($referer && str_contains($referer, 'url=')) {
            $parts = parse_url($referer);
            parse_str($parts['query'] ?? '', $query);
            if (!empty($query['url'])) {
                $rootUrl = parse_url($query['url'], PHP_URL_SCHEME) . '://' . parse_url($query['url'], PHP_URL_HOST);
            }
        }

        $path = $request->path();
        $targetUrl = $rootUrl . '/' . $path;
        
        return redirect()->route('proxy', ['url' => $targetUrl]);
    }

    private function resolveUrl($base, $rel) {
        if (filter_var($rel, FILTER_VALIDATE_URL)) return $rel;

        $parts = parse_url($base);
        $basePath = $parts['path'] ?? '/';
        
        // Handle absolute paths (e.g. /login/index.php)
        if (str_starts_with($rel, '/')) {
            $path = $rel;
        } 
        // Handle relative paths (e.g. index.php)
        else {
            // SPECIAL CASE: If base path looks like a directory but has no trailing slash (e.g. /login),
            // and we are appending a relative path, treat base as directory.
            // Most servers do a 301 to add the slash first, but some (like Moodle) might just send content or relative redirect.
            if (!str_ends_with($basePath, '/') && !pathinfo($basePath, PATHINFO_EXTENSION)) {
                $basePath .= '/';
            }

            // Remove filename from base path if it doesn't end in slash (standard behavior)
            if (!str_ends_with($basePath, '/')) {
                $basePath = dirname($basePath);
            }
            
            // Normalize slashes
            $basePath = rtrim($basePath, '/');
            $path = $basePath . '/' . $rel;
        }

        // Build final URL
        $scheme = $parts['scheme'] ?? 'http';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        
        $resolved = $scheme . '://' . $host . $port . $path;
        
        Log::info("Proxy: Resolved Redirect [Base: $base] [Rel: $rel] -> $resolved");
        
        return $resolved;
    }

    private function addCookieToResponse($response, $rawCookie) {
        try {
            // Log the raw cookie for debugging
            Log::info("Proxy: Processing upstream cookie: " . $rawCookie);

            // Manual simpler parsing to avoid Symfony strictness
            $parts = explode(';', $rawCookie);
            $kv = explode('=', $parts[0], 2);
            
            if (count($kv) !== 2) return;
            
            $name = trim($kv[0]);
            $value = trim($kv[1]); // Do not urldecode, Moodle might expect raw
            
            // Check for explicit expiry
            $expire = 0;
            foreach($parts as $part) {
                $part = trim($part);
                if (stripos($part, 'expires=') === 0) {
                    $dateStr = substr($part, 8);
                    $expire = strtotime($dateStr);
                }
            }

            // Create cookie with OUR constraints (Force root path, no domain, non-secure for localhost)
            $newCookie = new Cookie(
                $name,
                $value,
                $expire,
                '/',     // Force Root Path
                null,    // Force Localhost Domain
                false,   // Force Non-Secure (HTTP)
                true,    // HttpOnly (Safe default)
                false,   // Raw (Keep encoding as received?) - Let's try false first
                'Lax'    // SameSite
            );

            $response->headers->setCookie($newCookie);
            Log::info("Proxy: Set-Cookie attached: {$name}={$value}");

        } catch (\Exception $e) {
            Log::error('Cookie Parse Error: ' . $e->getMessage());
        }
    }

    private function rewriteHtml($content, $rootUrl) {
        // 0. Inject Monkey-Patch for AJAX (Fetch & XHR)
        $interceptor = "
        <script>
            (function() {
                const proxyPrefix = '/proxy?url=';
                const rootUrl = '" . $rootUrl . "';
                const originalFetch = window.fetch;
                const originalOpen = window.XMLHttpRequest.prototype.open;

                // Intercept Fetch
                window.fetch = function(input, init) {
                    let url = (typeof input === 'string') ? input : input.url;
                    if (!url) return originalFetch(input, init);
                    
                    try {
                        if (!url.startsWith('http')) {
                            url = new URL(url, rootUrl).href;
                        }
                        if (!url.includes(window.location.host)) {
                            url = proxyPrefix + encodeURIComponent(url);
                        }
                    } catch (e) { console.error('Interceptor Error:', e); }
                    
                    return originalFetch(url, init);
                };

                // Intercept XHR
                window.XMLHttpRequest.prototype.open = function(method, url) {
                    try {
                        if (url && !url.startsWith('http')) {
                            url = new URL(url, rootUrl).href;
                        }
                        if (url && !url.includes(window.location.host)) {
                            url = proxyPrefix + encodeURIComponent(url);
                        }
                    } catch (e) { console.error('Interceptor Error:', e); }
                    
                    originalOpen.apply(this, [method, url]);
                };
                
                // Notify parent
                window.addEventListener('beforeunload', function() {
                    window.parent.postMessage({ type: 'ZENITH_PROXY_LOADING' }, '*');
                });
            })();
        </script>";

        // Inject at the top of HEAD
        $content = str_replace('<head>', '<head>' . $interceptor, $content);

        // 1. Rewrite href and src attributes
        $content = preg_replace_callback(
            '/(href|src)=["\'](.*?)["\']/',
            function ($matches) use ($rootUrl) {
                $link = $matches[2];
                if (str_starts_with($link, 'data:') || str_starts_with($link, '#') || str_starts_with($link, 'javascript:')) {
                    return $matches[0];
                }
                
                $target = $this->resolveUrl($rootUrl, $link);
                return $matches[1] . '="/proxy?url=' . urlencode($target) . '"';
            },
            $content
        );

        // 2. Rewrite Form Actions
        $content = preg_replace_callback(
            '/action=["\'](.*?)["\']/',
            function ($matches) use ($rootUrl) {
                $link = $matches[1];
                $target = $this->resolveUrl($rootUrl, $link);
                return 'action="/proxy?url=' . urlencode($target) . '"';
            },
            $content
        );

        // 3. Rewrite Meta Refresh
        $content = preg_replace_callback(
            '/<meta[^>]*?url=(.*?)(["\'])/i',
            function ($matches) use ($rootUrl) {
                $link = $matches[1];
                $target = $this->resolveUrl($rootUrl, $link);
                return str_replace($link, '/proxy?url=' . urlencode($target), $matches[0]);
            },
            $content
        );

        // 4. Rewrite window.location
        $content = preg_replace_callback(
            '/window\.location\.replace\(["\'](.*?)["\']\)/',
            function ($matches) use ($rootUrl) {
                $link = $matches[1];
                 if (str_starts_with($link, 'http')) {
                     $target = $link;
                 } else {
                     $target = $this->resolveUrl($rootUrl, $link);
                 }
                return 'window.location.replace("/proxy?url=' . urlencode($target) . '")';
            },
            $content
        );
        
        return $content;
    }
}