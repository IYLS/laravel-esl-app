@if($unit->listening_tips_enabled)
    @php $modal_id = "listeningTipsModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('listening_tips');">Tips</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->listening_tips, 'modal_title' => 'Tips', 'type' => 'listening_tips'])
@endif

@if($unit->cultural_notes_enabled)
    @php $modal_id = "culturalNotesModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('cultural_notes');">Cultural Notes</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->cultural_notes, 'modal_title' => 'Cultural Notes', 'type' => 'cultural_notes'])
@endif

@if($unit->transcript_enabled)
    @php $modal_id = "transcriptModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('transcript');">Transcript</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->transcript, 'modal_title' => 'Transcript', 'type' => 'transcript'])
@endif

@if($unit->glossary_enabled)
    @php $modal_id = "glossaryModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('glossary');">Glossary</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->glossary, 'modal_title' => 'Glossary', 'type' => 'glossary'])
@endif

@if($unit->translation_enabled)
    @php $modal_id = "translationModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('translation');">Translation</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->translation, 'modal_title' => 'Translation', 'type' => 'translation'])
@endif

@if($unit->dictionary_enabled)
    @php $modal_id = "dictionaryModal"; @endphp
    <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="onHelpOptionClicked('dictionary');">Dictionary</button>
    @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $unit->dictionary, 'modal_title' => 'Dictionary', 'type' => 'dictionary'])
@endif