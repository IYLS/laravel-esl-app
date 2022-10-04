<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->text('title');
            $table->text('content');
            $table->softDeletes();
            $table->timestamps();

            $table->integer('user_id')->nullable(true);
            $table->integer('group_id')->nullable(true);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
