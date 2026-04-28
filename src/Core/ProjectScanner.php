<?php
declare(strict_types=1);

namespace App\Core;

require_once __DIR__ . '/../Data/ProjectRepository.php';

use App\Data\ProjectRepository;
use DirectoryIterator;

class ProjectScanner
{
    private string $contentPath;
    private array $meta;
    private array $phases;

    public function __construct(string $contentPath)
    {
        $this->contentPath = $contentPath;
        $this->meta = ProjectRepository::getMetadata();
        $this->phases = ProjectRepository::getPhases();
    }

    public function getProjects(): array
    {
        $projects = [];
        if (!is_dir($this->contentPath)) return [];

        $iterator = new DirectoryIterator($this->contentPath);
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot() && str_starts_with($fileInfo->getFilename(), 'dia-')) {
                $folderName = $fileInfo->getFilename();
                $projects[] = $this->parseFolder($folderName);
            }
        }

        usort($projects, fn($a, $b) => $a['day'] <=> $b['day']);
        return $projects;
    }

    private function parseFolder(string $folder): array
    {
        $parts = explode('-', $folder);
        $dayNum = (int)($parts[1] ?? 0);
        $rawTitle = implode(' ', array_slice($parts, 2));
        
        $webPath = "/content/{$folder}/index.php";
        if (file_exists($this->contentPath . "/{$folder}/public/index.php")) {
            $webPath = "/content/{$folder}/public/index.php";
        }

        // Determinar fase (1-10: F1, 11-20: F2, etc.)
        $phaseId = (int)ceil($dayNum / 10);
        $phase = $this->phases[$phaseId] ?? $this->phases[1];

        $projectMeta = $this->meta[$dayNum] ?? [
            'desc' => 'Desafío técnico enfocado en patrones de diseño y lógica moderna.',
            'tags' => ['PHP 8.5'],
            'icon' => 'devicon-php-plain'
        ];

        return [
            'id' => $folder,
            'day' => $dayNum,
            'phase_id' => $phaseId,
            'phase' => $phase,
            'title' => ucwords(str_replace('-', ' ', $rawTitle)),
            'description' => $projectMeta['desc'],
            'tags' => $projectMeta['tags'],
            'icon' => $projectMeta['icon'] ?? 'devicon-php-plain',
            'path' => $webPath,
            'category' => $dayNum > 20 ? 'Arquitectura' : 'Laboratorio'
        ];
    }
}
