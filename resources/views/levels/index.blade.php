@extends('layouts.app')
@section('main')


<div class="container mt-5">
    <div class="row">
        @foreach ($levels as $level)
        <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ $level->name }}</h5>
                <p class="card-text">This level contains the following units:</p></li>
                @foreach($level->units as $levelUnit)
                <ul>
                  <li>
                    <p class="card-text"><small>{{ $levelUnit->title }}</small></p></li>
                </ul>
                @endforeach
                <a href="{{ route('levels.show', $level->id) }}" class="btn btn-primary">Details</a>
              </div>
            </div>
          </div>
        @endforeach
    </div>

    <a class="btn btn-primary p-3 m-5" href="{{ route('levels.create') }}">New Proficiency Level</a>
</div>


@endsection