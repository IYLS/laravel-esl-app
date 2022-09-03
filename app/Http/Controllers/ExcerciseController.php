<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class ExcerciseController extends Controller
{
    public function index($unit_id)
    {   
        $unit = Unit::where("id", $unit_id)->first();
        return view('excercises.index', compact('unit'));
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
        $excercises = $section->excercises()->get();
        return $excercises;
    }
}
