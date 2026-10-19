<?php

namespace App\Exports;

use App\Models\Tracking;

/**
 * Versión liviana de un intento (Tracking) para el export. El índice de
 * intentos queda completo en memoria durante todo el export, y un modelo de
 * Eloquent con sus tres relaciones pesa varias veces más que estos datos,
 * lo que en un servidor de 512MB marca la diferencia en grupos grandes.
 */
final class ExportAttempt
{
    /**
     * @param  array<string,array{count:int,seconds:int}>  $helpUsage  help_type => totales
     * @param  array<string,int>  $feedbackUsage  feedback_type => veces abierto
     * @param  array<int,string[]>  $responses  question_id => respuestas no vacías, ya recortadas
     */
    public function __construct(
        public readonly int $timeSpentSeconds,
        public readonly int $correctAnswers,
        public readonly int $wrongAnswers,
        public readonly int $intentNumber,
        public readonly array $helpUsage,
        public readonly array $feedbackUsage,
        public readonly array $responses,
    ) {
    }

    public static function fromTracking(Tracking $tracking): self
    {
        $help = [];
        foreach ($tracking->helpUsage as $usage) {
            $type = (string) $usage->help_type;
            $help[$type]['count'] = ($help[$type]['count'] ?? 0) + (int) $usage->open_count;
            $help[$type]['seconds'] = ($help[$type]['seconds'] ?? 0) + (int) $usage->time_spent_seconds;
        }

        $feedback = [];
        foreach ($tracking->feedbackUsage as $usage) {
            $type = (string) $usage->feedback_type;
            $feedback[$type] = ($feedback[$type] ?? 0) + (int) $usage->open_count;
        }

        $responses = [];
        foreach ($tracking->userResponses as $response) {
            $text = trim((string) $response->response);

            if ($text !== '') {
                $responses[(int) $response->question_id][] = $text;
            }
        }

        return new self(
            (int) $tracking->time_spent_in_seconds,
            (int) $tracking->correct_answers,
            (int) $tracking->wrong_answers,
            (int) $tracking->intent_number,
            $help,
            $feedback,
            $responses,
        );
    }
}
