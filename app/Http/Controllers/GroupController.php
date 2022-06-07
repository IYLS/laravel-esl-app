<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Unit;
use App\Models\User;


class GroupController extends Controller
{
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

    public function create()
    {
        $users = User::where('role', 'student')->get();
        return view('groups.create', compact(['users']));
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
        
        return view('groups.show', compact(['group', 'users', 'units']));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $old_users = User::where('group_id', $id)->get();
        foreach($old_users as $user) {
            $user->group_id = null;
            $user->save();
        }

        // Usuarios que van a pertenecer al grupo
        $user_ids = $request->input('users');
        if ($user_ids != null) {
            // Asignar a todos los usuarios al grupo correspondiente
            foreach($user_ids as $user_id) {
                $current_user = User::find($user_id);
                $current_user->group_id = $id;
                $current_user->save();
            }
        }

        $old_units = Unit::where('group_id', $id)->get();
        foreach($old_units as $unit) {
            $unit->group_id = null;
            $unit->save();
        }

        // Unidades que van a pertenecer al grupo
        $unit_ids = $request->input('units');
        if ($unit_ids != null) {
            // Asignar a todos los usuarios al grupo correspondiente
            foreach($unit_ids as $unit_id) {
                $current_unit = Unit::find($unit_id);
                $current_unit->group_id = $id;
                $current_unit->save();
            }
        }

        $current_group = Group::find($id);
        $current_group->name = $request->name;
        $current_group->save();

        return redirect()->route('groups.index');
    }

    public function destroy($id)
    {
        //
    }
}
