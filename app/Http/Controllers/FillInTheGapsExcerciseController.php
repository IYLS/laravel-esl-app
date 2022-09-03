<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillInTheGapsExcercise;
use App\Models\FillInTheGapsQuestion;
use App\Models\Section;
use App\Models\Feedback;

class FillInTheGapsExcerciseController extends Controller
{
    public function create($unit_id, $section_id, $excercise_id)
    {
        $questions = FillInTheGapsQuestion::where('excercise_id', $excercise_id)->get();
        $excercise = FillInTheGapsExcercise::where('id', $excercise_id)->get()->first();
        $feedback = Feedback::where('excercise_id', $excercise_id)->get()->first();
        
        return view('excercises.fill_in_the_gaps.create', compact('unit_id', 'excercise', 'questions'));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_excercise = new FillInTheGapsExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->subtype = $request->subtype;
        $new_excercise->section_id = $section->id;
        $new_excercise->type = 'fill_in_the_gaps';
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
        $excercise = FillInTheGapsExcercise::find($excercise_id);
        $excercise->questions()->delete();
        $excercise->delete();

        return redirect()->route('excercises.index', [$unit_id]);
    }
}
