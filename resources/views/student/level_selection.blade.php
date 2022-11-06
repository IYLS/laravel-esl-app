@extends('layouts.app')
@section('main')

@section('title', 'Unit selection')

<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-10 col-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="bg-white p-4 rounded border border-1 border-white shadow" style="margin-top: 25%;">
                @if(isset($units) and $units != null)
                    <form action="{{ route('student.select') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="unit" name="unit-label" class="form-label">Select Unit</label>
                            <select name="unit" id="unit" class="form-select" required>
                                @forelse($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                @empty
                                    <p>nothing to show</p>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Enter</button>
                            <a class="btn btn-secondary" type="submit">Cancel</a>
                        </div>
                    </form>
                @else
                    <p class="text-secondary text-center">No units available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection