<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('excercise_types', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('underscore_name');
            $table->text('description');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excercise_types');
    }
};
