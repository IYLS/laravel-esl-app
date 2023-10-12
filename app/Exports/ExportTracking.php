<?php

namespace App\Exports;

use App\Models\Group;
use App\Models\Tracking;
use App\Models\User;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTracking implements FromCollection, WithHeadings, WithMapping
{
    protected $groupId;

    function __construct(string $groupId) {
        $this->groupId = $groupId;
    }

    public function collection()
    {
        return User::where('group_id', $this->groupId)->get();
    }

    public function map($user): array
    {
        $trackingData = $this->processTrackingData($user);
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
        return [
                "ID Usuario",
                "Nombre",
                "Numero de unidades completadas",
                "Tiempo total en plataforma",
                "Aciertos totales en plataforma",
                "U1: TIEMPO",
                "U1: ACIERTOS",
                "U1: Transcript Time Spent",
                "U1: Transcript Interactions",
                "U1: Tips Time Spent",
                "U1: Tips Interactions",
                "U1: Cultural Notes Time Spent",
                "U1: Cultural Notes Interactions",
                "U1: Glossary Time Spent",
                "U1: Glossary Interactions",
                "U1: Translation Time Spent",
                "U1: Translation Interactions",
                "U1: Dictionary Time Spent",
                "U1: Dictionary Interactions",
                "U2: TIEMPO",
                "U2: ACIERTOS",
                "U2: Transcript Time Spent",
                "U2: Transcript Interactions",
                "U2: Tips Time Spent",
                "U2: Tips Interactions",
                "U2: Cultural Notes Time Spent",
                "U2: Cultural Notes Interactions",
                "U2: Glossary Time Spent",
                "U2: Glossary Interactions",
                "U2: Translation Time Spent",
                "U2: Translation Interactions",
                "U2: Dictionary Time Spent",
                "U2: Dictionary Interactions",
                "U3: TIEMPO",
                "U3: ACIERTOS",
                "U3: Transcript Time Spent",
                "U3: Transcript Interactions",
                "U3: Tips Time Spent",
                "U3: Tips Interactions",
                "U3: Cultural Notes Time Spent",
                "U3: Cultural Notes Interactions",
                "U3: Glossary Time Spent",
                "U3: Glossary Interactions",
                "U3: Translation Time Spent",
                "U3: Translation Interactions",
                "U3: Dictionary Time Spent",
                "U3: Dictionary Interactions",
                "U4: TIEMPO",
                "U4: ACIERTOS",
                "U4: Transcript Time Spent",
                "U4: Transcript Interactions",
                "U4: Tips Time Spent",
                "U4: Tips Interactions",
                "U4: Cultural Notes Time Spent",
                "U4: Cultural Notes Interactions",
                "U4: Glossary Time Spent",
                "U4: Glossary Interactions",
                "U4: Translation Time Spent",
                "U4: Translation Interactions",
                "U4: Dictionary Time Spent",
                "U4: Dictionary Interactions",
                "U5: TIEMPO",
                "U5: ACIERTOS",
                "U5: Transcript Time Spent",
                "U5: Transcript Interactions",
                "U5: Tips Time Spent",
                "U5: Tips Interactions",
                "U5: Cultural Notes Time Spent",
                "U5: Cultural Notes Interactions",
                "U5: Glossary Time Spent",
                "U5: Glossary Interactions",
                "U5: Translation Time Spent",
                "U5: Translation Interactions",
                "U5: Dictionary Time Spent",
                "U5: Dictionary Interactions",
            ];
    }

    private function processTrackingData($user): array
    {
        $units = Unit::orderBy('title', 'asc')->get();
        $trackings = Tracking::where('user_id', $user->id)->get();
        $interactionTimes = array();
        $totalCorrectAnswersOnPlatform = 0;

        foreach($trackings as $tracking)
        {
            array_push($interactionTimes, $tracking->time_spent_in_minutes);
            $totalCorrectAnswersOnPlatform += intval($tracking->correct_answers);
        }

        $totalTimeSpentOnPlatform = $this->sumTime($interactionTimes);

        return [
            "5",
            $totalTimeSpentOnPlatform,
            "$totalCorrectAnswersOnPlatform",
        ];
    }

    private function processUnits($user): array
    {
        $units = Unit::all();
        $data = array();
        $tips = 0;
        $unitsIndicators = array();

        foreach($units as $unit)
        {
            $unitTrackings = array();
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

            // Extraer todos los tracking de cada seccion y ejercicio
            foreach($unit->sections as $section)
            {
                $exercises = $section->exercises;
                foreach($exercises as $exercise) {
                    if ($exercise->tracking != null) {
                        array_push($timeSpentInUnit, $exercise->tracking->time_spent_in_minutes);
                        array_push($unitTrackings, $exercise->tracking);
                    }
                }
            }

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
                    }

                    if (count($tipsData) == 3) {
                        $tipsInteractions = $tipsData[1];
                        $tipsTime = $tipsData[2];
                    }

                    if (count($culturalNotesData) == 3) {
                        $culturalNotesInteractions = $culturalNotesData[1];
                        $culturalNotesTime = $culturalNotesData[2];
                    }

                    if (count($glossaryData) == 3) {
                        $glossaryInteractions = $glossaryData[1];
                        $glossaryTime = $glossaryData[2];
                    }

                    if (count($translationData) == 3) {
                        $translationInteractions = $translationData[1];
                        $translationTime = $translationData[2];
                    }

                    if (count($dictionaryData) == 3) {
                        $dictionaryInteractions = $dictionaryData[1];
                        $dictionaryTime = $dictionaryData[2];
                    }
                }

                $correctAnswersInUnit += intval($tracking->correct_answers);
                array_push($timeSpentInUnit, $tracking->time_spent_in_minutes);

                array_push($transcriptTimesUnit, $transcriptTime);
                $transcriptInteractionsUnit += intval($transcriptInteractions);
                array_push($tipsTimesUnit, $tipsTime);
                $tipsInteractionsUnit += intval($tipsInteractions);
                array_push($culturalNotesTimesUnit, $culturalNotesTime);
                $culturalNotesInteractionsUnit += intval($culturalNotesInteractions);
                array_push($glossaryTimesUnit, $glossaryTime);
                $glossaryInteractionsUnit += intval($glossaryInteractions);
                array_push($translationTimesUnit, $translationTime);
                $translationInteractionsUnit += intval($translationInteractions);
                array_push($dictionaryTimesUnit, $dictionaryTime);
                $dictionaryInteractionsUnit += intval($dictionaryInteractions);
            }

            $unitData = [
                "timeSpentInUnit" => $this->sumTime($timeSpentInUnit),
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

        return "$accumulatedHours:$accumulatedMinutes";
    }
}