@extends('layouts.app')
@section('main')

<div class="container">
    @if (Auth::user() != null) 
    <h3>Welcome, {{ $user->name }}</h3>        
    @else
    <h3>Home screen</h3>
    @endif
</div>

@include('partials.prompt')

@endsection