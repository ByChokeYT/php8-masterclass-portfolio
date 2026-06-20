<?php
declare(strict_types=1);

namespace App;

class TemplateEngine
{
    private string $templateDir;

    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function render(string $templateFile, array $data): string
    {
        $path = $this->templateDir . '/' . $templateFile;
        if (!file_exists($path)) {
            throw new \Exception("Plantilla no encontrada: {$templateFile}");
        }

        $content = file_get_contents($path);

        // Reemplazar marcadores estilo {{ variable }}
        foreach ($data as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', (string)$value, $content);
            $content = str_replace('{{' . $key . '}}', (string)$value, $content);
        }

        return $content;
    }
}
