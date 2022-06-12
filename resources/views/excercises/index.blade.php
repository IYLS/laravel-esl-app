@extends('layouts.app')
@section('main')

<style>
    body {
        background-color: darkgrey;
    }
</style>
<div class="container">
    <div class="card row p-2 m-2">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h4>Pre-listening</h4>
                <p class="text-secondary">5 excercises</p>
            </div>
            <button class="btn btn-primary">Add excercises</button>
        </div>
    </div>

    <div class="card row p-2 m-2">
        <div class="card-body d-flex justify-content-between">
            <h4>While-listening</h4>
            <button class="btn btn-primary">Add excercises</button>
        </div>
    </div>

    <div class="card row p-2 m-2">
        <div class="card-body d-flex justify-content-between">
            <h4>Post-listening</h4>
            <button class="btn btn-primary">Add excercises</button>

        </div>
    </div>
</div>

@endsection