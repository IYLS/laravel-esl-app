<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Tiempo total de interacción por unidad.
 */
class UnitTimeSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Unit (time)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->units() as $unit) {
            $columns[] = [
                'heading' => $this->context->unitShortLabel($unit),
                'exercise_ids' => $unit->sections
                    ->flatMap(fn ($section) => $section->exercises->pluck('id'))
                    ->all(),
            ];
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
