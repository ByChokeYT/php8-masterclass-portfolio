<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Classes/TextAnalyzer.php';

use App\Classes\TextAnalyzer;

echo "\033[1;36mTEXT ENGINE — CLI EDITION\033[0m\n";
echo "==============================================\n\n";

$text = "PHP 8.5 es el lenguaje del desarrollo web moderno. ¡Programar con Tipado Estricto es asombroso!";

echo "Analizando texto: \033[1;37m\"$text\"\033[0m\n\n";

$analyzer = new TextAnalyzer($text);
$results = $analyzer->analyze();

echo "\033[1;33mESTADÍSTICAS DEL TEXTO:\033[0m\n";
echo "----------------------------------------------\n";
printf("Total Caracteres : \033[1;37m%d\033[0m\n", $results['char_count']);
printf("Total Palabras    : \033[1;37m%d\033[0m\n", $results['word_count']);
printf("Tiempo de Lectura : \033[1;32m%s seg\033[0m\n", $results['read_time']);

echo "\n\033[1;35mDENSIDAD DE PALABRAS:\033[0m\n";
echo "----------------------------------------------\n";
foreach ($results['keywords'] as $word => $count) {
    $percent = ($count / $results['word_count']) * 100;
    printf("%-15s | %d (%d%%)\n", $word, $count, $percent);
}

echo "----------------------------------------------\n";
echo "\033[1;37mPROCESAMIENTO MULTIBYTE (mbstring): \033[1;32mACTIVO\033[0m\n";
echo "==============================================\n";
