@extends('layouts.app')
@section('main')

<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="bg-white p-4 rounded border border-1 border-white shadow" style="margin-top: 25%;">
                <form action="{{ route('student.level_selection') }}" method="POST">
                    @csrf
                    <h3 class="form-label mb-3">Level selection</h3>
                    <div class="mb-3">
                        <label for="level" name="level-label" class="form-label">Proficiency Level</label>
                        <select name="level" id="level" class="form-select">
                            <option value="">High-beginner</option>
                            <option value="">Beginner</option>
                            <option value="">Intermediate</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit" name="unit-label" class="form-label">Unit</label>
                        <select name="unit" id="unit" class="form-select">
                            <option value="">Soft Electronics</option>
                            <option value="">Around the world</option>
                            <option value="">Other Cultures</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="class" name="class-label" class="form-label">Class</label>
                        <select name="class" id="class" class="form-select">
                            <option value="">21</option>
                            <option value="">49</option>
                        </select>                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">Enter</button>
                        <a class="btn btn-secondary" type="submit">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection