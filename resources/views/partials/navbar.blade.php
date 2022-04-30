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
                    <a class="nav-link active" aria-current="page" href="{{ route('auth.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">User manuals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('levels.index') }}">Edit Levels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('units.index') }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tracking Systems</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@else
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">ESL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('auth.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">User manuals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('levels.index') }}">Edit Levels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('units.index') }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tracking Systems</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif
@endauth