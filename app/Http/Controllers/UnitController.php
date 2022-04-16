<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\ProficiencyLevel;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = ProficiencyLevel::all();
        return view('units.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_unit = new Unit;
        $new_unit->title = $request->title;
        $new_unit->author = $request->author;
        $new_unit->description = $request->description;
        $new_unit->listening_tips = $request->listening_tips;
        $new_unit->cultural_notes = $request->cultural_notes;
        $new_unit->technology_notes = $request->technology_notes;
        $new_unit->biology_notes = $request->biology_notes;
        $new_unit->transcript = $request->transcript;
        $new_unit->glossary = $request->glossary;
        $new_unit->translation = $request->translation;
        $new_unit->dictionary = $request->dictionary;
        $new_unit->video_url = $request->video_url;

        // FIXME: Probar si funciona
        $new_unit->proficiency_level_id = $request->level;

        return redirect()->route('units.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        $levels = ProficiencyLevel::all();

        return view('units.show', compact('unit', 'levels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        $unit->title = $request->title;
        $unit->author = $request->author;
        $unit->description = $request->description;
        $unit->listening_tips = $request->listening_tips;
        $unit->cultural_notes = $request->cultural_notes;
        $unit->technology_notes = $request->technology_notes;
        $unit->biology_notes = $request->biology_notes;
        $unit->transcript = $request->transcript;
        $unit->glossary = $request->glossary;
        $unit->translation = $request->translation;
        $unit->dictionary = $request->dictionary;
        $unit->video_url = $request->video_url;
        $unit->save();

        return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
