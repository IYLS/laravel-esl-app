<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use Generator;

/**
 * Una pestaña del export. Entrega sus filas con un generador para que
 * ExportTracking las escriba al archivo de a una, sin armar la pestaña
 * completa en memoria.
 */
abstract class BaseSheet
{
    protected TrackingExportContext $context;

    public function __construct(TrackingExportContext $context)
    {
        $this->context = $context;
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
