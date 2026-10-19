<?php

namespace App\Exports\Sheets;

use Generator;

class UnitsCompletedSheet extends BaseSheet
{
    public function title(): string
    {
        return 'Units completed';
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Numero de unidades completadas'];
    }

    public function generator(): Generator
    {
        $units = $this->context->units();

        foreach ($this->context->users() as $user) {
            $completed = 0;

            foreach ($units as $unit) {
                if ($this->context->hasCompletedUnit((int) $user->id, $unit)) {
                    $completed++;
                }
            }

            yield [$user->user_id, $user->name, $completed];
        }
    }
}
