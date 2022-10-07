@auth
@if (Auth::user()->role=='teacher')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">ESL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" aria-current="page" href="{{ route('auth.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('users.index') }}">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('units.index') }}">Units</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('groups.index') }}">Groups</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="#">Tracking System</a>
                    </li> --}}
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
            <a class="navbar-brand" href="#">ESL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">Greetings, {{ Auth::user()->name }}!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('student.level_selection') }}">Choose different unit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="this.classList.add('active');" href="{{ route('forum.index') }}">Forum</a>
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