<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cyber Security Awareness Quiz</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background: #f4f6f9; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .meta { margin-bottom: 20px; color: #666; }
        .response-item { border-bottom: 1px solid #eee; padding: 15px 0; }
        .question { font-weight: bold; margin-bottom: 5px; color: #333; }
        .answer { margin-bottom: 5px; }
        .correct { color: green; font-weight: bold; }
        .incorrect { color: red; font-weight: bold; }
        .btn-back { display: inline-block; margin-top: 20px; text-decoration: none; background: #2c3e50; color: white; padding: 10px 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Result Details: <?= esc($result['full_name']) ?></h1>
        <div class="meta">
            <strong>Email:</strong> <?= esc($result['email']) ?> | 
            <strong>Score:</strong> <?= esc($result['score']) ?>% | 
            <strong>Status:</strong> <?= esc($result['status']) ?>
        </div>

        <?php 
        $responses = json_decode($result['responses'], true);
        if ($responses): 
            foreach($responses as $idx => $resp): 
        ?>
            <div class="response-item">
                <div class="question"><?= esc($resp['q'] ?? ($idx + 1)) ?>. <?= esc($resp['text'] ?? $resp['question'] ?? 'Question Text Missing') ?></div>
                <div class="answer">
                    User Answer: <span class="<?= ($resp['correct'] ?? $resp['is_correct'] ?? false) ? 'correct' : 'incorrect' ?>">
                        <?= esc($resp['userAnswer'] ?? $resp['selected'] ?? 'N/A') ?>
                    </span>
                </div>
                <?php if(!($resp['correct'] ?? $resp['is_correct'] ?? false)): ?>
                    <div class="answer" style="color:green;">
                        Correct Answer: <?= esc($resp['correctAnswer'] ?? $resp['correct_answer'] ?? 'N/A') ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php 
            endforeach; 
        else: 
        ?>
            <p>No detailed responses recorded for this user.</p>
        <?php endif; ?>

        <a href="<?= base_url('dashboard') ?>" class="btn-back">Back to Dashboard</a>
    </div>
</body>
</html>
