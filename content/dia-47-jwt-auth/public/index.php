<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/JWT.php';

use App\JWT;

$jwtHelper = new JWT("secreto_super_seguro_bychoke");

$tokenGenerated = '';
$verificationResult = '';
$usernameInput = $_POST['username'] ?? 'bychoke_dev';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_generate'])) {
        $payload = [
            'sub' => $usernameInput,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 3600 // Expira en 1 hora
        ];
        $tokenGenerated = $jwtHelper->generate($payload);
    }
}

$tokenVerifyInput = $_POST['token_to_verify'] ?? '';
if ($tokenVerifyInput !== '') {
    $decoded = $jwtHelper->validate($tokenVerifyInput);
    if ($decoded) {
        $verificationResult = "✅ Autorizado. Usuario: " . htmlspecialchars($decoded['sub']) . " (Rol: " . htmlspecialchars($decoded['role']) . ")";
    } else {
        $verificationResult = "❌ Denegado: Token inválido, modificado o expirado.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador y Validador JWT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
        <h1 class="text-2xl font-black mb-2 text-slate-800">Generador & Validador de JWT</h1>
        <p class="text-slate-500 mb-6 text-sm">Crea un JSON Web Token y verifícalo. Intenta modificar una sola letra del token generado y observa cómo la firma criptográfica lo rechaza de inmediato.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Generación -->
            <div class="p-6 bg-slate-50 rounded-xl border border-slate-200">
                <h2 class="text-sm font-bold text-slate-700 uppercase mb-4">1. Generar Token</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-slate-700 text-xs font-bold mb-2">Nombre de Usuario (Claim 'sub')</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($usernameInput) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 text-xs focus:outline-none">
                    </div>
                    <button type="submit" name="action_generate" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-xs transition-colors">
                        Generar JWT
                    </button>
                </form>

                <?php if ($tokenGenerated): ?>
                    <div class="mt-4">
                        <label class="block text-slate-700 text-xs font-bold mb-2">Token Generado (Copia esto):</label>
                        <textarea class="w-full h-24 p-2 font-mono text-[10px] bg-white border border-slate-300 rounded resize-none" readonly><?= $tokenGenerated ?></textarea>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Validación -->
            <div class="p-6 bg-slate-50 rounded-xl border border-slate-200">
                <h2 class="text-sm font-bold text-slate-700 uppercase mb-4">2. Validar Token en API</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-slate-700 text-xs font-bold mb-2">Pegar Token a Enviar</label>
                        <textarea name="token_to_verify" class="w-full h-24 p-2 font-mono text-[10px] bg-white border border-slate-300 rounded resize-none"><?= htmlspecialchars($tokenVerifyInput ?: $tokenGenerated) ?></textarea>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded text-xs transition-colors">
                        Enviar a Recurso Protegido
                    </button>
                </form>

                <?php if ($verificationResult): ?>
                    <div class="mt-4 p-3 rounded text-xs font-bold <?= str_contains($verificationResult, 'Denegado') ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' ?>">
                        <?= htmlspecialchars($verificationResult) ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>
</html>
