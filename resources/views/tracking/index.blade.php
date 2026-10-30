@extends('layouts.app')
@section('main')

<style>
    .tracking-index-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .tracking-header {
        margin-bottom: 2rem;
    }
    .tracking-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .tracking-header h1 .material-symbols-outlined {
        font-size: 2rem;
        color: var(--color-primary);
    }
    .tracking-header p {
        color: var(--color-text-secondary);
        font-size: 1rem;
        margin: 0;
    }
    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .filters-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .filters-title .material-symbols-outlined {
        font-size: 20px;
        color: var(--color-primary);
    }
    .filters-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .filter-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--color-text-secondary);
        margin-bottom: 0.5rem;
    }
    .filter-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .filter-group select:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .filter-actions .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .filter-actions .btn .material-symbols-outlined {
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
        max-height: 70vh;
        border-radius: 8px;
        -webkit-overflow-scrolling: touch;
    }
    .tracking-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 800px;
    }
    @media (max-width: 768px) {
        .tracking-table {
            min-width: 600px;
        }
        .tracking-table thead th,
        .tracking-table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.85rem;
        }
    }
    .tracking-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .tracking-table thead th {
        background: #f8f9fa;
        color: var(--color-text-primary);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        border-bottom: 2px solid #dee2e6;
    }
    .tracking-table thead th:first-child {
        border-top-left-radius: 8px;
    }
    .tracking-table thead th:last-child {
        border-top-right-radius: 8px;
    }
    .tracking-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        color: var(--color-text-primary);
        font-size: 0.9rem;
    }
    .tracking-table tbody tr {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tracking-table tbody tr:hover {
        background: #f8f9fa;
        transform: translateX(2px);
    }
    .tracking-table tbody tr:last-child td {
        border-bottom: none;
    }
    .tracking-table tbody td:last-child {
        text-align: center;
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
    .badge-group {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
        background: #e7f5f8;
        color: #0dcaf0;
    }
    /* Mobile Card View */
    .tracking-mobile-card {
        display: none;
    }
    .tracking-mobile-item {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 4px solid var(--color-primary);
    }
    .tracking-mobile-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .mobile-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .mobile-item-title {
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    .mobile-item-meta {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }
    .mobile-item-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .mobile-info-item {
        display: flex;
        flex-direction: column;
    }
    .mobile-info-label {
        font-size: 0.75rem;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    .mobile-info-value {
        font-size: 0.9rem;
        color: var(--color-text-primary);
        font-weight: 500;
    }
    .mobile-item-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid #e9ecef;
    }
    .mobile-item-date {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }
    .mobile-item-arrow {
        color: var(--color-primary);
    }
    @media (max-width: 768px) {
        .tracking-index-container {
            padding: 1rem 0.75rem;
        }
        .tracking-header {
            margin-bottom: 1.5rem;
        }
        .tracking-header h1 {
            font-size: 1.5rem;
            flex-wrap: wrap;
        }
        .tracking-header h1 .material-symbols-outlined {
            font-size: 1.5rem;
        }
        .tracking-header p {
            font-size: 0.9rem;
        }
        .filters-card {
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .filters-title {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .filters-form {
            flex-direction: column;
            gap: 1rem;
        }
        .filter-group {
            width: 100%;
            min-width: unset;
        }
        .filter-actions {
            width: 100%;
            flex-direction: column;
        }
        .filter-actions .btn {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1.25rem;
        }
        .table-card {
            padding: 0;
            display: none;
        }
        .tracking-mobile-card {
            display: block;
        }
        .table-wrapper {
            max-height: none;
        }
    }
    @media (max-width: 480px) {
        .tracking-index-container {
            padding: 0.75rem 0.5rem;
        }
        .tracking-header h1 {
            font-size: 1.25rem;
        }
        .mobile-item-info {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        .tracking-mobile-item {
            padding: 1rem;
        }
    }
</style>

<div class="tracking-index-container">
    <div class="tracking-header">
        <h1>
            <span class="material-symbols-outlined">analytics</span>
            <span>Tracking System</span>
        </h1>
        <p>Monitor student progress, review answers, and analyze learning patterns</p>
    </div>

    <div class="filters-card">
        <div class="filters-title">
            <span class="material-symbols-outlined">filter_list</span>
            <span>Filters</span>
        </div>
        <form action="{{ route('tracking.execute_filter') }}" method="POST">
            @csrf
            @method('POST')
            <div class="filters-form">
                <div class="filter-group">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-select">
                        <option value="any" {{ (!isset($currentGroup) || $currentGroup == 'any') ? 'selected' : '' }}>All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ (isset($currentGroup) && $currentGroup == $group->id) ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="student">Student</label>
                    <select name="student" id="student" class="form-select">
                        <option value="any" {{ (!isset($currentStudent) || $currentStudent == 'any') ? 'selected' : '' }}>All Students</option>
                        @foreach($groups as $group)
                            <optgroup label="{{ $group->name }}">
                                @foreach($students as $student)
                                    @if($student->group_id == $group->id)
                                        <option value="{{ $student->id }}" {{ (isset($currentStudent) && $currentStudent == $student->id) ? 'selected' : '' }}>{{ $student->user_id }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-success" type="submit">
                        <span class="material-symbols-outlined">search</span>
                        <span>Apply Filters</span>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectGroupForDataExportModal">
                        <span class="material-symbols-outlined">download</span>
                        <span>Export Data</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Desktop Table View -->
    <div class="table-card">
        <div class="table-wrapper">
            <table class="tracking-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Unit</th>
                        <th>Group</th>
                        <th>Exercise</th>
                        <th>Date/Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tracking as $t)
                        @php
                            $showUrl = route('tracking.show', $t->id);
                            $queryParams = [];
                            if (isset($currentGroup) && $currentGroup != 'any') {
                                $queryParams['group'] = $currentGroup;
                            }
                            if (isset($currentStudent) && $currentStudent != 'any') {
                                $queryParams['student'] = $currentStudent;
                            }
                            if (!empty($queryParams)) {
                                $showUrl .= '?' . http_build_query($queryParams);
                            }
                        @endphp
                        <tr onclick="navigateTo({{ json_encode($showUrl) }})">
                            <td>
                                @if(is_null($t->user))
                                    <span class="text-muted">-</span>
                                @else
                                    <strong>{{ $t->user->user_id }}</strong>
                                @endif
                            </td>
                            <td>
                                @if(isset($t->exercise->section->unit->title))
                                    {{ $t->exercise->section->unit->title }}
                                @else
                                    <span class="text-muted">Not found</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($t->user->group->name))
                                    <span class="badge-group">{{ $t->user->group->name }}</span>
                                @else
                                    <span class="text-muted">Not found</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($t->exercise))
                                    {{ $t->exercise->exerciseType->name . " - " . $t->exercise->section->name }}
                                @else
                                    <span class="text-muted">Not found</span>
                                @endif
                            </td>
                            <td>
                                {{ date('d-m-Y - H:i:s', strtotime($t->created_at)); }}
                            </td>
                            <td>
                                <span class="material-symbols-outlined" style="color: var(--color-primary);">chevron_right</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">inbox</span>
                                    <h3>No tracking data found</h3>
                                    <p>Try adjusting your filters to see more results</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="tracking-mobile-card">
        @forelse($tracking as $t)
            @php
                $showUrl = route('tracking.show', $t->id);
                $queryParams = [];
                if (isset($currentGroup) && $currentGroup != 'any') {
                    $queryParams['group'] = $currentGroup;
                }
                if (isset($currentStudent) && $currentStudent != 'any') {
                    $queryParams['student'] = $currentStudent;
                }
                if (!empty($queryParams)) {
                    $showUrl .= '?' . http_build_query($queryParams);
                }
            @endphp
            <div class="tracking-mobile-item" onclick="navigateTo({{ json_encode($showUrl) }})">
                <div class="mobile-item-header">
                    <div>
                        <div class="mobile-item-title">
                            @if(is_null($t->user))
                                <span class="text-muted">Unknown Student</span>
                            @else
                                {{ $t->user->user_id }}
                            @endif
                        </div>
                        <div class="mobile-item-meta">
                            @if(isset($t->exercise->section->unit->title))
                                {{ $t->exercise->section->unit->title }}
                            @else
                                <span class="text-muted">Unit not found</span>
                            @endif
                        </div>
                    </div>
                    @if(isset($t->user->group->name))
                        <span class="badge-group">{{ $t->user->group->name }}</span>
                    @endif
                </div>
                <div class="mobile-item-info">
                    <div class="mobile-info-item">
                        <div class="mobile-info-label">Exercise</div>
                        <div class="mobile-info-value">
                            @if(isset($t->exercise))
                                {{ $t->exercise->exerciseType->name }}
                            @else
                                <span class="text-muted">Not found</span>
                            @endif
                        </div>
                    </div>
                    <div class="mobile-info-item">
                        <div class="mobile-info-label">Section</div>
                        <div class="mobile-info-value">
                            @if(isset($t->exercise->section->name))
                                {{ $t->exercise->section->name }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mobile-item-footer">
                    <div class="mobile-item-date">
                        {{ date('d/m/Y H:i', strtotime($t->created_at)); }}
                    </div>
                    <span class="material-symbols-outlined mobile-item-arrow">chevron_right</span>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <span class="material-symbols-outlined">inbox</span>
                <h3>No tracking data found</h3>
                <p>Try adjusting your filters to see more results</p>
            </div>
        @endforelse
    </div>
</div>

@include('modals.tracking.export_data')

<script>
    function navigateTo(url) {
        window.location.href = url;
    }
</script>

@endsection