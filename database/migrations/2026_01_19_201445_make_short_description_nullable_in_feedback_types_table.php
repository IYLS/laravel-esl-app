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
            DB::statement('ALTER TABLE feedback_types ALTER COLUMN short_description DROP NOT NULL');
        } else {
            Schema::table('feedback_types', function (Blueprint $table) {
                $table->text('short_description')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE feedback_types ALTER COLUMN short_description SET NOT NULL');
        } else {
            Schema::table('feedback_types', function (Blueprint $table) {
                $table->text('short_description')->nullable(false)->change();
            });
        }
    }
};
