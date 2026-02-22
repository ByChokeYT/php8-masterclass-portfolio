<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analizador de Texto | PHP 8.5</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --primary: #4F5B93;
            --primary-light: #8892BF;
            --bg: #F8F9FC;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, #E2E4F3 100%);
            color: #232531;
            min-height: 100vh;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1100px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .header h1 {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .header p {
            color: #64748b;
            font-size: 0.75rem;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 1rem;
            height: calc(100vh - 120px);
        }

        .input-section {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 20px rgba(79, 91, 147, 0.1);
            display: flex;
            flex-direction: column;
        }

        .input-section label {
            display: block;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        textarea {
            width: 100%;
            flex: 1;
            padding: 0.8rem;
            border: 2px solid #E2E4F3;
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            resize: none;
            transition: all 0.3s;
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 91, 147, 0.1);
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
            align-content: start;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 0.9rem;
            box-shadow: 0 4px 20px rgba(79, 91, 147, 0.1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.1rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            textarea {
                min-height: 200px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="ph-duotone ph-text-aa"></i> Analizador de Texto</h1>
        <p>Cuenta palabras, caracteres y más • PHP 8.5</p>
    </div>

    <div class="main-grid">
        <div class="input-section">
            <label for="text">Escribe o pega tu texto aquí:</label>
            <textarea 
                id="text" 
                placeholder="Comienza a escribir para ver el análisis en tiempo real..."
                oninput="analyzeText()"
            ></textarea>
        </div>

        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-text-t"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Palabras</div>
                    <div class="stat-value" id="words">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-text-aa"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Caracteres</div>
                    <div class="stat-value" id="characters">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-text-align-left"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Sin espacios</div>
                    <div class="stat-value" id="charactersNoSpaces">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-paragraph"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Oraciones</div>
                    <div class="stat-value" id="sentences">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-article"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Párrafos</div>
                    <div class="stat-value" id="paragraphs">0</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ph-fill ph-chart-bar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Promedio letras/palabra</div>
                    <div class="stat-value" id="avgWordLength">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function analyzeText() {
        const text = document.getElementById('text').value;
        
        // Contar palabras
        const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
        
        // Contar caracteres
        const characters = text.length;
        const charactersNoSpaces = text.replace(/\s/g, '').length;
        
        // Contar oraciones
        const sentences = text.trim() === '' ? 0 : (text.match(/[.!?]+/g) || []).length;
        
        // Contar párrafos
        const paragraphs = text.trim() === '' ? 0 : text.split(/\n\s*\n/).filter(p => p.trim() !== '').length;
        
        // Promedio de longitud de palabra
        const avgWordLength = words === 0 ? 0 : (charactersNoSpaces / words).toFixed(2);
        
        // Actualizar UI
        document.getElementById('words').textContent = words.toLocaleString();
        document.getElementById('characters').textContent = characters.toLocaleString();
        document.getElementById('charactersNoSpaces').textContent = charactersNoSpaces.toLocaleString();
        document.getElementById('sentences').textContent = sentences.toLocaleString();
        document.getElementById('paragraphs').textContent = paragraphs.toLocaleString();
        document.getElementById('avgWordLength').textContent = avgWordLength;
    }
</script>

</body>
</html>
