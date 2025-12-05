<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cyber Security Awareness Quiz</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --bg-light: #f4f6f9;
            --success: #27ae60;
            --danger: #c0392b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 0; }
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; background: #2c3e50; color: white; padding: 10px 20px; border-radius: 5px; }

        /* --- VISUAL MOCKUP STYLES (Copied from quiz_view.php) --- */
        /* Visual Mockup Styles moved to public/style.css */

        /* --- ITEM STYLES --- */
        .q-preview-item {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            background: #fafafa;
        }
        .q-title { font-weight: bold; color: var(--primary); margin-bottom: 10px; font-size: 1.2rem; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .q-text { font-size: 1.1rem; margin-bottom: 20px; color: #444; }
        
        .option-item {
            padding: 12px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: white;
        }
        .correct-opt { border-color: var(--success); background: #eafaf1; font-weight: bold; color: var(--success); }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <a href="<?= base_url('dashboard') ?>" class="btn-back">Back to Dashboard</a>
        <div style="float:right; display:flex; gap:10px;">
            <button onclick="downloadQuestionsPDF()" style="background:#e74c3c; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-size:1rem;">Download PDF</button>
        </div>
        <h1>All Questions Preview (50 Questions)</h1>
        <div id="questions-list"></div>
        <a href="<?= base_url('dashboard') ?>" class="btn-back">Back to Dashboard</a>
    </div>

    <script src="<?= base_url('public/js/questions.js') ?>?v=<?= time() ?>"></script>
    <script>
        function downloadQuestionsPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            doc.setFontSize(16);
            doc.text("Cyber Quiz - All Questions", 14, 15);
            doc.setFontSize(10);
            doc.text("Generated on: " + new Date().toLocaleString(), 14, 22);
            
            let y = 30;
            const pageHeight = doc.internal.pageSize.height;
            
            QUESTION_POOL.forEach((q, index) => {
                // Check page break
                if (y > pageHeight - 40) {
                    doc.addPage();
                    y = 20;
                }
                
                doc.setFontSize(12);
                doc.setFont("helvetica", "bold");
                doc.text(`Q${index + 1}: ${q.type}`, 14, y);
                y += 7;
                
                doc.setFont("helvetica", "normal");
                doc.setFontSize(11);
                
                // Wrap text
                const splitText = doc.splitTextToSize(q.text, 180);
                doc.text(splitText, 14, y);
                y += (splitText.length * 5) + 5;
                
                q.options.forEach((opt, i) => {
                    if (y > pageHeight - 20) {
                        doc.addPage();
                        y = 20;
                    }
                    const prefix = (i === q.correct) ? "[CORRECT] " : "- ";
                    doc.text(`${prefix}${opt}`, 20, y);
                    y += 5;
                });
                
                y += 10; // Spacing between questions
            });
            
            doc.save("cyber_quiz_questions.pdf");
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
                            </div>
                            <div class="outlook-body">
                                ${content.external ? '<div class="external-banner">⚠️ <strong>External Sender</strong> - Be careful with links and attachments.</div>' : ''}
                                <p>${content.body}</p>
                                ${content.qrImage ? `<div style="margin-top:15px;"><img src="<?= base_url() ?>/${content.qrImage}" alt="QR Code" style="width:150px; height:150px; border:1px solid #ccc;"></div>` : ''}
                                ${content.linkText ? `<a href="#" style="color:#0078d4; text-decoration:underline;">${content.linkText}</a>` : ''}
                                ${content.attachment ? `<div class="attachment-pill">📎 ${content.attachment}</div>` : ''}
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
            case 'windows_update':
                html = `
                <div class="windows-update-mock">
                    <div class="win-update-header">
                        <i class="fas fa-sync-alt win-update-icon"></i>
                        <div class="win-update-title">Windows Update</div>
                    </div>
                    <div class="win-update-body">
                        <div class="win-update-status">
                            <i class="fas fa-exclamation-circle win-update-status-icon"></i>
                            <div class="win-update-text">
                                <h4>${content.header || 'Restart required'}</h4>
                                <p>${content.body || 'Your device needs to restart to install updates. Select a time to restart.'}</p>
                                <button class="win-update-btn">Restart now</button>
                            </div>
                        </div>
                    </div>
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

    function renderAllQuestions() {
        const container = document.getElementById('questions-list');
        container.innerHTML = '';

        QUESTION_POOL.forEach((q, idx) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'q-preview-item';
            
            // Title
            const title = document.createElement('div');
            title.className = 'q-title';
            title.innerText = `${idx + 1}. ${q.type}`;
            wrapper.appendChild(title);

            // Text
            const text = document.createElement('div');
            text.className = 'q-text';
            text.innerText = q.text;
            wrapper.appendChild(text);

            // Visual
            const visual = document.createElement('div');
            visual.innerHTML = getVisualHTML(q.visualType, q.content);
            wrapper.appendChild(visual);

            // Options
            const optsDiv = document.createElement('div');
            q.options.forEach((opt, optIdx) => {
                const optDiv = document.createElement('div');
                optDiv.className = 'option-item';
                optDiv.innerText = opt;
                if(optIdx === q.correct) {
                    optDiv.classList.add('correct-opt');
                    optDiv.innerText += ' (Correct Answer)';
                }
                optsDiv.appendChild(optDiv);
            });
            wrapper.appendChild(optsDiv);

            container.appendChild(wrapper);
        });
    }

    // Init
    renderAllQuestions();
    </script>
</body>
</html>
