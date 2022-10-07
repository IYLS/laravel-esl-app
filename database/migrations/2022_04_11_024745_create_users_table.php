<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->string('user_id');
            $table->string('name');
            $table->integer('age')->nullable(true);
            $table->string('gender');
            $table->string('language');
            $table->string('email');
            $table->string('role');
            $table->boolean('activated')->nullable(true);
            $table->text('password');
            $table->integer('group_id')->nullable(true);
            $table->softDeletes();

            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
