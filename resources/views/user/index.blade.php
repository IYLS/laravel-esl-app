@extends('layouts.app')

@section('main')

<div class="container">

	<div class="overflow-auto" style="height: 65vh !important;">
		<table class="table">
		<thead>
			<tr>
				<th scope="col" class="d-none d-md-table-cell">ID</th>
				<th scope="col">Name</th>
				<th scope="col" class="d-none d-md-table-cell">Role</th>
				<th scope="col">Group</th>
				<th scope="col" class="d-none d-md-table-cell">Activated</th>
				<th scope="col">Actions</th>
            </tr>
			</thead>
			<tbody>
				@forelse($users as $user)
					<tr>
						<td class="d-none d-md-table-cell">{{ $user->user_id }}</td>
						<td>{{ $user->name }}</td>
						<td class="d-none d-md-table-cell">{{ $user->role }}</td>
						<td>
							@foreach($groups as $group)
								@if($user->group_id == $group->id)
									{{ $group->name }}
								@endif
							@endforeach
						</td>
						<td class="d-none d-md-table-cell">
							@if ($user->activated == true) 
								Yes
							@else
								No
							@endif
						</td>
						<td class="d-flex">
							<a id="details" class="btn btn-success" href="{{ route('users.show', $user->id) }}">Details</a>
							<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="ms-1">
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
							<p class="text-secondary"><small>No users added</small></p>
						</td>
					</tr>	
				@endforelse
            </tbody>
		</table>
  	</div>
	<form action="{{ route('users.execute_filter') }}" method="POST">
		@csrf
		@method('POST')
		<div class="d-flex">
			<div class="ms-2 me-2 row">
				<p>Filter</p>
			</div>
			<div class="ms-2 me-2 row">
				<select name="group" id="" class="form-select form-select-sm">
					<option value="any">Any</option>
					@foreach($groups as $group)
						<option value="{{ $group->id }}">{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="ms-2 me-2 row">
				<select name="role" id="" class="form-select form-select-sm">
					<option value="any">Any</option>
					<option value="teacher">Teacher</option>
					<option value="student">Student</option>
				</select>
			</div>
			<div class="ms-2 me-2 row">
				<button class="btn btn-success" type="submit">
					Filter
				</button>
			</div>
		</div>
	</form>
	<br>
	<div class="mt-2">
		<a class="btn btn-primary" href="{{ route('users.create') }}">Add user</a>
	</div>

</div>

@endsection