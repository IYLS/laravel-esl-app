<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migra datos de help_options y feedback desde tracking a las nuevas tablas
     */
    public function up(): void
    {
        // Verificar que las nuevas tablas existan
        if (!Schema::hasTable('tracking_help_usage') || !Schema::hasTable('tracking_feedback_usage')) {
            return; // Las tablas aún no existen, esta migración se ejecutará después
        }

        // Verificar que las columnas antiguas existan
        if (!Schema::hasColumn('tracking', 'help_options') || !Schema::hasColumn('tracking', 'feedback')) {
            return; // Las columnas ya fueron eliminadas, no hay nada que migrar
        }

        // Migrar help_options
        $this->migrateHelpOptions();

        // Migrar feedback
        $this->migrateFeedback();
    }

    /**
     * Migra datos de help_options a tracking_help_usage
     */
    private function migrateHelpOptions(): void
    {
        $trackings = DB::table('tracking')
            ->whereNotNull('help_options')
            ->where('help_options', '!=', '')
            ->get();

        foreach ($trackings as $tracking) {
            try {
                $helpOptionsData = $this->parseHelpOptions($tracking->help_options);
                
                if (empty($helpOptionsData)) {
                    continue;
                }

                foreach ($helpOptionsData as $helpType => $data) {
                    // Verificar si ya existe un registro para evitar duplicados
                    $exists = DB::table('tracking_help_usage')
                        ->where('tracking_id', $tracking->id)
                        ->where('help_type', $helpType)
                        ->exists();

                    if (!$exists) {
                        DB::table('tracking_help_usage')->insert([
                            'tracking_id' => $tracking->id,
                            'help_type' => $helpType,
                            'open_count' => (int)($data['count'] ?? 0),
                            'time_spent_seconds' => $this->convertTimeToSeconds($data['time'] ?? 0),
                            'created_at' => $tracking->created_at ?? now(),
                            'updated_at' => $tracking->updated_at ?? now(),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Log error pero continuar con el siguiente registro
                \Log::warning("Error migrando help_options para tracking_id {$tracking->id}: " . $e->getMessage());
                continue;
            }
        }
    }

    /**
     * Migra datos de feedback a tracking_feedback_usage
     */
    private function migrateFeedback(): void
    {
        $trackings = DB::table('tracking')
            ->whereNotNull('feedback')
            ->where('feedback', '!=', '')
            ->get();

        foreach ($trackings as $tracking) {
            try {
                $feedbackData = $this->parseFeedback($tracking->feedback);
                
                if (empty($feedbackData)) {
                    continue;
                }

                foreach ($feedbackData as $feedbackType => $count) {
                    // Verificar si ya existe un registro para evitar duplicados
                    $exists = DB::table('tracking_feedback_usage')
                        ->where('tracking_id', $tracking->id)
                        ->where('feedback_type', $feedbackType)
                        ->exists();

                    if (!$exists && $count > 0) {
                        DB::table('tracking_feedback_usage')->insert([
                            'tracking_id' => $tracking->id,
                            'feedback_type' => $feedbackType,
                            'open_count' => (int)$count,
                            'created_at' => $tracking->created_at ?? now(),
                            'updated_at' => $tracking->updated_at ?? now(),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Log error pero continuar con el siguiente registro
                \Log::warning("Error migrando feedback para tracking_id {$tracking->id}: " . $e->getMessage());
                continue;
            }
        }
    }

    /**
     * Parsea help_options que puede estar en formato JSON o texto
     */
    private function parseHelpOptions($data): array
    {
        if (empty($data)) {
            return [];
        }

        // Intentar decodificar como JSON
        $decoded = json_decode($data, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Si no es JSON válido, intentar parsear como texto estructurado
        // Formato esperado: {"Transcript": {"count": 1, "time": 120}, ...}
        return [];
    }

    /**
     * Parsea feedback que puede estar en formato JSON o texto
     */
    private function parseFeedback($data): array
    {
        if (empty($data)) {
            return [];
        }

        // Intentar decodificar como JSON
        $decoded = json_decode($data, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Si no es JSON válido, retornar vacío
        return [];
    }

    /**
     * Convierte tiempo a segundos
     * Acepta: segundos (int), formato "HH:MM:SS", formato "MM:SS", o milisegundos
     */
    private function convertTimeToSeconds($time): int
    {
        if (is_numeric($time)) {
            // Si es un número mayor a 100000, probablemente son milisegundos
            if ($time > 100000) {
                return (int)($time / 1000);
            }
            return (int)$time;
        }

        if (is_string($time) && strpos($time, ':') !== false) {
            $parts = explode(':', $time);
            $count = count($parts);
            
            if ($count === 3) {
                // Formato HH:MM:SS
                return (int)$parts[0] * 3600 + (int)$parts[1] * 60 + (int)$parts[2];
            } elseif ($count === 2) {
                // Formato MM:SS
                return (int)$parts[0] * 60 + (int)$parts[1];
            }
        }

        return 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No revertir la migración de datos
        // Los datos migrados permanecerán en las nuevas tablas
    }
};
