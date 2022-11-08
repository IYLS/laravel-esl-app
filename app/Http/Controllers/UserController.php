<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }

    public function index($message = null)
    {
        $users = User::orderBy('user_id')->get();
        $groups = Group::all();

        return view('user.index', compact(['users', 'groups']));
    }

    public function create()
    {
        $groups = Group::all();
        return view('user.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $newUser = new User;
        $newUser->user_id = $request->user_id;
        $newUser->age = $request->age;
        $newUser->name = $request->name;
        $newUser->gender = $request->gender;
        $newUser->language = $request->language;
        $newUser->email = $request->email;
        $newUser->role = $request->role;
        $newUser->activated = $request->activated;
        $newUser->password = Hash::make($request->password);

        if($request->group == 0) {
            $newUser->group_id = null;
        } else {
            $newUser->group_id = $request->group;
        }
        
        $newUser->save();

        return redirect()->route('users.index')->with('success', "User $newUser->name created successfully.");
    }

    public function show($id)
    {
        $user = User::find($id);
        $groups = Group::all();

        return view('user.show', compact(['user', 'groups']));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        $user->user_id = $request->user_id;
        $user->age = $request->age;
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->language = $request->language;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->activated = $request->activated;
        
        if($request->has('password') and $request->password != null) {
            $user->password = Hash::make($request->password);
        }
        
        if($request->group == 0) {
            $user->group_id = null;
        } else {
            $user->group_id = $request->group;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function executeFilter(Request $request)
    {
        $group_id = $request->group;
        $role = $request->role;
        
        if($role != null and $group_id != null) {
            if ($role != 'any' and $group_id != 'any') {
                $users = User::where('role', $role)->where('group_id', $group_id)->orderBy('user_id')->get();
            } else if ($role == 'any' and $group_id != 'any') {
                $users = User::where('group_id', $group_id)->orderBy('user_id')->get();
            } else if ($role != 'any' and $group_id == 'any'){
                $users = User::where('role', $role)->orderBy('user_id')->get();
            } else {
                $users = User::orderBy('user_id')->get();
            }
        }

        $groups = Group::all();

        return view('user.index', compact(['users', 'groups']));
    }
}
