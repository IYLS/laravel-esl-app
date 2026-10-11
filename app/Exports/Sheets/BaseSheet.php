<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * WithStrictNullComparison es necesario para que los ceros se escriban como 0
 * y no queden como celdas vacías.
 */
abstract class BaseSheet implements FromArray, WithHeadings, WithStrictNullComparison, WithStyles, WithTitle
{
    protected TrackingExportContext $context;

    public function __construct(TrackingExportContext $context)
    {
        $this->context = $context;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
