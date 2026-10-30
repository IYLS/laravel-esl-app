@extends('layouts.app')
@section('main')

<style>
    .profile-container {
        max-width: 600px;
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
    .avatar-preview-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }
    .avatar-preview-wrapper {
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
    .avatar-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-preview-placeholder {
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
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .file-input-label {
        display: block;
        padding: 0.75rem 1.5rem;
        background: var(--color-primary);
        color: white;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .file-input-label:hover {
        background: var(--color-hover-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(30, 58, 138, 0.3);
    }
    .file-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }
    .info-text {
        font-size: 0.875rem;
        color: var(--color-text-secondary);
        text-align: center;
        margin-top: 0.5rem;
    }
</style>

<div class="container mt-2 mb-5">
    <div class="profile-container">
        <div class="profile-header">
            <h1>✏️ Editar Avatar</h1>
            <p class="text-muted">Actualiza tu foto de perfil</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="profile-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="avatar-preview-container">
                    <div class="avatar-preview-wrapper">
                        <img id="avatarPreview" 
                             src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : '' }}" 
                             alt="{{ $user->name }}" 
                             class="avatar-preview-image"
                             style="{{ $user->avatar ? '' : 'display: none;' }}"
                             onerror="this.style.display='none'; document.getElementById('avatarPlaceholder').style.display='flex';">
                        <div id="avatarPlaceholder" class="avatar-preview-placeholder" style="{{ $user->avatar ? 'display: none;' : '' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>

                <div class="file-input-wrapper">
                    <label for="avatar" class="file-input-label">
                        <span class="material-symbols-outlined">photo_camera</span>
                        Seleccionar Imagen
                    </label>
                    <input type="file" 
                           id="avatar" 
                           name="avatar" 
                           class="file-input" 
                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/heic,image/heif"
                           onchange="previewAvatar(this)">
                    <p class="info-text">Formatos permitidos: JPG, PNG, GIF, WebP, HEIC (máx. 2MB)</p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <span class="material-symbols-outlined">save</span>
                        Guardar Cambios
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                        <span class="material-symbols-outlined">cancel</span>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        const preview = document.getElementById('avatarPreview');
        const placeholder = document.getElementById('avatarPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'flex';
        }
    }
</script>

@endsection
