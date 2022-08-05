<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('unit_id');
            
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('section');
    }
};
