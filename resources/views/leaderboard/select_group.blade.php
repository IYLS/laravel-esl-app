@extends('layouts.app')
@section('title', 'Leaderboard - Seleccionar grupo')
@section('main')

<style>
    .leaderboard-select-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .leaderboard-select-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .leaderboard-select-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }
    .leaderboard-select-header p {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
    }
    .group-select-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .group-select-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        border-color: var(--color-primary);
    }
    .group-select-card .material-symbols-outlined {
        font-size: 24px;
        color: var(--color-primary);
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--color-text-secondary);
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
</style>

<div class="leaderboard-select-container">
    <div class="leaderboard-select-header">
        <h1>🏆 Leaderboard</h1>
        <p>Selecciona un grupo para ver el ranking de progreso de los estudiantes</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($groups->count() > 0)
        @foreach($groups as $group)
            <a href="{{ route('leaderboard.index', ['group' => $group->id]) }}" class="group-select-card">
                <span class="material-symbols-outlined">groups</span>
                <span class="flex-grow-1 fw-semibold">{{ $group->name }}</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        @endforeach
    @else
        <div class="empty-state">
            <p class="mb-0">No hay grupos con leaderboard habilitado. Habilita el leaderboard en la configuración de un grupo.</p>
        </div>
    @endif
</div>

@endsection
