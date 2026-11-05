<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Varias migraciones del proyecto usan DDL exclusivo de PostgreSQL, así que las
 * pruebas de los exports arman en SQLite en memoria sólo el esquema que tocan.
 */
trait BuildsTrackingSchema
{
    protected function useInMemorySqlite(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
    }

    /**
     * Esquema mínimo que necesita el export, con los mismos nombres de columna
     * que las migraciones del proyecto.
     */
    protected function buildTrackingSchema(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('leaderboard_enabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('unit_group', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('group_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('language')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('activated')->default(true);
            $table->integer('group_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('underscore_name')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('position')->nullable();
            $table->integer('unit_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exercise_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('underscore_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('heading_title')->nullable();
            $table->string('category')->nullable();
            $table->string('subtype')->nullable();
            $table->integer('position')->nullable();
            $table->integer('section_id');
            $table->integer('exercise_type_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('statement')->nullable();
            $table->text('answer')->nullable();
            $table->string('correct_answer')->nullable();
            $table->boolean('personal_response')->default(false);
            $table->boolean('exclusive_responses')->default(false);
            $table->integer('position')->nullable();
            $table->integer('exercise_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->string('intent_number');
            $table->integer('time_spent_in_seconds')->default(0);
            $table->string('correct_answers')->nullable();
            $table->string('wrong_answers')->nullable();
            $table->integer('exercise_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_responses', function (Blueprint $table) {
            $table->id();
            $table->text('response');
            $table->integer('question_id');
            $table->integer('tracking_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tracking_help_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('tracking_id');
            $table->string('help_type');
            $table->integer('open_count')->default(0);
            $table->integer('time_spent_seconds')->default(0);
            $table->timestamps();
        });

        Schema::create('tracking_feedback_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('tracking_id');
            $table->integer('question_id')->nullable();
            $table->string('feedback_type');
            $table->integer('open_count')->default(0);
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('content');
            $table->integer('user_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
