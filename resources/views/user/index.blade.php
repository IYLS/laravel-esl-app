@extends('layouts.app')

@section('main')

<style>
    .users-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .users-header {
        margin-bottom: 2rem;
    }
    .users-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .users-header h1 .material-symbols-outlined {
        font-size: 2rem;
        color: var(--color-primary);
    }
    .users-header p {
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
    }
    .filter-actions .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .add-user-btn {
        margin-bottom: 1.5rem;
    }
    .add-user-btn .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        max-height: 65vh;
    }
    .users-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 800px;
    }
    .users-table thead th {
        background: #f8f9fa;
        color: var(--color-text-primary);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        border-bottom: 2px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .users-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        color: var(--color-text-primary);
        font-size: 0.9rem;
    }
    .users-table tbody tr:hover {
        background: #f8f9fa;
    }
    .users-table tbody tr:last-child td {
        border-bottom: none;
    }
    .badge-role {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .badge-role.teacher {
        background: #e7f5f8;
        color: #0dcaf0;
    }
    .badge-role.student {
        background: #d1e7dd;
        color: #198754;
    }
    .badge-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .badge-status.active {
        background: #d1e7dd;
        color: #198754;
    }
    .badge-status.inactive {
        background: #f8d7da;
        color: #dc3545;
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
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
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
    .users-mobile-card {
        display: none;
    }
    .user-mobile-item {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid var(--color-primary);
    }
    .user-mobile-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .user-mobile-info {
        flex: 1;
    }
    .user-mobile-name {
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .user-mobile-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .user-mobile-id {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
    }
    .user-mobile-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .user-mobile-actions .btn {
        flex: 1;
        min-width: 100px;
        justify-content: center;
    }
    @media (max-width: 768px) {
        .users-container {
            padding: 1rem 0.75rem;
        }
        .users-header h1 {
            font-size: 1.5rem;
        }
        .users-header h1 .material-symbols-outlined {
            font-size: 1.5rem;
        }
        .filters-card {
            padding: 1.25rem;
        }
        .filters-form {
            flex-direction: column;
        }
        .filter-group {
            width: 100%;
        }
        .filter-actions {
            width: 100%;
        }
        .filter-actions .btn {
            width: 100%;
            justify-content: center;
        }
        .table-card {
            display: none;
        }
        .users-mobile-card {
            display: block;
        }
        .table-wrapper {
            max-height: none;
        }
    }
</style>

<div class="users-container">
    <div class="users-header">
        <h1>
            <span class="material-symbols-outlined">people</span>
            <span>Users</span>
        </h1>
        <p>Manage users, assign groups, passwords, and permissions</p>
    </div>

    <div class="filters-card">
        <div class="filters-title">
            <span class="material-symbols-outlined">filter_list</span>
            <span>Filters</span>
        </div>
        <form action="{{ route('users.execute_filter') }}" method="POST">
            @csrf
            @method('POST')
            <div class="filters-form">
                <div class="filter-group">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-select">
                        <option value="any">All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="any">All Roles</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-success" type="submit">
                        <span class="material-symbols-outlined">search</span>
                        <span>Apply Filters</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="add-user-btn">
        <a class="btn btn-primary" href="{{ route('users.create') }}">
            <span class="material-symbols-outlined">person_add</span>
            <span>Add User</span>
        </a>
    </div>

    <!-- Desktop Table View -->
    <div class="table-card">
        <div class="table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">ID</th>
                        <th>Name</th>
                        <th class="d-none d-md-table-cell">Role</th>
                        <th>Group</th>
                        <th class="d-none d-md-table-cell">Activated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $user->user_id }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge-role {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                @foreach($groups as $group)
                                    @if($user->group_id == $group->id)
                                        <span class="badge-group">{{ $group->name }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if ($user->activated == true)
                                    <span class="badge-status active">Yes</span>
                                @else
                                    <span class="badge-status inactive">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-success" href="{{ route('users.show', $user->id) }}">
                                        <span class="material-symbols-outlined">visibility</span>
                                        <span class="d-none d-lg-inline">Details</span>
                                    </a>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updatePasswordModal{{ $user->id }}" title="Update password">
                                        <span class="material-symbols-outlined">lock_reset</span>
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" title="Delete user">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">people</span>
                                    <h3>No users found</h3>
                                    <p>Try adjusting your filters or create a new user</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="users-mobile-card">
        @forelse($users as $user)
            <div class="user-mobile-item">
                <div class="user-mobile-header">
                    <div class="user-mobile-info">
                        <div class="user-mobile-name">{{ $user->name }}</div>
                        <div class="user-mobile-meta">
                            <span class="user-mobile-id">ID: {{ $user->user_id }}</span>
                            <span class="badge-role {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            @if ($user->activated == true)
                                <span class="badge-status active">Active</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif
                        </div>
                        @foreach($groups as $group)
                            @if($user->group_id == $group->id)
                                <span class="badge-group">{{ $group->name }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="user-mobile-actions">
                    <a class="btn btn-success" href="{{ route('users.show', $user->id) }}">
                        <span class="material-symbols-outlined">visibility</span>
                        <span>Details</span>
                    </a>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updatePasswordModal{{ $user->id }}">
                        <span class="material-symbols-outlined">lock_reset</span>
                        <span>Password</span>
                    </button>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                        <span class="material-symbols-outlined">delete</span>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <span class="material-symbols-outlined">people</span>
                <h3>No users found</h3>
                <p>Try adjusting your filters or create a new user</p>
            </div>
        @endforelse
    </div>
</div>

@foreach($users as $user)
	<!-- Modal para actualizar contraseña - {{ $user->name }} -->
	<div class="modal fade" id="updatePasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="updatePasswordModalLabel{{ $user->id }}" aria-hidden="true" data-bs-focus="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updatePasswordModalLabel{{ $user->id }}">Update password for {{ $user->name }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ route('users.update_password', $user->id) }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							<label for="new_password{{ $user->id }}" class="form-label">New password</label>
							<div class="input-group">
								<input type="password" class="form-control" id="new_password{{ $user->id }}" name="password" required minlength="6" placeholder="Minimum 6 characters">
								<button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password{{ $user->id }}', 'toggleNewPasswordIcon{{ $user->id }}')" aria-label="Show password">
									<span class="material-symbols-outlined" id="toggleNewPasswordIcon{{ $user->id }}">visibility</span>
								</button>
							</div>
						</div>
						<div class="mb-3">
							<label for="password_confirmation{{ $user->id }}" class="form-label">Confirm password</label>
							<div class="input-group">
								<input type="password" class="form-control" id="password_confirmation{{ $user->id }}" name="password_confirmation" required minlength="6" placeholder="Repeat the password">
								<button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation{{ $user->id }}', 'toggleConfirmPasswordIcon{{ $user->id }}')" aria-label="Show password">
									<span class="material-symbols-outlined" id="toggleConfirmPasswordIcon{{ $user->id }}">visibility</span>
								</button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Update password</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación de eliminación - {{ $user->name }} -->
	<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true" data-bs-focus="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0 pb-0">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-center px-4 pb-4">
					<div class="mb-3">
						<span class="material-symbols-outlined text-danger" style="font-size: 64px;">warning</span>
					</div>
					<h5 class="modal-title mb-3" id="deleteUserModalLabel{{ $user->id }}">Delete User</h5>
					<p class="text-muted mb-4">Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.</p>
					<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<div class="d-flex gap-2 justify-content-center">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-danger">
								<span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">delete</span>
								Delete User
							</button>
						</div>
					</form>
				</div>
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
