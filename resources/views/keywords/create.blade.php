@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New Keyword</h3>
        <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>
                            <input id="name" name="name" class="form-control" type="text" placeholder="Type an Name for the new level">
                        </td>
                    </tr>
                    <tr>
                        <td>Students</td>
                        <td>
                            <div class="card card-body">
                                @foreach($users as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}"w>
                                    <label class="form-check-label" for="flexCheckChecked">{{ $user->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Units</td>
                        <td>
                            <select class="form-select" name="units" id="units">
                                @foreach(units as $unit)
                                    <option value="{{ $unit->id }}" selected>{{ $unit->title }}</option>
                                @endforeach
                            </select>
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
    function nameStudentFields() {
        const fields = document.getElementsByClassName('form-check-input');

        for (var i=0; i < fields.length; i++) { 
            fields[i].setAttribute('name', `user_${i}`);
        }
    }
</script>

@endsection