@extends('layouts.app')
@section('main')

<div class="container">
    <table class="table">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Details</th>
        </tr>
        </thead>
        <tbody>
            @forelse($units as $unit)
                <tr>
                    <td>{{ $unit->title }}</td>
                    <td>{{ $unit->author }}</td>
                    <td class="d-flex">
                        <a id="details" class="btn btn-success" href="{{ route('units.show', $unit->id) }}">Details</a>
                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="ms-1">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger" type="submit">
								<i class="mdi mdi-delete"></i>
							</button>
						</form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        <p class="text-secondary"><small>No units added</small></p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="row">
        <div class="col-2">
            <a class="btn btn-primary" href="{{ route('units.create') }}">Add unit</a>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#units_positions_modal">
                Positions  <i class="mdi mdi-sort-ascending"></i>
            </button>
            @include('modals.units.set_positions', ["modal_id" => "units_positions_modal"])
        </div>
    </div>
  </div>

@endsection