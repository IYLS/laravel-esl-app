@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>{{ $proficiencyLevel->name }} level details</h3>
        <form action="{{ route('levels.update', $proficiencyLevel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" disabled value={{ $proficiencyLevel->name }}>
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <a class="btn btn-secondary" onClick="enableFields()">Edit</a>
            <button class="btn btn-danger">Delete</button>
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('levels.index') }}">Cancel</a>
        </div>
    </form>
    </div>
</div>

<script>
    function enableFields() {
        document.getElementById('name').disabled = false;
    };
</script>

@endsection