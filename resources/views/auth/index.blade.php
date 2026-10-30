@extends('layouts.app')
@section('main')

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .dashboard-header {
        margin-bottom: 2.5rem;
    }
    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }
    .dashboard-header p {
        color: var(--color-text-secondary);
        font-size: 1rem;
        margin: 0;
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    .dashboard-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 28px;
    }
    .dashboard-card-icon .material-symbols-outlined {
        font-size: 28px;
        color: white;
    }
    .dashboard-card.users .dashboard-card-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .dashboard-card.groups .dashboard-card-icon {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .dashboard-card.tracking .dashboard-card-icon {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
    }
    .dashboard-card.units .dashboard-card-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .dashboard-card.forum .dashboard-card-icon {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .dashboard-card.faq .dashboard-card-icon {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }
    .dashboard-card.leaderboard .dashboard-card-icon {
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    }
    .dashboard-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 0.75rem;
    }
    .dashboard-card-description {
        color: var(--color-text-secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .dashboard-card-action {
        margin-top: auto;
    }
    .dashboard-card-action .btn {
        width: 100%;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .dashboard-card-action .btn .material-symbols-outlined {
        font-size: 18px;
    }
    .dashboard-card.users .dashboard-card-action .btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    .dashboard-card.users .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a91 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    .dashboard-card.groups .dashboard-card-action .btn {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        color: white;
    }
    .dashboard-card.groups .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #0e7a72 0%, #2dd66a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
    }
    .dashboard-card.tracking .dashboard-card-action .btn {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        border: none;
        color: white;
    }
    .dashboard-card.tracking .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #0bb5d6 0%, #0b5ed7 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.3);
    }
    .dashboard-card.units .dashboard-card-action .btn {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        color: white;
    }
    .dashboard-card.units .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #d77ae3 0%, #d9465e 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
    }
    .dashboard-card.forum .dashboard-card-action .btn {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border: none;
        color: white;
    }
    .dashboard-card.forum .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #e85d8a 0%, #e6cd2a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
    }
    .dashboard-card.faq .dashboard-card-action .btn {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        border: none;
        color: white;
    }
    .dashboard-card.faq .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #28b8b9 0%, #2a0756 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(48, 207, 208, 0.3);
    }
    .dashboard-card.leaderboard .dashboard-card-action .btn {
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        border: none;
        color: white;
    }
    .dashboard-card.leaderboard .dashboard-card-action .btn:hover {
        background: linear-gradient(135deg, #e6c200 0%, #e69400 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem 0.5rem;
        }
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .dashboard-card {
            padding: 1.25rem;
        }
    }
</style>

<div class="dashboard-container">
    @if (Auth::user() != null and Auth::user()->role == 'teacher') 
        <div class="dashboard-header">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('logo.png') }}" alt="Ideas for Listening Logo" style="max-width: 60px; height: auto; margin-right: 1rem;">
                <div>
                    <h1 class="mb-0">Welcome back, {{ $user->name }}! 👋</h1>
                    <p class="mb-0">Manage your platform and track student progress from here</p>
                </div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card users">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">people</span>
                </div>
                <h3 class="dashboard-card-title">Users</h3>
                <p class="dashboard-card-description">
                    Manage users, assign groups, passwords, and permissions to access the platform.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('users.index') }}" class="btn">
                        <span>Go to Users</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card groups">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <h3 class="dashboard-card-title">Groups</h3>
                <p class="dashboard-card-description">
                    Create and manage student groups. Assign units to groups and organize your classes efficiently.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('groups.index') }}" class="btn">
                        <span>Go to Groups</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card tracking">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
                <h3 class="dashboard-card-title">Tracking System</h3>
                <p class="dashboard-card-description">
                    Monitor student progress, review answers, track time spent, and analyze learning patterns.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('tracking.index') }}" class="btn">
                        <span>Go to Tracking</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card units">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <h3 class="dashboard-card-title">Units</h3>
                <p class="dashboard-card-description">
                    Create and manage content units, activities, questions, and learning materials for your students.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('units.index') }}" class="btn">
                        <span>Go to Units</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card forum">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">forum</span>
                </div>
                <h3 class="dashboard-card-title">Forum</h3>
                <p class="dashboard-card-description">
                    Engage with students through discussions, answer questions, and foster collaborative learning in the community forum.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('forum.index') }}" class="btn">
                        <span>Go to Forum</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card leaderboard">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">emoji_events</span>
                </div>
                <h3 class="dashboard-card-title">Leaderboard</h3>
                <p class="dashboard-card-description">
                    View student progress rankings by group. Track completion rates and motivate engagement with the leaderboard.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('leaderboard.index') }}" class="btn">
                        <span>Go to Leaderboard</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="dashboard-card faq">
                <div class="dashboard-card-icon">
                    <span class="material-symbols-outlined">help</span>
                </div>
                <h3 class="dashboard-card-title">FAQ</h3>
                <p class="dashboard-card-description">
                    Access frequently asked questions, guides, and documentation to help you navigate and use the platform effectively.
                </p>
                <div class="dashboard-card-action">
                    <a href="{{ route('faq.teacher') }}" class="btn">
                        <span>Go to FAQ</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    @elseif(Auth::user() != null and Auth::user()->role == 'student')
        <div class="p-5">
          <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('logo.png') }}" alt="Ideas for Listening Logo" style="max-width: 60px; height: auto; margin-right: 1rem;">
            <div>
              <h3 class="mb-0">Welcome, {{ Auth::user()->name }}!</h3>
            </div>
          </div>
          <h5>We are glad to have you here 🥳</h5>
          <h5>Start <a href="{{ route('student.welcome') }}">here</a> to begin your learning journey.</h5>
        </div>
    @endif
</div>

@endsection