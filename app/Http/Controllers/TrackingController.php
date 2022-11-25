<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Unit;
use App\Models\Group;

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
        $tracking = new Tracking;
        
        $intent_number = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
        $intent_number += 1;

        $tracking->intent_number = "$intent_number";

        if($request->time == null) { 
            $tracking->time_spent_in_minutes = "00:00";
        } else {
            $tracking->time_spent_in_minutes = $request->time;
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
            $feedback_interactions = array();
            foreach($exercise->questions as $index=>$question) {
                $directive_count = $request->directive["$question->id"];
                $explanatory_count = $request->explanatory["$question->id"];
                $elaborative_count = $request->elaborative["$question->id"];
                $knowledge_count = $request->knowledge["$question->id"];

                $question_number = $index+1;
                array_push($feedback_interactions, "$question_number:Directive~$directive_count,Explanatory~$explanatory_count,Elaborative~$elaborative_count,Knowledge of Correct Response~$knowledge_count");
            }

            $tracking->feedback = implode(';', $feedback_interactions);
        }

        $help_options_interactions = array();
        array_push($help_options_interactions, "Transcript~$request->transcript_count~$request->transcript_total_time");
        array_push($help_options_interactions, "Listening tips~$request->listening_tips_count~$request->listening_tips_total_time");
        array_push($help_options_interactions, "Culturalnotes~$request->cultural_notes_count~$request->cultural_notes_total_time");
        array_push($help_options_interactions, "Glossary~$request->glossary_count~$request->glossary_total_time");
        array_push($help_options_interactions, "Translation~$request->translation_count~$request->translation_total_time");
        array_push($help_options_interactions, "Dictionary~$request->dictionary_count~$request->dictionary_total_time");

        $tracking->help_options = implode(",", $help_options_interactions);

        $tracking->save();

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
        $tracking = Tracking::find($id);
        return view('tracking.show', compact('tracking'));
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