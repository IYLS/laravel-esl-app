<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultipleChoiceQuestion;

class MultipleChoiceQuestionController extends Controller
{
    public function store(Request $request, $unit_id, $section_id, $excercise_id)
    {
        $new_question = new MultipleChoiceQuestion;
        $new_question->statement = $request->statement;
        $new_question->audio_name = $request->audio_name;
        $new_question->excercise_id = $request->excercise_id;

        $new_question->save();

        return redirect()->route('excercises.multiple_choice.create', [$unit_id, $section_id, $excercise_id]);
    }

    public function show($unit_id, $excercise_id)
    {
        return route('excercises.multiple_choice.create', [$unit_id, $excercise->section_id, $excercise_id]);
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
        $question = OpenEndedQuestion::find($question_id);
        $question->delete();

        return redirect()->route('excercises.multiple_choice.show', [$unit_id, $excercise_id]);
    }

    public function storeAlternative()
    {
        
    }
}
