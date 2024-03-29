@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New Group</h3>
        <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                        <input id="name" name="name" class="form-control" type="text" placeholder="Type an Name for the new level" required>
                    </td>
                </tr>
                <tr>
                    <td>Students</td>
                    <td>
                        <div class="card card-body">
                            @foreach($users as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" onclick="ifUserChecked(this);" value="{{ $user->id }}" id="user_checkbox">
                                    {{ $user->id }}
                                    <label class="form-check-label" for="user_checkbox">{{ $user->name }}</label>
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
                                    <input class="form-check-input" type="checkbox" onclick="ifUnitChecked(this);" value="{{ $unit->id }}" id="user_checkbox">
                                    {{ $unit->id }}
                                    <label class="form-check-label" for="user_checkbox">{{ $unit->title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <button class="btn btn-success" type="submit" onclick="nameStudentFields()">Save</button>
        </div>
    </form>
    </div>
</div>

<script>
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