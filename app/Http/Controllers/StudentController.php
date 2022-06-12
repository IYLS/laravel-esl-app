<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;


class StudentController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($unit)
    {
        $unit = Unit::find($unit);
        $keywords = $unit->keywords;

        $help_options = array();

        if ($unit->cultural_notes_enabled) {
            array_push($help_options, $unit->cultural_notes);
        }
        if ($unit->listening_tips_enabled) {
            array_push($help_options, $unit->listening_tips);
        }
        if ($unit->transcript_enabled) {
            array_push($help_options, $unit->transcript);
        }
        if ($unit->glossary_enabled) {
            array_push($help_options, $unit->glossary);
        }
        if ($unit->translation_enabled) {
            array_push($help_options, $unit->translation);
        }
        if ($unit->dictionary_enabled) {
            array_push($help_options, $unit->dictionary);
        }

        return view('student.show', compact(['unit', 'keywords', 'help_options']));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function level_selection(Request $request) 
    {
        $user = Auth::user();
        $units = $user->group->units;

        return view('student.level_selection', compact(['user', 'units']));
    }
}
