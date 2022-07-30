<?php

namespace App\Http\Controllers;

use App\Models\VoiceRecognitionExcercise;
use Illuminate\Http\Request;

class VoiceRecognitionExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('excercises.voice_recognition.create');
    }

    public function store(Request $request)
    {
        //
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
