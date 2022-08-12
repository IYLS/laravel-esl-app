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
        $new_question->excercise_id = $request->excercise_id;

        $new_question->save();

        return redirect()->route('excercises.fill_in_the_gaps.create', [$unit_id, $section_id, $excercise_id]);
    }

    public function show($unit_id, $excercise_id)
    {
        return route('excercises.fill_in_the_gaps.create', [$unit_id, $excercise->section_id, $excercise_id]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($unit_id, $excercise_id, $question_id)
    {
        $question = FillInTheGapsQuestion::find($question_id);
        $question->delete();

        return redirect()->route('excercises.fill_in_the_gaps.create', [$unit_id, $question->excercise->section_id, $excercise_id]);
    }
}
