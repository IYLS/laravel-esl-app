<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultipleChoiceQuestion;

class MultipleChoiceQuestionController extends Controller
{
    public function store(Request $request, $unit_id, $section_id, $exercise_id)
    {
        $new_question = new MultipleChoiceQuestion;
        $new_question->statement = $request->statement;
        $new_question->audio_name = $request->audio_name;
        $new_question->exercise_id = $request->exercise_id;

        $new_question->save();

        return redirect()->route('exercises.multiple_choice.create', [$unit_id, $section_id, $exercise_id]);
    }

    public function show($unit_id, $exercise_id)
    {
        return route('exercises.multiple_choice.create', [$unit_id, $exercise->section_id, $exercise_id]);
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
        $question = MultipleChoiceQuestion::find($question_id);
        $question->delete();

        return redirect()->route('exercises.multiple_choice.create', [$unit_id, $question->exercise->section_id, $exercise_id]);
    }

    public function storeAlternative()
    {
        
    }
}
