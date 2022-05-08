<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
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
        $newUser->group = $request->group;
        $newUser->save();

        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        //
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
        $user->group = $request->group;

        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        //
    }
}
