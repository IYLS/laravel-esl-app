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

        if (isset($unit->sections->first()->exercises)) {
            $first_exercise_id = $unit->sections->first()->exercises->first()->id;
        } else {
            $first_exercise_id = 0;
        }

        $completed_exercises = Tracking::where('user_id', $user->id)->get()->map(function ($tracking) {
            return $tracking->exercise_id;
        })->toArray();

        // Calcular progreso de la unidad (ejercicios completados / total de ejercicios, excluyendo tipo 5)
        $total_exercises = 0;
        $completed_count = 0;
        
        foreach($unit->sections as $section) {
            $section_exercises = $section->exercises->where('exercise_type_id', '!=', 5);
            $total_exercises += $section_exercises->count();
            
            foreach($section_exercises as $exercise) {
                if (in_array($exercise->id, $completed_exercises)) {
                    $completed_count++;
                }
            }
        }
        
        $unit_progress = $total_exercises > 0 ? round(($completed_count / $total_exercises) * 100) : 0;

        $help_options = array();
        if ($unit->cultural_notes_enabled) array_push($help_options, $unit->cultural_notes);
        if ($unit->listening_tips_enabled) array_push($help_options, $unit->listening_tips);
        if ($unit->transcript_enabled) array_push($help_options, $unit->transcript);
        if ($unit->glossary_enabled) array_push($help_options, $unit->glossary);
        if ($unit->translation_enabled) array_push($help_options, $unit->translation);
        if ($unit->dictionary_enabled) array_push($help_options, $unit->dictionary);

        return view('student.show', compact(['unit', 'keywords', 'help_options', 'user', 'completed_exercises', 'first_exercise_id', 'unit_progress', 'completed_count', 'total_exercises']));
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

    public function welcome()
    {
        $user = Auth::user();
        return view('student.welcome', compact(['user']));
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
