@extends('layouts.app')
@section('main')

<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1rem 0;
    }
    .profile-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 2.5rem;
        margin-bottom: 2rem;
    }
    .avatar-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }
    .avatar-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--color-primary);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        background: var(--color-background);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-link) 100%);
        color: white;
        font-size: 4rem;
        font-weight: 600;
    }
    .profile-info {
        margin-bottom: 1.5rem;
    }
    .profile-info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .profile-info-value {
        font-size: 1.125rem;
        color: var(--color-text-primary);
        font-weight: 500;
    }
    .profile-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }
    .role-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .role-badge.teacher {
        background: var(--color-info-soft);
        color: var(--color-info);
    }
    .role-badge.student {
        background: var(--color-success-soft);
        color: var(--color-success);
    }
</style>

<div class="container mt-2 mb-5">
    <div class="profile-container">
        <div class="profile-header">
            <h1>👤 Mi Perfil</h1>
            <p class="text-muted">Información de tu cuenta</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="profile-card">
            <div class="avatar-container">
                <div class="avatar-wrapper">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="avatar-placeholder" style="display: none;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Nombre</div>
                <div class="profile-info-value">{{ $user->name }}</div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Correo electrónico</div>
                <div class="profile-info-value">{{ $user->email }}</div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Rol</div>
                <div class="profile-info-value">
                    <span class="role-badge {{ $user->role }}">{{ $user->role }}</span>
                </div>
            </div>

            @if($user->user_id)
            <div class="profile-info">
                <div class="profile-info-label">ID de Usuario</div>
                <div class="profile-info-value">{{ $user->user_id }}</div>
            </div>
            @endif

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    <span class="material-symbols-outlined">edit</span>
                    Editar Avatar
                </a>
                @if($user->role == 'teacher')
                    <a href="{{ route('auth.index') }}" class="btn btn-secondary">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Volver
                    </a>
                @else
                    <a href="{{ route('student.level_selection') }}" class="btn btn-secondary">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Volver
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
