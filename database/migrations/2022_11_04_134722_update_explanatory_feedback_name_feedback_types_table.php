<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("UPDATE feedback_types SET name = 'Explanatory' where name = 'Explainatory'");
    }

    public function down() {}
};
