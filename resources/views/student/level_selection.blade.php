@extends('layouts.app')
@section('main')

<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-10 col-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="bg-white p-4 rounded border border-1 border-white shadow" style="margin-top: 25%;">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="unit" name="unit-label" class="form-label">Select Unit</label>
                        <select name="unit" id="unit" class="form-select">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <a class="btn btn-primary" href="{{ route('student.show', $unit->id) }}">Enter</a>
                        <a class="btn btn-secondary" type="submit">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection