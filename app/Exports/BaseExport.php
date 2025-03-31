<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class BaseExport
{
    protected $data;
    protected $columns;
    protected $templateFileName;
    protected $fileName;

    public function __construct($data, array $columns = [], $fileName = null, $templateFileName = null)
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->templateFileName = $templateFileName ? public_path('/template-excel/' . $templateFileName . '.xlsx') : null;
        $this->fileName = $fileName ?? 'export_excel_' . date('Ymd') . '.xlsx';
    }

    public function download()
    {
        $spreadsheet = $this->templateFileName
            ? IOFactory::load($this->templateFileName)
            : new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        if ($this->templateFileName) {
            $sheetData = $sheet->toArray();
            $headerRow = $sheetData[0];
            $headerCount = array_reduce($headerRow, fn($carry, $item) => ($item === null || $item === '') ? $carry : $carry + 1, 0);
            $this->fillData($sheet, $headerCount);
        } else {
            $this->fillHeaders($sheet);
            $this->fillData($sheet, count($this->columns));
        }

        return $this->streamResponse($spreadsheet);
    }

    protected function fillData($sheet, $maxIndex)
    {
        $columnIndex = 'A';
        $row = 2;

        foreach ($this->data as $dataRow) {
            $index = 0;
            foreach ($this->columns as $name => $config) {
                if ($index + 1 > $maxIndex) break;

                $keys = explode('|', $config['key']) ?? [strtolower(str_replace(' ', '_', $name))];
                $keyColumn = null;

                foreach ($keys as $key) {
                    if (!empty($dataRow[$key])) {
                        $keyColumn = $key;
                        break;
                    }
                }

                $sheet->setCellValue("{$columnIndex}{$row}", $dataRow[$keyColumn] ?? null);
                $columnIndex++;
                $index++;
            }
            $columnIndex = 'A';  // Reset column index for next row
            $row++;
        }
    }

    protected function fillHeaders($sheet)
    {
        $columnIndex = 'A';
        $totalColumns = count($this->columns);
        $lastColumnIndex = Coordinate::stringFromColumnIndex($totalColumns);
        $lastRow = count($this->data) + 1;

        foreach ($this->columns as $name => $config) {
            $align = $this->getHorizontalAlignment($config['align'] ?? 'left');
            $typeValue = $config['typeValue'] ?? 'text';

            $sheet->setCellValue("{$columnIndex}1", $name);

            $sheet->getStyle("{$columnIndex}1")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => 'CEEED0']
                ],
                'font' => [
                    'color' => ['argb' => '285F17'],
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => $align,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $range = "{$columnIndex}1:{$lastColumnIndex}{$lastRow}";
            $sheet->getStyle($range)->applyFromArray([
                'alignment' => [
                    'horizontal' => $align,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $formatCode = $this->getExcelFormat($typeValue);
            $sheet->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode($formatCode);

            $sheet->getColumnDimension($columnIndex)->setWidth(20);
            $sheet->getStyle($range)->getAlignment()->setWrapText(true);
            $columnIndex++;
        }
    }

    private function getHorizontalAlignment($align)
    {
        return match (strtolower($align)) {
            'center' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'right' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            default => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        };
    }

    private function getExcelFormat($type)
    {
        return match (strtolower($type)) {
            'integer' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER,
            'decimal' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00,
            'date' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY,
            default => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT,
        };
    }

    protected function streamResponse($spreadsheet)
    {
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(
            function () use ($writer, $spreadsheet) {
                $writer->save('php://output');
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $this->fileName . '"',
                'Cache-Control' => 'max-age=0',
            ],
        );
    }
}
