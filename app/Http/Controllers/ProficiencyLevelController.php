<?php

namespace App\Http\Controllers;

use App\Models\ProficiencyLevel;
use Illuminate\Http\Request;
use App\Models\Unit;

class ProficiencyLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = ProficiencyLevel::all();
        return view('levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_level = new ProficiencyLevel;
        $new_level->name = $request->name;
        $new_level->save();

        return redirect()->route('levels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProficiencyLevel  $proficiencyLevel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proficiencyLevel = ProficiencyLevel::find($id);
        $units = $proficiencyLevel->units;

        return view('levels.show', compact(['proficiencyLevel', 'units']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProficiencyLevel  $proficiencyLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(ProficiencyLevel $proficiencyLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProficiencyLevel  $proficiencyLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $level = ProficiencyLevel::find($id);

        $level->name = $request->name;
        $level->save();

        return redirect()->route('levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProficiencyLevel  $proficiencyLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProficiencyLevel $proficiencyLevel)
    {
        //
    }
}
