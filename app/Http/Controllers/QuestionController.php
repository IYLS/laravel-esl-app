<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Excercise;

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

    public function store(Request $request, $excercise_id, $section_id, $excercise_type_id)
    {
        $question = new Question;
        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->excercise_id = $excercise_id;
        $question->audio_name = $request->audio_name;
        $question->image_name = $request->image_name;
        $question->save();

        return redirect()->route('excercises.show', [$excercise_id]);
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

    public function destroy($excercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('excercises.show', $question->excercise_id);
    }
}
