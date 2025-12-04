<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIYONA FINTECH | Instructions</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .instructions-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }
        .instructions-list li {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            color: var(--text-main);
            font-size: 1.05rem;
        }
        .instructions-list li i {
            color: #667eea;
            font-size: 1.2rem;
            margin-top: 4px;
            flex-shrink: 0;
        }
        .instructions-list strong {
            display: block;
            color: var(--primary);
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="container fade-in" style="max-width: 700px;">
        <div class="wrapper" style="padding: 50px;">
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 style="font-size: 2.5rem; margin-bottom: 10px;">Spot the Phish Contest</h1>
                <h2 style="font-size: 1.5rem; color: var(--text-light); font-weight: 400;">Assessment Instructions</h2>
            </div>
            
            <ul class="instructions-list">
                <li>
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>15 Cybersecurity Scenarios</strong>
                        You will be presented with 15 real-world scenarios designed to test your awareness.
                    </div>
                </li>
                <li>
                    <i class="fas fa-search"></i>
                    <div>
                        <strong>Identify the Threat</strong>
                        Analyze emails, messages, and situations to determine if they are safe or malicious.
                    </div>
                </li>
                <li>
                    <i class="fas fa-expand"></i>
                    <div>
                        <strong>Full Screen Mode</strong>
                        The test must be taken in full screen. Exiting full screen may result in automatic submission.
                    </div>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Passing Score</strong>
                        You need a score of 70% or higher to pass this assessment.
                    </div>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Time Limit</strong>
                        You have 10 minutes to complete the assessment.
                    </div>
                </li>
            </ul>

            <div style="text-align: center; margin-top: 40px;">
                <a href="<?= base_url('quiz/start') ?>" class="btn" style="padding: 15px 40px; font-size: 1.1rem;">Start Assessment <i class="fas fa-arrow-right" style="margin-left: 10px;"></i></a>
            </div>
        </div>
    </div>
</body>
</html>