<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\DragAndDropExcercise;
use App\Models\FillInTheGapsExcercise;
use App\Models\OpenEndedExcercise;
use App\Models\VoiceRecognitionExcercise;
use App\Models\MultipleChoiceExcercise;

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

        $sections = $unit->sections;
        $pre_listening_excercises = array();
        $while_listening_excercises = array();
        $post_listening_excercises = array();

        foreach($sections as $section) {
            $drag_and_drop_excercises = DragAndDropExcercise::where('section_id', $section->id)->get();
            $fill_in_the_gaps_excercises = FillInTheGapsExcercise::where('section_id', $section->id)->get();
            $open_ended_excercises = OpenEndedExcercise::where('section_id', $section->id)->get();
            $voice_recognition_excercises = VoiceRecognitionExcercise::where('section_id', $section->id)->get();
            $multiple_choice_excercises = MultipleChoiceExcercise::where('section_id', $section->id)->get();

            switch ($section->name) {
            case 'pre_listening':
                $pre_listening_excercises = $drag_and_drop_excercises
                                            ->merge($fill_in_the_gaps_excercises)
                                            ->merge($open_ended_excercises)
                                            ->merge($voice_recognition_excercises)
                                            ->merge($multiple_choice_excercises);
                break;
            case 'while_listening':
                $while_listening_excercises = $drag_and_drop_excercises
                                            ->merge($fill_in_the_gaps_excercises)
                                            ->merge($open_ended_excercises)
                                            ->merge($voice_recognition_excercises)
                                            ->merge($multiple_choice_excercises);
                break;
            case 'post_listening':
                $post_listening_excercises = $drag_and_drop_excercises
                                            ->merge($fill_in_the_gaps_excercises)
                                            ->merge($open_ended_excercises)
                                            ->merge($voice_recognition_excercises)
                                            ->merge($multiple_choice_excercises);
                break;
            }
        }

        return view('student.show', compact(['unit', 'keywords', 'help_options', 'pre_listening_excercises', 'while_listening_excercises', 'post_listening_excercises']));
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
