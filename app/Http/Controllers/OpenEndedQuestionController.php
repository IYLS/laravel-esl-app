<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenEndedQuestion;
use App\Models\OpenEndedExercise;

class OpenEndedQuestionController extends Controller
{
    public function store(Request $request, $unit_id, $section_id, $exercise_id)
    {
        $new_question = new OpenEndedQuestion;
        $new_question->title = $request->question;
        $new_question->exercise_id = $exercise_id;
        $new_question->save();

        return redirect()->route('exercises.open_ended.create', [$unit_id, $section_id, $exercise_id]);
    }

    public function show($unit_id, $exercise_id)
    {
        // return route('exercises.open_ended.create', [$unit_id, $exercise->section_id, $exercise_id]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($unit_id, $exercise_id, $question_id)
    {
        $exercise = OpenEndedExercise::find($exercise_id);
        $question->delete();

        return redirect()->route('exercises.open_ended.create', [$unit_id, $question->exercise->section_id, $exercise_id]);
    }
}
