@extends('layouts.app')
@section('main')

<style>
    .units-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .units-header {
        margin-bottom: 2rem;
    }
    .units-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .units-header h1 .material-symbols-outlined {
        font-size: 2rem;
        color: var(--color-primary);
    }
    .units-header p {
        color: var(--color-text-secondary);
        font-size: 1rem;
        margin: 0;
    }
    .units-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .units-actions .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .units-actions .btn .material-symbols-outlined {
        font-size: 18px;
    }
    .table-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .table-wrapper {
        overflow-x: auto;
    }
    .units-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 600px;
    }
    .units-table thead th {
        background: #f8f9fa;
        color: var(--color-text-primary);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        border-bottom: 2px solid #dee2e6;
    }
    .units-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        color: var(--color-text-primary);
        font-size: 0.9rem;
    }
    .units-table tbody tr:hover {
        background: #f8f9fa;
    }
    .units-table tbody tr:last-child td {
        border-bottom: none;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .action-buttons .btn {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--color-text-secondary);
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
    /* Mobile Card View */
    .units-mobile-card {
        display: none;
    }
    .unit-mobile-item {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid var(--color-primary);
    }
    .unit-mobile-header {
        margin-bottom: 1rem;
    }
    .unit-mobile-title {
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .unit-mobile-author {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }
    .unit-mobile-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .unit-mobile-actions .btn {
        flex: 1;
        min-width: 120px;
        justify-content: center;
    }
    @media (max-width: 768px) {
        .units-container {
            padding: 1rem 0.75rem;
        }
        .units-header h1 {
            font-size: 1.5rem;
        }
        .units-header h1 .material-symbols-outlined {
            font-size: 1.5rem;
        }
        .units-actions {
            flex-direction: column;
        }
        .units-actions .btn {
            width: 100%;
            justify-content: center;
        }
        .table-card {
            display: none;
        }
        .units-mobile-card {
            display: block;
        }
    }
</style>

<div class="units-container">
    <div class="units-header">
        <h1>
            <span class="material-symbols-outlined">menu_book</span>
            <span>Units</span>
        </h1>
        <p>Create and manage content units, activities, and learning materials</p>
    </div>

    <div class="units-actions">
        <a class="btn btn-primary" href="{{ route('units.create') }}">
            <span class="material-symbols-outlined">add</span>
            <span>Add Unit</span>
        </a>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#units_positions_modal">
            <span class="material-symbols-outlined">sort</span>
            <span>Positions</span>
        </button>
        @include('modals.units.set_positions', ["modal_id" => "units_positions_modal"])
    </div>

    <!-- Desktop Table View -->
    <div class="table-card">
        <div class="table-wrapper">
            <table class="units-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td><strong>{{ $unit->title }}</strong></td>
                            <td>{{ $unit->author }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-success" href="{{ route('units.show', $unit->id) }}">
                                        <span class="material-symbols-outlined">visibility</span>
                                        <span>Details</span>
                                    </a>
                                    <form action="{{ route('units.duplicate', $unit->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-info" type="submit" title="Duplicate unit">
                                            <span class="material-symbols-outlined">content_copy</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this unit?');">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">menu_book</span>
                                    <h3>No units added</h3>
                                    <p>Create your first unit to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="units-mobile-card">
        @forelse($units as $unit)
            <div class="unit-mobile-item">
                <div class="unit-mobile-header">
                    <div class="unit-mobile-title">{{ $unit->title }}</div>
                    <div class="unit-mobile-author">Author: {{ $unit->author }}</div>
                </div>
                <div class="unit-mobile-actions">
                    <a class="btn btn-success" href="{{ route('units.show', $unit->id) }}">
                        <span class="material-symbols-outlined">visibility</span>
                        <span>Details</span>
                    </a>
                    <form action="{{ route('units.duplicate', $unit->id) }}" method="POST" style="flex: 1; min-width: 120px;">
                        @csrf
                        <button class="btn btn-info w-100" type="submit" title="Duplicate unit">
                            <span class="material-symbols-outlined">content_copy</span>
                            <span>Duplicate</span>
                        </button>
                    </form>
                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="flex: 1; min-width: 120px;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100" type="submit" onclick="return confirm('Are you sure you want to delete this unit?');">
                            <span class="material-symbols-outlined">delete</span>
                            <span>Delete</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <span class="material-symbols-outlined">menu_book</span>
                <h3>No units added</h3>
                <p>Create your first unit to get started</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
