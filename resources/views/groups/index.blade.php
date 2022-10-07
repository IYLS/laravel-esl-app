@extends('layouts.app')
@section('main')

<div class="container mt-5">
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-12 col-md-6 mt-2">
            <div class="card">
				<div class="card-body">
					<h5 class="card-title">{{ $group->name }}</h5>
					<p class="card-text text-secondary"><small>
						@if($students_count["$group->id"] == 1)
						1 student belongs to this group
						@elseif($students_count["$group->id"] == 0)
						any student belongs to this group
						@else
						{{ $students_count["$group->id"] }} students belong to this group
						@endif
					</small></p>
					<p class="card-text text-secondary"><small>
						@if($units_count["$group->id"] == 1)
						1 unit assigned to this group
						@elseif($units_count["$group->id"] == 0)
						there are no units assigned to this group
						@else
						{{ $units_count["$group->id"] }} units assigned to this group
						@endif
					</small></p>
					<div class="d-flex">
						<a href="{{ route('groups.show', $group->id) }}" class="btn btn-success">Details</a>
						<form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="ms-1">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger" type="submit">
								<i class="mdi mdi-delete"></i>
							</button>
						</form>					
					</div>

				</div>
            </div>
          </div>
        @endforeach
    </div>

    <a class="btn btn-primary p-3 m-5" href="{{ route('groups.create') }}">New Group</a>
</div>

@endsection