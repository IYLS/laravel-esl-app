<?php

namespace App\Exports\Sheets;

use Generator;

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

    public function generator(): Generator
    {
        foreach ($this->context->users() as $user) {
            yield [
                $user->user_id,
                $user->name,
                $this->context->formatSeconds($this->context->platformSeconds((int) $user->id)),
            ];
        }
    }
}
