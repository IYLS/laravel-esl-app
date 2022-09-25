<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Section;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\ExerciseType;
use App\Models\Feedback;
use App\Models\FeedbackType;

class ExerciseController extends Controller
{
    public function index($unit_id)
    {   
        $types = ExerciseType::all();
        $unit = Unit::where("id", $unit_id)->first();
        return view('exercises.index', compact('unit', 'types'));
     }

     public function create(Request $request, $unit_id, $exercise_type_id, $section_id)
     {
        $type = ExerciseType::find($exercise_type_id);

        $title = $request->title;
        $description = $request->description;

        return view("exercises.$type->underscore_name.create", compact(['unit_id', 'section_id', 'title', 'description']));
    }

    public function store(Request $request, $unit_id, $type_id, $section_id)
    {
        $exercise = new Exercise;
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->exercise_type_id = $type_id;
        $exercise->section_id = $section_id;

        if(isset($request->subtype)) {
            $exercise->subtype = $request->subtype;
        }

        $exercise->save();

        return redirect()->route('exercises.show', $exercise->id);
    }

    public function show($exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $feedback_types = FeedbackType::all();
        $sections = Section::where('unit_id', $exercise->section->unit->id)->get();
        $type_name = $exercise->exerciseType->underscore_name;

        return view("exercises.$type_name.create", compact('exercise', 'feedback_types', 'sections'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $unit_id, $type_id, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->section_id = $request->section;
        $exercise->save();

        return redirect()->route('exercises.show', $exercise->id);
    }

    public function destroy($unit_id, $exercise_type_id, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $exercise->delete();

        return redirect()->route('exercises.index', [$exercise->section->unit_id]);
    }

    private function getExercises($unit_id, $section_name)
    {
        $section = Section::where('unit_id', $unit_id)->where('name', $section_name)->get()->first();
        $exercises = $section->exercises()->get();
        return $exercises;
    }

    private function subtype($id)
    {
        $name = "";

        switch($id){
            case 1: 
                $name = "predicting";
                break;
            case 2: 
                $name = "what_do_you_hear";
                break;
            case 3:
                $name = "evaluating_statements";
                break;
            case 4:
                $name = "multiple_choice";
                break;
        }

        return $name;
    }
}