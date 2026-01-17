<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Unit;
use App\Models\Group;
use App\Models\TrackingHelpUsage;
use App\Models\TrackingFeedbackUsage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTracking;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        $students = User::where('role', 'student')->get();
        $tracking = Tracking::all()->sortByDesc('created_at')->take(50);

        if ($tracking != null)  {
            return view('tracking.index', compact('tracking', 'groups', 'students'));
        } else if($tracking == null) {
            $tracking = array();
            return view('tracking.index', compact('tracking', 'groups', 'students'));
        }
    }

    public function executeFilter(Request $request)
    {
        $group_id = $request->group;
        $month_number = $request->month;
        $user_id = $request->student;

        if ($user_id != null and $user_id != "any") {
            $tracking = Tracking::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        } else if ($group_id != "any" and $group_id != null) {
            $users = User::where('group_id', $group_id)->get();
            $track = collect(new Tracking);
            foreach($users as $user) { $track = $track->merge(Tracking::where('user_id', $user->id)->get()); }
            $tracking = $track->sortByDesc('created_at');
        } else {
            $tracking = Tracking::orderBy('created_at', 'desc')->get();
        }

        $groups = Group::all();
        $students = User::where('role', 'student')->get();

        return view('tracking.index', compact('tracking', 'groups', 'students'));
    }

    public function store(Request $request, $exercise_id, $user_id)
    {
        $exercise = Exercise::find($exercise_id);

        if($exercise->exercise_type_id != 5) {
            $tracking = new Tracking;

            $intent_number = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
            $intent_number += 1;
    
            $tracking->intent_number = "$intent_number";
    
            if($request->time == null) {
                $tracking->time_spent_in_seconds = 0;
            } else {
                // Convertir formato "HH:MM:SS" o "MM:SS" a segundos
                $time = $request->time;
                $parts = explode(':', $time);
                
                if (count($parts) == 3) {
                    // Formato HH:MM:SS
                    $tracking->time_spent_in_seconds = (int)$parts[0] * 3600 + (int)$parts[1] * 60 + (int)$parts[2];
                } elseif (count($parts) == 2) {
                    // Formato MM:SS
                    $tracking->time_spent_in_seconds = (int)$parts[0] * 60 + (int)$parts[1];
                } else {
                    // Si no es formato válido, asumir que ya viene en segundos
                    $tracking->time_spent_in_seconds = (int)$time;
                }
            }
    
            if($request->correct == null) {
                $tracking->correct_answers = "0";
            } else {
                $tracking->correct_answers = $request->correct;
            }
    
            if($request->wrong == null) {
                $tracking->wrong_answers = "0";
            } else {
                $tracking->wrong_answers = $request->wrong;
            }
    
            $tracking->exercise_id = $exercise_id;
            $tracking->user_id = $user_id;
            $tracking->save();
    
            if($exercise != null and $exercise->exerciseType->underscore_name != 'form')
            {
                if ($request->responses != null)
                {
                    foreach($request->responses as $id=>$response)
                    {
                        $user_response = new UserResponse;
                        if($response == null) $response = "";
                        $user_response->response = $response;
                        $user_response->question_id = $id;
                        $user_response->tracking_id = $tracking->id;
                        $user_response->save();
                    }
                }
            } else {
                foreach($exercise->questions as $question)
                {
                    // EXCLUSIVE RESPONSES IS FALSE
                    if (!$question->exclusive_responses)
                    {
                        if ($request->answers != null)
                        {
                            foreach($request->answers as $id=>$answer)
                            {
                                $question_id = $id;
                                foreach($answer as $a)
                                {
                                    foreach($a as $response)
                                    {
                                        $user_response = new UserResponse;
                                        $user_response->response = $response;
                                        $user_response->question_id = $question_id;
                                        $user_response->tracking_id = $tracking->id;
                                        $user_response->save();
                                    }
                                }
                            }
                        }
                    // FIXME: EXCLUSIVE RESPONSES IS TRUE
                    } else {
                        if ($request->answers != null)
                        {
                            foreach($request->answers as $id=>$answer)
                            {
                                $question_id = $id;
                                foreach($answer as $response)
                                {
                                    $user_response = new UserResponse;
                                    $user_response->response = $response;
                                    $user_response->question_id = $question_id;
                                    $user_response->tracking_id = $tracking->id;
                                    $user_response->save();
                                }
                            }
                        }
                    }
                }
            }
    
    
            if ($exercise->subtype != 99 and $exercise->subtype != 991) {
                // Acumular contadores de feedback por tipo
                $feedback_counts = [
                    'Directive' => 0,
                    'Explanatory' => 0,
                    'Elaborative' => 0,
                    'Knowledge of Correct Response' => 0
                ];
                
                foreach($exercise->questions as $question) {
                    if (isset($request->directive["$question->id"])) {
                        $feedback_counts['Directive'] += (int)$request->directive["$question->id"];
                    }
                    if (isset($request->explanatory["$question->id"])) {
                        $feedback_counts['Explanatory'] += (int)$request->explanatory["$question->id"];
                    }
                    if (isset($request->elaborative["$question->id"])) {
                        $feedback_counts['Elaborative'] += (int)$request->elaborative["$question->id"];
                    }
                    if (isset($request->knowledge["$question->id"])) {
                        $feedback_counts['Knowledge of Correct Response'] += (int)$request->knowledge["$question->id"];
                    }
                }
    
                // Guardar feedback usage en la nueva tabla
                foreach($feedback_counts as $feedback_type => $count) {
                    if ($count > 0) {
                        TrackingFeedbackUsage::create([
                            'tracking_id' => $tracking->id,
                            'feedback_type' => $feedback_type,
                            'open_count' => $count
                        ]);
                    }
                }
            }
    
            // Guardar help options en la nueva tabla
            $help_options = [
                'Transcript' => ['count' => $request->transcript_count ?? 0, 'time' => $request->transcript_total_time ?? 0],
                'Listening tips' => ['count' => $request->listening_tips_count ?? 0, 'time' => $request->listening_tips_total_time ?? 0],
                'Cultural notes' => ['count' => $request->cultural_notes_count ?? 0, 'time' => $request->cultural_notes_total_time ?? 0],
                'Glossary' => ['count' => $request->glossary_count ?? 0, 'time' => $request->glossary_total_time ?? 0],
                'Translation' => ['count' => $request->translation_count ?? 0, 'time' => $request->translation_total_time ?? 0],
                'Dictionary' => ['count' => $request->dictionary_count ?? 0, 'time' => $request->dictionary_total_time ?? 0]
            ];
    
            foreach($help_options as $help_type => $data) {
                if ($data['count'] > 0 || $data['time'] > 0) {
                    TrackingHelpUsage::create([
                        'tracking_id' => $tracking->id,
                        'help_type' => $help_type,
                        'open_count' => (int)$data['count'],
                        'time_spent_seconds' => (int)$data['time']
                    ]);
                }
            }
    
            $tracking->save();
        }

        $message = '🎉 Submission completed successfully! 🎉';
        if($exercise->feedbacks->where('feedback_type_id', 1)->first() != null) {
            $message = $exercise->feedbacks->where('feedback_type_id', 1)->first()->message;
        }

        $status = $this->exerciseStatus($exercise, $user_id);

        return response()->json([
            'result' => 'success',
            'feedback_message' => "$message",
            'status_message' => $status['message'],
            'navigation_url' => $status['url'],
            'navigation_type' => $status['type'],
        ]);

        return response()->json($request);
    }

    public function show($id)
    {
        $tracking = Tracking::with(['helpUsage', 'feedbackUsage'])->find($id);
        return view('tracking.show', compact('tracking'));
    }

    public function exportData(Request $request)
    {
        $userId = $request->student;
        $user = User::find($userId);
        $userName = $user->name;
        $currentDate = Carbon::now()->format('d-m-Y H:i');
        return Excel::download(new ExportTracking($userId), "$userName - $currentDate.xlsx");
    }

    private function sectionStatus($exercise, $user_id) {
        $section = $exercise->section;
        $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
        $section_completed = false;
        $completed_exercises = array();

        foreach($exercises as $exercise) {
            $tracking_count = Tracking::where('user_id', $user_id)->where('exercise_id', $exercise->id)->count();
            if($tracking_count >= 1) array_push($completed_exercises, $exercise->id);
        }
        if(count($exercises) == count($completed_exercises))
            return true;
        else {
            return false;
        }
    }

    private function unitStatus($exercise, $user_id) {
        $unit = $exercise->section->unit;
        $section_completed = false;
        $sections_completed = array();

        foreach($unit->sections as $section) {
            $exercises = $section->exercises->where('exercise_type_id', '!=', 5);

            $completed_exercises = array();
            foreach($exercises as $exercise) {
                $tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
                if($tracking_count >= 1) array_push($completed_exercises, $exercise->id);
            }

            if (count($completed_exercises) == count($exercises)) array_push($sections_completed, $section->id);
        }

        if(count($unit->sections) == count($sections_completed))
            return true;
        else {
            return false;
        }
    }

    private function getNextExercise($exercise, $user_id) {
        // Buscar primer ejercicio sin respuesta registrado que no sea de tipo Voice Recognition

        $section = $exercise->section;
        $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
        $next_exercise = "";

        foreach($exercises as $exercise)
        {
            $exercise_tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
            if($exercise_tracking_count == 0) {
                $next_exercise = $exercise;
                break;
            }
        }

        $url = $next_exercise->exerciseType->underscore_name . $next_exercise->id;

        return $url;
    }

    private function getNextSection($exercise, $user_id) {
        // Buscar primer ejercicio sin respuesta registrado que no sea de tipo Voice Recognition

        $section = $exercise->section;
        $unit = $section->unit;
        $next_section;

        foreach($unit->sections as $section) {
            $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
            foreach($exercises as $exercise)
            {
                $exercise_tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
                if($exercise_tracking_count == 0) {
                    $next_section = $exercise->section;
                    break;
                }
            }
        }

        if(isset($next_section)) {
            $url = $next_section->underscore_name;
        } else {
            $url = "";
        }

        return $url;
    }

    private function getNextUnit($exercise, $user_id) {
        $section = $exercise->section;
        $unit = $section->unit;
        $user = User::find($user_id);
        $group = Group::find($user->group_id);
        $units = $group->units;
        $completed_sections = [];

        $next_unit;

        foreach($units as $unit) {
            foreach($unit->sections as $section) {
                $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
                $completed_exercises = [];
                foreach($exercises as $exercise)
                {
                    $exercise_tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
                    if($exercise_tracking_count >= 1) array_push($completed_exercises, $exercise->id);
                }
                if(count($exercises) == count($completed_exercises)) array_push($completed_sections, $section->id);
            }
            if(count($unit->sections) == count($completed_sections)) {
                $u = Unit::where('position', $unit->position + 1)->get()->first();
                $next_unit = route('student.show', "$u->id");
                break;
            }
        }

        if ($next_unit != null and isset($next_unit)) {
            return $next_unit;
        } else {
            return "";
        }

    }

    private function exerciseStatus($exercise, $user_id) {
        $section_completed = $this->sectionStatus($exercise, $user_id);
        $unit_completed = $this->unitStatus($exercise, $user_id);

        if ($unit_completed) {
            $next_unit_url = $this->getNextUnit($exercise, $user_id);
            return ["message" => "You completed this unit, now you can move to the next unit", "url" => "$next_unit_url", 'type' => 'unit'];
        } else if ($section_completed) {
            $next_section_url = $this->getNextSection($exercise, $user_id);
            return ["message" => "You completed this stage, now you can continue with the next one", "url" => "$next_section_url", 'type' => 'section'];
        } else {
            $next_exercise_url = $this->getNextExercise($exercise, $user_id);
            return ["message" => "You completed this exercise, now you can continue with the next one", "url" => "$next_exercise_url", 'type' => 'exercise'];
        }
    }
}