<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Unit;
use App\Models\User;
use App\Models\UnitGroup;

class GroupController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }

    public function index()
    {
        $groups = Group::all();
        $units = Unit::all();

        $students_count = array();
        $units_count = array();

        foreach($groups as $group) {
            $count = $group->users()->where('role','student')->count();
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

        dump(Group::find($id)->units());

        foreach($request->units as $unit_id) {
            $units = Group::find($id)->units();

            if (!in_array($unit_id, $units)) {
                
            }
        }

        // dump($request);
        // $group = Group::find($id);
        // $group->name = $request->name;
        // $group->save();

        // if($request->has('units') and $request->units != null)
        // {
        //     $units = Unit::all();
        //     foreach($units as $unit)
        //     {
        //         if(!in_array("$unit->id", $request->units))
        //         {
        //             UnitGroup::where('unit_id', $unit->id)->delete();
        //         }
        //     }
        // } else {
        //     UnitGroup::where('group_id', $group->id)->delete();
        // }

        // if($request->has('users') and $request->users != null)
        // {
        //     $users = User::all();
        //     foreach($users as $user)
        //     {
        //         if(!in_array("$user->id", $request->users))
        //         {
        //             $user->group_id = null;
        //             $user->save();
        //         }
        //     }
        // } else {
        //     $users = User::where('group_id', $group->id)->get();
        //     foreach($users as $user) {
        //         $user->group_id = null;
        //         $user->save();
        //     }
        // }

        // return redirect()->route('groups.index');
    }

    public function destroy($id)
    {
        Group::find($id)->delete();
        return redirect()->route('groups.index');
    }
}
