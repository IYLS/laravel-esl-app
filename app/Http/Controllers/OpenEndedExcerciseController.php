<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenEndedExercise;
use App\Models\OpenEndedQuestion;
use App\Models\Section;
use App\Models\Feedback;

class OpenEndedExerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $exercise_id)
    {
        $questions = OpenEndedQuestion::where('exercise_id', $exercise_id)->get();
        $exercise = OpenEndedExercise::where('id', $exercise_id)->get()->first();
        $feedback = Feedback::where('exercise_id', $exercise_id)->get()->first();
        
        return view('exercises.open_ended.create', compact('unit_id', 'exercise', 'questions'));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_exercise = new OpenEndedExercise;
        $new_exercise->title = $request->title;
        $new_exercise->description = $request->description;
        $new_exercise->section_id = $section->id;
        $new_exercise->save();

        return redirect()->route('exercises.open_ended.create', [$unit_id, $section->id, $new_exercise->id]);
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
        $types = ExerciseTypes::all();
        $exercise = Exercise::find($exercise_id);
        $exercise->questions()->delete();
        $exercise->delete();

        return redirect()->route('exercises.index', [$unit_id, $types]);
    }
}
