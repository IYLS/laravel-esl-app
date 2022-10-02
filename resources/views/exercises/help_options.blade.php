@if($unit->listening_tips_enabled)
@php $modal_id = "listeningTipsModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Listening Tips</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Listening Tips'])
@endif

@if($unit->cultural_notes_enabled)
@php $modal_id = "culturalNotesModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Cultural Notes</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Cultural Notes'])
@endif

@if($unit->transcript_enabled)
@php $modal_id = "transcriptModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Transcript</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Transcript'])
@endif

@if($unit->glossary_enabled)
@php $modal_id = "glossaryModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Glossary</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Glossary'])
@endif

@if($unit->translation_enabled)
@php $modal_id = "translationModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Translation</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Translation'])
@endif

@if($unit->dictionary_enabled)
@php $modal_id = "dictionaryModal"; @endphp
<button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">Dictionary</button>
@include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Dictionary'])
@endif
 {{-- @if($unit->listening_tips_enabled)<a href="#" class="mt-1 btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText()">Google search</a>@endif --}}
 {{-- @if($unit->listening_tips_enabled)<a href="#" class="mt-1 btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText()">Pronunciation aids</a>@endif --}}