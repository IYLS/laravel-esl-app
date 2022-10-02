@extends('layouts.app')

@section('main')

<div class="container">
    <div class="p-2 mt-2 border shadow rounded mb-2">
        <h3>User details</h3>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>
                            <input id="user_id" name="user_id" class="form-control" type="text" disabled value="{{ $user->user_id }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>
                            <div class="input-group">
                                <input id="password" name="password" type="password" class="form-control" disabled value="" placeholder="*********">
                                <span class="input-group-btn">
                                  <a class="btn btn-primary" onclick="revealPassword()">
                                      <i class="mdi mdi-eye"></i>
                                  </a>
                                </span>
                            </div>
                        <td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" disabled value={{ $user->name }}>
                        </td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>
                            <input id="age" name="age" class="form-control" type="text" disabled value={{ $user->age }}>
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select id="gender" name="gender" class="form-select" disabled>
                                <option value="male" @if ($user->gender == "male") selected @endif>Male</option>
                                <option value="female" @if ($user->gender == "female") selected @endif>Female</option>
                                <option value="other" @if ($user->gender == "other") selected @endif>Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td>
                            <input id="language" name="language" class="form-control" type="text" disabled value={{ $user->language }}>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input id="email" name="email" class="form-control" type="text" disabled value={{ $user->email }}>
                        </td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>
                            <select id="role" name="role" class="form-select" disabled>
                                <option value="teacher" @if ($user->role == "teacher") selected @endif>Teacher</option>
                                <option value="student" @if ($user->role == "student") selected @endif>Student</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Activated</td>
                        <td>
                            <select id="activated" name="activated" class="form-select" disabled>
                                <option value=true @if ($user->activated == true) selected @endif>Yes </option>
                                <option value=false @if ($user->activated == false) selected @endif>No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>
                            <select id="group" name="group" class="form-select" disabled>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" @if($user->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <a class="btn btn-success" onClick="enableFields()">Edit</a>
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
    </div>
</div>

<script>
    function enableFields() {
        var input_elements = document.getElementsByTagName('input');
        var select_elements = document.getElementsByTagName('select');

        for (i = 0; i < input_elements.length; i++) {
            input_elements[i].disabled = false;
        }

        for (i = 0; i < select_elements.length; i++) {
            select_elements[i].disabled = false;
        }
    };

    function revealPassword() {
        const passwordField = document.getElementById('password');;

        if (passwordField.type == 'text') {
            passwordField.type = 'password'
        } else {
            passwordField.type = 'text'
        }
    }
</script>

@endsection