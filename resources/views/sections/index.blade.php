@extends('layouts.app')
@section('main')


<div class="container">
    <div class="mt-3 mb-2 p-2">
        <h3>{{ $unit->title }}</h3>
    </div>
    <table class="table" id="sections_table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Information</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
            <tr>
                <td>
                    <p>{{ $section->name }}</p>
                </td>
                <td>
                    <p class="text-break">{{ $section->instructions }}</p>
                </td>
                <td class="d-flex">
                    <form action="{{ route('sections.destroy', $section, $unit_id) }}" method="POST" class="me-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" >
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </form>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSectionModal-{{ $section->id }}">
                        Edit
                    </button>
                    @include('modals.sections.edit', ["section" => $section, "unit_id" => $unit_id])
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <p class="text-secondary text-center"><small>No sections added yet.</small></p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex">
        <div class="m-1">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                Add section
            </button>
        </div>
        <div class="m-1">
            <a type="button" class="btn btn-secondary" href="{{ route('units.show', $unit_id) }}">
                Go back
            </a>
        </div>
        <div class="m-1">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#sections_positions_modal">
                Positions  <i class="mdi mdi-sort-ascending"></i>
            </button>
        </div>
    </div>
</div>

@include('modals.sections.set_positions', ["modal_id" => "sections_positions_modal"])
@include('modals.sections.add')

@endsection