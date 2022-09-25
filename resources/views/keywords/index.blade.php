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
                <td>
                    <p>{{ $keyword->description }}</p>
                </td>
                <td>
                    {{-- <form action="{{ route('keywords.destroy', [$exercise->section->unit_id, $keyword->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                        <button type="button" id="addKeywordButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editKeywordModal">Edit</button>
                    </form> --}}
                    <button class="btn btn-danger btn-sm">Delete</button>
                    <br>
                    <button class="btn btn-warning btn-sm">Edit</button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="editKeywordModal" tabindex="-1" aria-labelledby="editKeywordModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKeywordModal">Edit Keyword</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('keywords.update', [$exercise->section->unit_id, $keyword->id]) }}" method="POST">
                                @csrf
                                <input id="word" name="word" type="text" class="form-control" placeholder="Enter keyword" value="{{ $keyword->keyword }}">
                                <br>
                                <input id="description" name="description" type="text" class="form-control" placeholder="Enter description" value="{{ $keyword->description }}">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
    <div>
        <button type="button" id="addKeywordButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKeywordModal">
            Add keyword
        </button>
        <a type="button" class="btn btn-secondary" href="{{ url()->previous() }}">
            Go back
        </a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addKeywordModal" tabindex="-1" aria-labelledby="addKeywordModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKeywordModal">New Keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('keywords.store', $exercise->section->unit_id) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Enter keyword">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Enter description">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection