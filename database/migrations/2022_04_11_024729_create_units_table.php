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
        Schema::create('units', function (Blueprint $table) {
            $table->id('id');
            $table->text('title');
            $table->text('author');
            $table->text('description');
            $table->text('listening_tips');
            $table->text('cultural_notes');
            $table->text('transcript');
            $table->text('glossary');
            $table->text('translation');
            $table->text('dictionary');
            $table->integer('group_id');

            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
