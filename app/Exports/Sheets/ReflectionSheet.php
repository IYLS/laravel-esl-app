<?php

namespace App\Exports\Sheets;

use App\Models\User;

/**
 * Respuestas del estudiante a los ejercicios del Reflection stage.
 */
class ReflectionSheet extends StudentMatrixSheet
{
    public function title(): string
    {
        return 'Reflection';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->exerciseRows() as $row) {
            if (! $this->context->isReflectionStage($row['section'])) {
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
        return $this->context->answersFor((int) $user->id, $column['exercise']);
    }
}
