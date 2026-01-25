@extends('layouts.app')
@section('main')

<style>
    .unit-detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .unit-header {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .unit-header h1 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--color-text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .unit-header h1 .material-symbols-outlined {
        font-size: 1.75rem;
        color: var(--color-primary);
    }
    .unit-header .btn-back {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .unit-header .btn-back:hover {
        color: var(--color-hover-primary);
        transform: translateX(-2px);
    }
    .unit-form-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section:last-child {
        margin-bottom: 0;
    }
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .form-section-title .material-symbols-outlined {
        font-size: 24px;
        color: var(--color-primary);
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }
    .form-group input,
    .form-group textarea {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .form-group input:disabled,
    .form-group textarea:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
    }
    .help-options-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .help-options-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }
    .help-options-toggle {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .help-options-toggle .material-symbols-outlined {
        transition: transform 0.3s ease;
    }
    .help-options-toggle[aria-expanded="true"] .material-symbols-outlined {
        transform: rotate(180deg);
    }
    .help-options-content {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    .help-option-item {
        margin-bottom: 1.5rem;
    }
    .help-option-item:last-child {
        margin-bottom: 0;
    }
    .help-option-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    .help-option-header h6 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .form-check-input:disabled {
        cursor: not-allowed;
    }
    .form-check-label {
        margin: 0;
        font-size: 0.9rem;
        color: var(--color-text-secondary);
        cursor: pointer;
    }
    .video-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .video-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .video-info p {
        margin: 0;
        color: var(--color-text-primary);
    }
    .video-info strong {
        color: var(--color-text-primary);
    }
    .video-copyright {
        margin-top: 1rem;
    }
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #e9ecef;
    }
    .form-actions-left,
    .form-actions-right {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .form-actions .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }
    .form-actions .btn .material-symbols-outlined {
        font-size: 18px;
    }
    @media (max-width: 768px) {
        .unit-detail-container {
            padding: 1rem 0.75rem;
        }
        .unit-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .unit-form-card {
            padding: 1.25rem;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions-left,
        .form-actions-right {
            width: 100%;
        }
        .form-actions .btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="unit-detail-container">
    <div class="unit-header">
        <h1>
            <span class="material-symbols-outlined">menu_book</span>
            <span>Unit Details</span>
        </h1>
        <a href="{{ route('units.index') }}" class="btn-back">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Go back</span>
        </a>
    </div>

    <form enctype="multipart/form-data" action="{{ route('units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="unit-form-card">
            <div class="form-section">
                <div class="form-section-title">
                    <span class="material-symbols-outlined">info</span>
                    <span>Basic Information</span>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" class="form-control" type="text" value="{{ $unit->title }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input id="author" name="author" class="form-control" type="text" value="{{ $unit->author }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="mce-editor">{!! $unit->description !!}</textarea>
                </div>
            </div>
        </div>

        <div class="unit-form-card">
            <div class="form-section">
                <div class="row mb-2">
                    <div class="d-flex align-items-center">
                        <h4>Help Options</h4>
                        <button class="btn btn-primary btn-sm ms-3" type="button" id="helpOptionsToggle" onclick="toggleHelpOptions()">
                            <span class="material-symbols-outlined" id="helpOptionsIcon">expand_more</span>
                        </button>
                    </div>
                </div>
                <div class="mt-2 mb-2" id="collapsableHelpOptions" style="display: none;">
                    <div class="card card-body mt-1">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Listening Tips</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->listening_tips_enabled) checked @endif name="listening_tips_enabled" value="true" id="listening_tips_enabled" disabled>
                                            <label class="form-check-label" for="listening_tips_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="listening_tips" name="listening_tips" class="mce-editor">{!! $unit->listening_tips !!}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Cultural Notes</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->cultural_notes_enabled) checked @endif name="cultural_notes_enabled" value="true" id="cultural_notes_enabled" disabled>
                                            <label class="form-check-label" for="cultural_notes_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="cultural_notes" name="cultural_notes" class="mce-editor">{!! $unit->cultural_notes !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Transcript</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->transcript_enabled) checked @endif name="transcript_enabled" value="true" id="transcript_enabled" disabled>
                                            <label class="form-check-label" for="transcript_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="transcript" name="transcript" class="mce-editor">{!! $unit->transcript !!}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Glossary</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->glossary_enabled) checked @endif name="glossary_enabled" value="true" id="glossary_enabled" disabled>
                                            <label class="form-check-label" for="glossary_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="glossary" name="glossary" class="mce-editor">{!! $unit->glossary !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Translation</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->translation_enabled) checked @endif name="translation_enabled" value="true" id="translation_enabled" disabled>
                                            <label class="form-check-label" for="translation_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="translation" name="translation" class="mce-editor">{!! $unit->translation !!}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="help-option-item">
                                    <div class="help-option-header">
                                        <h6>Dictionary</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" @if($unit->dictionary_enabled) checked @endif name="dictionary_enabled" value="true" id="dictionary_enabled" disabled>
                                            <label class="form-check-label" for="dictionary_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <textarea id="dictionary" name="dictionary" class="mce-editor">{!! $unit->dictionary !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="unit-form-card">
            <div class="form-section">
                <div class="form-section-title">
                    <span class="material-symbols-outlined">videocam</span>
                    <span>Video</span>
                </div>
                <div class="video-section">
                    <div class="video-info">
                        <p>
                            Current video file: 
                            <strong>
                                @if($unit->video_name != "")
                                    {{ $unit->video_name }}
                                @else
                                    No video file found for this unit.
                                @endif
                            </strong>
                        </p>
                        <button class="btn btn-primary btn-sm" type="button" onclick="document.getElementById('video-picker-container').hidden = false;" id="replace_video_button" disabled>
                            <span class="material-symbols-outlined">swap_horiz</span>
                            <span>Replace</span>
                        </button>
                    </div>
                    <div class="mb-3" id="video-picker-container" hidden>
                        <label for="video" class="form-label">Select new video file:</label>
                        <input class="form-control" type="file" name="video" id="video" accept="video/*" value="{{ asset('storage/files/'.$unit->video_name) }}">
                    </div>
                    <div class="video-copyright">
                        <input name="video_copyright" id="video_copyright" type="text" class="form-control" placeholder="Video copyright info" value="{{ $unit->video_copyright }}" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="unit-form-card">
            <div class="form-actions">
                <div class="form-actions-left">
                    <a class="btn btn-success" onClick="enableFields()">
                        <span class="material-symbols-outlined">edit</span>
                        <span>Edit</span>
                    </a>
                    <button class="btn btn-primary" type="submit">
                        <span class="material-symbols-outlined">save</span>
                        <span>Save</span>
                    </button>
                    <a class="btn btn-secondary" href="{{ route('units.index') }}">
                        <span class="material-symbols-outlined">close</span>
                        <span>Cancel</span>
                    </a>
                </div>
                <div class="form-actions-right">
                    <a class="btn btn-info" href="{{ route('sections.index', $unit->id) }}">
                        <span class="material-symbols-outlined">list</span>
                        <span>Sections</span>
                    </a>
                    <a class="btn btn-info" href="{{ route('glossed_words.index', $unit->id) }}">
                        <span class="material-symbols-outlined">translate</span>
                        <span>Glossed Words</span>
                    </a>
                    <a class="btn btn-info" href="{{ route('keywords.index', $unit->id) }}">
                        <span class="material-symbols-outlined">key</span>
                        <span>Keywords</span>
                    </a>
                    <a class="btn btn-info" href="{{ route('exercises.index', $unit->id) }}">
                        <span class="material-symbols-outlined">quiz</span>
                        <span>Exercises</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var textarea_elements = document.getElementsByClassName('mce-editor');
    $(document).ready(function() {
        $('.mce-editor').each(function(i) {
            tinymce.get(textarea_elements[i].id).mode.set("readonly");
        });
    });

    function toggleHelpOptions() {
        var collapseElement = document.getElementById('collapsableHelpOptions');
        var iconElement = document.getElementById('helpOptionsIcon');
        var toggleButton = document.getElementById('helpOptionsToggle');
        
        if (collapseElement && iconElement && toggleButton) {
            if (collapseElement.style.display === 'none') {
                collapseElement.style.display = 'block';
                iconElement.textContent = 'expand_less';
                toggleButton.setAttribute('aria-expanded', 'true');
            } else {
                collapseElement.style.display = 'none';
                iconElement.textContent = 'expand_more';
                toggleButton.setAttribute('aria-expanded', 'false');
            }
        }
    }

    function enableFields() {
        var input_elements = document.getElementsByTagName('input');
        for (i = 0; i < input_elements.length; i++) {
            input_elements[i].disabled = false;
        }

        var select_elements = document.getElementsByTagName('select');
        for (i = 0; i < select_elements.length; i++) {
            select_elements[i].disabled = false;
        }

        var textarea_elements = document.getElementsByClassName('mce-editor');
        for (i = 0; i < textarea_elements.length; i++) {
            tinymce.get(textarea_elements[i].id).mode.set("design");
        }
        
        var replaceButton = document.getElementById('replace_video_button');
        replaceButton.disabled = false;
    }
</script>

@endsection
