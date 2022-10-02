@extends('layouts.app')

@section('main')

    <div class="container">
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
		<div>
			<a class="btn btn-primary" href="{{ route('users.create') }}">Add user</a>
		</div>
  	</div>

@endsection