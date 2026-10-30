<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Número de intentos del estudiante en cada ejercicio.
 */
class TriesPerExerciseSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Number of tries per exercise';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            $columns[] = [
                'heading' => sprintf(
                    '%s - %s - %s%s',
                    $this->context->unitShortLabel($row['unit']),
                    $this->context->stageShortLabel($row['section']),
                    $this->context->exerciseTitle($row['exercise']),
                    $this->context->categorySuffix($row['exercise'])
                ),
                'exercise_id' => $row['exercise']->id,
            ];
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        return count($this->context->attempts((int) $user->id, (int) $column['exercise_id']));
    }
}
