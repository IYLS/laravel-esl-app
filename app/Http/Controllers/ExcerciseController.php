<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\ExcerciseType;
use App\Models\Excercise;
use App\Models\Question;
use App\Models\Feedback;
use App\Models\Section;

class ExcerciseController extends Controller
{
    public function index($unit_id)
    {   
        $types = ExcerciseType::all();
        $unit = Unit::where("id", $unit_id)->first();
        return view('excercises.index', compact('unit', 'types'));
     }

     public function create($unit_id, $excercise_type_id, $section_id)
     {
        $type = ExcerciseType::find($excercise_type_id);

        return view("excercises.$type->underscore_name.create", compact(['unit_id', 'section_id']));
    }

    public function store(Request $request, $unit_id, $section_id)
    {
        $section = Section::find($section_id);

        $excercise = new Excercise;
        $excercise->title = $request->title;
        $excercise->description = $request->description;
        $excercise->excercise_type_id = $request->type;
        $excercise->section_id = $section->id;
        $excercise->type = $request->type;
        $excercise->save();

        return redirect()->route('excercises.create', [$unit_id, $section_id, $excercise->id]);
    }

    public function show($excercise_id)
    {
        $excercise = Excercise::find($excercise_id);
        $type_name = $excercise->excerciseType->underscore_name;

        return view("excercises.$type_name.create", compact('excercise'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($excercise_id)
    {
        $types = ExcerciseTypes::all();
        $excercise = Excercise::find($excercise_id);
        $excercise->delete();

        return redirect()->route('excercises.index', [$excercise->section->unit_id, $types]);
    }

    private function getExcercises($unit_id, $section_name)
    {
        $section = Section::where('unit_id', $unit_id)->where('name', $section_name)->get()->first();
        $excercises = $section->excercises()->get();
        return $excercises;
    }
}
