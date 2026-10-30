<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use App\Models\User;

/**
 * Tiempo de interacción por categoría de ejercicio (comprehension,
 * metacognition y engagement) en cada unidad.
 */
class ExerciseCategoryTimeSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Type of exercises (time)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->units() as $unit) {
            foreach (TrackingExportContext::CATEGORIES as $category => $label) {
                $columns[] = [
                    'heading' => sprintf('%s: %s', $this->context->unitShortLabel($unit), $label),
                    'exercise_ids' => $unit->sections
                        ->flatMap(fn ($section) => $section->exercises)
                        ->filter(fn ($exercise) => mb_strtolower((string) $exercise->category) === $category)
                        ->pluck('id')
                        ->all(),
                ];
            }
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        return $this->context->formatSeconds(
            $this->context->secondsForExercises((int) $user->id, $column['exercise_ids'])
        );
    }
}
