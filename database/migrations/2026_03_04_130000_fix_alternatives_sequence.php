<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Corrige la secuencia de alternatives cuando está desincronizada
     * (error: llave duplicada viola restricción de unicidad «alternatives_pkey»)
     */
    public function up()
    {
        $maxId = DB::table('alternatives')->max('id') ?? 3999;
        $sequenceName = 'alternatives_id_seq';

        // PostgreSQL: setval hace que el próximo nextval() devuelva maxId + 1
        DB::statement("SELECT setval('{$sequenceName}', {$maxId})");
    }

    public function down()
    {
        // No reversible
    }
};
