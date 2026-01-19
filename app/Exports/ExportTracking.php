<?php

namespace App\Exports;

use App\Models\Tracking;
use App\Models\User;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTracking implements FromCollection, WithHeadings, WithMapping
{
    protected $userIds; // Puede ser un string (un usuario) o un array (múltiples usuarios)
    protected $exportType; // 'student' o 'group'

    function __construct($userIds, string $exportType = 'student') {
        $this->userIds = is_array($userIds) ? $userIds : [$userIds];
        $this->exportType = $exportType;
    }

    public function collection()
    {
        return User::whereIn('id', $this->userIds)->get();
    }

    public function map($user): array
    {
        $units = $this->getUserUnits();
        $trackingData = $this->processTrackingData($user, $units);
        $unitsData = $this->processUnits($user);

        $data = [
            $user->user_id,
            $user->name,
            $trackingData[0],
            $trackingData[1],
            $trackingData[2],
        ];

        foreach($unitsData as $unitData) {
            array_push($data, $unitData["timeSpentInUnit"]);
            array_push($data, $unitData["rightAnswersAmount"]);
            array_push($data, $unitData["transcriptInteractions"]);
            array_push($data, $unitData["transcriptTime"]);
            array_push($data, $unitData["tipsInteractions"]);
            array_push($data, $unitData["tipsTime"]);
            array_push($data, $unitData["culturalNotesInteractions"]);
            array_push($data, $unitData["culturalNotesTime"]);
            array_push($data, $unitData["glossaryInteractions"]);
            array_push($data, $unitData["glossaryTime"]);
            array_push($data, $unitData["translationInteractions"]);
            array_push($data, $unitData["translationTime"]);
            array_push($data, $unitData["dictionaryInteractions"]);
            array_push($data, $unitData["dictionaryTime"]);
        }

        return $data;
    }

    public function headings(): array
    {
        $units = $this->getUserUnits();
        $array = [
            "ID Usuario",
            "Nombre",
            "Numero de unidades completadas",
            "Tiempo total en plataforma",
            "Aciertos totales en plataforma",
        ];

        foreach($units as $key=>$unit) {
            $key += 1;
            array_push($array, "U$key: Tiempo");
            array_push($array, "U$key: Aciertos");
            array_push($array, "U$key: Transcript Interactions");
            array_push($array, "U$key: Transcript Time Spent");
            array_push($array, "U$key: Tips Interactions");
            array_push($array, "U$key: Tips Time Spent");
            array_push($array, "U$key: Cultural Notes Interactions");
            array_push($array, "U$key: Cultural Notes Time Spent");
            array_push($array, "U$key: Glossary Interactions");
            array_push($array, "U$key: Glossary Time Spent");
            array_push($array, "U$key: Translation Interactions");
            array_push($array, "U$key: Translation Time Spent");
            array_push($array, "U$key: Dictionary Interactions");
            array_push($array, "U$key: Dictionary Time Spent");
        };

        return $array;
    }

    private function processTrackingData($user, $units): array
    {
        $trackings = Tracking::where('user_id', $user->id)->get();
        $interactionTimes = array();
        $totalCorrectAnswersOnPlatform = 0;

        $totalSecondsOnPlatform = 0;
        foreach($trackings as $tracking)
        {
            $totalSecondsOnPlatform += (int)$tracking->time_spent_in_seconds;
            $totalCorrectAnswersOnPlatform += intval($tracking->correct_answers);
        }

        $totalTimeSpentOnPlatform = $this->formatSecondsToTime($totalSecondsOnPlatform);
        
        // Contar unidades completadas por este usuario específico
        $completedUnitsCount = 0;
        foreach($units as $unit) {
            $hasTracking = Tracking::whereHas('exercise.section.unit', function ($query) use ($unit) {
                $query->where('units.id', $unit->id);
            })->where('user_id', $user->id)->exists();
            
            if ($hasTracking) {
                $completedUnitsCount++;
            }
        }

        return [
            $completedUnitsCount,
            $totalTimeSpentOnPlatform,
            "$totalCorrectAnswersOnPlatform",
        ];
    }

    private function processUnits($user): array
    {
        $units = $this->getUserUnits();
        $userId = $user->id;
        $unitsIndicators = array();

        foreach($units as $unit)
        {
            $unitId = $unit->id;
            $unitTrackings = Tracking::whereHas('exercise.section.unit', function ($query) use ($unitId) {
                $query->where('units.id', $unitId);
            })->where('user_id', "$userId")->with('helpUsage')->get();

            $timeSpentInUnit = 0; // Ahora es un entero (segundos totales)
            $correctAnswersInUnit = 0;

            // Indicadores de opciones de ayuda por unidad (ahora en segundos)
            $transcriptInteractionsUnit = 0;
            $transcriptTimesUnit = 0;
            $tipsInteractionsUnit = 0;
            $tipsTimesUnit = 0;
            $culturalNotesInteractionsUnit = 0;
            $culturalNotesTimesUnit = 0;
            $glossaryInteractionsUnit = 0;
            $glossaryTimesUnit = 0;
            $translationInteractionsUnit = 0;
            $translationTimesUnit = 0;
            $dictionaryInteractionsUnit = 0;
            $dictionaryTimesUnit = 0;

            foreach($unitTrackings as $tracking)
            {
                // Leer help usage desde la nueva tabla
                foreach($tracking->helpUsage as $helpUsage) {
                    $helpType = $helpUsage->help_type;
                    $count = $helpUsage->open_count;
                    $time = $helpUsage->time_spent_seconds;

                    switch ($helpType) {
                        case 'Transcript':
                            $transcriptTimesUnit += (int)$time;
                            $transcriptInteractionsUnit += $count;
                            break;
                        case 'Listening tips':
                            $tipsTimesUnit += (int)$time;
                            $tipsInteractionsUnit += $count;
                            break;
                        case 'Cultural notes':
                            $culturalNotesTimesUnit += (int)$time;
                            $culturalNotesInteractionsUnit += $count;
                            break;
                        case 'Glossary':
                            $glossaryTimesUnit += (int)$time;
                            $glossaryInteractionsUnit += $count;
                            break;
                        case 'Translation':
                            $translationTimesUnit += (int)$time;
                            $translationInteractionsUnit += $count;
                            break;
                        case 'Dictionary':
                            $dictionaryTimesUnit += (int)$time;
                            $dictionaryInteractionsUnit += $count;
                            break;
                    }
                }

                $correctAnswersInUnit += intval($tracking->correct_answers);
                // Acumular segundos directamente
                $timeSpentInUnit += (int)$tracking->time_spent_in_seconds;
            }

            $unitData = [
                "timeSpentInUnit" => $this->formatSecondsToTime($timeSpentInUnit),
                "rightAnswersAmount" => "$correctAnswersInUnit",
                "transcriptInteractions" => "$transcriptInteractionsUnit",
                "transcriptTime" => $this->formatSecondsToTime($transcriptTimesUnit),
                "tipsInteractions" => "$tipsInteractionsUnit",
                "tipsTime" => $this->formatSecondsToTime($tipsTimesUnit),
                "culturalNotesInteractions" => "$culturalNotesInteractionsUnit",
                "culturalNotesTime" => $this->formatSecondsToTime($culturalNotesTimesUnit),
                "glossaryInteractions" => "$glossaryInteractionsUnit",
                "glossaryTime" => $this->formatSecondsToTime($glossaryTimesUnit),
                "translationInteractions" => "$translationInteractionsUnit",
                "translationTime" => $this->formatSecondsToTime($translationTimesUnit),
                "dictionaryInteractions" => "$dictionaryInteractionsUnit",
                "dictionaryTime" => $this->formatSecondsToTime($dictionaryTimesUnit),
            ];

            array_push($unitsIndicators, $unitData);
        }

        return $unitsIndicators;
    }

    /**
     * Formatea segundos a formato "HH:MM:SS" o "MM:SS" para Excel
     */
    private function formatSecondsToTime($seconds): string
    {
        $seconds = (int)$seconds;
        
        if ($seconds === 0) {
            return '00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        } else {
            return sprintf('%02d:%02d', $minutes, $secs);
        }
    }

    private function getUserUnits()
    {
        // Obtener unidades del primer usuario (todos los usuarios del grupo deberían tener las mismas unidades)
        $user = $this->currentUser();
        if ($user && $user->group) {
            return $user->group->units()->orderBy('title', 'asc')->get();
        }
        // Si no hay grupo, obtener todas las unidades
        return Unit::orderBy('title', 'asc')->get();
    }

    private function currentUser()
    {
        return User::whereIn('id', $this->userIds)->first();
    }
}