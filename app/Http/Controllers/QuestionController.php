<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
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

    public function store(StoreQuestionRequest $request)
    {
        //
    }

    public function show(Question $question)
    {
        //
    }

    public function edit(Question $question)
    {
        //
    }

    public function update(UpdateQuestionRequest $request, Question $question)
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
