<?php

namespace App\Http\Controllers;

use App\Models\VoiceRecognitionQuestion;
use Illuminate\Http\Request;

class VoiceRecognitionQuestionController extends Controller
{
    public function create()
    {
        return view('excercises.voice_recognition.create');
    }

    public function store(Request $request, $unit_id, $section_id, $excercise_id)
    {
        $audio_file_name = $request->file('audio')->getClientOriginalName();
        $audio_file_path = $request->file('audio')->storeAs('public/files', $audio_file_name);

        $image_file_name = $request->file('image')->getClientOriginalName();
        $image_file_path = $request->file('image')->storeAs('public/files', $image_file_name);

        $new_question = new VoiceRecognitionQuestion;
        $new_question->image_url = $image_file_path;
        $new_question->image_name = $image_file_name;
        $new_question->audio_url = $audio_file_path;
        $new_question->audio_name = $audio_file_name;
        $new_question->title = $request->title;        
        $new_question->excercise_id = $excercise_id;
        $new_question->save();

        return redirect()->route('excercises.voice_recognition.create', [$unit_id, $section_id, $excercise_id]);
    }

    public function show($unit_id, $excercise_id)
    {
        return route('excercises.voice_recognition.create', [$unit_id, $excercise->section_id, $excercise_id]);
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
        $question = VoiceRecognitionQuestion::find($question_id);
        $question->delete();

        return redirect()->route('excercises.open_ended.show', [$unit_id, $excercise_id]);
    }
}
