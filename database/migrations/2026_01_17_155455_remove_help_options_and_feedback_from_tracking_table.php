<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verificar que las columnas existen antes de eliminarlas
        if (!Schema::hasColumn('tracking', 'help_options') || !Schema::hasColumn('tracking', 'feedback')) {
            return; // Las columnas ya fueron eliminadas
        }

        // Verificar que las nuevas tablas existen (los datos deberían estar migrados)
        if (!Schema::hasTable('tracking_help_usage') || !Schema::hasTable('tracking_feedback_usage')) {
            throw new \Exception('Las tablas tracking_help_usage y tracking_feedback_usage deben existir antes de eliminar las columnas antiguas. Ejecuta primero la migración de datos.');
        }

        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('help_options');
            $table->dropColumn('feedback');
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
            $table->text('help_options')->nullable(true);
            $table->text('feedback')->nullable(true);
        });
    }
};
