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
                "U1: Tips",
                "U1: Cultural Notes",
                "U1: Transcript",
                "U1: Glossary",
                "U1: Translation",
                "U1: Dictionary",
                "U2: TIEMPO",
                "U2: ACIERTOS",
                "U2: Tips",
                "U2: Cultural Notes",
                "U2: Transcript",
                "U2: Glossary",
                "U2: Translation",
                "U2: Dictionary",
                "U3: TIEMPO",
                "U3: ACIERTOS",
                "U3: Tips",
                "U3: Cultural Notes",
                "U3: Transcript",
                "U3: Glossary",
                "U3: Translation",
                "U3: Dictionary",
                "U4: TIEMPO",
                "U4: ACIERTOS",
                "U4: Tips",
                "U4: Cultural Notes",
                "U4: Transcript",
                "U4: Glossary",
                "U4: Translation",
                "U4: Dictionary",
                "U5: TIEMPO",
                "U5: ACIERTOS",
                "U5: Tips",
                "U5: Cultural Notes",
                "U5: Transcript",
                "U5: Glossary",
                "U5: Translation",
                "U5: Dictionary",
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

            // Extraer todos los tracking de cada sección y ejercicio
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

                $transcriptInteractions = explode("~", $helpOptions[0])[1];
                $transcriptTime = explode("~", $helpOptions[0])[2];
                $tipsInteractions = explode("~", $helpOptions[1])[1];
                $tipsTime = explode("~", $helpOptions[1])[2];
                $culturalNotesInteractions = explode("~", $helpOptions[2])[1];
                $culturalNotesTime = explode("~", $helpOptions[2])[2];
                $glossaryInteractions = explode("~", $helpOptions[3])[1];
                $glossaryTime = explode("~", $helpOptions[3])[2];
                $translationInteractions = explode("~", $helpOptions[4])[1];
                $translationTime = explode("~", $helpOptions[4])[2];
                $dictionaryInteractions = explode("~", $helpOptions[5])[1];
                $dictionaryTime = explode("~", $helpOptions[5])[2];

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

    private function processSectionExerciseData($section, $user)
    {}

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