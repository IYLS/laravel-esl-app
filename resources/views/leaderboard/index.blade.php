@extends('layouts.app')
@section('main')

<style>
    .leaderboard-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .leaderboard-header {
        text-align: center;
        margin-bottom: 1.5rem;
        padding: 1rem 0;
    }
    .leaderboard-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0;
    }
    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .unit-selector select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 6px;
        border: 1px solid var(--color-border);
        font-size: 0.9rem;
    }
    .leaderboard-list {
        background: white;
        border-radius: 8px;
        padding: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-radius: 6px;
        border: 1px solid transparent;
        gap: 0.75rem;
    }
    .leaderboard-item:hover {
        background: var(--color-background);
    }
    .leaderboard-item.current-user {
        background: var(--color-info-soft);
        border-color: var(--color-info);
    }
    .rank-badge {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .rank-badge.first {
        background: #FFD700;
        color: white;
    }
    .rank-badge.second {
        background: #C0C0C0;
        color: white;
    }
    .rank-badge.third {
        background: #CD7F32;
        color: white;
    }
    .rank-badge.other {
        background: var(--color-background);
        color: var(--color-text-secondary);
        border: 1px solid var(--color-border);
    }
    .student-avatar {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        object-fit: cover;
    }
    .avatar-placeholder {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .student-info {
        flex: 1;
        min-width: 0;
    }
    .student-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--color-text-primary);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .student-stats {
        font-size: 0.75rem;
        color: var(--color-text-secondary);
        margin-bottom: 0.25rem;
    }
    .progress-wrapper {
        flex: 1;
        min-width: 0;
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }
    .progress-text {
        font-size: 0.75rem;
        color: var(--color-text-secondary);
    }
    .progress-percentage {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-primary);
    }
    .progress-bar-container {
        height: 4px;
        background-color: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: width 0.6s ease;
        border-radius: 2px;
    }
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--color-text-secondary);
    }
    
    /* Mobile first - luego se ajusta para desktop */
    @media (min-width: 768px) {
        .leaderboard-container {
            padding: 0;
        }
        .leaderboard-header h1 {
            font-size: 2rem;
        }
        .leaderboard-item {
            padding: 1rem;
            gap: 1rem;
        }
        .rank-badge {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 1rem;
        }
        .student-avatar, .avatar-placeholder {
            width: 40px;
            height: 40px;
            min-width: 40px;
        }
        .student-name {
            font-size: 1rem;
        }
        .student-stats {
            font-size: 0.875rem;
        }
        .progress-text {
            font-size: 0.875rem;
        }
        .progress-percentage {
            font-size: 1rem;
        }
    }
</style>

<div class="container mt-2 mb-5">
    <div class="leaderboard-container">
        <div class="leaderboard-header">
            <h1>🏆 Leaderboard</h1>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($group)
            @php
                $leaderboardBase = route('leaderboard.index');
                $teacherGroupParam = in_array($user->role ?? '', ['teacher', 'researcher']) ? '?group=' . $group->id : '';
            @endphp
            <div class="filter-section">
                @if(isset($groups) && $groups->count() > 0)
                    <div class="mb-2">
                        <label class="form-label small text-muted">Grupo</label>
                        <select class="form-select" onchange="var u=document.getElementById('unitSelect')?.value||''; location.href='{{ $leaderboardBase }}?group='+this.value+(u?'&unit='+u:'');">
                            @foreach($groups as $g)
                                <option value="{{ $g->id }}" {{ $g->id == $group->id ? 'selected' : '' }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if($units->count() > 0)
                    <div class="{{ isset($groups) && $groups->count() > 0 ? 'mt-2' : '' }}">
                        <label class="form-label small text-muted">Unidad</label>
                        <select id="unitSelect" class="form-select" onchange="var u=this.value; var base='{{ $leaderboardBase }}{{ $teacherGroupParam }}'; var sep=base.includes('?')?'&':'?'; location.href=u?base+sep+'unit='+u:base;">
                            <option value="">Todas las unidades</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $selectedUnitId == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="leaderboard-list">
                @if(count($leaderboard) > 0)
                    @foreach($leaderboard as $index => $entry)
                        @php
                            $rank = $index + 1;
                            $isCurrentUser = $entry['student']->id === $user->id;
                            $rankClass = $rank == 1 ? 'first' : ($rank == 2 ? 'second' : ($rank == 3 ? 'third' : 'other'));
                        @endphp
                        <div class="leaderboard-item {{ $isCurrentUser ? 'current-user' : '' }}">
                            <div class="rank-badge {{ $rankClass }}">
                                {{ $rank }}
                            </div>
                            
                            @if($entry['student']->avatar)
                                <img src="{{ asset('storage/avatars/' . $entry['student']->avatar) }}" 
                                     alt="{{ $entry['student']->name }}" 
                                     class="student-avatar"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="avatar-placeholder" style="display: none;">
                                    {{ strtoupper(substr($entry['student']->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($entry['student']->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="student-info">
                                <div class="student-name">
                                    {{ $entry['student']->name }}
                                    @if($isCurrentUser)
                                        <span class="badge bg-info ms-1" style="font-size: 0.7rem;">Tú</span>
                                    @endif
                                </div>
                                <div class="student-stats">
                                    {{ $entry['completed'] }} / {{ $entry['total'] }} ejercicios
                                    @if($selectedUnitId)
                                        • {{ $entry['unit_title'] }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="progress-wrapper">
                                <div class="progress-header">
                                    <span class="progress-text">{{ $entry['completed'] }}/{{ $entry['total'] }}</span>
                                    <span class="progress-percentage">{{ $entry['progress'] }}%</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar" style="width: {{ $entry['progress'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <p>No hay datos disponibles</p>
                    </div>
                @endif
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                No tienes un grupo asignado. Contacta a tu profesor para obtener acceso al leaderboard.
            </div>
        @endif
    </div>
</div>

@endsection
