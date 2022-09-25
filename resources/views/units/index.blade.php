@extends('layouts.app')
@section('main')

<div class="container">
    <table class="table">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Details</th>
        </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->title }}</td>
                    <td>{{ $unit->author }}</td>
                    <td>
                        <a id="details" class="btn btn-primary" href="{{ route('units.show', $unit->id) }}">Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <a class="btn btn-primary" href="{{ route('units.create') }}">Add unit</a>
    </div>
  </div>

@endsection