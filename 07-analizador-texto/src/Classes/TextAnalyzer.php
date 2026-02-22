<?php
declare(strict_types=1);

namespace App\Classes;

class TextAnalyzer {
    public function __construct(
        private string $text
    ) {}

    public function countWords(): int {
        $text = trim($this->text);
        if (empty($text)) return 0;
        
        return str_word_count($text);
    }

    public function countCharacters(bool $withSpaces = true): int {
        if ($withSpaces) {
            return mb_strlen($this->text);
        }
        return mb_strlen(str_replace(' ', '', $this->text));
    }

    public function countSentences(): int {
        $text = trim($this->text);
        if (empty($text)) return 0;
        
        return preg_match_all('/[.!?]+/', $text);
    }

    public function countParagraphs(): int {
        $text = trim($this->text);
        if (empty($text)) return 0;
        
        $paragraphs = preg_split('/\n\s*\n/', $text);
        return count(array_filter($paragraphs, fn($p) => !empty(trim($p))));
    }

    public function averageWordLength(): float {
        $words = $this->countWords();
        if ($words === 0) return 0;
        
        $chars = $this->countCharacters(false);
        return round($chars / $words, 2);
    }

    public function getAnalysis(): array {
        return [
            'words' => $this->countWords(),
            'characters' => $this->countCharacters(true),
            'characters_no_spaces' => $this->countCharacters(false),
            'sentences' => $this->countSentences(),
            'paragraphs' => $this->countParagraphs(),
            'avg_word_length' => $this->averageWordLength(),
        ];
    }
}
