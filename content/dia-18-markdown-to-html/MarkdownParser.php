<?php
declare(strict_types=1);

/**
 * Masterclass PHP 8.5 - Day 18
 * Custom Markdown to HTML Parser using Regex
 */
readonly class MarkdownParser {
    
    public function parse(string $text): string {
        // 1. Escapar HTML para evitar XSS (excepto lo que nosotros generemos)
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        // 2. Bloques de código (Triple backticks)
        $text = preg_replace_callback('/```(.*?)```/s', function($matches) {
            return '<pre class="bg-gray-900 text-cyan-300 p-4 rounded-lg my-4 font-mono text-sm overflow-x-auto"><code>' . trim($matches[1]) . '</code></pre>';
        }, $text);

        // 3. Código inline (Single backtick)
        $text = preg_replace('/`(.*?)`/', '<code class="bg-slate-800 text-pink-400 px-1.5 py-0.5 rounded font-mono text-xs">$1</code>', $text);

        // 4. Encabezados (H1, H2, H3)
        $text = preg_replace('/^### (.*?)$/m', '<h3 class="text-xl font-bold text-white mt-6 mb-2">$1</h3>', $text);
        $text = preg_replace('/^## (.*?)$/m', '<h2 class="text-2xl font-black text-white mt-8 mb-4 border-b border-white/5 pb-2">$1</h2>', $text);
        $text = preg_replace('/^# (.*?)$/m', '<h1 class="text-4xl font-black text-white mb-6 tracking-tighter">$1</h1>', $text);

        // 5. Negritas y Cursivas
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong class="text-white font-bold">$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em class="italic opacity-80">$1</em>', $text);

        // 6. Listas (Bullets)
        $text = preg_replace('/^\- (.*?)$/m', '<li class="ml-4 mb-1 list-disc text-slate-400">$1</li>', $text);
        $text = preg_replace('/(<li.*<\/li>)/s', '<ul class="my-4 space-y-1">$1</ul>', $text);

        // 7. Enlaces
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" class="text-cyan-400 hover:underline decoration-cyan-400/30">$1</a>', $text);

        // 8. Párrafos (Convertir saltos de línea dobles en <p>)
        $text = preg_replace('/\n\n/', '</p><p class="mb-4 leading-relaxed text-slate-400">', $text);
        $text = '<p class="mb-4 leading-relaxed text-slate-400">' . $text . '</p>';

        // Limpiar párrafos vacíos o mal cerrados por las listas
        $text = str_replace(['<p></p>', '<p><ul', '</ul></p>'], ['', '<ul', '</ul>'], $text);

        return $text;
    }
}
