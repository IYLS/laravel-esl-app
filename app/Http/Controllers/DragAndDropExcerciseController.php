<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Question;
use App\Models\Feedback;
use App\Models\Section;


class DragAndDropExerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $exercise_id)
    {
        $questions = Question::where('exercise_id', $exercise_id)->get();
        $exercise = Exercise::where('id', $exercise_id)->get()->first();
        $feedback = Feedback::where('exercise_id', $exercise_id)->get()->first();

        return view('exercises.drag_and_drop.create', compact(['unit_id', 'section_id', 'questions', 'exercise', 'feedback']));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_exercise = new DragAndDropExercise;
        $new_exercise->title = $request->title;
        $new_exercise->description = $request->description;
        $new_exercise->section_id = $section->id;
        $new_exercise->save();

        $exercise_id = $new_exercise->id;

        return redirect()->route('exercises.drag_and_drop.create', [$unit_id, $section_id, $exercise_id]);
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
        $exercise->questions()->delete();
        $exercise->delete();

        return redirect()->route('exercises.index', [$unit_id, $types]);
    }
}
