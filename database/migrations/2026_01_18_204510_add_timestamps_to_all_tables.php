<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tablas que tienen softDeletes pero no timestamps
        $this->addTimestampsIfNotExists('units');
        $this->addTimestampsIfNotExists('sections');
        $this->addTimestampsIfNotExists('exercises');
        $this->addTimestampsIfNotExists('questions');
        $this->addTimestampsIfNotExists('alternatives');
        $this->addTimestampsIfNotExists('keywords');
        $this->addTimestampsIfNotExists('glossed_words');
        $this->addTimestampsIfNotExists('feedback_types');
        $this->addTimestampsIfNotExists('feedback');
        $this->addTimestampsIfNotExists('groups');
        $this->addTimestampsIfNotExists('users');

        // Tablas que no tienen ni timestamps ni softDeletes
        $this->addTimestampsIfNotExists('exercise_types');
        $this->addSoftDeletesIfNotExists('exercise_types');
    }

    /**
     * Helper method to add timestamps if they don't exist
     */
    private function addTimestampsIfNotExists(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn($tableName, 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Helper method to add softDeletes if it doesn't exist
     */
    private function addSoftDeletesIfNotExists(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        if (!Schema::hasColumn($tableName, 'deleted_at')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('exercises', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('alternatives', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('keywords', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('glossed_words', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('feedback_types', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('exercise_types', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
        });
    }
};
