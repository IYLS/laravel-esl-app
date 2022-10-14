@extends('layouts.app')
@section('main')

<div class="container">
    <table class="table" id="keywords_table">
    <thead>
        <tr>
            <th scope="col">Word</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($keywords as $keyword)            
            <tr>
                <td>
                    <p>{{ $keyword->keyword }}</p>
                </td>
                <td class="">
                    <p class="text-break">{{ $keyword->description }}</p>
                </td>
                <td class="d-flex">
                    <form action="{{ route('keywords.destroy', $keyword->id, $keyword) }}" method="POST" class="me-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" >
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </form>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKeywordModal-{{ $keyword->id }}">
                        Edit
                    </button>
                    @include('modals.keywords.edit', [$keyword, $unit_id])
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKeywordModal">
            Add keyword
        </button>
        <a type="button" class="btn btn-secondary" href="{{ route('units.show', $unit_id) }}">
            Go back
        </a>
    </div>
</div>

@include('modals.keywords.add')

@endsection