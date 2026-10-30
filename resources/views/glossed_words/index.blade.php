@extends('layouts.app')
@section('main')

<div class="container">
    <table class="table" id="glossed_words_table">
    <thead>
        <tr>
            <th scope="col">Word</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @forelse($glossed_words as $word)            
                <tr>
                    <td>
                        <p>{{ $word->word }}</p>
                    </td>
                    <td class="">
                        <p class="text-break">{{ $word->description }}</p>
                    </td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deleteGlossedWordModal{{ $word->id }}" title="Delete word">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGlossedWordModal-{{ $word->id }}">
                            Edit
                        </button>
                        @include('modals.glossed_words.edit', [$word, $unit_id])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=3>
                        <p class="text-secondary text-center"><small>Empty</small></p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGlossedWordModal">Add word</button>
        <a type="button" class="btn btn-secondary" href="{{ route('units.show', $unit_id) }}">Go back</a>
    </div>
</div>

@include('modals.glossed_words.add')

@foreach($glossed_words as $word)
    @include('components.delete-confirmation-modal', [
        'modalId' => 'deleteGlossedWordModal' . $word->id,
        'title' => 'Delete Glossed Word',
        'itemName' => $word->word,
        'route' => route('glossed_words.destroy', [$word->id, $word]),
        'deleteButtonText' => 'Delete Word'
    ])
@endforeach

@endsection