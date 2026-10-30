<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Intentos incorrectos por pregunta, en los ejercicios de comprehension que la
 * plataforma corrige sola.
 */
class IncorrectPerQuestionSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Number of incorrect (question)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            if (! $this->context->isGradableComprehension($row['exercise'])) {
                continue;
            }

            foreach ($this->context->gradableQuestions($row['exercise']) as $question) {
                $columns[] = [
                    'heading' => $this->context->questionLabel($row, $question),
                    'exercise' => $row['exercise'],
                    'question' => $question,
                ];
            }
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        return $this->context->incorrectAttemptsForQuestion(
            (int) $user->id,
            $column['exercise'],
            $column['question']
        );
    }
}
