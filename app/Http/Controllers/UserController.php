<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = $this->getUsers();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        $user->id = "S-BC-SPANISH";
        $user->name = "Benjamin Caceres";
        $user->age = "24";
        $user->gender = "male";
        $user->language = "spanish";
        $user->email = "benjamin.caceres.ra@gmail.com";
        $user->role = "student";
        $user->activated = true;
        return view('user.create', compact('user'));
    }

    public function store(Request $request)
    {
        // $data = $request->getContent();
        $newUser = new User();
        $newUser->user_id = $request->user_id;
        $newUser->age = $request->name;
        $newUser->name = $request->age;
        $newUser->gender = $request->gender;
        $newUser->language = $request->language;
        $newUser->email = $request->email;
        $newUser->role = $request->role;
        $newUser->activated = $request->activated;

        // Guardar en BD

        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = $this->getUserById($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = $this->getUserById($id);
        
        $user->user_id = $request->user_id;
        $user->age = $request->name;
        $user->name = $request->age;
        $user->gender = $request->gender;
        $user->language = $request->language;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->activated = $request->activated;

        // TODO: Guardar en la base de datos

        return redirect()->route('users.index');

    }

    public function destroy($id)
    {
        //
    }

    public function getUsers() {
        $user1 = new User();
        $user1->id = "S-BC-SPANISH";
        $user1->name = "Benjamin Caceres";
        $user1->age = "24";
        $user1->gender = "male";
        $user1->language = "spanish";
        $user1->email = "benjamin.caceres.ra@gmail.com";
        $user1->role = "student";
        $user1->activated = true;

        $user2 = new User();
        $user2->id = "T-CD-SPANISH";
        $user2->name = "Camila Diaz";
        $user2->age = "24";
        $user2->gender = "female";
        $user2->language = "english";
        $user2->email = "camileinnnn@gmail.com";
        $user2->role = "teacher";
        $user2->activated = false;

        $users = [$user1, $user2];

        return $users;
    }

    public function getUserById($id) {
        $users = $this->getUsers();
        
        foreach ($users as $user) {
            if ($user->id == $id) {
                return $user;
            }
        }
    }
}
