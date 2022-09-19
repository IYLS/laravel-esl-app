<?php

namespace App\Http\Controllers;

use App\Models\VoiceRecognitionExercise;
use Illuminate\Http\Request;
use App\Models\VoiceRecognitionQuestion;
use App\Models\Section;
use App\Models\Feedback;

class VoiceRecognitionExerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $exercise_id)
    {
        $questions = VoiceRecognitionQuestion::where('exercise_id', $exercise_id)->get();
        $exercise = VoiceRecognitionExercise::where('id', $exercise_id)->get()->first();
        $feedback = Feedback::where('exercise_id', $exercise_id)->get()->first();

        return view('exercises.voice_recognition.create', compact(['unit_id', 'section_id', 'questions', 'exercise']));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_exercise = new VoiceRecognitionExercise;
        $new_exercise->title = $request->title;
        $new_exercise->description = $request->description;
        $new_exercise->section_id = $section->id;
        $new_exercise->save();

        $exercise_id = $new_exercise->id;

        return redirect()->route('exercises.voice_recognition.create', [$unit_id, $section->id, $exercise_id]);
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

    public function destroy($unit_id, $exercise_id)
    {
        $exercise = VoiceRecognitionExercise::find($exercise_id);
        $exercise->questions()->delete();
        $exercise->delete();

        return redirect()->route('exercises.index', [$unit_id]);
    }
}
