<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Unit;
use App\Models\User;


class GroupController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }

    public function index()
    {
        $groups = Group::all();
        $students_count = array();

        $units = Unit::all();
        $units_count = array();

        foreach($groups as $group) {
            $count = $group->users()->count();
            $students_count["$group->id"] = $count;

            $count2 = $group->units()->count();
            $units_count["$group->id"] = $count2;
        }

        return view('groups.index', compact('groups'))->with(compact(['students_count', 'units_count']));
    }

    public function create()
    {
        $users = User::where('role', 'student')->get();
        $units = Unit::all();

        return view('groups.create', compact(['users', 'units']));
    }

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

    public function show($id)
    {
        $group = Group::find($id);
        $users = User::where('role','student')->get();
        $units = Unit::all();

        $unit_groups = $group->units;
        $unit_groups_array = array();

        foreach($unit_groups as $unit_group) {
            array_push($unit_groups_array, $unit_group->id);
        }
        
        return view('groups.show', compact(['group', 'users', 'units', 'unit_groups_array']));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $current_group = Group::find($id);
        $current_group->name = $request->name;

        $user_ids = $request->input('users');
        foreach($user_ids as $user_id) {
            $current_user = User::find($user_id);
            $current_user->group()->associate($current_group)->save();
        }

        $unit_ids = $request->input('units');
        if ($unit_ids != null) {
            $current_group->units()->sync($unit_ids);
        }

        $current_group->save();

        return redirect()->route('groups.index');
    }

    public function destroy($id)
    {
        Group::find($id)->delete();
        return redirect()->route('groups.index');
    }
}
