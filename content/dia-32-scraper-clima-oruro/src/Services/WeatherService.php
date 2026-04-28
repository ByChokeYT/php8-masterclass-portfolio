<?php
declare(strict_types=1);

namespace App\Services;

readonly class WeatherService {
    private string $apiUrl;

    public function __construct() {
        // Oruro, Bolivia: -17.9647, -67.106
        $this->apiUrl = "https://api.open-meteo.com/v1/forecast?latitude=-17.9647&longitude=-67.106&current=temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,rain,showers,snowfall,weather_code,cloud_cover,pressure_msl,surface_pressure,wind_speed_10m,wind_direction_10m,wind_gusts_10m&timezone=auto";
    }

    public function getOruroWeather(): array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ByChoke Masterclass/1.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            throw new \Exception("No se pudo obtener el clima de Oruro. Status: " . $httpCode);
        }

        $data = json_decode((string)$response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error al procesar los datos del clima.");
        }

        return $data;
    }

    public function getWeatherDescription(int $code): array {
        // WMO Weather interpretation codes (WW)
        // https://open-meteo.com/en/docs
        $codes = [
            0 => ['label' => 'Cielo Despejado', 'icon' => 'ph-sun'],
            1 => ['label' => 'Principalmente Despejado', 'icon' => 'ph-sun-horizon'],
            2 => ['label' => 'Parcialmente Nublado', 'icon' => 'ph-cloud-sun'],
            3 => ['label' => 'Nublado', 'icon' => 'ph-cloud'],
            45 => ['label' => 'Niebla', 'icon' => 'ph-cloud-fog'],
            48 => ['label' => 'Niebla con Rima', 'icon' => 'ph-cloud-fog'],
            51 => ['label' => 'Llovizna Ligera', 'icon' => 'ph-cloud-rain'],
            53 => ['label' => 'Llovizna Moderada', 'icon' => 'ph-cloud-rain'],
            55 => ['label' => 'Llovizna Densa', 'icon' => 'ph-cloud-rain'],
            61 => ['label' => 'Lluvia Ligera', 'icon' => 'ph-cloud-rain'],
            63 => ['label' => 'Lluvia Moderada', 'icon' => 'ph-cloud-rain'],
            65 => ['label' => 'Lluvia Fuerte', 'icon' => 'ph-cloud-rain'],
            71 => ['label' => 'Nieve Ligera', 'icon' => 'ph-cloud-snow'],
            73 => ['label' => 'Nieve Moderada', 'icon' => 'ph-cloud-snow'],
            75 => ['label' => 'Nieve Fuerte', 'icon' => 'ph-cloud-snow'],
            77 => ['label' => 'Granizo', 'icon' => 'ph-cloud-snow'],
            80 => ['label' => 'Chubascos Ligeros', 'icon' => 'ph-cloud-rain'],
            81 => ['label' => 'Chubascos Moderados', 'icon' => 'ph-cloud-rain'],
            82 => ['label' => 'Chubascos Violentos', 'icon' => 'ph-cloud-rain'],
            95 => ['label' => 'Tormenta Eléctrica', 'icon' => 'ph-cloud-lightning'],
            96 => ['label' => 'Tormenta con Granizo', 'icon' => 'ph-cloud-lightning'],
            99 => ['label' => 'Tormenta Fuerte con Granizo', 'icon' => 'ph-cloud-lightning'],
        ];

        return $codes[$code] ?? ['label' => 'Desconocido', 'icon' => 'ph-question'];
    }
}
