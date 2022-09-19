<?php

namespace App\Http\Controllers;

use App\Models\VoiceRecognitionQuestion;
use App\Models\VoiceRecognitionExercise;
use Illuminate\Http\Request;

class VoiceRecognitionQuestionController extends Controller
{
    public function create()
    {
        return view('exercises.voice_recognition.create');
    }

    public function store(Request $request, $unit_id, $section_id, $exercise_id)
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
        $new_question->exercise_id = $exercise_id;
        $new_question->save();

        return redirect()->route('exercises.voice_recognition.create', [$unit_id, $section_id, $exercise_id]);
    }

    public function show($unit_id, $exercise_id)
    {
        return route('exercises.voice_recognition.create', [$unit_id, $exercise->section_id, $exercise_id]);
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
        $exercise = VoiceRecognitionExercise::find($exercise_id);
        $question->delete();

        return redirect()->route('exercises.voice_recognition.create', [$unit_id, $question->exercise->section_id, $exercise_id]);
    }
}
