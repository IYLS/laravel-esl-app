<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->text('title');
            $table->text('author');
            $table->text('description');

            $table->text('listening_tips')->nullable(true);
            $table->text('cultural_notes')->nullable(true);
            $table->text('transcript')->nullable(true);
            $table->text('glossary')->nullable(true);
            $table->text('translation')->nullable(true);
            $table->text('dictionary')->nullable(true);
            
            $table->boolean('listening_tips_enabled');
            $table->boolean('cultural_notes_enabled');
            $table->boolean('transcript_enabled');
            $table->boolean('glossary_enabled');
            $table->boolean('translation_enabled');
            $table->boolean('dictionary_enabled');
            $table->softDeletes();

            $table->string('video_url');
            $table->string('video_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
};
