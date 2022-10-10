@extends('layouts.app')
@section('main')

<div class="container">
    @if (Auth::user() != null and Auth::user()) 
        <div class="p-3 mt-3">
            <h3>Welcome, {{ $user->name }}</h3>
        </div>
        <br>
        <div>
            <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Users</h5>
                      <p class="card-text">Manage users, assign each user a group, password or permission to access the platform.</p>
                      <a href="{{ route('users.index') }}" class="btn btn-primary">Go to Users</a>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Groups</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <br>
                      <a href="{{ route('groups.index') }}" class="btn btn-primary">Go to Groups</a>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Researcher module</h5>
                      <p class="card-text">Check users right and wrong answers, dates, time spent, etc.</p>
                      <br>
                      <a href="{{ route('tracking.index') }}" class="btn btn-primary">Go to Researcher module</a>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Units</h5>
                      <p class="card-text">Manage units contents, activities, questions, metacognition and more in this module.</p>
                      <br>
                      <a href="{{ route('units.index') }}" class="btn btn-primary">Go to Units</a>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    @endif
</div>

@endsection