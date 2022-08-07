<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Excercise;
use App\Models\Section;

class ExcerciseController extends Controller
{
    public function index($unit_id)
    {   
        $pre_listening_excercises = $this->getExcercises($unit_id, 'pre_listening');
        $while_listening_excercises = $this->getExcercises($unit_id, 'while_listening');
        $post_listening_excercises = $this->getExcercises($unit_id, 'post_listening');

        return view('excercises.index', compact('unit_id', 'pre_listening_excercises', 'while_listening_excercises', 'post_listening_excercises'));
     }

    public function create()
    {
        //
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

    private function getExcercises($unit_id, $section_name)
    {
        $section = Section::where('unit_id', $unit_id)->where('name', $section_name)->get()->first();

        $voice_recognition = $section->voiceRecognitionExcercises()->get();
        $multiple_choice = $section->multipleChoiceExcercises()->get();
        $fill_in_the_gaps = $section->fillInTheGapsExcercises()->get();
        $drag_and_drop = $section->dragAndDropExcercises()->get();
        $open_ended = $section->openEndedExcercises()->get();
        
        $excercises = $drag_and_drop->merge($open_ended)->merge($fill_in_the_gaps)->merge($multiple_choice)->merge($voice_recognition);

        return $excercises;
    }
}
