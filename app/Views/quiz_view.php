<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viyona Fintech | Interactive Training</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Quiz Specific Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .quiz-container {
            width: 100%;
            max-width: 900px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: var(--glass-border);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 40px;
            position: relative;
        }

        /* --- VISUAL MOCKUP STYLES --- */
        /* Visual Mockup Styles moved to public/style.css */

        /* --- INTERFACE ELEMENTS --- */
        .question-header { margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .q-tag { background: #eee; padding: 5px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: bold; color: #555; float:right; }
        
        .option-item {
            padding: 20px;
            margin-bottom: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            font-size: 1rem;
            position: relative;
            padding-left: 50px;
        }
        .option-item:before {
            content: '';
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            transition: all 0.2s;
        }
        .option-item:hover { border-color: #667eea; background: #f8fafc; }
        .option-item.selected { border-color: #667eea; background: #eff6ff; font-weight: 600; }
        .option-item.selected:before { border-color: #667eea; background: #667eea; box-shadow: inset 0 0 0 4px white; }

        .btn-nav {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-prev { background: #94a3b8; color: white; }
        .btn-prev:hover { background: #64748b; }
        .btn-next { background: var(--secondary-gradient); color: white; }
        .btn-next:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); }

        /* Results Screen */
        #result-ui { text-align: center; padding: 50px 20px; }
        .score-circle { 
            width: 180px; height: 180px; border-radius: 50%; 
            background: var(--secondary-gradient); color: white; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 3.5rem; margin: 30px auto; font-weight: bold; 
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        .logout-btn { background: var(--accent-error); margin-top: 30px; }
        
        /* Full Screen Overlay */
        #start-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.98); z-index: 1000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: white; text-align: center;
        }
        #start-box {
            background: white; color: #333; padding: 50px; border-radius: 16px;
            max-width: 550px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        
        /* Palette */
        .palette-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(35px, 1fr)); gap: 8px; margin-bottom: 30px; }
        .palette-item { 
            padding: 8px; text-align: center; background: #f1f5f9; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 600; color: #64748b; transition: 0.2s;
        }
        .palette-item:hover { background: #e2e8f0; }
        .palette-item.visited { background: var(--accent-warning); color: white; } 
        .palette-item.answered { background: var(--accent-success); color: white; } 
        .palette-item.current { border: 2px solid #667eea; transform: scale(1.1); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

        /* Modals */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 2000; display: none;
            backdrop-filter: blur(5px);
            align-items: center; justify-content: center;
        }
        .modal-box {
            background: white; padding: 40px; border-radius: 16px; max-width: 450px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .modal-btn { margin: 15px 5px; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.2s; }
        .btn-primary { background: var(--secondary-gradient); color: white; }
        .btn-danger { background: var(--accent-error); color: white; }
        
        #timer {
            font-size: 1.2rem; font-weight: bold; color: var(--accent-error); 
            border: 2px solid var(--accent-error); padding: 6px 15px; border-radius: 8px;
            background: #fff1f2;
        }
    </style>
</head>
<body>

<div id="start-overlay">
    <div id="start-box">
        <h1 style="color:var(--primary); margin-bottom:20px;">Ready to Begin?</h1>
        <p style="font-size:1.1rem; line-height:1.6; color:#64748b; margin-bottom:30px;">
            This assessment requires <strong>Full Screen Mode</strong>.
            <br>
            The test has a <strong>10-minute time limit</strong>.
            <br>
            If you exit full screen, the test will be <strong>automatically submitted</strong>.
        </p>
        <button class="btn" onclick="startTest()" style="width:100%; font-size:1.1rem;">Start Assessment</button>
    </div>
</div>

<div class="quiz-container fade-in" style="filter: blur(5px);">
    <!-- QUIZ INTERFACE -->
    <div id="quiz-ui">
        <!-- Question Palette -->
        <div class="palette-grid" id="palette-container"></div>

        <div class="question-header">
            <h2 id="q-number" style="margin:0; color:var(--primary);">Question 1</h2>
            <div id="timer">10:00</div>
        </div>

        <p id="q-text" style="font-size:1.2rem; margin-bottom:30px; color:#334155; line-height:1.6;"></p>

        <!-- DYNAMIC VISUAL CONTAINER -->
        <div id="visual-container"></div>

        <div id="options-container"></div>
        
        <div id="error-msg" style="color: var(--accent-error); font-weight: bold; margin-top: 15px; display: none; text-align:center;">
            Please select an answer to proceed.
        </div>

        <div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center;">
            <button id="prev-btn" class="btn-nav btn-prev" onclick="prevQuestion()">Previous</button>
            <button id="next-btn" class="btn-nav btn-next" onclick="nextQuestion()">Next Question</button>
        </div>
    </div>

    <!-- RESULT INTERFACE -->
    <div id="result-ui" style="display:none;">
        <h1 style="color:var(--primary); margin-bottom:10px;">Training Completed</h1>
        <p style="color:#64748b;">Your responses have been securely recorded.</p>
        
        <div class="score-circle">
            <span id="final-score">0%</span>
        </div>
        
        <h3 id="pass-fail-msg" style="font-size:1.5rem; margin-bottom:10px;"></h3>
        <p id="auto-submit-msg" style="color: var(--accent-error); font-weight: bold; display: none;"></p>
        
        <div id="detailed-results" style="text-align: left; margin-top: 30px; max-height: 400px; overflow-y: auto; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; display:none;">
            <!-- Detailed results will be injected here -->
        </div>

        <a href="<?= base_url('logout') ?>" class="btn logout-btn">Logout System</a>
    </div>
</div>

<!-- MODALS -->
<div id="fullscreen-warning-modal" class="modal-overlay">
    <div class="modal-box">
        <h2 style="color:var(--accent-error); margin-bottom:15px;">⚠️ Full Screen Exited</h2>
        <p style="margin-bottom:25px; color:#64748b;">You are required to stay in full screen mode to maintain the integrity of the assessment.</p>
        <button class="modal-btn btn-primary" onclick="resumeFullscreen()">Resume Quiz</button>
        <button class="modal-btn btn-danger" onclick="confirmExitSubmit()">Submit Quiz</button>
    </div>
</div>

<div id="submission-check-modal" class="modal-overlay">
    <div class="modal-box">
        <h2 style="color:var(--primary); margin-bottom:15px;">Unanswered Questions</h2>
        <p id="unanswered-list" style="margin-bottom:20px; color:#64748b; font-weight:500;"></p>
        <p style="margin-bottom:25px;">Are you sure you want to submit?</p>
        <button class="modal-btn btn-primary" onclick="closeModal('submission-check-modal')">Review</button>
        <button class="modal-btn btn-danger" onclick="submitQuiz()">Submit Anyway</button>
    </div>
</div>


<script src="<?= base_url('public/js/questions.js') ?>?v=<?= time() ?>"></script>
<script>
    let questions = [];
    let currentIdx = 0;
    let answers = {};
    let visited = new Set();
    let isSubmitting = false;
    let timerInterval;
    const TIME_LIMIT = 10 * 60; // 10 minutes in seconds

    function initQuestions() {
        if (typeof QUESTION_POOL === 'undefined') {
            console.error("QUESTION_POOL is not defined!");
            alert("Error loading questions. Please refresh the page.");
            return;
        }
        // Shuffle and select 15
        const shuffled = [...QUESTION_POOL].sort(() => 0.5 - Math.random());
        questions = shuffled.slice(0, 15);
    }

    function startTest() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }

        document.getElementById('start-overlay').style.display = 'none';
        document.querySelector('.quiz-container').style.filter = 'none';
        
        // Re-render with the selected questions (though they are selected at init)
        renderQ();
        startTimer();
    }

    function startTimer() {
        let startTime = sessionStorage.getItem('quizStartTime');
        if (!startTime) {
            startTime = Date.now();
            sessionStorage.setItem('quizStartTime', startTime);
        }

        timerInterval = setInterval(() => {
            const now = Date.now();
            const elapsed = Math.floor((now - startTime) / 1000);
            const remaining = TIME_LIMIT - elapsed;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').innerText = "00:00";
                submitQuiz('Time Expired');
            } else {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                document.getElementById('timer').innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }
        }, 1000);
    }

    // Monitor Full Screen Exit
    document.addEventListener('fullscreenchange', (event) => {
        if (!document.fullscreenElement && !isSubmitting) {
            // Show Warning Modal
            document.getElementById('fullscreen-warning-modal').style.display = 'flex';
            document.querySelector('.quiz-container').style.filter = 'blur(5px)';
        }
    });

    function resumeFullscreen() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        }
        document.getElementById('fullscreen-warning-modal').style.display = 'none';
        document.querySelector('.quiz-container').style.filter = 'none';
    }

    function confirmExitSubmit() {
        submitQuiz();
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function renderQ(shouldScroll = true) {
        if (shouldScroll) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        const q = questions[currentIdx];
        visited.add(currentIdx);
        
        // Update Palette
        const palDiv = document.getElementById('palette-container');
        palDiv.innerHTML = '';
        questions.forEach((_, idx) => {
            const item = document.createElement('div');
            item.className = 'palette-item';
            item.innerText = idx + 1;
            
            if (idx === currentIdx) item.classList.add('current');
            else if (answers[idx] !== undefined) item.classList.add('answered');
            else if (visited.has(idx)) item.classList.add('visited');
            
            item.onclick = () => jumpToQuestion(idx);
            palDiv.appendChild(item);
        });

        // Update Header
        document.getElementById('q-number').innerText = `Question ${currentIdx + 1} of ${questions.length}`;
        document.getElementById('q-text').innerText = q.text;

        // Render Visual
    // 1. Disable Copy/Paste/Context Menu
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.addEventListener('copy', event => event.preventDefault());
    document.addEventListener('cut', event => event.preventDefault());
    document.addEventListener('paste', event => event.preventDefault());

    // Block F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
    document.addEventListener('keydown', function(e) {
        if (
            e.key === 'F12' || 
            (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) || 
            (e.ctrlKey && e.key === 'u')
        ) {
            e.preventDefault();
            return false;
        }
    });

    // 2. Focus Loss / Tab Switch Detection
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && !isSubmitting) {
            triggerSecurityWarning("Tab switched or minimized.");
        }
    });

    window.addEventListener('blur', () => {
        if (!isSubmitting && document.fullscreenElement) {
            triggerSecurityWarning("Focus lost (clicked outside or switched app).");
        }
    });

    function triggerSecurityWarning(reason) {
        // Reuse the fullscreen warning modal but update text
        const modal = document.getElementById('fullscreen-warning-modal');
        const title = modal.querySelector('h2');
        const text = modal.querySelector('p');
        
        title.innerText = "⚠️ Security Alert";
        text.innerText = reason + " You must stay on this screen.";
        
        modal.style.display = 'flex';
        document.querySelector('.quiz-container').style.filter = 'blur(5px)';
    }

    // 3. Projector / Extended Screen Check
    // Note: 'isExtended' is part of the Window Management API and may not be supported in all browsers.
    // We will also check if the window size matches the screen size as a fallback.
    async function checkScreenConfig() {
        if (window.screen.isExtended === true) {
            alert("External displays/projectors are not allowed. Please disconnect external monitors.");
            // Ideally, we would block the test here, but for now we just warn.
        }
    }

    // Initialize
    initQuestions();
    renderQ();
    checkScreenConfig();
</script>
</body>
</html>