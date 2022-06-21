<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Excercise;

class ExcerciseController extends Controller
{
    public function index()
    {
        
        $pre_listening_excercises = [
            "Meet the character",
            "Predicting 1",
            "What do you hear?",
            "Vocabulary activation",
            "Vocabulary practice",
        ];

        $while_listening_excercises = [
            "Evaluating statement",
            "Multiple choice",
            "Dictation cloze"
        ];

        $post_listening_excercises = [
            "Multiple choice 1",
            "Multiple choice 2",
            "Personal response 1",
            "Personal response 2"
        ];


        return view('excercises.index');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
