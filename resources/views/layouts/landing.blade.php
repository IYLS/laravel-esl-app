<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.head')
    </head>
    <body class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark landing-navbar">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}" style="text-decoration: none;">
                    <img src="{{ asset('logo.png') }}" alt="Ideas for Listening" style="width: 40px; height: 40px; object-fit: contain;">
                    <span>Ideas for Listening</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landingNav">
                    <ul class="navbar-nav mx-auto align-items-center">
                        <li class="nav-item">
                            <span class="pe-3" style="color: rgba(255,255,255,0.75); font-size: 0.875rem;">Login</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login', ['role' => 'student']) }}" title="Student login — Access the research platform">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login', ['role' => 'teacher']) }}" title="Teacher login — Access the research platform">Teacher</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login', ['role' => 'researcher']) }}" title="Researcher login — Access the research platform">Researcher</a>
                        </li>
                    </ul>
                    <a href="https://sites.google.com/view/icll-2026/home" target="_blank" rel="noopener noreferrer" title="ICLL 2026 - Network for L2 Listening" class="d-flex align-items-center ms-auto" style="opacity: 0.9;">
                        <img src="{{ asset('logo_network.png') }}" alt="ICLL 2026" style="width: 36px; height: 36px; object-fit: contain;">
                    </a>
                </div>
            </div>
        </nav>

        @yield('main')

        @include('layouts.sections.footer-landing')

        @include('layouts.scripts')
        @yield('scripts')
    </body>
</html>
