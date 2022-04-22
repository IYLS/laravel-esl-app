@extends('layouts.app')
@section('main')
<div class="row d-flex justify-content-center mt-3 mb-3">

    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New User</h3>
        <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>
                            <input id="user_id" name="user_id" class="form-control" type="text" placeholder="Type an ID for the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>
                            <div class="input-group">
                                <input id="password" name="password" type="password" class="form-control" placeholder="Type a password for the new user">
                                <span class="input-group-btn">
                                  <a class="btn btn-primary" onclick="revealPassword()">
                                      <i class="fa fa-eye"></i>
                                  </a>
                                </span>
                            </div>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" placeholder="Type the full name of the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>
                            <input id="age" name="age" type="number" min="8" max="99" class="form-control" placeholder="Insert the age of the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select id="gender" name="gender" class="form-select">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td>
                            <input id="language" name="language" class="form-control" type="text" placeholder="Insert the language for the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input id="email" name="email" class="form-control" type="text" placeholder="Insert the e-mail for the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>
                            <input id="group" name="group" class="form-control" type="text" placeholder="Insert the group for the new user">
                        </td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>
                            <select id="role" name="role" class="form-select">
                                <option value="teacher" selected>Teacher</option>
                                <option value="student">Student</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Activated</td>
                        <td>
                            <select id="activated" name="activated" class="form-select">
                                <option value=true selected>Yes</option>
                                <option value=false>No</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
    </form>
    </div>
</div>

<script>
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