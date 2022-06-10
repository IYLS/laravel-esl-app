@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>Pre-listening activities</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Type</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($excercises as $excercise)
                    <tr>
                        <td>{{ $excercise->name }}</td>
                        <td>{{ $excercise->type }}</td>
                        <td>
                            <a id="details" class="btn btn-primary" href="{{ route('units.show', $unit->id) }}">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary">Add excercise</button>
    </div>
</div>

@endsection