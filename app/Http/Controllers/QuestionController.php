<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exercise;

class QuestionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $exercise_id, $section_id, $exercise_type_id)
    {
        $question = new Question;
        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;
        $question->audio_name = $request->audio_name;
        $question->image_name = $request->image_name;
        $question->save();

        return redirect()->route('exercises.show', [$exercise_id]);
    }

    public function show(Question $question)
    {
        //
    }

    public function edit(Question $question)
    {
        //
    }

    public function update(Request $request, Question $question)
    {
        //
    }

    public function destroy($exercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('exercises.show', $question->exercise_id);
    }
}
