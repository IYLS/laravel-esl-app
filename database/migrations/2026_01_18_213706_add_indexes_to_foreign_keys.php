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
        // Agregar índices a foreign keys para mejorar rendimiento de consultas
        
        // Sections
        if (Schema::hasTable('sections') && Schema::hasColumn('sections', 'unit_id')) {
            Schema::table('sections', function (Blueprint $table) {
                if (!$this->hasIndex('sections', 'sections_unit_id_index')) {
                    $table->index('unit_id');
                }
            });
        }

        // Exercises
        if (Schema::hasTable('exercises')) {
            Schema::table('exercises', function (Blueprint $table) {
                if (Schema::hasColumn('exercises', 'section_id') && !$this->hasIndex('exercises', 'exercises_section_id_index')) {
                    $table->index('section_id');
                }
                if (Schema::hasColumn('exercises', 'exercise_type_id') && !$this->hasIndex('exercises', 'exercises_exercise_type_id_index')) {
                    $table->index('exercise_type_id');
                }
            });
        }

        // Questions
        if (Schema::hasTable('questions') && Schema::hasColumn('questions', 'exercise_id')) {
            Schema::table('questions', function (Blueprint $table) {
                if (!$this->hasIndex('questions', 'questions_exercise_id_index')) {
                    $table->index('exercise_id');
                }
            });
        }

        // Alternatives
        if (Schema::hasTable('alternatives') && Schema::hasColumn('alternatives', 'question_id')) {
            Schema::table('alternatives', function (Blueprint $table) {
                if (!$this->hasIndex('alternatives', 'alternatives_question_id_index')) {
                    $table->index('question_id');
                }
            });
        }

        // Keywords
        if (Schema::hasTable('keywords') && Schema::hasColumn('keywords', 'unit_id')) {
            Schema::table('keywords', function (Blueprint $table) {
                if (!$this->hasIndex('keywords', 'keywords_unit_id_index')) {
                    $table->index('unit_id');
                }
            });
        }

        // Glossed Words
        if (Schema::hasTable('glossed_words') && Schema::hasColumn('glossed_words', 'unit_id')) {
            Schema::table('glossed_words', function (Blueprint $table) {
                if (!$this->hasIndex('glossed_words', 'glossed_words_unit_id_index')) {
                    $table->index('unit_id');
                }
            });
        }

        // Feedback
        if (Schema::hasTable('feedback')) {
            Schema::table('feedback', function (Blueprint $table) {
                if (Schema::hasColumn('feedback', 'feedback_type_id') && !$this->hasIndex('feedback', 'feedback_feedback_type_id_index')) {
                    $table->index('feedback_type_id');
                }
                if (Schema::hasColumn('feedback', 'exercise_id') && !$this->hasIndex('feedback', 'feedback_exercise_id_index')) {
                    $table->index('exercise_id');
                }
                if (Schema::hasColumn('feedback', 'question_id') && !$this->hasIndex('feedback', 'feedback_question_id_index')) {
                    $table->index('question_id');
                }
                if (Schema::hasColumn('feedback', 'alternative_id') && !$this->hasIndex('feedback', 'feedback_alternative_id_index')) {
                    $table->index('alternative_id');
                }
            });
        }

        // Comments
        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                if (Schema::hasColumn('comments', 'user_id') && !$this->hasIndex('comments', 'comments_user_id_index')) {
                    $table->index('user_id');
                }
                if (Schema::hasColumn('comments', 'group_id') && !$this->hasIndex('comments', 'comments_group_id_index')) {
                    $table->index('group_id');
                }
            });
        }

        // Replies
        if (Schema::hasTable('replies')) {
            Schema::table('replies', function (Blueprint $table) {
                if (Schema::hasColumn('replies', 'comment_id') && !$this->hasIndex('replies', 'replies_comment_id_index')) {
                    $table->index('comment_id');
                }
                if (Schema::hasColumn('replies', 'user_id') && !$this->hasIndex('replies', 'replies_user_id_index')) {
                    $table->index('user_id');
                }
            });
        }

        // User Responses
        if (Schema::hasTable('user_responses')) {
            Schema::table('user_responses', function (Blueprint $table) {
                if (Schema::hasColumn('user_responses', 'tracking_id') && !$this->hasIndex('user_responses', 'user_responses_tracking_id_index')) {
                    $table->index('tracking_id');
                }
                if (Schema::hasColumn('user_responses', 'question_id') && !$this->hasIndex('user_responses', 'user_responses_question_id_index')) {
                    $table->index('question_id');
                }
            });
        }

        // Tracking
        if (Schema::hasTable('tracking')) {
            Schema::table('tracking', function (Blueprint $table) {
                if (Schema::hasColumn('tracking', 'user_id') && !$this->hasIndex('tracking', 'tracking_user_id_index')) {
                    $table->index('user_id');
                }
                if (Schema::hasColumn('tracking', 'exercise_id') && !$this->hasIndex('tracking', 'tracking_exercise_id_index')) {
                    $table->index('exercise_id');
                }
            });
        }

        // Users
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'group_id')) {
            Schema::table('users', function (Blueprint $table) {
                if (!$this->hasIndex('users', 'users_group_id_index')) {
                    $table->index('group_id');
                }
            });
        }

        // Tracking Help Usage
        if (Schema::hasTable('tracking_help_usage') && Schema::hasColumn('tracking_help_usage', 'tracking_id')) {
            Schema::table('tracking_help_usage', function (Blueprint $table) {
                if (!$this->hasIndex('tracking_help_usage', 'tracking_help_usage_tracking_id_index')) {
                    $table->index('tracking_id');
                }
            });
        }

        // Tracking Feedback Usage
        if (Schema::hasTable('tracking_feedback_usage') && Schema::hasColumn('tracking_feedback_usage', 'tracking_id')) {
            Schema::table('tracking_feedback_usage', function (Blueprint $table) {
                if (!$this->hasIndex('tracking_feedback_usage', 'tracking_feedback_usage_tracking_id_index')) {
                    $table->index('tracking_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar índices
        $indexes = [
            ['table' => 'sections', 'index' => 'sections_unit_id_index'],
            ['table' => 'exercises', 'index' => 'exercises_section_id_index'],
            ['table' => 'exercises', 'index' => 'exercises_exercise_type_id_index'],
            ['table' => 'questions', 'index' => 'questions_exercise_id_index'],
            ['table' => 'alternatives', 'index' => 'alternatives_question_id_index'],
            ['table' => 'keywords', 'index' => 'keywords_unit_id_index'],
            ['table' => 'glossed_words', 'index' => 'glossed_words_unit_id_index'],
            ['table' => 'feedback', 'index' => 'feedback_feedback_type_id_index'],
            ['table' => 'feedback', 'index' => 'feedback_exercise_id_index'],
            ['table' => 'feedback', 'index' => 'feedback_question_id_index'],
            ['table' => 'feedback', 'index' => 'feedback_alternative_id_index'],
            ['table' => 'comments', 'index' => 'comments_user_id_index'],
            ['table' => 'comments', 'index' => 'comments_group_id_index'],
            ['table' => 'replies', 'index' => 'replies_comment_id_index'],
            ['table' => 'replies', 'index' => 'replies_user_id_index'],
            ['table' => 'user_responses', 'index' => 'user_responses_tracking_id_index'],
            ['table' => 'user_responses', 'index' => 'user_responses_question_id_index'],
            ['table' => 'tracking', 'index' => 'tracking_user_id_index'],
            ['table' => 'tracking', 'index' => 'tracking_exercise_id_index'],
            ['table' => 'users', 'index' => 'users_group_id_index'],
            ['table' => 'tracking_help_usage', 'index' => 'tracking_help_usage_tracking_id_index'],
            ['table' => 'tracking_feedback_usage', 'index' => 'tracking_feedback_usage_tracking_id_index'],
        ];

        foreach ($indexes as $idx) {
            if (Schema::hasTable($idx['table'])) {
                try {
                    Schema::table($idx['table'], function (Blueprint $table) use ($idx) {
                        $table->dropIndex($idx['index']);
                    });
                } catch (\Exception $e) {
                    // Continuar si el índice no existe
                }
            }
        }
    }

    /**
     * Helper method to check if an index exists
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        try {
            $connection = Schema::getConnection();
            $databaseName = $connection->getDatabaseName();
            
            $driver = $connection->getDriverName();
            
            if ($driver === 'pgsql') {
                $result = $connection->select(
                    "SELECT COUNT(*) as count 
                     FROM pg_indexes 
                     WHERE schemaname = 'public' 
                     AND tablename = ? 
                     AND indexname = ?",
                    [$table, $indexName]
                );
            } else {
                // MySQL/MariaDB
                $result = $connection->select(
                    "SELECT COUNT(*) as count 
                     FROM information_schema.statistics 
                     WHERE table_schema = ? 
                     AND table_name = ? 
                     AND index_name = ?",
                    [$databaseName, $table, $indexName]
                );
            }
            
            return isset($result[0]) && $result[0]->count > 0;
        } catch (\Exception $e) {
            // Si hay error, asumir que el índice no existe
            return false;
        }
    }
};
