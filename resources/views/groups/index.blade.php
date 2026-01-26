@extends('layouts.app')
@section('main')

<style>
    .groups-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .groups-header {
        margin-bottom: 2rem;
    }
    .groups-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .groups-header h1 .material-symbols-outlined {
        font-size: 2rem;
        color: var(--color-primary);
    }
    .groups-header p {
        color: var(--color-text-secondary);
        font-size: 1rem;
        margin: 0;
    }
    .add-group-btn {
        margin-bottom: 2rem;
    }
    .add-group-btn .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .add-group-btn .btn .material-symbols-outlined {
        font-size: 18px;
    }
    .groups-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .group-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        border-left: 4px solid var(--color-primary);
        display: flex;
        flex-direction: column;
    }
    .group-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    .group-card-header {
        margin-bottom: 1rem;
    }
    .group-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .group-card-title .material-symbols-outlined {
        font-size: 24px;
        color: var(--color-primary);
    }
    .group-card-stats {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .group-stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    }
    .group-stat-item .material-symbols-outlined {
        font-size: 20px;
        color: var(--color-text-secondary);
    }
    .group-stat-label {
        color: var(--color-text-secondary);
        flex: 1;
    }
    .group-stat-value {
        font-weight: 600;
        color: var(--color-text-primary);
    }
    .group-card-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
    }
    .group-card-actions .btn {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .group-card-actions .btn .material-symbols-outlined {
        font-size: 18px;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--color-text-secondary);
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .empty-state .material-symbols-outlined {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--color-text-primary);
    }
    @media (max-width: 768px) {
        .groups-container {
            padding: 1rem 0.75rem;
        }
        .groups-header h1 {
            font-size: 1.5rem;
        }
        .groups-header h1 .material-symbols-outlined {
            font-size: 1.5rem;
        }
        .groups-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .group-card {
            padding: 1.25rem;
        }
        .add-group-btn .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="groups-container">
    <div class="groups-header">
        <h1>
            <span class="material-symbols-outlined">groups</span>
            <span>Groups</span>
        </h1>
        <p>Create and manage student groups. Assign units to groups and organize your classes</p>
    </div>

    <div class="add-group-btn">
        <a class="btn btn-primary" href="{{ route('groups.create') }}">
            <span class="material-symbols-outlined">add</span>
            <span>New Group</span>
        </a>
    </div>

    @if(count($groups) > 0)
        <div class="groups-grid">
            @foreach ($groups as $group)
                <div class="group-card">
                    <div class="group-card-header">
                        <div class="group-card-title">
                            <span class="material-symbols-outlined">groups</span>
                            <span>{{ $group->name }}</span>
                        </div>
                    </div>
                    <div class="group-card-stats">
                        <div class="group-stat-item">
                            <span class="material-symbols-outlined">people</span>
                            <span class="group-stat-label">Students:</span>
                            <span class="group-stat-value">
                                @if($students_count["$group->id"] == 1)
                                    1 student
                                @elseif($students_count["$group->id"] == 0)
                                    No students
                                @else
                                    {{ $students_count["$group->id"] }} students
                                @endif
                            </span>
                        </div>
                        <div class="group-stat-item">
                            <span class="material-symbols-outlined">menu_book</span>
                            <span class="group-stat-label">Units:</span>
                            <span class="group-stat-value">
                                @if($units_count["$group->id"] == 1)
                                    1 unit
                                @elseif($units_count["$group->id"] == 0)
                                    No units
                                @else
                                    {{ $units_count["$group->id"] }} units
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="group-card-actions">
                        <a href="{{ route('groups.show', $group->id) }}" class="btn btn-success">
                            <span class="material-symbols-outlined">visibility</span>
                            <span>Details</span>
                        </a>
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100" type="submit" onclick="return confirm('Are you sure you want to delete this group?');">
                                <span class="material-symbols-outlined">delete</span>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <span class="material-symbols-outlined">groups</span>
            <h3>No groups created</h3>
            <p>Create your first group to get started</p>
        </div>
    @endif
</div>

@endsection
