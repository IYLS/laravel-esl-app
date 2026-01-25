@auth
@if (Auth::user()->role=='teacher')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('profile.show') }}" style="text-decoration: none;">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="rounded-circle me-2" 
                         style="width: 32px; height: 32px; object-fit: cover;">
                @else
                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--color-primary); color: white; font-size: 0.875rem; font-weight: 600;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span style="color: white;">Profile</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" aria-current="page" href="{{ route('auth.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('units.index') }}">Units</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('groups.index') }}">Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('tracking.index') }}">Tracking System</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('forum.index') }}">Forum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('faq.teacher') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('auth.logout') }}">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@elseif(Auth::user()->role=='student')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('profile.show') }}" style="text-decoration: none;">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="rounded-circle me-2" 
                         style="width: 32px; height: 32px; object-fit: cover;">
                @else
                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--color-primary); color: white; font-size: 0.875rem; font-weight: 600;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span style="color: white;">Profile</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('student.level_selection') }}">Choose different unit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('forum.index') }}">Forum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('faq.student') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('leaderboard.index') }}">Leaderboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('auth.logout') }}">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif
@endauth