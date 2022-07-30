<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class VoiceRecognitionQuestionController extends Controller
{
    public function index()
    {
        return view('voice_recognition_question.index');
    }

    public function create()
    {
        return view('excercises.voice_recognition_question.create');
    }

    public function store(Request $request)
    {
        $question = new VoiceRecognitionQuestion;

        $question->image_url = $request->image_url;
        $question->audio_url = $request->audio_url;

        $question->save();

        return redirect()->route('voice_recognition_question.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
