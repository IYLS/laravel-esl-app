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
        Schema::create('tracking_help_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracking_id');
            $table->string('help_type'); // 'Transcript', 'Glossary', etc.
            $table->integer('open_count')->default(0);
            $table->integer('time_spent_seconds')->default(0);
            $table->timestamps();

            $table->foreign('tracking_id')->references('id')->on('tracking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_help_usage');
    }
};
