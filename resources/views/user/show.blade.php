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
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" disabled value="{{ $user->name }}">
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
                            <input id="language" name="language" class="form-control" type="text" disabled value="{{ $user->language }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input id="email" name="email" class="form-control" type="text" disabled value="{{ $user->email }}">
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
                                <option value="0">None. I'm a teacher.</option>
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
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                <span class="material-symbols-outlined">lock_reset</span> Actualizar contraseña
            </button>
            <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
    </div>
</div>

<!-- Modal para actualizar contraseña -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Actualizar contraseña de {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update_password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres">
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" aria-label="Mostrar contraseña">
                                <span class="material-symbols-outlined" id="toggleNewPasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="6" placeholder="Repite la contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" aria-label="Mostrar contraseña">
                                <span class="material-symbols-outlined" id="toggleConfirmPasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                </div>
            </form>
        </div>
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

    // Toggle para nueva contraseña en el modal
    document.addEventListener('DOMContentLoaded', function() {
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        const newPasswordInput = document.getElementById('new_password');
        const toggleNewPasswordIcon = document.getElementById('toggleNewPasswordIcon');
        
        if (toggleNewPassword && newPasswordInput && toggleNewPasswordIcon) {
            toggleNewPassword.addEventListener('click', function() {
                const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                newPasswordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    toggleNewPasswordIcon.textContent = 'visibility_off';
                } else {
                    toggleNewPasswordIcon.textContent = 'visibility';
                }
            });
        }

        // Toggle para confirmar contraseña en el modal
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');
        
        if (toggleConfirmPassword && confirmPasswordInput && toggleConfirmPasswordIcon) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    toggleConfirmPasswordIcon.textContent = 'visibility_off';
                } else {
                    toggleConfirmPasswordIcon.textContent = 'visibility';
                }
            });
        }
    });
</script>

@endsection