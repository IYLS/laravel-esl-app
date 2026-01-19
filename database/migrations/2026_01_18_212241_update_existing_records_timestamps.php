<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        // Actualizar todas las tablas que acabamos de agregar timestamps
        $tables = [
            'units',
            'sections',
            'exercises',
            'questions',
            'alternatives',
            'keywords',
            'glossed_words',
            'feedback_types',
            'feedback',
            'groups',
            'users',
            'exercise_types'
        ];

        foreach ($tables as $table) {
            // Verificar si la tabla tiene las columnas antes de actualizar
            if (Schema::hasColumn($table, 'created_at') && Schema::hasColumn($table, 'updated_at')) {
                DB::table($table)
                    ->where(function($query) {
                        $query->whereNull('created_at')
                              ->orWhereNull('updated_at');
                    })
                    ->update([
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hay necesidad de revertir esta migración
        // Los timestamps se mantendrán con los valores establecidos
    }
};
