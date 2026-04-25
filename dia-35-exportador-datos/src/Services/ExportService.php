<?php
declare(strict_types=1);

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExportService {
    public function export(array $data, string $format, string $filename = 'reporte'): void {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (empty($data)) {
            throw new \Exception("No hay datos para exportar.");
        }

        // Estilo de encabezados
        $headers = array_keys($data[0]);
        foreach ($headers as $col => $header) {
            $cell = $sheet->getCell([$col + 1, 1]);
            $cell->setValue($header);
            
            // Aplicar formato básico a la cabecera si es XLSX
            if ($format === 'xlsx') {
                $sheet->getStyle([$col + 1, 1])->getFont()->setBold(true);
                $sheet->getColumnDimensionByColumn($col + 1)->setAutoSize(true);
            }
        }

        // Datos
        foreach ($data as $rowIdx => $row) {
            $colIdx = 1;
            foreach ($row as $value) {
                $sheet->setCellValueExplicit([$colIdx, $rowIdx + 2], (string)$value, DataType::TYPE_STRING);
                $colIdx++;
            }
        }

        // Sanitizar nombre de archivo
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
        $finalName = "{$filename}_" . date('Ymd');

        // Configurar Headers de descarga
        if ($format === 'xlsx') {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$finalName.'.xlsx"');
            $writer = new Xlsx($spreadsheet);
        } else {
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment;filename="'.$finalName.'.csv"');
            echo "\xEF\xBB\xBF"; // UTF-8 BOM para que Excel reconozca tildes en CSV
            $writer = new Csv($spreadsheet);
        }

        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
