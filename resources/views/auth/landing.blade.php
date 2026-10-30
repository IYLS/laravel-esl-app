@extends('layouts.landing')
@section('main')

<div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1 class="h4 fw-semibold text-dark mb-2" style="font-size: 1.1rem;">Metacognition and Engagement in Computer-Based L2 Listening</h1>
                <p class="h6 fw-semibold text-secondary mb-4" style="font-size: 0.9rem;">Fondecyt Regular 1251060</p>
                <a href="https://sites.google.com/view/icll-2026/home" target="_blank" rel="noopener noreferrer" class="d-inline-block mb-4">
                    <img src="{{ asset('logo_network_complete.png') }}" alt="ICLL 2026 - Network for L2 Listening" class="img-fluid" style="max-width: 400px; width: 100%; height: auto;">
                </a>
                <div class="landing-platform-access mb-4 mx-auto" style="max-width: 420px;">
                    <p class="small text-uppercase mb-2" style="letter-spacing: 0.1em; color: rgba(0,0,0,0.5); font-weight: 600;">Access the research platform</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('auth.login', ['role' => 'student']) }}" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-pill" style="font-size: 0.85rem;">Student</a>
                        <a href="{{ route('auth.login', ['role' => 'teacher']) }}" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-pill" style="font-size: 0.85rem;">Teacher</a>
                        <a href="{{ route('auth.login', ['role' => 'researcher']) }}" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-pill" style="font-size: 0.85rem;">Researcher</a>
                    </div>
                </div>
                <div class="landing-info text-secondary mx-auto" style="max-width: 480px;">
                    <p class="mb-2">
                        <a href="https://www.instagram.com/networkl2listening?igsh=YWJnaHp5azJsbW54&utm_source=qr" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-secondary">Follow us on Instagram</a>
                    </p>
                    <p class="mb-2">
                        <a href="https://sites.google.com/view/icll-2026/home" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-secondary">News</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
