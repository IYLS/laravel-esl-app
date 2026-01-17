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
        
        if ($driver === 'pgsql') {
            // PostgreSQL: convertir datos existentes de "HH:MM:SS" o "MM:SS" a segundos
            // Primero convertir a texto para poder usar LIKE
            DB::statement("UPDATE tracking SET time_spent_in_minutes = CASE 
                WHEN time_spent_in_minutes::text LIKE '%:%:%' THEN 
                    (CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 1) AS INTEGER) * 3600 + 
                     CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 2) AS INTEGER) * 60 + 
                     CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 3) AS INTEGER))
                WHEN time_spent_in_minutes::text LIKE '%:%' THEN 
                    (CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 1) AS INTEGER) * 60 + 
                     CAST(SPLIT_PART(time_spent_in_minutes::text, ':', 2) AS INTEGER))
                ELSE CAST(time_spent_in_minutes AS INTEGER)
            END");
        } else {
            // MySQL: convertir datos existentes de "HH:MM:SS" o "MM:SS" a segundos
            DB::statement('UPDATE tracking SET time_spent_in_minutes = CASE 
                WHEN time_spent_in_minutes LIKE "%:%:%" THEN 
                    (CAST(SUBSTRING_INDEX(time_spent_in_minutes, ":", 1) AS UNSIGNED) * 3600 + 
                     CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(time_spent_in_minutes, ":", 2), ":", -1) AS UNSIGNED) * 60 + 
                     CAST(SUBSTRING_INDEX(time_spent_in_minutes, ":", -1) AS UNSIGNED))
                WHEN time_spent_in_minutes LIKE "%:%" THEN 
                    (CAST(SUBSTRING_INDEX(time_spent_in_minutes, ":", 1) AS UNSIGNED) * 60 + 
                     CAST(SUBSTRING_INDEX(time_spent_in_minutes, ":", -1) AS UNSIGNED))
                ELSE CAST(time_spent_in_minutes AS UNSIGNED)
            END');
        }

        Schema::table('tracking', function (Blueprint $table) {
            // Renombrar columna y cambiar tipo a integer
            $table->renameColumn('time_spent_in_minutes', 'time_spent_in_seconds');
        });

        Schema::table('tracking', function (Blueprint $table) {
            $table->integer('time_spent_in_seconds')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->string('time_spent_in_seconds')->change();
        });

        // Convertir segundos de vuelta a formato "HH:MM:SS" o "MM:SS"
        DB::statement('UPDATE tracking SET time_spent_in_seconds = CASE 
            WHEN time_spent_in_seconds >= 3600 THEN 
                CONCAT(
                    LPAD(FLOOR(time_spent_in_seconds / 3600), 2, "0"), 
                    ":",
                    LPAD(FLOOR((time_spent_in_seconds % 3600) / 60), 2, "0"), 
                    ":",
                    LPAD(time_spent_in_seconds % 60, 2, "0")
                )
            ELSE 
                CONCAT(
                    LPAD(FLOOR(time_spent_in_seconds / 60), 2, "0"), 
                    ":",
                    LPAD(time_spent_in_seconds % 60, 2, "0")
                )
        END');

        Schema::table('tracking', function (Blueprint $table) {
            $table->renameColumn('time_spent_in_seconds', 'time_spent_in_minutes');
        });
    }
};
