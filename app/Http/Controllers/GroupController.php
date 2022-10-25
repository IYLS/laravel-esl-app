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
        $units = Unit::all();

        $students_count = array();
        $units_count = array();

        foreach($groups as $group) {
            $count = $group->users()->where('role', 'student')->count();
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

        $unit_ids = array();
        if($request->has('units') and $request->units != null) $unit_ids = $request->units;

        $group->units()->attach($unit_ids);

        $user_ids = array();
        if($request->has('users') and $request->users != null) $user_ids = $request->users;

        $users = User::findMany($user_ids);
        foreach($users as $user)
        {
            $user->group()->associate($group);
            $user->save();
        }

        if($group->isDirty()) $group->save();

        return redirect()->route('groups.index')->with('success', 'Group created successfully');
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

    public function update(Request $request, $id)
    {
        $current_group = Group::find($id);
        
        if($request->has('name') and $request->name != '') $current_group->name = $request->name;

        $unit_ids = array();
        if($request->has('units') and $request->units != null) $unit_ids = $request->units;

        $current_group->units()->sync($unit_ids);

        $user_ids = array();
        if($request->has('users') and $request->users != null) $user_ids = $request->users;

        // Eliminar usuarios que no están en la lista
        foreach($current_group->users as $user)
        {
            if (!in_array($user->id, $user_ids)) 
            {
                $user->group()->dissociate();
                $user->save();
            }
        }

        // Asignar usuarios 
        foreach($user_ids as $user_id) 
        {
            $user = User::find($user_id);
            $user->group()->associate($current_group)->save();
        }

        if($current_group->isDirty()) $current_group->save();

        return redirect()->route('groups.index');
    }

    public function destroy($id)
    {
        Group::find($id)->delete();
        return redirect()->route('groups.index');
    }
}