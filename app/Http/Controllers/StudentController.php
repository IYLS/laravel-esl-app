<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Section;
use App\Models\Tracking;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    public function show($unit_id)
    {   
        $unit = Unit::find($unit_id);
        $keywords = $unit->keywords;
        $user = Auth::user();

        $completed_exercises = Tracking::where('user_id', $user->id)->get()->map(function ($tracking) {
            return $tracking->exercise_id;
        })->toArray();

        $help_options = array();
        if ($unit->cultural_notes_enabled) array_push($help_options, $unit->cultural_notes);
        if ($unit->listening_tips_enabled) array_push($help_options, $unit->listening_tips);
        if ($unit->transcript_enabled) array_push($help_options, $unit->transcript);
        if ($unit->glossary_enabled) array_push($help_options, $unit->glossary);
        if ($unit->translation_enabled) array_push($help_options, $unit->translation);
        if ($unit->dictionary_enabled) array_push($help_options, $unit->dictionary);

        return view('student.show', compact(['unit', 'keywords', 'help_options', 'user', 'completed_exercises']));
    }

    public function select(Request $request)
    {
        if ($request->unit != null)
        {
            $unit_id = $request->unit;
            return redirect()->route('student.show', $unit_id);
        } 
        else 
        {
            return view('student.level_selection');
        }
    }

    public function level_selection() 
    {
        $user = Auth::user();
        
        if(isset($user->group->units) and $user->group->units != null)
        {
            $units = $user->group->units->sortBy('position');
            return view('student.level_selection', compact(['user', 'units']));
        }
        else
        {
            return view('student.level_selection', compact(['user']));
        }
    }

}
