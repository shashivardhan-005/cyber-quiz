<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Security Awareness Quiz</title>
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
        sessionStorage.removeItem('quizStartTime');
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

    function getVisualHTML(type, content) {
        let html = '';
        switch(type) {
            case 'outlook':
                html = `
                <div class="outlook-mock">
                    <div class="outlook-top-bar">Outlook</div>
                    <div class="outlook-ribbon">
                        <span>Home</span> <span>View</span> <span>Help</span>
                    </div>
                    <div class="outlook-container">
                        <div class="outlook-sidebar">
                            <div style="padding:10px 0; font-weight:600;">Inbox</div>
                            <div style="padding:5px 0; color:#666;">Sent Items</div>
                            <div style="padding:5px 0; color:#666;">Drafts</div>
                        </div>
                        <div class="outlook-content">
                            <div class="outlook-email-header">
                                <div class="outlook-subject">${content.subject}</div>
                                <div class="outlook-sender-info">
                                    <div class="outlook-avatar">${content.from.charAt(0)}</div>
                                    <div>
                                        <div style="font-weight:600; font-size:0.9rem;">${content.from}</div>
                                        <div style="font-size:0.8rem; color:#666;">To: You</div>
                                    </div>
                                </div>
                                <div class="outlook-email-body">
                                    ${content.body}
                                    ${content.qrImage ? `<div style="margin-top:20px;"><img src="<?= base_url() ?>/${content.qrImage}" alt="QR Code" style="width:150px; height:150px; border:1px solid #333;"></div>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                break;
            case 'teams':
                html = `
                <div class="teams-mock">
                    <div class="teams-sidebar">
                        <i class="fas fa-bell"></i>
                        <i class="fas fa-comment-alt" style="color:#7b83eb;"></i>
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="teams-list">
                        <div style="padding:15px; font-weight:bold; border-bottom:1px solid #ddd;">Chat</div>
                        <div style="padding:10px; background:#fff; border-left:3px solid #6264a7;">
                            <div style="font-weight:600; font-size:0.9rem;">${content.sender}</div>
                            <div style="font-size:0.8rem; color:#666; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${content.msg}</div>
                        </div>
                    </div>
                    <div class="teams-chat-area">
                        <div class="teams-header">
                            <div class="teams-msg-avatar" style="margin-right:10px;">${content.initials}</div>
                            ${content.sender}
                        </div>
                        <div class="teams-messages">
                            <div class="teams-msg">
                                <div class="teams-msg-avatar">${content.initials}</div>
                                <div class="teams-msg-content">
                                    <div class="teams-msg-name">${content.sender} • 10:42 AM</div>
                                    <div class="teams-msg-bubble">${content.msg}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                break;
            case 'browser':
                html = `
                <div class="browser-mock">
                    <div class="browser-tabs">
                        <div class="browser-tab">
                            <span style="font-size:0.8rem;">📄</span> ${content.tabName || content.url.substring(0, 20) + '...'} <span style="margin-left:auto; font-size:0.7rem;">✕</span>
                        </div>
                        <div style="padding:8px; color:#5f6368;">+</div>
                    </div>
                    <div class="browser-toolbar">
                        <div class="browser-nav-btns">
                            <i class="fas fa-arrow-left"></i>
                            <i class="fas fa-arrow-right"></i>
                            <i class="fas fa-redo"></i>
                        </div>
                        <div class="browser-address-bar">
                            ${content.secure ? '<i class="fas fa-lock" style="color:#1a73e8;"></i>' : '<i class="fas fa-exclamation-triangle" style="color:#d93025;"></i> <span style="color:#d93025">Not Secure</span> | '}
                            <span style="color:#202124;">${content.url}</span>
                        </div>
                    </div>
                    <div class="browser-viewport">
                        ${content.html}
                    </div>
                </div>`;
                break;
            case 'sms':
                html = `
                <div class="sms-mock">
                    <div class="sms-top-bar">
                        <div class="sms-back"><i class="fas fa-chevron-left"></i></div>
                        <div style="display:flex; flex-direction:column; align-items:center;">
                            <div style="width:30px; height:30px; background:#ccc; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:2px;"><i class="fas fa-user" style="color:white; font-size:0.8rem;"></i></div>
                            <span style="font-size:0.75rem;">${content.sender}</span>
                        </div>
                        <div style="position:absolute; right:15px; color:#007aff;"><i class="fas fa-info-circle"></i></div>
                    </div>
                    <div class="sms-thread">
                        <div style="text-align:center; color:#8e8e93; font-size:0.75rem; margin-bottom:10px;">Today 9:41 AM</div>
                        <div class="sms-bubble-rx">
                            ${content.msg}
                        </div>
                    </div>
                </div>`;
                break;
            case 'poster':
                html = `
                <div class="poster-mock">
                    <div class="poster-header">${content.header}</div>
                    <div class="poster-body">${content.body}</div>
                    ${content.qrImage ? `<div style="margin-top:20px;"><img src="<?= base_url() ?>/${content.qrImage}" alt="QR Code" style="width:150px; height:150px; border:1px solid #333;"></div>` : (content.qr ? '<div style="margin-top:20px; background:#000; color:#fff; display:inline-block; padding:15px; font-family:monospace;">[QR CODE]</div>' : '')}
                </div>`;
                break;
            case 'whatsapp':
                html = `
                <div class="whatsapp-mock">
                    <div class="whatsapp-header">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <i class="fas fa-arrow-left"></i>
                            <div class="whatsapp-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="whatsapp-info">
                            <div class="whatsapp-name">${content.sender}</div>
                            <div class="whatsapp-status">online</div>
                        </div>
                        <div style="display:flex; gap:15px;">
                            <i class="fas fa-video"></i>
                            <i class="fas fa-phone"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                    <div class="whatsapp-body">
                        <div style="background:#e1f5fe; color:#333; padding:5px 10px; border-radius:5px; align-self:center; font-size:12px; margin-bottom:10px; box-shadow:0 1px 1px rgba(0,0,0,0.1);">
                            Messages are end-to-end encrypted. No one outside of this chat, not even WhatsApp, can read or listen to them.
                        </div>
                        <div class="whatsapp-message received">
                            ${content.msg}
                            <div class="whatsapp-time">10:42 AM</div>
                        </div>
                    </div>
                    <div class="whatsapp-input-area">
                        <i class="far fa-smile" style="color:#666; font-size:20px;"></i>
                        <input type="text" class="whatsapp-input" placeholder="Message" disabled>
                        <i class="fas fa-paperclip" style="color:#666; font-size:20px; margin:0 10px;"></i>
                        <i class="fas fa-camera" style="color:#666; font-size:20px;"></i>
                        <div style="width:40px; height:40px; background:#075e54; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-left:5px;">
                            <i class="fas fa-microphone" style="color:white;"></i>
                        </div>
                    </div>
                </div>`;
                break;
            case 'screenshot':
                html = `
                <div class="screenshot-mock" style="text-align:center; margin-top:15px;">
                    <img src="<?= base_url() ?>/${content.image}" alt="Screenshot" style="max-width:100%; border:1px solid #ddd; border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                </div>`;
                break;
            case 'popup':
                html = `
                <div class="popup-mock">
                    <div class="popup-window">
                        <div class="popup-header">
                            <div class="popup-title">${content.header}</div>
                            <div class="popup-controls">
                                <div class="popup-control"></div>
                                <div class="popup-control"></div>
                                <div class="popup-control close"></div>
                            </div>
                        </div>
                        <div class="popup-body">
                            <div class="popup-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="popup-message">${content.body}</div>
                            <div class="popup-subtext">${content.subtext || ''}</div>
                            <div class="popup-actions">
                                <button class="popup-btn primary">${content.buttonText || 'OK'}</button>
                                <button class="popup-btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                break;
        }
        return html;
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
        const visualContainer = document.getElementById('visual-container');
        visualContainer.innerHTML = getVisualHTML(q.visualType, q.content);

        // Render Options
        const optDiv = document.getElementById('options-container');
        optDiv.innerHTML = '';
        q.options.forEach((opt, idx) => {
            const div = document.createElement('div');
            div.className = 'option-item';
            div.innerText = opt;
            if (answers[currentIdx] === idx) div.classList.add('selected');
            div.onclick = () => selectAnswer(idx);
            optDiv.appendChild(div);
        });

        // Update Buttons
        document.getElementById('prev-btn').disabled = (currentIdx === 0);
        const nextBtn = document.getElementById('next-btn');
        if (currentIdx === questions.length - 1) {
            nextBtn.innerText = 'Submit Assessment';
            nextBtn.onclick = () => showSubmissionCheck();
        } else {
            nextBtn.innerText = 'Next Question';
            nextBtn.onclick = nextQuestion;
        }
    }

    function selectAnswer(idx) {
        answers[currentIdx] = idx;
        renderQ(false);
    }

    function jumpToQuestion(idx) {
        currentIdx = idx;
        renderQ();
    }

    function nextQuestion() {
        if (answers[currentIdx] === undefined) {
            document.getElementById('error-msg').style.display = 'block';
            return;
        }
        document.getElementById('error-msg').style.display = 'none';
        
        if (currentIdx < questions.length - 1) {
            currentIdx++;
            renderQ();
        }
    }

    function prevQuestion() {
        document.getElementById('error-msg').style.display = 'none';
        if (currentIdx > 0) {
            currentIdx--;
            renderQ();
        }
    }

    function showSubmissionCheck() {
        if (answers[currentIdx] === undefined) {
             document.getElementById('error-msg').style.display = 'block';
             return;
        }
        document.getElementById('error-msg').style.display = 'none';

        const unanswered = questions.length - Object.keys(answers).length;
        if (unanswered > 0) {
            const list = [];
            questions.forEach((_, i) => {
                if (answers[i] === undefined) list.push(i + 1);
            });
            document.getElementById('unanswered-list').innerText = "Questions: " + list.join(', ');
            document.getElementById('submission-check-modal').style.display = 'flex';
        } else {
            submitQuiz();
        }
    }

    function submitQuiz(reason = null) {
        isSubmitting = true;
        clearInterval(timerInterval);
        
        // Hide Modals
        document.getElementById('submission-check-modal').style.display = 'none';
        document.getElementById('fullscreen-warning-modal').style.display = 'none';
        document.querySelector('.quiz-container').style.filter = 'none';
        
        // Calculate Score
        let score = 0;
        let results = [];
        
        questions.forEach((q, idx) => {
            const isCorrect = (answers[idx] === q.correct);
            if (isCorrect) score++;
            results.push({
                q: idx + 1,
                text: q.text,
                correct: isCorrect,
                userAnswer: q.options[answers[idx]] || 'Skipped',
                correctAnswer: q.options[q.correct]
            });
        });
        
        const percentage = Math.round((score / questions.length) * 100);
        const passed = percentage >= 80; // 80% passing
        
        // UI Update
        document.getElementById('quiz-ui').style.display = 'none';
        document.getElementById('result-ui').style.display = 'block';
        document.getElementById('final-score').innerText = percentage + '%';
        document.getElementById('pass-fail-msg').innerText = passed ? "PASSED" : "FAILED";
        document.getElementById('pass-fail-msg').style.color = passed ? "var(--accent-success)" : "var(--accent-error)";
        
        if (reason) {
            const autoMsg = document.getElementById('auto-submit-msg');
            autoMsg.innerText = "Auto-submitted: " + reason;
            autoMsg.style.display = 'block';
        }

        // Send to Backend
        fetch('<?= base_url("save-result") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                score: percentage,
                details: results
            })
        }).catch(err => console.error(err));
        
        // Exit Fullscreen
        if (document.fullscreenElement && document.exitFullscreen) {
            document.exitFullscreen().catch(err => console.log("Exit fullscreen failed: ", err));
        }
    }
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