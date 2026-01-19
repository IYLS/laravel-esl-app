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
							<button type="button" class="btn btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#updatePasswordModal{{ $user->id }}" title="Actualizar contraseña">
								<span class="material-symbols-outlined">lock_reset</span>
							</button>
							<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="ms-1">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger" type="submit">
									<span class="material-symbols-outlined">delete</span>
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

@foreach($users as $user)
	<!-- Modal para actualizar contraseña - {{ $user->name }} -->
	<div class="modal fade" id="updatePasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="updatePasswordModalLabel{{ $user->id }}" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updatePasswordModalLabel{{ $user->id }}">Actualizar contraseña de {{ $user->name }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ route('users.update_password', $user->id) }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label for="new_password{{ $user->id }}" class="form-label">Nueva contraseña</label>
							<div class="input-group">
								<input type="password" class="form-control" id="new_password{{ $user->id }}" name="password" required minlength="6" placeholder="Mínimo 6 caracteres">
								<button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password{{ $user->id }}', 'toggleNewPasswordIcon{{ $user->id }}')" aria-label="Mostrar contraseña">
									<span class="material-symbols-outlined" id="toggleNewPasswordIcon{{ $user->id }}">visibility</span>
								</button>
							</div>
						</div>
						<div class="mb-3">
							<label for="password_confirmation{{ $user->id }}" class="form-label">Confirmar contraseña</label>
							<div class="input-group">
								<input type="password" class="form-control" id="password_confirmation{{ $user->id }}" name="password_confirmation" required minlength="6" placeholder="Repite la contraseña">
								<button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation{{ $user->id }}', 'toggleConfirmPasswordIcon{{ $user->id }}')" aria-label="Mostrar contraseña">
									<span class="material-symbols-outlined" id="toggleConfirmPasswordIcon{{ $user->id }}">visibility</span>
								</button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Actualizar contraseña</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endforeach

<script>
	function togglePasswordVisibility(inputId, iconId) {
		const passwordInput = document.getElementById(inputId);
		const icon = document.getElementById(iconId);
		
		if (passwordInput && icon) {
			const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
			passwordInput.setAttribute('type', type);
			
			if (type === 'text') {
				icon.textContent = 'visibility_off';
			} else {
				icon.textContent = 'visibility';
			}
		}
	}
</script>

@endsection