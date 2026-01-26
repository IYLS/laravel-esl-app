<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = DB::connection()->getDriverName();
        
        // Verificar que la columna existe
        if (!Schema::hasColumn('tracking', 'time_spent_in_minutes')) {
            return; // La columna ya fue renombrada o no existe
        }

        // Convertir datos existentes de forma segura
        if ($driver === 'pgsql') {
            $this->convertTimePostgreSQL();
        } else {
            $this->convertTimeMySQL();
        }

        // Renombrar columna
        Schema::table('tracking', function (Blueprint $table) {
            $table->renameColumn('time_spent_in_minutes', 'time_spent_in_seconds');
        });

        // Cambiar tipo de dato
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE tracking ALTER COLUMN time_spent_in_seconds TYPE INTEGER USING time_spent_in_seconds::integer');
        } else {
            Schema::table('tracking', function (Blueprint $table) {
                $table->integer('time_spent_in_seconds')->change();
            });
        }
    }

    /**
     * Convierte tiempo en PostgreSQL de forma segura
     */
    private function convertTimePostgreSQL(): void
    {
        // Primero, limpiar valores inválidos (NaN, null, vacíos, etc.)
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = '0'
            WHERE time_spent_in_minutes IS NULL 
            OR time_spent_in_minutes::text = ''
            OR time_spent_in_minutes::text = 'NaN'
            OR time_spent_in_minutes::text = 'null'
            OR time_spent_in_minutes::text = 'NULL'
            OR LOWER(time_spent_in_minutes::text) = 'nan'");

        // Actualizar registros con formato "HH:MM:SS"
        // Verificar que todas las partes sean numéricas válidas
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = (
                CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 1) AS INTEGER) * 3600 + 
                CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 2) AS INTEGER) * 60 + 
                CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 3) AS INTEGER)
            )
            WHERE time_spent_in_minutes::text LIKE '%:%:%'
            AND time_spent_in_minutes IS NOT NULL
            AND SPLIT_PART(time_spent_in_minutes::text, ':', 1) ~ '^[0-9]+$'
            AND SPLIT_PART(time_spent_in_minutes::text, ':', 2) ~ '^[0-9]+$'
            AND SPLIT_PART(time_spent_in_minutes::text, ':', 3) ~ '^[0-9]+$'");

        // Actualizar registros con formato "MM:SS"
        // Verificar que ambas partes sean numéricas válidas
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = (
                CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 1) AS INTEGER) * 60 + 
                CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 2) AS INTEGER)
            )
            WHERE time_spent_in_minutes::text LIKE '%:%'
            AND time_spent_in_minutes::text NOT LIKE '%:%:%'
            AND time_spent_in_minutes IS NOT NULL
            AND SPLIT_PART(time_spent_in_minutes::text, ':', 1) ~ '^[0-9]+$'
            AND SPLIT_PART(time_spent_in_minutes::text, ':', 2) ~ '^[0-9]+$'");

        // Si son muy grandes (> 100000), probablemente son milisegundos
        // Solo procesar si son numéricos válidos
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = CAST(time_spent_in_minutes AS INTEGER) / 1000
            WHERE time_spent_in_minutes::text NOT LIKE '%:%'
            AND time_spent_in_minutes::text ~ '^[0-9]+$'
            AND CAST(time_spent_in_minutes AS INTEGER) > 100000
            AND time_spent_in_minutes IS NOT NULL");

        // Limpiar cualquier valor que no sea numérico válido restante
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = '0'
            WHERE time_spent_in_minutes::text NOT LIKE '%:%'
            AND time_spent_in_minutes::text !~ '^[0-9]+$'
            AND time_spent_in_minutes IS NOT NULL");
    }

    /**
     * Convierte tiempo en MySQL de forma segura
     */
    private function convertTimeMySQL(): void
    {
        // Primero, limpiar valores inválidos (NaN, null, vacíos, etc.)
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = '0'
            WHERE time_spent_in_minutes IS NULL 
            OR time_spent_in_minutes = ''
            OR UPPER(time_spent_in_minutes) = 'NAN'
            OR UPPER(time_spent_in_minutes) = 'NULL'");

        // Actualizar registros con formato "HH:MM:SS"
        // Verificar que todas las partes sean numéricas válidas usando REGEXP
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = (
                CAST(SUBSTRING_INDEX(time_spent_in_minutes, ':', 1) AS UNSIGNED) * 3600 + 
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(time_spent_in_minutes, ':', 2), ':', -1) AS UNSIGNED) * 60 + 
                CAST(SUBSTRING_INDEX(time_spent_in_minutes, ':', -1) AS UNSIGNED)
            )
            WHERE time_spent_in_minutes LIKE '%:%:%'
            AND time_spent_in_minutes IS NOT NULL
            AND SUBSTRING_INDEX(time_spent_in_minutes, ':', 1) REGEXP '^[0-9]+$'
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(time_spent_in_minutes, ':', 2), ':', -1) REGEXP '^[0-9]+$'
            AND SUBSTRING_INDEX(time_spent_in_minutes, ':', -1) REGEXP '^[0-9]+$'");

        // Actualizar registros con formato "MM:SS"
        // Verificar que ambas partes sean numéricas válidas
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = (
                CAST(SUBSTRING_INDEX(time_spent_in_minutes, ':', 1) AS UNSIGNED) * 60 + 
                CAST(SUBSTRING_INDEX(time_spent_in_minutes, ':', -1) AS UNSIGNED)
            )
            WHERE time_spent_in_minutes LIKE '%:%'
            AND time_spent_in_minutes NOT LIKE '%:%:%'
            AND time_spent_in_minutes IS NOT NULL
            AND SUBSTRING_INDEX(time_spent_in_minutes, ':', 1) REGEXP '^[0-9]+$'
            AND SUBSTRING_INDEX(time_spent_in_minutes, ':', -1) REGEXP '^[0-9]+$'");

        // Si son muy grandes (> 100000), probablemente son milisegundos
        // Solo procesar si son numéricos válidos
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = CAST(time_spent_in_minutes AS UNSIGNED) / 1000
            WHERE time_spent_in_minutes NOT LIKE '%:%'
            AND time_spent_in_minutes REGEXP '^[0-9]+$'
            AND CAST(time_spent_in_minutes AS UNSIGNED) > 100000
            AND time_spent_in_minutes IS NOT NULL");

        // Limpiar cualquier valor que no sea numérico válido restante
        DB::statement("UPDATE tracking 
            SET time_spent_in_minutes = '0'
            WHERE time_spent_in_minutes NOT LIKE '%:%'
            AND time_spent_in_minutes NOT REGEXP '^[0-9]+$'
            AND time_spent_in_minutes IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = DB::connection()->getDriverName();
        
        Schema::table('tracking', function (Blueprint $table) {
            $table->string('time_spent_in_seconds')->change();
        });

        // Convertir segundos de vuelta a formato "HH:MM:SS" o "MM:SS"
        if ($driver === 'pgsql') {
            DB::statement("UPDATE tracking 
                SET time_spent_in_seconds = CASE 
                    WHEN CAST(time_spent_in_seconds AS INTEGER) >= 3600 THEN 
                        LPAD(FLOOR(CAST(time_spent_in_seconds AS INTEGER) / 3600)::text, 2, '0') || ':' ||
                        LPAD(FLOOR((CAST(time_spent_in_seconds AS INTEGER) % 3600) / 60)::text, 2, '0') || ':' ||
                        LPAD((CAST(time_spent_in_seconds AS INTEGER) % 60)::text, 2, '0')
                    ELSE 
                        LPAD(FLOOR(CAST(time_spent_in_seconds AS INTEGER) / 60)::text, 2, '0') || ':' ||
                        LPAD((CAST(time_spent_in_seconds AS INTEGER) % 60)::text, 2, '0')
                END
                WHERE time_spent_in_seconds IS NOT NULL");
        } else {
            DB::statement("UPDATE tracking 
                SET time_spent_in_seconds = CASE 
                    WHEN CAST(time_spent_in_seconds AS UNSIGNED) >= 3600 THEN 
                        CONCAT(
                            LPAD(FLOOR(CAST(time_spent_in_seconds AS UNSIGNED) / 3600), 2, '0'), 
                            ':',
                            LPAD(FLOOR((CAST(time_spent_in_seconds AS UNSIGNED) % 3600) / 60), 2, '0'), 
                            ':',
                            LPAD(CAST(time_spent_in_seconds AS UNSIGNED) % 60, 2, '0')
                        )
                    ELSE 
                        CONCAT(
                            LPAD(FLOOR(CAST(time_spent_in_seconds AS UNSIGNED) / 60), 2, '0'), 
                            ':',
                            LPAD(CAST(time_spent_in_seconds AS UNSIGNED) % 60, 2, '0')
                        )
                END
                WHERE time_spent_in_seconds IS NOT NULL");
        }

        Schema::table('tracking', function (Blueprint $table) {
            $table->renameColumn('time_spent_in_seconds', 'time_spent_in_minutes');
        });
    }
};
