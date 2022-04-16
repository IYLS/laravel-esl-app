@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New proficiency level</h3>
        <form action="{{ route('levels.store') }}" method="POST">
        @csrf
        <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" placeholder="Type an Name for the new level">
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
    </form>
    </div>
</div>

@endsection