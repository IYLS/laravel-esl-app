<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Tiempo de interacción por stage.
 */
class StagesTimeSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Stages (time of interaction)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->units() as $unit) {
            foreach ($unit->sections as $section) {
                $columns[] = [
                    'heading' => sprintf(
                        '%s: %s',
                        $this->context->unitLongLabel($unit),
                        $this->context->stageShortName($section)
                    ),
                    'exercise_ids' => $section->exercises->pluck('id')->all(),
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
