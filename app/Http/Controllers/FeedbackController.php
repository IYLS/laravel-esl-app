<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;
use App\Models\Feedback;
use App\Models\FeedbackType;
use App\Models\Question;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher');
    }

    public function create(Request $request, $exercise_id)
    {
        $feedback_types = FeedbackType::findMany($request->types);
        $exercise = Exercise::find($exercise_id);

        return view('feedback.create', compact('feedback_types', 'exercise'));
    }

    public function store(Request $request, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $data = $request->input('data', []);

        if (isset($data['question'])) {
            $this->storeQuestionFeedbackFromData($exercise, $data['question'], $request, 'data');
        }

        if (isset($data['exercise'])) {
            $this->storeExerciseFeedbackFromData($exercise, $data['exercise'], $request, 'data');
        }

        return redirect()->route('exercises.show', $exercise_id)->with('success', 'Feedback saved successfully.');
    }

    public function destroy($exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        foreach ($exercise->feedbacks as $fb) {
            $fb->delete();
        }

        return redirect()->route('exercises.show', $exercise_id)->with('success', 'Feedback settings deleted successfully.');
    }

    public function edit($exercise_id)
    {
        $exercise = Exercise::with(['questions.alternatives', 'feedbacks.feedbackType'])->findOrFail($exercise_id);

        $feedbackTypes = FeedbackType::orderBy('id')->get();

        $exerciseLevelTypeIds = $exercise->feedbacks->whereNull('question_id')->pluck('feedback_type_id')->unique()->filter();

        $missingExerciseTypes = $feedbackTypes->where('level', 'exercise')->filter(function ($t) use ($exerciseLevelTypeIds) {
            return !$exerciseLevelTypeIds->contains($t->id);
        })->values();

        $hasExerciseLevelTypeSeven = $exercise->feedbacks
            ->whereNull('question_id')
            ->where('feedback_type_id', 7)
            ->isNotEmpty();

        $showDictationKnowledgeImage = $exercise->exercise_type_id == 3
            && $exercise->subtype == 1
            && !$hasExerciseLevelTypeSeven;

        $missingQuestionTypesByQuestion = [];
        foreach ($exercise->questions->sortBy('position') as $question) {
            $missingQuestionTypesByQuestion[$question->id] = $feedbackTypes->where('level', 'question')->filter(function ($t) use ($exercise, $question) {
                if ((int) $t->id === 5) {
                    return $exercise->feedbacks->where('question_id', $question->id)->where('feedback_type_id', 5)->isEmpty();
                }

                return $exercise->feedbacks->where('question_id', $question->id)->where('feedback_type_id', $t->id)->isEmpty();
            })->values();
        }

        $hasAnyAppendOption = $missingExerciseTypes->isNotEmpty()
            || $showDictationKnowledgeImage
            || collect($missingQuestionTypesByQuestion)->contains(fn ($c) => $c->isNotEmpty());

        return view('feedback.edit', compact(
            'exercise',
            'feedbackTypes',
            'missingExerciseTypes',
            'missingQuestionTypesByQuestion',
            'showDictationKnowledgeImage',
            'hasAnyAppendOption'
        ));
    }

    public function update(Request $request, $exercise_id)
    {
        $exercise = Exercise::findOrFail($exercise_id);

        DB::transaction(function () use ($request, $exercise) {
            $feedbackById = $request->input('feedback', []);
            $files = $request->file('feedback', []);

            foreach ($feedbackById as $id => $feedbackUpdates) {
                $existing = Feedback::where('id', $id)->where('exercise_id', $exercise->id)->first();
                if (!$existing) {
                    continue;
                }

                if (isset($feedbackUpdates['message'])) {
                    $existing->message = $feedbackUpdates['message'];
                }

                if (isset($files[$id]['audio'])) {
                    $audioFile = $files[$id]['audio'];
                    $audioFileName = $audioFile->getClientOriginalName();
                    $audioFile->storeAs('files', $audioFileName, 'public');
                    $existing->audio_name = $audioFileName;
                }

                if (isset($files[$id]['image'])) {
                    $imageFile = $files[$id]['image'];
                    $imageFileName = $imageFile->getClientOriginalName();
                    $imageFile->storeAs('files', $imageFileName, 'public');
                    $existing->image_name = $imageFileName;
                }

                $existing->save();
            }

            $append = $request->input('append', []);

            if (!empty($append['question']) && is_array($append['question'])) {
                $this->storeQuestionFeedbackFromData($exercise, $append['question'], $request, 'append');
            }

            if (!empty($append['exercise']) && is_array($append['exercise'])) {
                $this->storeExerciseFeedbackFromData($exercise, $append['exercise'], $request, 'append');
            }
        });

        return redirect()->route('feedback.edit', $exercise_id)->with('success', 'Feedback updated successfully.');
    }

    /**
     * @param  array<string, mixed>  $questionData
     */
    private function storeQuestionFeedbackFromData(Exercise $exercise, array $questionData, Request $request, string $prefix): void
    {
        foreach ($questionData as $feedback_type_id => $questionsBlock) {
            if (!is_array($questionsBlock)) {
                continue;
            }
            foreach ($questionsBlock as $questionKey => $payload) {
                $question = Question::find($questionKey);
                if (!$question || (int) $question->exercise_id !== (int) $exercise->id) {
                    continue;
                }

                if (!is_array($payload)) {
                    continue;
                }

                foreach ($payload as $k => $item) {
                    switch ($k) {
                        case 'message':
                            if (trim((string) $item) === '') {
                                break;
                            }
                            $feedback = new Feedback;
                            $feedback->feedback_type_id = $feedback_type_id;
                            $feedback->message = $item;
                            $feedback->question_id = $question->id;
                            $feedback->exercise_id = $exercise->id;
                            $feedback->save();
                            break;

                        case 'audio':
                            $audioName = $this->resolveQuestionAudioUpload($request, $prefix, (int) $feedback_type_id, (int) $question->id);
                            if ($audioName === null) {
                                break;
                            }
                            $feedback = new Feedback;
                            $feedback->feedback_type_id = $feedback_type_id;
                            $feedback->audio_name = $audioName;
                            $feedback->question_id = $question->id;
                            $feedback->exercise_id = $exercise->id;
                            $feedback->save();
                            break;

                        default:
                            if (!is_array($item) || !isset($item['message'])) {
                                break;
                            }
                            if (trim((string) $item['message']) === '') {
                                break;
                            }
                            $feedback = new Feedback;
                            $feedback->feedback_type_id = $feedback_type_id;
                            $feedback->message = $item['message'];
                            $feedback->question_id = $question->id;
                            $feedback->exercise_id = $exercise->id;
                            if (is_numeric($k)) {
                                $feedback->alternative_id = (int) $k;
                            }
                            $feedback->save();
                            break;
                    }
                }
            }
        }
    }

    /**
     * @param  array<string, mixed>  $exerciseData
     */
    private function storeExerciseFeedbackFromData(Exercise $exercise, array $exerciseData, Request $request, string $prefix): void
    {
        foreach ($exerciseData as $feedback_type_id => $typePayload) {
            if (!is_array($typePayload)) {
                continue;
            }
            foreach ($typePayload as $key => $value) {
                if ($key === 'message') {
                    if (trim((string) $value) === '') {
                        break;
                    }
                    $feedback = new Feedback;
                    $feedback->feedback_type_id = $feedback_type_id;
                    $feedback->message = $value;
                    $feedback->exercise_id = $exercise->id;
                    $feedback->save();
                    break;
                }
                if ($key === 'image') {
                    $imageName = $this->resolveExerciseImageUpload($request, $prefix, (int) $feedback_type_id);
                    if ($imageName === null) {
                        break;
                    }
                    $feedback = new Feedback;
                    $feedback->feedback_type_id = $feedback_type_id;
                    $feedback->image_name = $imageName;
                    $feedback->exercise_id = $exercise->id;
                    $feedback->save();
                    break;
                }
            }
        }
    }

    private function resolveQuestionAudioUpload(Request $request, string $prefix, int $feedbackTypeId, int $questionId): ?string
    {
        $file = $request->file("{$prefix}.question.{$feedbackTypeId}.{$questionId}.audio");
        if (!$file || !$file->isValid()) {
            return null;
        }
        $audioFileName = $file->getClientOriginalName();
        $file->storeAs('files', $audioFileName, 'public');

        return $audioFileName;
    }

    private function resolveExerciseImageUpload(Request $request, string $prefix, int $feedbackTypeId): ?string
    {
        $imageFile = $request->file("{$prefix}.exercise.{$feedbackTypeId}.image");
        if (!$imageFile || !$imageFile->isValid()) {
            return null;
        }
        $imageFileName = $imageFile->getClientOriginalName();
        $imageFile->storeAs('files', $imageFileName, 'public');

        return $imageFileName;
    }
}
