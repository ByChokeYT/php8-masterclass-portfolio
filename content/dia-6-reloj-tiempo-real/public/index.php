<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reloj & Clima Oruro | PHP 8.5</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --primary: #4F5B93;
            --primary-light: #8892BF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .container {
            max-width: 500px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .header h1 {
            font-size: 1.3rem;
            color: var(--primary-light);
            margin-bottom: 0.3rem;
            letter-spacing: 1px;
        }

        .header p {
            color: #8892BF;
            font-size: 0.75rem;
        }

        .clock-card {
            background: rgba(79, 91, 147, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 0 30px rgba(79, 91, 147, 0.3);
            margin-bottom: 1rem;
        }

        .time {
            font-family: 'Orbitron', monospace;
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--primary-light);
            text-shadow: 0 0 20px rgba(136, 146, 191, 0.8);
            letter-spacing: 0.1em;
            text-align: center;
            animation: glow 2s ease-in-out infinite;
        }

        .date {
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(136, 146, 191, 0.3);
            font-size: 1rem;
            color: #fff;
        }

        .day {
            text-align: center;
            font-size: 0.85rem;
            color: var(--primary-light);
            margin-top: 0.3rem;
        }

        .weather-card {
            background: rgba(79, 91, 147, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 0 30px rgba(79, 91, 147, 0.3);
        }

        .weather-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .weather-header i {
            font-size: 1.5rem;
            color: var(--primary-light);
        }

        .weather-header h2 {
            font-size: 1.1rem;
            color: var(--primary-light);
        }

        .weather-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .temp-display {
            font-family: 'Orbitron', monospace;
            font-size: 3rem;
            font-weight: 900;
            color: #fff;
        }

        .weather-icon {
            font-size: 4rem;
        }

        .weather-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .detail-item {
            background: rgba(136, 146, 191, 0.1);
            border-radius: 8px;
            padding: 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-item i {
            font-size: 1.2rem;
            color: var(--primary-light);
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.7rem;
            color: #8892BF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
        }

        @keyframes glow {
            0%, 100% { 
                text-shadow: 0 0 20px rgba(136, 146, 191, 0.8);
            }
            50% { 
                text-shadow: 0 0 30px rgba(136, 146, 191, 1);
            }
        }

        .loading {
            text-align: center;
            color: #8892BF;
            font-size: 0.9rem;
            padding: 1rem;
        }
    </style>
</head>
<body>
<?php
$dayLabel = 'DÍA 06';
$dayTitle = 'Reloj en Tiempo Real';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>

<div class="container">
    <div class="header">
        <h1>⏰ RELOJ & CLIMA</h1>
        <p>Oruro, Bolivia • PHP 8.5</p>
    </div>

    <div class="clock-card">
        <div class="time" id="clock">--:--:--</div>
        <div class="date" id="date">--</div>
        <div class="day" id="day">--</div>
    </div>

    <div class="weather-card">
        <div class="weather-header">
            <i class="ph-fill ph-cloud-sun"></i>
            <h2>Clima en Oruro</h2>
        </div>
        
        <div id="weather-content" class="loading">
            Cargando datos del clima...
        </div>
    </div>
</div>

<script>
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

    // Actualizar reloj
    function actualizarReloj() {
        const ahora = new Date();
        
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        
        document.getElementById('clock').textContent = `${horas}:${minutos}:${segundos}`;
        
        const dia = ahora.getDate();
        const mes = meses[ahora.getMonth()];
        const año = ahora.getFullYear();
        const diaSemana = dias[ahora.getDay()];
        
        document.getElementById('date').textContent = `${dia} de ${mes} de ${año}`;
        document.getElementById('day').textContent = diaSemana;
    }

    // Obtener clima de Oruro
    async function obtenerClima() {
        try {
            // Usando Open-Meteo API (gratuita, sin API key)
            // Coordenadas de Oruro: -17.9833, -67.1167
            const response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-17.9833&longitude=-67.1167&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code&timezone=America/La_Paz');
            const data = await response.json();
            
            const temp = Math.round(data.current.temperature_2m);
            const humidity = data.current.relative_humidity_2m;
            const windSpeed = Math.round(data.current.wind_speed_10m);
            const weatherCode = data.current.weather_code;
            
            // Iconos según código del clima
            const weatherIcons = {
                0: '☀️', 1: '🌤️', 2: '⛅', 3: '☁️',
                45: '🌫️', 48: '🌫️',
                51: '🌦️', 53: '🌦️', 55: '🌧️',
                61: '🌧️', 63: '🌧️', 65: '🌧️',
                71: '🌨️', 73: '🌨️', 75: '🌨️',
                80: '🌦️', 81: '🌧️', 82: '⛈️',
                95: '⛈️', 96: '⛈️', 99: '⛈️'
            };
            
            const icon = weatherIcons[weatherCode] || '🌡️';
            
            document.getElementById('weather-content').innerHTML = `
                <div class="weather-main">
                    <div class="temp-display">${temp}°C</div>
                    <div class="weather-icon">${icon}</div>
                </div>
                <div class="weather-details">
                    <div class="detail-item">
                        <i class="ph-fill ph-thermometer"></i>
                        <div class="detail-content">
                            <div class="detail-label">Temperatura</div>
                            <div class="detail-value">${temp}°C</div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="ph-fill ph-drop"></i>
                        <div class="detail-content">
                            <div class="detail-label">Humedad</div>
                            <div class="detail-value">${humidity}%</div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="ph-fill ph-wind"></i>
                        <div class="detail-content">
                            <div class="detail-label">Viento</div>
                            <div class="detail-value">${windSpeed} km/h</div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="ph-fill ph-map-pin"></i>
                        <div class="detail-content">
                            <div class="detail-label">Ubicación</div>
                            <div class="detail-value">Oruro</div>
                        </div>
                    </div>
                </div>
            `;
        } catch (error) {
            document.getElementById('weather-content').innerHTML = `
                <div style="text-align: center; color: #ff6b6b;">
                    <i class="ph ph-warning" style="font-size: 2rem;"></i>
                    <p style="margin-top: 0.5rem;">No se pudo cargar el clima</p>
                </div>
            `;
        }
    }

    // Inicializar
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
    
    obtenerClima();
    // Actualizar clima cada 10 minutos
    setInterval(obtenerClima, 600000);
</script>

</body>
</html>
