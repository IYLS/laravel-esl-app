<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use App\Models\User;

/**
 * Veces que el estudiante abrió cada tipo de feedback en cada unidad.
 *
 * La plataforma registra el número de aperturas (tracking_feedback_usage.open_count),
 * no el tiempo que el feedback estuvo abierto.
 */
class FeedbackSheet extends StudentMatrixSheet
{
    /** @var array<string,array<string,int>> Totales ya calculados, por estudiante y unidad. */
    private array $cache = [];

    public function title(): string
    {
        return 'Feedback';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->units() as $unit) {
            $exerciseIds = $unit->sections
                ->flatMap(fn ($section) => $section->exercises->pluck('id'))
                ->all();

            foreach (TrackingExportContext::FEEDBACK_TYPES as $type => $label) {
                $columns[] = [
                    'heading' => sprintf('%s: Feedback: %s', $this->context->unitShortLabel($unit), $label),
                    'type' => $type,
                    'unit_id' => $unit->id,
                    'exercise_ids' => $exerciseIds,
                ];
            }
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        // Los cuatro tipos de feedback de una unidad salen del mismo recorrido.
        $key = $user->id . ':' . $column['unit_id'];

        if (! isset($this->cache[$key])) {
            $this->cache[$key] = $this->context->feedbackTotals((int) $user->id, $column['exercise_ids']);
        }

        return $this->cache[$key][$column['type']] ?? 0;
    }
}
