<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\Section;
use App\Models\Feedback;

class MultipleChoiceExerciseController extends Controller
{
    public function create($unit_id, $section_id, $exercise_id)
    {
        $questions = Question::where('exercise_id', $exercise_id)->get();
        $exercise = Exercise::where('id', $exercise_id)->get()->first();
        $feedback = Feedback::where('exercise_id', $exercise_id)->get()->first();
        
        return view('exercises.multiple_choice.create', compact('unit_id', 'exercise', 'questions'));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_exercise = new Exercise;
        $new_exercise->title = $request->title;
        $new_exercise->description = $request->description;
        $new_exercise->instructions = $request->instructions;
        $new_exercise->subtype = $request->subtype;
        $new_exercise->section_id = $section->id;
        $new_exercise->image_name = $request->image_name;
        $new_exercise->video_name = $request->video_name;
        $new_exercise->save();

        return redirect()->route('exercises.multiple_choice.create', [$unit_id, $section->id, $new_exercise->id]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($unit_id, $exercise_id)
    {
        $types = ExerciseType::all();
        $exercise = Exercise::find($exercise_id);
        $exercise->delete();

        return redirect()->route('exercises.index', [$unit_id, $types]);
    }
}
