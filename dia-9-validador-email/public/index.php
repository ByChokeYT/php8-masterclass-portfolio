<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/EmailValidator.php';

use App\Classes\EmailValidator;

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($email) {
        $validator = new EmailValidator($email);
        $result = $validator->analyze();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Validator | PHP 8.5</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --bg: #0d0d0d;
            --term-bg: #1a1a1a;
            --primary: #00ff00; /* Hacker Green */
            --warning: #ffa500;
            --danger: #ff0000;
            --text: #e0e0e0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'JetBrains Mono', monospace;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-image: radial-gradient(circle at 50% 50%, #1a1a1a 0%, #000 100%);
        }

        .terminal-window {
            width: 100%;
            max-width: 600px;
            background-color: var(--term-bg);
            border: 1px solid #333;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
            overflow: hidden;
        }

        .terminal-header {
            background: #2d2d2d;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid #333;
        }

        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .red { background: #ff5f56; }
        .yellow { background: #ffbd2e; }
        .green { background: #27c93f; }
        .title { margin-left: auto; font-size: 0.8rem; color: #888; }

        .terminal-body {
            padding: 2rem;
        }

        h1 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 0 0 5px var(--primary);
        }

        .cursor::after {
            content: '█';
            animation: blink 1s infinite;
            color: var(--primary);
            margin-left: 5px;
        }

        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .prompt {
            color: var(--primary);
            margin-right: 0.5rem;
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid #444;
            color: #fff;
            padding: 0.5rem;
            font-family: inherit;
            font-size: 1rem;
            outline: none;
        }

        input[type="email"]:focus {
            border-bottom-color: var(--primary);
        }

        button {
            background: var(--primary);
            color: #000;
            border: none;
            padding: 0.8rem 1.5rem;
            font-family: inherit;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        button:hover {
            box-shadow: 0 0 15px var(--primary);
            transform: translateY(-1px);
        }

        .result-box {
            margin-top: 2rem;
            border: 1px dashed #444;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.3);
        }

        .result-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #222;
        }

        .result-row:last-child { border-bottom: none; margin-bottom: 0; }
        .label { color: #888; }
        
        .val-true { color: var(--primary); }
        .val-false { color: var(--danger); }

        .status-badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 3px;
            font-weight: bold;
        }

        .status-valid { background: rgba(0, 255, 0, 0.2); color: var(--primary); border: 1px solid var(--primary); }
        .status-warning { background: rgba(255, 165, 0, 0.2); color: var(--warning); border: 1px solid var(--warning); }
        .status-invalid { background: rgba(255, 0, 0, 0.2); color: var(--danger); border: 1px solid var(--danger); }

    </style>
</head>
<body>
<?php
$dayLabel = 'DÍA 09';
$dayTitle = 'Validador de Email';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="terminal-window">
        <div class="terminal-header">
            <div class="dot red"></div>
            <div class="dot yellow"></div>
            <div class="dot green"></div>
            <span class="title">root@server:~/validador</span>
        </div>
        <div class="terminal-body">
            <h1><span class="prompt">$</span>./verify_email.sh<span class="cursor"></span></h1>

            <form method="POST">
                <div class="input-group">
                    <span class="prompt">TARGET >></span>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="user@example.com" 
                        required 
                        autocomplete="off"
                        autofocus
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    >
                </div>
                <button type="submit"> ANALIZAR PROTOCOLOS </button>
            </form>

            <?php if ($result): ?>
                <div class="result-box">
                    <div class="result-row">
                        <span class="label">STATUS:</span>
                        <span class="status-badge status-<?= $result['status'] ?>">
                            <?= $result['icon'] ?> <?= strtoupper($result['message']) ?>
                        </span>
                    </div>
                </div>

                <div class="result-box">
                    <div class="result-row">
                        <span class="label">SYNTAX CHECK:</span>
                        <span class="<?= $result['syntax_valid'] ? 'val-true' : 'val-false' ?>">
                            [<?= $result['syntax_valid'] ? 'PASSED' : 'FAILED' ?>]
                        </span>
                    </div>
                    <?php if ($result['syntax_valid']): ?>
                        <div class="result-row">
                            <span class="label">USER:</span>
                            <span><?= $result['user'] ?></span>
                        </div>
                        <div class="result-row">
                            <span class="label">DOMAIN:</span>
                            <span><?= $result['domain'] ?></span>
                        </div>
                        <div class="result-row">
                            <span class="label">DNS MX RECORDS:</span>
                            <span class="<?= $result['mx_records'] ? 'val-true' : 'val-false' ?>">
                                [<?= $result['mx_records'] ? 'FOUND' : 'MISSING' ?>]
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
