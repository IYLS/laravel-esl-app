<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Cuántos ejercicios completó el estudiante en cada stage.
 */
class StagesCompletedExercisesSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Stages (completed exercises)';
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
                    // Voice recognition no cuenta para el avance.
                    'exercise_ids' => $section->exercises
                        ->filter(fn ($exercise) => $this->context->countsTowardsCompletion($exercise))
                        ->pluck('id')
                        ->all(),
                ];
            }
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        $completed = 0;

        foreach ($column['exercise_ids'] as $exerciseId) {
            if ($this->context->hasCompleted((int) $user->id, (int) $exerciseId)) {
                $completed++;
            }
        }

        return $completed;
    }
}
