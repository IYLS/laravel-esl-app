<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenEndedQuestion;
use App\Models\OpenEndedExcercise;

class OpenEndedQuestionController extends Controller
{
    public function store(Request $request, $unit_id, $section_id, $excercise_id)
    {
        $new_question = new OpenEndedQuestion;
        $new_question->title = $request->question;
        $new_question->excercise_id = $excercise_id;
        $new_question->save();

        return redirect()->route('excercises.open_ended.create', [$unit_id, $section_id, $excercise_id]);
    }

    public function show($unit_id, $excercise_id)
    {
        return route('excercises.open_ended.create', [$unit_id, $excercise->section_id, $excercise_id]);
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
        $excercise = OpenEndedExcercise::find($excercise_id);
        $question = OpenEndedQuestion::find($question_id);
        $question->delete();

        return redirect()->route('excercises.open_ended.create', [$unit_id, $excercise->section_id, $excercise_id]);
    }
}
