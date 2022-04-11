@extends('layouts.app')

@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">

    <div class="col-6 p-5 mt-2 border shadow rounded">
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
                                <option value=true @if ($user->role == "teacher") selected @endif>Teacher</option>
                                <option value=false @if ($user->role == "student") selected @endif>Student</option>
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
                            <input id="group" name="group" class="form-control" type="text" disabled value={{ $user->group }}>
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <a class="btn btn-secondary" onClick="enableFields()">Edit</a>
            <button class="btn btn-danger">Delete</button>
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-secondary">Cancel</button>
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

    function saveChanges() {
        var input_elements = document.getElementsByTagName('input');
        var select_elements = document.getElementsByTagName('select');

        console.log(document.getElementById('name').placeholder);

        for (i = 0; i < input_elements.length; i++) {
            input_elements[i].disabled = true;
        }

        for (i = 0; i < select_elements.length; i++) {
            select_elements[i].disabled = true;
        }

        const id = document.getElementById('user_id').value;
        const name = document.getElementById('name').value;
        const age = document.getElementById('age').value;
        const gender = document.getElementById('gender').value;
        const language = document.getElementById('language').value;
        const email = document.getElementById('email').value;
        const role = document.getElementById('role').value;
        const activated = document.getElementById('activated').value;
        const group = document.getElementById('group').value;
    }
</script>

@endsection