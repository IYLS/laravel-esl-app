<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;

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

    public function array(): array
    {
        $rows = [];

        foreach ($this->context->users() as $user) {
            foreach ($this->context->exerciseRows() as $row) {
                $exercise = $row['exercise'];

                foreach ($this->context->attempts((int) $user->id, (int) $exercise->id) as $attempt) {
                    $rows[] = [
                        optional($user->group)->name,
                        $user->name,
                        $user->user_id,
                        $this->context->unitShortLabel($row['unit']),
                        $this->context->stageShortName($row['section']),
                        $this->context->exerciseTitle($exercise),
                        $this->helpOptions($attempt),
                        $this->context->formatSeconds($attempt->time_spent_in_seconds),
                        (int) $attempt->correct_answers,
                        (int) $attempt->intent_number,
                        (int) $attempt->wrong_answers,
                        $this->context->answersForAttempt($attempt, $exercise),
                    ];
                }
            }
        }

        return $rows;
    }

    protected function textColumns(): array
    {
        return [array_search('Respuestas', $this->headings(), true) + 1];
    }

    /**
     * Opciones de ayuda que el estudiante abrió durante el intento.
     */
    private function helpOptions($attempt): string
    {
        $used = [];

        foreach ($attempt->helpUsage as $usage) {
            if ((int) $usage->open_count <= 0) {
                continue;
            }

            $used[] = TrackingExportContext::HELP_TYPES[$usage->help_type] ?? $usage->help_type;
        }

        return implode(', ', array_unique($used));
    }
}
