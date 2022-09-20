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
        $audio_file_name = $request->file('audio')->getClientOriginalName();
        $audio_file_path = $request->file('audio')->storeAs('public/files', $audio_file_name);

        $image_file_name = $request->file('image')->getClientOriginalName();
        $image_file_path = $request->file('image')->storeAs('public/files', $image_file_name);

        $question = new Question;
        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;
        $question->audio_name = $audio_file_name;
        $question->image_name = $image_file_name;
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
