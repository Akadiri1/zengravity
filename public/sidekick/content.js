// Zenith Academy Sidekick - Content Script
(function() {
    // Prevent multiple injections
    if (window.zenithInjected) return;
    window.zenithInjected = true;

    console.log("%c 🚀 Zenith Sidekick Connected", "color: #06b6d4; font-weight: bold; font-size: 1.2em;");

    const API_ENDPOINT = 'http://127.0.0.1:8000/api/exam/solve';
    let processedQuestions = new Set();
    let isActive = false; // Default to TRUE for auto-start

    // Handshake with Parent Dashboard
    window.top.postMessage({ type: 'ZENITH_CONNECTED' }, '*');
    
    // Listen for Ping from Dashboard
    window.addEventListener('message', (event) => {
        if (event.data && event.data.type === 'ZENITH_PING') {
            window.top.postMessage({ type: 'ZENITH_CONNECTED' }, '*');
        }
    });

    // Listen for activation message from Popup
    chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
        if (request.action === "activate") {
            isActive = true;
            scanPage();
            showToast("AI Scanning Activated");
            sendResponse({status: "active"});
        } else if (request.action === "deactivate") {
            isActive = false;
            showToast("AI Scanning Paused");
            sendResponse({status: "inactive"});
        }
        return true;
    });

    // Auto-activate if previously enabled (Optional, simpler to just require click for now)
    
    function scanPage() {
        if (!isActive) return;

        const candidates = document.querySelectorAll('p, h1, h2, h3, h4, li, div.question-text, span.q-text, div.content');
        
        candidates.forEach(el => {
            const text = el.innerText.trim();
            // Broader regex for detection
            const questionPattern = /^(Q\d+|Question|Problem|Task|\d+[\u0029\u002E])\s+/i;
            
            // Check if it looks like a question and hasn't been processed
            if (text.length > 15 && (questionPattern.test(text) || text.endsWith('?')) && !processedQuestions.has(text)) {
                
                console.log("Found Question:", text.substring(0, 30) + "...");
                processedQuestions.add(text);
                
                // Visual Highlight
                el.style.borderLeft = "4px solid #06b6d4";
                el.style.backgroundColor = "rgba(6, 182, 212, 0.05)";
                el.dataset.zenithId = Date.now();

                solveQuestion(text, el);
            }
        });
    }

    async function solveQuestion(text, element) {
        try {
            // Add "Thinking" indicator
            const indicator = document.createElement('span');
            indicator.innerText = " ⚡";
            indicator.style.animation = "pulse 1s infinite";
            element.appendChild(indicator);

            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question: text })
            });

            if (response.ok) {
                const data = await response.json();
                console.log(`%c ✅ Answer: ${data.answer}`, "color: #22c55e");
                
                // Update specific element with answer (Subtle)
                indicator.remove();
                
                const answerDiv = document.createElement('div');
                answerDiv.style.marginTop = "8px";
                answerDiv.style.padding = "8px";
                answerDiv.style.fontSize = "14px";
                answerDiv.style.color = "#ffffff";
                answerDiv.style.backgroundColor = "#0f172a";
                answerDiv.style.borderRadius = "6px";
                answerDiv.style.border = "1px solid #06b6d4";
                answerDiv.innerHTML = `<strong>Zenith:</strong> ${data.answer} <span style="font-size:10px;color:#94a3b8">(${data.confidence}%)</span>`;
                
                element.appendChild(answerDiv);
                
                showToast(`Answer Found (${data.confidence}%)`);
            }
        } catch (error) {
            console.error("Zenith API Error:", error);
        }
    }

    // Watch for DOM changes (SPA support)
    const observer = new MutationObserver((mutations) => {
        if (!isActive) return;
        let shouldScan = false;
        mutations.forEach(m => { if (m.addedNodes.length > 0) shouldScan = true; });
        if(shouldScan) {
            clearTimeout(window.scanTimeout);
            window.scanTimeout = setTimeout(scanPage, 1000);
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    function showToast(msg) {
        const div = document.createElement('div');
        div.innerText = "ZENITH: " + msg;
        div.style.position = 'fixed';
        div.style.bottom = '20px';
        div.style.right = '20px';
        div.style.background = '#06b6d4';
        div.style.color = '#fff';
        div.style.padding = '8px 16px';
        div.style.borderRadius = '8px';
        div.style.fontSize = '12px';
        div.style.fontWeight = 'bold';
        div.style.zIndex = 2147483647;
        div.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
        div.style.transition = 'opacity 0.3s';
        document.body.appendChild(div);
        setTimeout(() => { div.style.opacity = '0'; setTimeout(()=>div.remove(), 300); }, 3000);
    }
})();
