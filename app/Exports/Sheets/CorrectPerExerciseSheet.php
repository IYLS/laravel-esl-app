<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Respuestas correctas en cada ejercicio de comprehension corregible, según el
 * último intento del estudiante.
 */
class CorrectPerExerciseSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Number of correct (exercise)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            if ($this->context->gradableQuestions($row['exercise'])->isEmpty()) {
                continue;
            }

            $columns[] = [
                'heading' => sprintf(
                    '%s: %s',
                    $this->context->unitShortLabel($row['unit']),
                    $this->context->exerciseTitle($row['exercise'])
                ),
                'exercise' => $row['exercise'],
            ];
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        $correct = $this->context->correctAnswersFor((int) $user->id, $column['exercise']);

        return $correct === null ? '' : $correct;
    }
}
