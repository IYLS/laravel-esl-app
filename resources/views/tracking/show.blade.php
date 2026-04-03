@extends('layouts.app')
@section('main')

<style>
    .tracking-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .tracking-header {
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
    .tracking-header h4 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-text-primary);
    }
    .tracking-header .btn-back {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .tracking-header .btn-back:hover {
        color: var(--color-hover-primary);
        transform: translateX(-2px);
    }
    .tracking-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .tracking-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .tracking-section-title .material-symbols-outlined {
        font-size: 20px;
        color: var(--color-primary);
    }
    .tracking-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    .tracking-info-item {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .tracking-info-label {
        font-size: 0.85rem;
        color: var(--color-text-secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tracking-info-value {
        font-size: 1rem;
        color: var(--color-text-primary);
        font-weight: 600;
    }
    .tracking-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .tracking-table thead th {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--color-text-primary);
        font-size: 0.9rem;
        border-bottom: 2px solid #e9ecef;
    }
    .tracking-table tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
        color: var(--color-text-primary);
    }
    .tracking-table tbody tr:last-child td {
        border-bottom: none;
    }
    .tracking-table tbody tr:hover {
        background: #f8f9fa;
    }
    .section-divider {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        margin: 1.5rem 0 1rem 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-divider .material-symbols-outlined {
        font-size: 18px;
    }
    .question-header {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 600;
        text-align: center;
        border-radius: 8px;
        margin: 1.5rem 0 1rem 0;
    }
    .response-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .response-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .response-list li:last-child {
        border-bottom: none;
    }
    @media (max-width: 768px) {
        .tracking-detail-container {
            padding: 1rem 0.5rem;
        }
        .tracking-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .tracking-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="tracking-detail-container">
    <div class="tracking-header">
        <h4>
            @if(isset($tracking->exercise->exerciseType->name))
                {{ $tracking->exercise->exerciseType->name }} Exercise Tracking
            @else
                Tracking Information
            @endif
        </h4>
        @php
            $backUrl = route('tracking.index');
            $queryParams = [];
            if (isset($group_id) && $group_id && $group_id != 'any') {
                $queryParams['group'] = $group_id;
            }
            if (isset($user_id) && $user_id && $user_id != 'any') {
                $queryParams['student'] = $user_id;
            }
            if (!empty($queryParams)) {
                $backUrl .= '?' . http_build_query($queryParams);
            }
        @endphp
        <a href="{{ $backUrl }}" class="btn-back">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Go back</span>
        </a>
    </div>
    
    <div class="tracking-section">
        <div class="tracking-section-title">
            <span class="material-symbols-outlined">person</span>
            <span>Student Information</span>
        </div>
        <div class="tracking-info-grid">
            <div class="tracking-info-item">
                <div class="tracking-info-label">Student ID</div>
                <div class="tracking-info-value">{{ $tracking->user->user_id }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Group</div>
                <div class="tracking-info-value">{{ $tracking->user->group->name }}</div>
            </div>
        </div>
    </div>

    <div class="tracking-section">
        <div class="tracking-section-title">
            <span class="material-symbols-outlined">assignment</span>
            <span>Activity Information</span>
        </div>
        <div class="tracking-info-grid">
            <div class="tracking-info-item">
                <div class="tracking-info-label">Activity Title</div>
                <div class="tracking-info-value">{{ $tracking->exercise->title }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Unit</div>
                <div class="tracking-info-value">{{ $tracking->exercise->section->unit->title }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Section</div>
                <div class="tracking-info-value">{{ $tracking->exercise->section->name }}</div>
            </div>
        </div>
    </div>

    <div class="tracking-section">
        <div class="tracking-section-title">
            <span class="material-symbols-outlined">analytics</span>
            <span>Response Information</span>
        </div>
        <div class="tracking-info-grid">
            <div class="tracking-info-item">
                <div class="tracking-info-label">Time Spent</div>
                <div class="tracking-info-value">{{ $tracking->formatted_time }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Correct Answers</div>
                <div class="tracking-info-value" style="color: #198754;">{{ $tracking->correct_answers }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Wrong Answers</div>
                <div class="tracking-info-value" style="color: #dc3545;">{{ $tracking->wrong_answers }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Number of Tries</div>
                <div class="tracking-info-value">{{ $tracking->intent_number }}</div>
            </div>
            <div class="tracking-info-item">
                <div class="tracking-info-label">Date</div>
                <div class="tracking-info-value">{{ date('d/m/Y - h:i:s', strtotime($tracking->created_at)); }}</div>
            </div>
        </div>
    </div>

    @if($tracking->helpUsage->count() > 0)
    <div class="tracking-section">
        <div class="tracking-section-title">
            <span class="material-symbols-outlined">help</span>
            <span>Help Options Interactions</span>
        </div>
        <table class="tracking-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Interactions Count</th>
                    <th>Time Spent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tracking->helpUsage as $helpUsage)
                    <tr>
                        <td><strong>{{ $helpUsage->help_type }}</strong></td>
                        <td>{{ $helpUsage->open_count }}</td>
                        <td>{{ $helpUsage->formatted_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="tracking-section">
        <div class="tracking-section-title">
            <span class="material-symbols-outlined">quiz</span>
            <span>Question Responses</span>
        </div>
        @php
            $type = $tracking->exercise->exerciseType->underscore_name;
            $feedbackByQuestion = $tracking->feedbackUsage->whereNotNull('question_id');
            $feedbackLegacyAggregate = $tracking->feedbackUsage->whereNull('question_id');
            $usePerQuestionFeedback = $feedbackByQuestion->isNotEmpty();
        @endphp

        @if(!$usePerQuestionFeedback && $feedbackLegacyAggregate->isNotEmpty())
            @include('components.feedback-interactions-table', ['feedbackUsage' => $feedbackLegacyAggregate])
        @endif

        @if($type == 'form')
            @foreach($tracking->exercise->questions->sortBy('position') as $question)
                @php $q_n = $loop->index + 1; @endphp
                <div class="question-header">Question {{ $q_n }}</div>
                <div class="tracking-info-item" style="margin-bottom: 1.5rem;">
                    <div class="tracking-info-label">Response</div>
                    <ul class="response-list">
                        @foreach($tracking->userResponses->where('question_id', $question->id) as $response)
                            <li>{{ $response->response }}</li>
                        @endforeach
                    </ul>
                </div>
                @if($usePerQuestionFeedback)
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $feedbackByQuestion->where('question_id', $question->id)])
                @endif
            @endforeach
        @elseif($type == 'multiple_choice')
            @forelse($tracking->userResponses as $response)
                @php $q_n = $loop->index + 1; @endphp
                <div class="tracking-info-item" style="margin-bottom: 1.5rem;">
                    <div class="tracking-info-label">
                        @if($response->question && $response->question->statement)
                            {{ $q_n }}. {!! $response->question->statement !!}
                        @else
                            Question {{ $q_n }}
                        @endif
                    </div>
                    <div class="tracking-info-value">{{ $response->response }}</div>
                </div>
                @if($usePerQuestionFeedback)
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $feedbackByQuestion->where('question_id', $response->question_id)])
                @endif
            @empty
                <p class="text-secondary text-center"><small>No responses available</small></p>
            @endforelse
        @elseif($type == 'drag_and_drop')
            @forelse($tracking->userResponses as $response)
                @php $q_n = $loop->index + 1; @endphp
                <div class="question-header">Question {{ $q_n }}</div>
                <div class="tracking-info-item" style="margin-bottom: 1.5rem;">
                    <div class="tracking-info-label">Response</div>
                    <div class="tracking-info-value">{{ $response->response }}</div>
                </div>
                @if($usePerQuestionFeedback)
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $feedbackByQuestion->where('question_id', $response->question_id)])
                @endif
            @empty
                <p class="text-secondary text-center"><small>No responses available</small></p>
            @endforelse
        @else
            @forelse($tracking->userResponses as $response)
                @php $q_n = $loop->index + 1; @endphp
                <div class="question-header">Question {{ $q_n }}</div>
                <div class="tracking-info-item" style="margin-bottom: 1.5rem;">
                    <div class="tracking-info-label">Response</div>
                    <div class="tracking-info-value">{{ $response->response }}</div>
                </div>
                @if($usePerQuestionFeedback)
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $feedbackByQuestion->where('question_id', $response->question_id)])
                @endif
            @empty
                <p class="text-secondary text-center"><small>No responses available</small></p>
            @endforelse
        @endif
    </div>
</div>

@endsection