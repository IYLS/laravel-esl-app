<?php

namespace App\Http\Controllers;

use App\Models\VoiceRecognitionExcercise;
use Illuminate\Http\Request;
use App\Models\VoiceRecognitionQuestion;
use App\Models\Section;

class VoiceRecognitionExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $excercise_id)
    {
        $questions = VoiceRecognitionQuestion::where('excercise_id', $excercise_id)->get();
        $excercise = VoiceRecognitionExcercise::where('id', $excercise_id)->get()->first();

        return view('excercises.voice_recognition.create', compact(['unit_id', 'section_id', 'questions', 'excercise']));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_excercise = new VoiceRecognitionExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->section_id = $section->id;
        $new_excercise->type = 'voice_recognition';
        $new_excercise->save();

        $excercise_id = $new_excercise->id;

        return redirect()->route('excercises.voice_recognition.create', [$unit_id, $section->id, $excercise_id]);
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

    public function destroy($unit_id, $section_id, $excercise_id)
    {
        $excercise = VoiceRecognitionExcercise::find($excercise_id);
        $excercise->delete();

        return redirect()->route('excercises.index', [$unit_id]);
    }
}
