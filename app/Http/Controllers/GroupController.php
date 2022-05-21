<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Unit;
use App\Models\User;
use App\Models\ProficiencyLevel;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        $students_count = array();

        foreach($groups as $group) {
            $count = User::where('group_id', $group->id)->where('role', 'student')->count();
            $students_count["$group->id"] = $count;
        }

        return view('groups.index', compact('groups'))->with(compact('students_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'student')->get();
        $levels = ProficiencyLevel::all();

        return view('groups.create', compact(['users', 'levels']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $group = new Group;
        $group->name = $request->name;
        $group->save();


        $users = array();
        $count = 0;
        $params = $request->collect();

        while ($params->contains("user_$count")) {

            $user_id = $request->collect()["user_$count"];

            $user = User::find($user_id);
            $user->group_id = $group->id;
            $user->save();

            $count++;
        }

        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::find($id);
        $users = User::where('role', 'student')->get();
        $levels = ProficiencyLevel::all();
        
        return view('groups.show', compact(['group', 'users', 'levels']));
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
