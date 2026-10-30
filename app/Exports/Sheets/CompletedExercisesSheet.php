<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Si el estudiante completó o no cada ejercicio del currículum.
 */
class CompletedExercisesSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Completed exercises';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            if (! $this->context->countsTowardsCompletion($row['exercise'])) {
                continue;
            }

            $columns[] = [
                'heading' => sprintf(
                    '%s - %s - %s',
                    $this->context->unitShortLabel($row['unit']),
                    $this->context->stageFullName($row['section']),
                    $this->context->exerciseTitle($row['exercise'])
                ),
                'exercise_id' => $row['exercise']->id,
            ];
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        return $this->context->hasCompleted((int) $user->id, (int) $column['exercise_id']) ? 'Yes' : 'No';
    }
}
