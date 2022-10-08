<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'title' => 'required|string',
            // 'author' => 'required|string',
            // 'description' => 'nullable|string',
            // 'listening_tips' => 'nullable|string',
            // 'cultural_notes' => 'nullable|string',
            // 'transcript' => 'nullable|string',
            // 'glossary' => 'nullable|string',
            // 'translation' => 'nullable|string',
            // 'dictionary' => 'nullable|string',
            // 'listening_tips_enabled' => 'nullable|boolean',
            // 'cultural_notes_enabled' => 'nullable|boolean',
            // 'transcript_enabled' => 'nullable|boolean',
            // 'glossary_enabled' => 'nullable|boolean',
            // 'translation_enabled' => 'nullable|boolean',
            // 'dictionary_enabled' => 'nullable|boolean',
            // 'video' => 'required|file|mimetypes:video',
        ];
    }
}
