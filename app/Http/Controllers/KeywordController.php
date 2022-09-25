<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index($unit_id)
    {
        $keywords = Keyword::where('unit_id', $unit_id)->get();
        return view('keywords.index', compact('keywords', 'unit_id'));
    }   

    public function create()
    {
        //
    }

    public function store(Request $request, $unit_id)
    {
        $keyword = new Keyword;
        $keyword->keyword = $request->word;
        $keyword->description = $request->description;
        $keyword->unit_id = $unit_id;

        $keyword->save();

        return redirect()->route('keywords.index', $unit_id);
    }

    public function show(Keyword $keyword)
    {
        //
    }

    public function edit(Keyword $keyword)
    {
        //
    }

    public function update(Request $request, $unit_id, $keyword_id)
    {
        $keyword = Keyword::find($keyword_id);
        $keyword->keyword = $request->word;
        $keyword->description = $request->description;

        $keyword->save();

        return redirect()->route('keywords.index', $unit_id);
    }

    public function destroy($unit_id, $keyword_id)
    {
        Keyword::destroy($keyword_id);
        return redirect()->route('keywords.index', $unit_id);
    }
}
