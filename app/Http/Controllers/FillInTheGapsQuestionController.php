<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillInTheGapsQuestion;

class FillInTheGapsQuestionController extends Controller
{
    public function store(Request $request)
    {
        $new_question = new FillInTheGapsQuestion;
        $new_question->statement = $request->statement;
        $new_question->audio_name = $request->audio_name;
        $new_question->exercise_id = $request->exercise_id;

        $new_question->save();

        return redirect()->route('exercises.fill_in_the_gaps.create', [$unit_id, $section_id, $exercise_id]);
    }

    public function show($unit_id, $exercise_id)
    {
        return route('exercises.fill_in_the_gaps.create', [$unit_id, $exercise->section_id, $exercise_id]);
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
        $question = FillInTheGapsQuestion::find($question_id);
        $question->delete();

        return redirect()->route('exercises.fill_in_the_gaps.create', [$unit_id, $question->exercise->section_id, $exercise_id]);
    }
}
