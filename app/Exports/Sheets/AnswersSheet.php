<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Respuestas del estudiante a los ejercicios sin respuesta correcta
 * (metacognition, engagement y en general todo lo que la plataforma no corrige),
 * en todos los stages.
 */
class AnswersSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Answers';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            if (! $this->context->isOpenAnswer($row['exercise'])) {
                continue;
            }

            // Voice recognition no guarda respuestas.
            if (! $this->context->countsTowardsCompletion($row['exercise'])) {
                continue;
            }

            $columns[] = [
                'heading' => sprintf(
                    '%s %s: %s',
                    $this->context->unitShortLabel($row['unit']),
                    $this->context->stageShortLabel($row['section']),
                    $this->context->exerciseTitle($row['exercise'])
                ),
                'exercise' => $row['exercise'],
            ];
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        return $this->context->answersFor((int) $user->id, $column['exercise']);
    }
}
