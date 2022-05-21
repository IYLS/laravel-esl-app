@extends('layouts.app')
@section('main')


<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>Group {{ $group->name }} details</h3>
        <form action="{{ route('groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                        <input id="name" name="name" class="form-control" type="text" placeholder="Type an Name for the new level" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Students</td>
                    <td>
                        <div class="card card-body">
                            @foreach($users as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="user_checkbox" disabled=true>
                                <label class="form-check-label" for="user_checkbox" disabled=true>{{ $user->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Units</td>
                    <td>
                        <select class="form-select" name="units" id="units" disabled>
                            @foreach($levels as $level)
                                <optgroup label="{{ $level->name }}">
                                @foreach($level->units as $unit)
                                    <option value="{{ $unit->id }}" selected>{{ $unit->title }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
    </table>
        <div>
            <a class="btn btn-secondary" onClick="enableFields()">Edit</a>
            <button class="btn btn-danger">Delete</button>
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('groups.index') }}">Cancel</a>
        </div>
    </form>
    </div>
</div>

<script>
    function enableFields() {
        document.getElementById('name').disabled = false;

        const inputs = document.getElementsByTagName('input');
        for(input in inputs) {
            input.disabled = false;
        }

        const labels = document.getElementsByTagName('label');
        for(label in labels) {
            label.disabled = false;
        }

        document.getElementById('units').disabled = false;
    };
</script>

@endsection