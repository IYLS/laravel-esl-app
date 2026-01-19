<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero eliminar todas las foreign keys existentes sin reglas de eliminación
        // y luego recrearlas con las reglas apropiadas

        // ============================================
        // SECCIONES - CASCADE cuando se elimina unit
        // ============================================
        $this->dropAndRecreateForeignKey('sections', 'sections_unit_id_foreign', 'unit_id', 'units', 'id', 'cascade');

        // ============================================
        // EJERCICIOS - CASCADE cuando se elimina section, RESTRICT para exercise_type
        // ============================================
        $this->dropAndRecreateForeignKey('exercises', 'exercises_section_id_foreign', 'section_id', 'sections', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('exercises', 'exercises_exercise_type_id_foreign', 'exercise_type_id', 'exercise_types', 'id', 'restrict');

        // ============================================
        // PREGUNTAS - CASCADE cuando se elimina exercise
        // ============================================
        $this->dropAndRecreateForeignKey('questions', 'questions_exercise_id_foreign', 'exercise_id', 'exercises', 'id', 'cascade');

        // ============================================
        // ALTERNATIVAS - CASCADE cuando se elimina question
        // ============================================
        $this->dropAndRecreateForeignKey('alternatives', 'alternatives_question_id_foreign', 'question_id', 'questions', 'id', 'cascade');

        // ============================================
        // KEYWORDS - CASCADE cuando se elimina unit
        // ============================================
        $this->dropAndRecreateForeignKey('keywords', 'keywords_unit_id_foreign', 'unit_id', 'units', 'id', 'cascade');

        // ============================================
        // GLOSSED WORDS - CASCADE cuando se elimina unit
        // ============================================
        $this->dropAndRecreateForeignKey('glossed_words', 'glossed_words_unit_id_foreign', 'unit_id', 'units', 'id', 'cascade');

        // ============================================
        // FEEDBACK - CASCADE para relaciones principales, SET NULL para feedback_type (nullable)
        // ============================================
        $this->dropAndRecreateForeignKey('feedback', 'feedback_feedback_type_id_foreign', 'feedback_type_id', 'feedback_types', 'id', 'set null');
        $this->dropAndRecreateForeignKey('feedback', 'feedback_exercise_id_foreign', 'exercise_id', 'exercises', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('feedback', 'feedback_question_id_foreign', 'question_id', 'questions', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('feedback', 'feedback_alternative_id_foreign', 'alternative_id', 'alternatives', 'id', 'cascade');

        // ============================================
        // COMMENTS - SET NULL cuando se elimina user o group (nullable)
        // ============================================
        $this->dropAndRecreateForeignKey('comments', 'comments_user_id_foreign', 'user_id', 'users', 'id', 'set null');
        $this->dropAndRecreateForeignKey('comments', 'comments_group_id_foreign', 'group_id', 'groups', 'id', 'set null');

        // ============================================
        // REPLIES - CASCADE cuando se elimina comment, SET NULL cuando se elimina user
        // ============================================
        $this->dropAndRecreateForeignKey('replies', 'replies_comment_id_foreign', 'comment_id', 'comments', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('replies', 'replies_user_id_foreign', 'user_id', 'users', 'id', 'set null');

        // ============================================
        // USER RESPONSES - CASCADE cuando se elimina tracking o question
        // ============================================
        $this->dropAndRecreateForeignKey('user_responses', 'user_responses_tracking_id_foreign', 'tracking_id', 'tracking', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('user_responses', 'user_responses_question_id_foreign', 'question_id', 'questions', 'id', 'cascade');

        // ============================================
        // TRACKING - SET NULL cuando se elimina user, CASCADE cuando se elimina exercise
        // ============================================
        $this->dropAndRecreateForeignKey('tracking', 'tracking_user_id_foreign', 'user_id', 'users', 'id', 'set null');
        $this->dropAndRecreateForeignKey('tracking', 'tracking_exercise_id_foreign', 'exercise_id', 'exercises', 'id', 'cascade');

        // ============================================
        // USERS - SET NULL cuando se elimina group (nullable)
        // ============================================
        $this->dropAndRecreateForeignKey('users', 'users_group_id_foreign', 'group_id', 'groups', 'id', 'set null');

        // ============================================
        // UNIT_GROUP (tabla pivot) - CASCADE en ambas direcciones
        // ============================================
        $this->dropAndRecreateForeignKey('unit_group', 'unit_group_unit_id_foreign', 'unit_id', 'units', 'id', 'cascade');
        $this->dropAndRecreateForeignKey('unit_group', 'unit_group_group_id_foreign', 'group_id', 'groups', 'id', 'cascade');
    }

    /**
     * Helper method to drop and recreate a foreign key with cascade rules
     */
    private function dropAndRecreateForeignKey(string $table, string $constraintName, string $column, string $referencedTable, string $referencedColumn, string $onDelete): void
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable($table)) {
            return;
        }

        // Verificar si la columna existe
        if (!Schema::hasColumn($table, $column)) {
            return;
        }

        // Intentar eliminar la foreign key existente si existe
        // Laravel genera nombres como: {table}_{column}_foreign
        $possibleNames = [
            $constraintName,
            "{$table}_{$column}_foreign",
            $column . '_foreign'
        ];

        foreach ($possibleNames as $name) {
            try {
                Schema::table($table, function (Blueprint $blueprint) use ($name, $column) {
                    // Intentar con el nombre completo
                    try {
                        $blueprint->dropForeign($name);
                    } catch (\Exception $e) {
                        // Intentar con array
                        $blueprint->dropForeign([$column]);
                    }
                });
                break; // Si se eliminó exitosamente, salir del loop
            } catch (\Exception $e) {
                // Continuar con el siguiente nombre
                continue;
            }
        }

        // Recrear la foreign key con la regla de eliminación apropiada
        Schema::table($table, function (Blueprint $blueprint) use ($column, $referencedTable, $referencedColumn, $onDelete) {
            $foreignKey = $blueprint->foreign($column)->references($referencedColumn)->on($referencedTable);
            
            switch (strtolower($onDelete)) {
                case 'cascade':
                    $foreignKey->onDelete('cascade');
                    break;
                case 'set null':
                    $foreignKey->onDelete('set null');
                    break;
                case 'restrict':
                    $foreignKey->onDelete('restrict');
                    break;
                default:
                    $foreignKey->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a las foreign keys sin reglas de eliminación
        // Esto es complejo, así que simplemente eliminamos las reglas de eliminación
        // dejando las foreign keys básicas
        
        $foreignKeys = [
            ['table' => 'sections', 'column' => 'unit_id'],
            ['table' => 'exercises', 'column' => 'section_id'],
            ['table' => 'exercises', 'column' => 'exercise_type_id'],
            ['table' => 'questions', 'column' => 'exercise_id'],
            ['table' => 'alternatives', 'column' => 'question_id'],
            ['table' => 'keywords', 'column' => 'unit_id'],
            ['table' => 'glossed_words', 'column' => 'unit_id'],
            ['table' => 'feedback', 'column' => 'feedback_type_id'],
            ['table' => 'feedback', 'column' => 'exercise_id'],
            ['table' => 'feedback', 'column' => 'question_id'],
            ['table' => 'feedback', 'column' => 'alternative_id'],
            ['table' => 'comments', 'column' => 'user_id'],
            ['table' => 'comments', 'column' => 'group_id'],
            ['table' => 'replies', 'column' => 'comment_id'],
            ['table' => 'replies', 'column' => 'user_id'],
            ['table' => 'user_responses', 'column' => 'tracking_id'],
            ['table' => 'user_responses', 'column' => 'question_id'],
            ['table' => 'tracking', 'column' => 'user_id'],
            ['table' => 'tracking', 'column' => 'exercise_id'],
            ['table' => 'users', 'column' => 'group_id'],
            ['table' => 'unit_group', 'column' => 'unit_id'],
            ['table' => 'unit_group', 'column' => 'group_id'],
        ];

        foreach ($foreignKeys as $fk) {
            if (Schema::hasTable($fk['table']) && Schema::hasColumn($fk['table'], $fk['column'])) {
                try {
                    Schema::table($fk['table'], function (Blueprint $blueprint) use ($fk) {
                        $blueprint->dropForeign([$fk['column']]);
                    });
                } catch (\Exception $e) {
                    // Continuar si falla
                }
            }
        }
    }
};
