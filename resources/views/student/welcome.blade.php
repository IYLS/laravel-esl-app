@extends('layouts.app')
@section('main')

@section('title', 'Welcome')

<div class="container h-100 student-module student-welcome">
    <div class="row align-items-center h-100">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6 mx-auto">
            <div class="bg-white p-5 rounded-lg shadow-lg text-center" style="margin-top: 10%;">
                {{-- Icono o emoji de bienvenida --}}
                <div class="mb-4">
                    <h1 class="display-1">👋</h1>
                </div>
                
                {{-- Título de bienvenida --}}
                <h2 class="text-primary fw-bold mb-3">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                
                {{-- Mensaje de bienvenida --}}
                <div class="mb-4">
                    <p class="lead text-secondary mb-3">
                        Estamos emocionados de tenerte aquí 🎉
                    </p>
                    <p class="text-muted">
                        Estás a punto de comenzar una increíble experiencia de aprendizaje. 
                        En este módulo podrás practicar y mejorar tus habilidades de comprensión auditiva 
                        a través de ejercicios interactivos y desafiantes.
                    </p>
                </div>

                {{-- Información adicional --}}
                <div class="alert alert-info rounded-lg mb-4" role="alert">
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="me-2">💡</span>
                        <div class="text-start">
                            <strong>Consejo:</strong> Asegúrate de tener tus auriculares listos para 
                            aprovechar al máximo las actividades de audio.
                        </div>
                    </div>
                </div>

                {{-- Botón para continuar --}}
                <div class="d-grid gap-2">
                    <a href="{{ route('student.level_selection') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        Comenzar 🚀
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
