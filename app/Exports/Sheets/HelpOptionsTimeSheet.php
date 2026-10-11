<?php

namespace App\Exports\Sheets;

use App\Exports\TrackingExportContext;
use App\Models\User;

/**
 * Tiempo que el estudiante tuvo abierta cada opción de ayuda en cada unidad.
 */
class HelpOptionsTimeSheet extends StudentMatrixSheet
{
    /** @var array<string,array<string,array{count:int,seconds:int}>> */
    private array $cache = [];

    public function title(): string
    {
        return 'Help options (time)';
    }

    protected function columns(): array
    {
        $columns = [];

        foreach ($this->context->units() as $unit) {
            $exerciseIds = $unit->sections
                ->flatMap(fn ($section) => $section->exercises->pluck('id'))
                ->all();

            foreach (TrackingExportContext::HELP_TYPES as $helpType => $label) {
                $columns[] = [
                    'heading' => sprintf('%s: %s Time Spent', $this->context->unitShortLabel($unit), $label),
                    'help_type' => $helpType,
                    'unit_id' => $unit->id,
                    'exercise_ids' => $exerciseIds,
                ];
            }
        }

        return $columns;
    }

    protected function value(User $user, array $column)
    {
        $key = $user->id . ':' . $column['unit_id'];

        if (! isset($this->cache[$key])) {
            $this->cache[$key] = $this->context->helpUsageTotals((int) $user->id, $column['exercise_ids']);
        }

        return $this->context->formatSeconds($this->cache[$key][$column['help_type']]['seconds'] ?? 0);
    }
}
