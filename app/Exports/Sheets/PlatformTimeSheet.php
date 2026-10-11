<?php

namespace App\Exports\Sheets;

class PlatformTimeSheet extends BaseSheet
{
    public function title(): string
    {
        return 'Platform time';
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Tiempo total en plataforma'];
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->context->users() as $user) {
            $rows[] = [
                $user->user_id,
                $user->name,
                $this->context->formatSeconds($this->context->platformSeconds((int) $user->id)),
            ];
        }

        return $rows;
    }
}
