<?php

namespace App\Exports\Sheets;

use App\Exports\ExportAttempt;
use App\Exports\TrackingExportContext;
use Generator;

/**
 * Detalle en bruto: una fila por cada intento registrado, con todas las
 * dimensiones (colegio, estudiante, unidad, stage y ejercicio) en columnas.
 */
class RawDataSheet extends BaseSheet
{
    public function title(): string
    {
        return 'Datos completos';
    }

    public function headings(): array
    {
        return [
            'Colegio',
            'Estudiante',
            'ID',
            'Unidad',
            'Stage',
            'Ejercicio',
            'Opciones de ayudas',
            'Tiempo',
            'Correctas',
            'Number tries',
            'Incorrectas',
            'Respuestas',
        ];
    }

    public function generator(): Generator
    {
        foreach ($this->context->users() as $user) {
            foreach ($this->context->exerciseRows() as $row) {
                $exercise = $row['exercise'];

                foreach ($this->context->attempts((int) $user->id, (int) $exercise->id) as $attempt) {
                    yield [
                        optional($user->group)->name,
                        $user->name,
                        $user->user_id,
                        $this->context->unitShortLabel($row['unit']),
                        $this->context->stageShortName($row['section']),
                        $this->context->exerciseTitle($exercise),
                        $this->helpOptions($attempt),
                        $this->context->formatSeconds($attempt->timeSpentSeconds),
                        $attempt->correctAnswers,
                        $attempt->intentNumber,
                        $attempt->wrongAnswers,
                        $this->context->answersForAttempt($attempt, $exercise),
                    ];
                }
            }
        }
    }

    protected function textColumns(): array
    {
        return [array_search('Respuestas', $this->headings(), true) + 1];
    }

    /**
     * Opciones de ayuda que el estudiante abrió durante el intento.
     */
    private function helpOptions(ExportAttempt $attempt): string
    {
        $used = [];

        foreach ($attempt->helpUsage as $helpType => $usage) {
            if ($usage['count'] <= 0) {
                continue;
            }

            $used[] = TrackingExportContext::HELP_TYPES[$helpType] ?? $helpType;
        }

        return implode(', ', array_unique($used));
    }
}
