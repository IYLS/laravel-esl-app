@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>Group {{ $group->name }} details</h3>
        <form action="{{ route('groups.update', $group->id ) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                        <input id="name" name="name" class="form-control" type="text" placeholder="Type an Name for the new level" disabled value="{{ $group->name }}">
                    </td>
                </tr>
                <tr>
                    <td>Students</td>
                    <td>
                        <div class="card card-body">
                            @foreach($users as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="ifUserChecked(this);" value="{{ $user->id }}" id="user_checkbox" disabled @if($user->group_id == $group->id) checked name="users[]" @endif>
                                <label class="form-check-label" for="user_checkbox" disabled>{{ $user->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Units</td>
                    <td>
                        <div class="card card-body">
                            @foreach($units as $unit)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="ifUnitChecked(this);" value="{{ $unit->id }}" id="user_checkbox" disabled @if(in_array($unit->id, $unit_groups_array)) checked name="units[]" @endif>
                                <label class="form-check-label" for="user_checkbox" disabled>{{ $unit->title }}</label>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <a class="btn btn-success" onClick="enableFields()">Edit</a>
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('groups.index') }}">Cancel</a>
        </div>
    </form>
    </div>
</div>

<script>
    function enableFields() {
        const studentFields = document.querySelectorAll('.form-check-input');
        studentFields.forEach(function(field) { field.disabled = false });

        const studentLabels = document.querySelectorAll('.form-check-label');
        studentLabels.forEach(function(label) { label.disabled = false });

        document.getElementById('name').disabled = false;
        document.getElementById('units').disabled = false;
    };
    
    function ifUserChecked(element) {
        if (element.checked) {
            element.name = "users[]";
        } else {
            element.name = "";
        }
    }

    function ifUnitChecked(element) {
        if (element.checked) {
            element.name = "units[]";
        } else {
            element.name = "";
        }
    }
</script>

@endsection