@extends('layouts.app')

@section('main')

    <div class="container">
		<table class="table">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Name</th>
				<th scope="col">Age</th>
				<th scope="col">Gender</th>
				<th scope="col">Language</th>
				<th scope="col">Email</th>
				<th scope="col">Role</th>
				<th scope="col">Group</th>
				<th scope="col">Activated</th>
				<th scope="col">Actions</th>
            </tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->user_id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->age }}</td>
					<td>{{ $user->gender }}</td>
					<td>{{ $user->language }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->role }}</td>
					<td>
						@foreach($groups as $group)
							@if($user->group_id == $group->id)
								{{ $group->name }}
							@endif
						@endforeach
					</td>
					<td>
						@if ($user->activated == true) 
							Yes
						@else
							No
						@endif
					</td>
					<td>
						<a id="details" class="btn btn-primary" href="{{ route('users.show', $user->id) }}">Details</a>
					</td>
				</tr>
			@endforeach
            </tbody>
		</table>
		<div>
			<a class="btn btn-primary" href="{{ route('users.create') }}">Add user</a>
		</div>
  	</div>

@endsection