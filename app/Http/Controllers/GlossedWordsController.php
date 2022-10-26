<?php

namespace App\Http\Controllers;

use App\Models\GlossedWord;
use Illuminate\Http\Request;

class GlossedWordsController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }
    
    public function index($unit_id)
    {
        $glossed_words = GlossedWord::where('unit_id', $unit_id)->get();
        return view('glossed_words.index', compact('glossed_words', 'unit_id'));
    }

    public function store(Request $request, $unit_id)
    {
        $word = new GlossedWord;
        $word->word = $request->word;
        $word->description = $request->description;
        $word->unit_id = $unit_id;

        $word->save();

        return redirect()->route('glossed_words.index', $unit_id);
    }

    public function update(Request $request, $unit_id, $word_id)
    {
        $word = GlossedWord::find($word_id);
        $word->word = $request->word;
        $word->description = $request->description;

        $word->save();

        return redirect()->route('glossed_words.index', $unit_id);
    }

    public function destroy(GlossedWord $word)
    {
        $word->delete();
        return redirect()->route('glossed_words.index', $word->unit_id);
    }
}