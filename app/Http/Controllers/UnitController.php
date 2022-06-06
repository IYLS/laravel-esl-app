<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Models\Group;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('units.create', compact(['groups']));
    }

    public function store(Request $request)
    {
        $new_unit = new Unit;
        $new_unit->title = $request->title;
        $new_unit->author = $request->author;
        $new_unit->description = $request->description;
        $new_unit->listening_tips = $request->listening_tips;
        $new_unit->cultural_notes = $request->cultural_notes;
        $new_unit->transcript = $request->transcript;
        $new_unit->glossary = $request->glossary;
        $new_unit->translation = $request->translation;
        $new_unit->dictionary = $request->dictionary;
        $new_unit->group_id = $request->group;
        $new_unit->save();

        return redirect()->route('units.index')->with('success', 'Unit created successfully!');
    }

    public function show($id)
    {
        $unit = Unit::find($id);
        $groups = Group::all();

        return view('units.show', compact(['unit', 'groups']));
    }

    public function edit(Unit $unit)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        $unit->title = $request->title;
        $unit->author = $request->author;
        $unit->description = $request->description;
        $unit->glossary = $request->glossary;
        $unit->cultural_notes = $request->cultural_notes;
        $unit->listening_tips = $request->listening_tips;
        $unit->transcript = $request->transcript;
        $unit->translation = $request->translation;
        $unit->dictionary = $request->dictionary;
        $unit->save();

        return redirect()->route('units.index');
    }

    public function destroy(Unit $unit)
    {
        //
    }
}
