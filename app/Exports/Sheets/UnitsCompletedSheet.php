<?php

namespace App\Exports\Sheets;

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

    public function array(): array
    {
        $units = $this->context->units();
        $rows = [];

        foreach ($this->context->users() as $user) {
            $completed = 0;

            foreach ($units as $unit) {
                if ($this->context->hasCompletedUnit((int) $user->id, $unit)) {
                    $completed++;
                }
            }

            $rows[] = [$user->user_id, $user->name, $completed];
        }

        return $rows;
    }
}
