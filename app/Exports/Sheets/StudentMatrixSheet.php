<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Generator;

/**
 * Pestaña con un estudiante por fila y una columna por indicador, que es la
 * forma que tienen casi todas las pestañas del archivo de referencia.
 */
abstract class StudentMatrixSheet extends BaseSheet
{
    /** @var array<int,array<string,mixed>>|null */
    private ?array $resolvedColumns = null;

    /**
     * Descriptores de columna. Cada uno debe traer al menos 'heading', y
     * además lo que necesite value() para calcular la celda.
     *
     * @return array<int,array<string,mixed>>
     */
    abstract protected function columns(): array;

    /**
     * Valor de la celda para un estudiante y una columna.
     *
     * @param  array<string,mixed>  $column
     * @return mixed
     */
    abstract protected function value(User $user, array $column);

    public function headings(): array
    {
        return array_merge(['ID', 'Nombre'], array_column($this->resolvedColumns(), 'heading'));
    }

    public function generator(): Generator
    {
        $columns = $this->resolvedColumns();

        foreach ($this->context->users() as $user) {
            $row = [$user->user_id, $user->name];

            foreach ($columns as $column) {
                $row[] = $this->value($user, $column);
            }

            yield $row;
        }
    }

    /**
     * Índices (desde 1) de las columnas de indicadores, sin ID ni Nombre.
     *
     * @return int[]
     */
    protected function valueColumnIndexes(): array
    {
        return array_map(fn (int $offset) => $offset + 3, array_keys($this->resolvedColumns()));
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    protected function resolvedColumns(): array
    {
        if ($this->resolvedColumns === null) {
            $this->resolvedColumns = $this->columns();
        }

        return $this->resolvedColumns;
    }
}
