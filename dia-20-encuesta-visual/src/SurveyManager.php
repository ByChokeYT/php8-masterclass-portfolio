<?php
declare(strict_types=1);

namespace App;

/**
 * Gestor de Encuestas con persistencia MANUAL en archivos .txt
 * (Masterclass Edition: No JSON, No DB)
 */
class SurveyManager {
    private string $filePath;
    private array $options = ['PHP', 'JavaScript', 'Python', 'Go'];

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        $this->initializeFile();
    }

    private function initializeFile(): void {
        if (!file_exists($this->filePath)) {
            $lines = [];
            foreach ($this->options as $opt) {
                $lines[] = "{$opt}:0";
            }
            file_put_contents($this->filePath, implode(PHP_EOL, $lines));
        }
    }

    public function vote(string $option): bool {
        if (!in_array($option, $this->options)) {
            return false;
        }

        $data = $this->getData();
        if (isset($data[$option])) {
            $data[$option]++;
        }
        
        return $this->saveData($data);
    }

    public function getResults(): array {
        $data = $this->getData();
        $total = array_sum($data);
        
        $results = [];
        foreach ($data as $option => $votes) {
            $results[] = [
                'option' => $option,
                'votes' => (int)$votes,
                'percentage' => $total > 0 ? round(($votes / $total) * 100, 1) : 0
            ];
        }

        return [
            'options' => $results,
            'total' => $total
        ];
    }

    private function getData(): array {
        if (!file_exists($this->filePath)) return [];
        
        $content = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = [];
        
        foreach ($content as $line) {
            $parts = explode(':', $line);
            if (count($parts) === 2) {
                $data[$parts[0]] = (int)$parts[1];
            }
        }
        
        // Asegurar que todas las opciones existan
        foreach ($this->options as $opt) {
            if (!isset($data[$opt])) $data[$opt] = 0;
        }

        return $data;
    }

    private function saveData(array $data): bool {
        $lines = [];
        foreach ($data as $opt => $val) {
            $lines[] = "{$opt}:{$val}";
        }
        
        $fp = fopen($this->filePath, 'w');
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, implode(PHP_EOL, $lines));
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
            return true;
        }
        fclose($fp);
        return false;
    }
}
