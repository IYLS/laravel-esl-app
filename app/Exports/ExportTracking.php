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
    protected string $userId;

    function __construct(string $userId) {
        $this->userId = $userId;
    }

    public function collection()
    {
        return User::where('id', $this->userId)->get();
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

        foreach($trackings as $tracking)
        {
            array_push($interactionTimes, $tracking->time_spent_in_minutes);
            $totalCorrectAnswersOnPlatform += intval($tracking->correct_answers);
        }

        $totalTimeSpentOnPlatform = $this->sumTime($interactionTimes);
        $completedUnitsCount = $units->count();

        return [
            $completedUnitsCount,
            $totalTimeSpentOnPlatform,
            "$totalCorrectAnswersOnPlatform",
        ];
    }

    private function processUnits($user): array
    {
        $units = $this->getUserUnits();
        $userId = $this->userId;
        $unitsIndicators = array();

        foreach($units as $unit)
        {
            $unitId = $unit->id;
            $unitTrackings = Tracking::whereHas('exercise.section.unit', function ($query) use ($unitId) {
                $query->where('units.id', $unitId);
            })->where('user_id', "$userId")->get();

            $timeSpentInUnit = array();
            $correctAnswersInUnit = 0;

            // Indicadores de opciones de ayuda por unidad
            $transcriptInteractionsUnit = 0;
            $transcriptTimesUnit = array();
            $tipsInteractionsUnit = 0;
            $tipsTimesUnit = array();
            $culturalNotesInteractionsUnit = 0;
            $culturalNotesTimesUnit = array();
            $glossaryInteractionsUnit = 0;
            $glossaryTimesUnit = array();
            $translationInteractionsUnit = 0;
            $translationTimesUnit = array();
            $dictionaryInteractionsUnit = 0;
            $dictionaryTimesUnit = array();

            foreach($unitTrackings as $tracking)
            {
                $helpOptions = explode(",", $tracking->help_options);

                if ($helpOptions != null and count($helpOptions) == 6) {
                    $transcriptData = explode("~", $helpOptions[0]);
                    $tipsData = explode("~", $helpOptions[1]);
                    $culturalNotesData = explode("~", $helpOptions[2]);
                    $glossaryData = explode("~", $helpOptions[3]);
                    $translationData = explode("~", $helpOptions[4]);
                    $dictionaryData = explode("~", $helpOptions[5]);

                    if (count($transcriptData) == 3) {
                        $transcriptInteractions = $transcriptData[1];
                        $transcriptTime = $transcriptData[2];
                        array_push($transcriptTimesUnit, $transcriptTime);
                        $transcriptInteractionsUnit += intval($transcriptInteractions);
                    }

                    if (count($tipsData) == 3) {
                        $tipsInteractions = $tipsData[1];
                        $tipsTime = $tipsData[2];
                        array_push($tipsTimesUnit, $tipsTime);
                        $tipsInteractionsUnit += intval($tipsInteractions);
                    }

                    if (count($culturalNotesData) == 3) {
                        $culturalNotesInteractions = $culturalNotesData[1];
                        $culturalNotesTime = $culturalNotesData[2];
                        array_push($culturalNotesTimesUnit, $culturalNotesTime);
                        $culturalNotesInteractionsUnit += intval($culturalNotesInteractions);
                    }

                    if (count($glossaryData) == 3) {
                        $glossaryInteractions = $glossaryData[1];
                        $glossaryTime = $glossaryData[2];
                        array_push($glossaryTimesUnit, $glossaryTime);
                        $glossaryInteractionsUnit += intval($glossaryInteractions);
                    }

                    if (count($translationData) == 3) {
                        $translationInteractions = $translationData[1];
                        $translationTime = $translationData[2];
                        array_push($translationTimesUnit, $translationTime);
                        $translationInteractionsUnit += intval($translationInteractions);
                    }

                    if (count($dictionaryData) == 3) {
                        $dictionaryInteractions = $dictionaryData[1];
                        $dictionaryTime = $dictionaryData[2];
                        array_push($dictionaryTimesUnit, $dictionaryTime);
                        $dictionaryInteractionsUnit += intval($dictionaryInteractions);
                    }
                }

                $correctAnswersInUnit += intval($tracking->correct_answers);
                array_push($timeSpentInUnit, $tracking->time_spent_in_minutes);
            }

            $unitData = [
                "timeSpentInUnit" => $this->sumTime($timeSpentInUnit),
                "rightAnswersAmount" => "$correctAnswersInUnit",
                "transcriptInteractions" => "$transcriptInteractionsUnit",
                "transcriptTime" => $this->sumTime($transcriptTimesUnit),
                "tipsInteractions" => "$tipsInteractionsUnit",
                "tipsTime" => $this->sumTime($tipsTimesUnit),
                "culturalNotesInteractions" => "$culturalNotesInteractionsUnit",
                "culturalNotesTime" => $this->sumTime($culturalNotesTimesUnit),
                "glossaryInteractions" => "$glossaryInteractionsUnit",
                "glossaryTime" => $this->sumTime($glossaryTimesUnit),
                "translationInteractions" => "$translationInteractionsUnit",
                "translationTime" => $this->sumTime($translationTimesUnit),
                "dictionaryInteractions" => "$dictionaryInteractionsUnit",
                "dictionaryTime" => $this->sumTime($dictionaryTimesUnit),
            ];

            array_push($unitsIndicators, $unitData);
        }

        return $unitsIndicators;
    }

    private function sumTime($times): string
    {
        $accumulatedHours = 0;
        $accumulatedMinutes = 0;

        foreach($times as $time) {
            $timeExploded = explode(":", $time);

            $hours = $timeExploded[0];
            $minutes = $timeExploded[1];

            if ($hours != "NaN" && $minutes != "NaN") {
                $hours = intval($hours);
                $minutes = intval($minutes);

                $accumulatedHours += $hours;
                $accumulatedMinutes += $minutes;
            } else {
                $accumulatedHours += 0;
                $accumulatedMinutes += 0;
            }
        }

        if ($accumulatedMinutes >= 60) {
            $hoursToSum = intval($accumulatedMinutes/60);
            $accumulatedMinutes = intval($accumulatedMinutes%60);
            $accumulatedHours += $hoursToSum;
        }

        $finalMinutes = "";
        $finalHours = "";

        if(strlen($accumulatedMinutes) == 1) {
            $finalMinutes = "0$accumulatedMinutes";
        } else {
            $finalMinutes = $accumulatedMinutes;
        }

        if(strlen($accumulatedHours) == 1) {
            $finalHours = "0$accumulatedHours";
        } else {
            $finalHours = $accumulatedHours;
        }

        return "$finalHours:$finalMinutes";
    }

    private function getUserUnits()
    {
        $user = $this->currentUser();
        return $user->group->units()->orderBy('title', 'asc')->get();
    }

    private function currentUser()
    {
        return User::where('id', $this->userId)->get()->first();
    }
}