<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Excercise;
use App\Models\DragAndDropExcercise;
use App\Models\OpenEndedExcercise;
use App\Models\FillInTheGapsExcercise;
use App\Models\MultipleChoiceExcercise;
use App\Models\VoiceRecognitionExcercise;

class ExcerciseController extends Controller
{
    public function index($unit_id)
    {
        $dragDropPre = DragAndDropExcercise::where('section', 'pre_listening')->get();
        $dragDropWhile = DragAndDropExcercise::where('section', 'while_listening')->get();
        $dragDropPost = DragAndDropExcercise::where('section', 'post_listening')->get();

        // $openEndedPre = OpenEndedExcercise::where('section', 'pre_listening')->get();
        // $openEndedWhile = OpenEndedExcercise::where('section', 'while_listening')->get();
        // $openEndedPost = OpenEndedExcercise::where('section', 'post_listening')->get();
        
        // $fillInPre = FillInTheGapsExcercise::where('section', 'pre_listening')->get();
        // $fillInWhile = FillInTheGapsExcercise::where('section', 'while_listening')->get();
        // $fillInPost = FillInTheGapsExcercise::where('section', 'post_listening')->get();

        // $multipleChoicePre = MultipleChoiceExcercise::where('section', 'pre_listening')->get();
        // $multipleChoiceWhile = MultipleChoiceExcercise::where('section', 'while_listening')->get();
        // $multipleChoicePost = MultipleChoiceExcercise::where('section', 'post_listening')->get();

        // $voiceRecPre = VoiceRecognitionExcercise::where('section', 'pre_listening')->get();
        // $voiceRecWhile = VoiceRecognitionExcercise::where('section', 'while_listening')->get();
        // $voiceRecPost = VoiceRecognitionExcercise::where('section', 'post_listening')->get();

        // $pre_listening_excercises = $dragDropPre->merge($openEndedPre)->merge($fillInPre)->merge($multipleChoicePre)->merge($voiceRecPre);
        // $while_listening_excercises = $dragDropWhile->merge($openEndedWhile)->merge($fillInWhile)->merge($multipleChoiceWhile)->merge($voiceRecWhile);
        // $post_listening_excercises = $dragDropPost->merge($openEndedPost)->merge($fillInPost)->merge($multipleChoicePost)->merge($voiceRecPost);

        $pre_listening_excercises = $dragDropPre;
        $while_listening_excercises = $dragDropWhile;
        $post_listening_excercises = $dragDropPost;

        return view('excercises.index', compact(['unit_id', 'pre_listening_excercises', 'while_listening_excercises', 'post_listening_excercises']));
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
}
