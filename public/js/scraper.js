/**
 * ZenGravity Side-Kick Scraper (Zenith Academy)
 * Usage: Paste this into the console of your exam portal or use as a Bookmarklet.
 * 
 * Target: DOM elements containing questions (h3, .question-text, li, etc.)
 * Action: Sends text to ZenGravity Zenith Academy API for RAG analysis.
 */

(function() {
    console.log("%c 🚀 Zenith Academy Scraper Initiated", "color: #06b6d4; font-weight: bold; font-size: 1.2em;");

    const API_ENDPOINT = 'http://127.0.0.1:8000/api/exam/solve'; // Adjust for production
    let processedQuestions = new Set();
    
    // Handshake with Parent Dashboard
    window.top.postMessage({ type: 'ZENITH_CONNECTED' }, '*');

    // 1. Identify Potential Questions
    function scanPage() {
        const candidates = document.querySelectorAll('p, h1, h2, h3, h4, li, div.question-text, span.q-text');
        
        candidates.forEach(el => {
            const text = el.innerText.trim();
            
            // Regex for "Q1.", "1)", "Question 5:", etc.
            const questionPattern = /^(Q\d+|Question\s\d+|\d+[\u0029\u002E])\s+/i;
            
            if (text.length > 20 && questionPattern.test(text) && !processedQuestions.has(text)) {
                // High probability of being a question
                console.log("Found Question:", text.substring(0, 30) + "...");
                processedQuestions.add(text);
                
                // Optional: Highlight on page
                el.style.borderLeft = "4px solid #06b6d4";
                el.style.backgroundColor = "rgba(6, 182, 212, 0.1)";

                solveQuestion(text);
            }
        });
    }

    // 2. Send to Exam Forge
    async function solveQuestion(text) {
        try {
            // Check for CSRF token if running on same domain, otherwise need API token logic
            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // 'Authorization': 'Bearer ...' // If using API tokens
                },
                body: JSON.stringify({ question: text })
            });

            if (response.ok) {
                const data = await response.json();
                console.log(`%c ✅ Answer Recieved (${data.confidence}%):`, "color: #22c55e", data.answer);
                
                // Notify User (Custom Toast)
                showToast(`Answer Found: ${data.confidence}% Confidence`);
            }
        } catch (error) {
            console.error("ZenGravity Connection Failed:", error);
        }
    }

    // 3. Automation: Watch for DOM Changes (Next Question)
    const observer = new MutationObserver((mutations) => {
        let shouldScan = false;
        mutations.forEach(m => {
            if (m.addedNodes.length > 0) shouldScan = true;
        });
        
        if(shouldScan) {
            // Debounce
            clearTimeout(window.scanTimeout);
            window.scanTimeout = setTimeout(scanPage, 1000);
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    // Initial Scan
    scanPage();

    // UI Helper
    function showToast(msg) {
        const div = document.createElement('div');
        div.innerText = "ZEN: " + msg;
        div.style.position = 'fixed';
        div.style.bottom = '20px';
        div.style.right = '20px';
        div.style.background = '#06b6d4';
        div.style.color = '#fff';
        div.style.padding = '10px 20px';
        div.style.borderRadius = '8px';
        div.style.zIndex = 99999;
        div.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 3000);
    }

})();
