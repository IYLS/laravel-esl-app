@extends('layouts.app')
@section('main')

<div class="container mt-5">
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ $group->name }}</h5>
                <p class="card-text">This level contains the following units:</p></li>
                <a href="{{ route('groups.show', $group->id) }}" class="btn btn-primary">Details</a>
              </div>
            </div>
          </div>
        @endforeach
    </div>

    <a class="btn btn-primary p-3 m-5" href="{{ route('groups.create') }}">New Group</a>
</div>


@endsection