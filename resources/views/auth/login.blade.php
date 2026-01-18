@extends('layouts.app')
@section('main')

<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-10 col-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="text-center mt-5 mb-2" style="margin-top: 25%;">
                <h2>Ideas for listening</h2>
            </div>
            <div class="bg-white p-4 rounded border border-1 border-white shadow mt-5">
                <form action="{{ route('auth.authenticate') }}" method="POST">
                    @csrf
                    <h3 class="form-label mb-3">Login</h3>
                    <p class="text-secondary"><small>Please enter your credentials.</small></p>
                    <div class="mb-3">
                        <label for="email" name="email-label" class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required placeholder="Please enter your e-mail">
                    </div>
                    <div class="mb-3">
                        <label for="password" name="password-label" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required aria-label placeholder="Please enter your password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Show password">
                                <span class="material-symbols-outlined" id="togglePasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="role" name="role" class="form-label">Select Role</label>
                        <select id="role" name="role" class="form-select">
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary col-12" type="submit">Enter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-auto text-secondary p-3">
    <div class="">
        <footer class="d-flex justify-content-center">
            <p>&#169; 2025 www.ideasforlistening.com </p>
        </footer>
    </div>    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
        
        if (togglePassword && passwordInput && togglePasswordIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Cambiar icono
                if (type === 'text') {
                    togglePasswordIcon.textContent = 'visibility_off';
                } else {
                    togglePasswordIcon.textContent = 'visibility';
                }
            });
        }
    });
</script>

@endsection