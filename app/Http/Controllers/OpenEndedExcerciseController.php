<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenEndedExcercise;
use App\Models\OpenEndedQuestion;
use App\Models\Section;
use App\Models\Feedback;

class OpenEndedExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $excercise_id)
    {
        $questions = OpenEndedQuestion::where('excercise_id', $excercise_id)->get();
        $excercise = OpenEndedExcercise::where('id', $excercise_id)->get()->first();
        $feedback = Feedback::where('excercise_id', $excercise_id)->get()->first();
        
        return view('excercises.open_ended.create', compact('unit_id', 'excercise', 'questions'));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_excercise = new OpenEndedExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->section_id = $section->id;
        $new_excercise->type = 'open_ended';
        $new_excercise->save();

        return redirect()->route('excercises.open_ended.create', [$unit_id, $section->id, $new_excercise->id]);
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

    public function destroy($unit_id, $excercise_id)
    {
        $excercise = OpenEndedExcercise::find($excercise_id);
        $excercise->questions()->delete();
        $excercise->delete();

        return redirect()->route('excercises.index', [$unit_id]);
    }
}
