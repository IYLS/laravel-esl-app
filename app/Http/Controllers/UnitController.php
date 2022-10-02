<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Models\Section;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }
    
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $new_unit = new Unit;

        $new_unit->title = $request->title;
        $new_unit->author = $request->author;
        $new_unit->description = $request-> description;

        $new_unit->listening_tips = $request->listening_tips;
        $new_unit->listening_tips_enabled = $request->listening_tips_enabled == 'true' ? true : false;

        $new_unit->cultural_notes = $request->cultural_notes;
        $new_unit->cultural_notes_enabled = $request->cultural_notes_enabled == 'true' ? true : false;

        $new_unit->transcript = $request->transcript;
        $new_unit->transcript_enabled = $request->transcript_enabled == 'true' ? true : false;

        $new_unit->glossary = $request->glossary;
        $new_unit->glossary_enabled = $request->glossary_enabled == 'true' ? true : false;
        
        $new_unit->translation = $request->translation;
        $new_unit->translation_enabled = $request->translation_enabled == 'true' ? true : false;

        $new_unit->dictionary = $request->dictionary;
        $new_unit->dictionary_enabled = $request->dictionary_enabled == 'true' ? true : false;

        $video_file_name = $request->file('video')->getClientOriginalName();
        $video_file_url = $request->file('video')->storeAs('public/files', $video_file_name);

        $new_unit->video_name = $video_file_name;
        $new_unit->video_url = $video_file_url;

        $new_unit->save();

        $pre = new Section;
        $pre->name = 'pre_listening';
        $pre->unit_id = $new_unit->id;
        $pre->save();
        
        $while = new Section;
        $while->name = 'while_listening';
        $while->unit_id = $new_unit->id;
        $while->save();
        
        $post = new Section;
        $post->name = 'post_listening';
        $post->unit_id = $new_unit->id;
        $post->save();

        return redirect()->route('units.index')->with('success', 'Unit created successfully!');
    }

    public function show($id)
    {
        $unit = Unit::find($id);
        return view('units.show', compact('unit'));
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

        $unit->listening_tips = $request->listening_tips;
        $unit->listening_tips_enabled = $request->listening_tips_enabled == 'true' ? true : false;

        $unit->cultural_notes = $request->cultural_notes;
        $unit->cultural_notes_enabled = $request->cultural_notes_enabled == 'true' ? true : false;

        $unit->transcript = $request->transcript;
        $unit->transcript_enabled = $request->transcript_enabled == 'true' ? true : false;

        $unit->glossary = $request->glossary;
        $unit->glossary_enabled = $request->glossary_enabled == 'true' ? true : false;
        
        $unit->translation = $request->translation;
        $unit->translation_enabled = $request->translation_enabled == 'true' ? true : false;

        $unit->dictionary = $request->dictionary;
        $unit->dictionary_enabled = $request->dictionary_enabled == 'true' ? true : false;

        $video_file_name = $request->file('video')->getClientOriginalName();
        $video_file_url = $request->file('video')->storeAs('public/files', $video_file_name);

        $new_unit->video_name = $video_file_name;
        $new_unit->video_url = $video_file_url;

        $unit->save();

        return redirect()->route('units.index');
    }

    public function destroy($id)
    {
        Unit::find($id)->delete();
        return redirect()->route('units.index');    
    }
}
