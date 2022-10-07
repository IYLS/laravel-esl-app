<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback_types', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->string('name');
            $table->text('description');
            $table->text('short_description');
            $table->string('level');
            $table->boolean('text_based');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback_types');
    }
};
