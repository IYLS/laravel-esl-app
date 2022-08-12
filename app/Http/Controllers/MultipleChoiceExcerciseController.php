<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultipleChoiceExcercise;
use App\Models\MultipleChoiceQuestion;
use App\Models\Section;

class MultipleChoiceExcerciseController extends Controller
{
    public function create($unit_id, $section_id, $excercise_id)
    {
        $questions = MultipleChoiceQuestion::where('excercise_id', $excercise_id)->get();
        $excercise = MultipleChoiceExcercise::where('id', $excercise_id)->get()->first();
        
        return view('excercises.multiple_choice.create', compact('unit_id', 'excercise', 'questions'));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_excercise = new MultipleChoiceExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->instructions = $request->instructions;
        $new_excercise->subtype = $request->subtype;
        $new_excercise->section_id = $section->id;
        $new_excercise->image_name = $request->image_name;
        $new_excercise->video_name = $request->video_name;
        $new_excercise->type = 'open_ended';
        $new_excercise->save();

        return redirect()->route('excercises.multiple_choice.create', [$unit_id, $section->id, $new_excercise->id]);
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
        $excercise = MultipleChoiceExcercise::find($excercise_id);
        $excercise->delete();

        return redirect()->route('excercises.index', [$unit_id]);
    }
}
