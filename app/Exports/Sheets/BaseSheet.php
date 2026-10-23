<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use Generator;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Una pestaña del export. Entrega sus filas con un generador para que
 * ExportTracking las escriba al archivo de a una, sin armar la pestaña
 * completa en memoria.
 */
abstract class BaseSheet
{
    /** Límites del ancho calculado a partir del contenido, en caracteres. */
    private const MIN_WIDTH = 12;
    private const MAX_WIDTH = 50;

    /**
     * Lo que aporta el encabezado al ancho: los más largos se envuelven en
     * varias líneas en vez de ensanchar una columna que solo tiene números.
     */
    private const HEADER_WIDTH = 20;

    /** Ancho fijo de las columnas de texto libre, que además se envuelven. */
    private const TEXT_WIDTH = 55;

    private const PADDING = 2;

    protected TrackingExportContext $context;

    public function __construct(TrackingExportContext $context)
    {
        $this->context = $context;
    }

    public function styles(Worksheet $sheet)
    {
        $this->sizeColumns($sheet);

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP],
            ],
        ];
    }

    /**
     * Columnas (índice desde 1) con texto libre, como las respuestas de los
     * estudiantes.
     *
     * @return int[]
     */
    protected function textColumns(): array
    {
        return [];
    }

    private function sizeColumns(Worksheet $sheet): void
    {
        $lastColumn = $sheet->getHighestDataColumn();
        $lastRow = $sheet->getHighestDataRow();
        $textColumns = $this->textColumns();

        $headings = $sheet->rangeToArray("A1:{$lastColumn}1", null, false, false)[0];
        $rows = $lastRow > 1
            ? $sheet->rangeToArray("A2:{$lastColumn}{$lastRow}", null, false, false)
            : [];

        foreach ($headings as $offset => $heading) {
            $letter = Coordinate::stringFromColumnIndex($offset + 1);

            if (in_array($offset + 1, $textColumns, true)) {
                $sheet->getColumnDimension($letter)->setWidth(self::TEXT_WIDTH);

                if ($lastRow > 1) {
                    $sheet->getStyle("{$letter}2:{$letter}{$lastRow}")->getAlignment()->setWrapText(true);
                }

                continue;
            }

            $width = min(mb_strlen((string) $heading), self::HEADER_WIDTH);

            foreach ($rows as $row) {
                $width = max($width, mb_strlen((string) $row[$offset]));
            }

            $width = max(self::MIN_WIDTH, min(self::MAX_WIDTH, $width + self::PADDING));

            $sheet->getColumnDimension($letter)->setWidth($width);
        }
    }

    abstract public function title(): string;

    /**
     * Fila de cabecera (se escribe en negrita).
     */
    abstract public function headings(): array;

    /**
     * Filas de datos, una por iteración.
     */
    abstract public function generator(): Generator;
}
