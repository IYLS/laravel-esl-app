@extends('layouts.app')
@section('main')

@section('title', 'Student Module')

<div class="p-4 row w-100 h-100 col-12 student-module">
    <div class="col-12 mb-2">
        <h5 class="mb-2">{{ $unit->title }}</h5>
        <div class="row g-2">
            {{-- Individual progress --}}
            <div class="col-6"
                 data-bs-toggle="tooltip"
                 data-bs-placement="bottom"
                 title="Check your progress here">
                <div class="d-flex align-items-center mb-1">
                    <span class="me-1" style="font-size:.9rem;">🎯</span>
                    <small class="text-muted fw-semibold">My progress</small>
                    <small class="text-muted ms-auto" id="progress-text">{{ $completed_count ?? 0 }}/{{ $total_exercises ?? 0 }}</small>
                </div>
                <div class="progress" style="height: 6px; border-radius: 3px;">
                    <div
                        class="progress-bar"
                        id="unit-progress-bar"
                        role="progressbar"
                        style="width: {{ $unit_progress ?? 0 }}%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); transition: width 0.6s ease;"
                        aria-valuenow="{{ $unit_progress ?? 0 }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>
            </div>
            {{-- Group progress --}}
            @if($user->group_id)
            <div class="col-6"
                 data-bs-toggle="tooltip"
                 data-bs-placement="bottom"
                 title="Check the progress of your classmates here">
                <div class="d-flex align-items-center mb-1">
                    <span class="me-1" style="font-size:.9rem;">👥</span>
                    <small class="text-muted fw-semibold">Group</small>
                    <small class="text-muted ms-auto" id="group-progress-text">...</small>
                </div>
                <div class="progress" style="height: 6px; border-radius: 3px;">
                    <div
                        class="progress-bar"
                        id="group-progress-bar"
                        role="progressbar"
                        style="width: 0%; background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); transition: width 0.8s ease;"
                        aria-valuenow="0"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="row sticky-top p-1" id="sticky-bar" style="background-color: white;">
        <div class="col-12 col-lg-4 col-xl-4">
            @forelse($keywords as $keyword)
                @php $modal_id = "keyword_modal-$keyword->id"; @endphp
                <button type="button" id="{{ $modal_id . "_button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="unstick()">{{ $keyword->keyword }}</button>
                @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @empty
                <p class="text-center text-secondary"><small>No keywords added for this unit.</small></p>
            @endforelse
        </div>
        <div class="col-12 col-lg-8 col-xl-8">
            @include('exercises.help_options', ['unit' => $unit])
        </div>
    </div>

    {{-- Video section --}}
    <div class="col-12 col-xl-4">
        @if(isset($unit->video_name) and $unit->video_name != null and $unit->video_name != '')
            <div class="ratio ratio-16x9 mt-3">
                <video id="unit-video-{{ $unit->id }}" title="Video" allowfullscreen controls>
                    <source src="{{ asset('storage/files') . "/" . $unit->video_name }}">
                </video>
            </div>
            @if(isset($unit->video_copyright) and $unit->video_copyright != '') <p class="text-secondary"><small>{{ $unit->video_copyright }}</small></p> @endif
        @else
            <div class="text-center">
                <p class="text-secondary"><small>No video set for this unit.</small></p>
            </div>
        @endif
    </div>

    {{-- Exercises and content section --}}
    <div class="col-12 col-xl-8 bg-light mt-2 p-3 rounded shadow overflow-auto" id="top_student_area" style="max-height: calc(100vh - 120px);">
        @if(!isset($has_exercises) || !$has_exercises)
            {{-- Mensaje cuando no hay ejercicios --}}
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px;">
                <span class="material-symbols-outlined" style="font-size: 80px; color: #6c757d; margin-bottom: 20px;">assignment</span>
                <h4 class="text-secondary mb-3">No hay ejercicios disponibles</h4>
                <p class="text-muted text-center mb-4" style="max-width: 500px;">
                    Esta unidad aún no tiene ejercicios creados en sus secciones. Por favor, contacta a tu profesor para más información.
                </p>
                <a href="{{ route('student.level_selection') }}" class="btn btn-primary">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Volver a selección de unidades
                </a>
            </div>
        @else
        <ul class="nav nav-tabs" id="sectionsTabs" role="tablist">
            @foreach($unit->sections->sortBy('position') as $section)
                @php 
                    $index = $loop->index + 1;
                    $section_exercises = $section->exercises->sortBy('position');
                    if($section_exercises->count() > 0) {
                        $section_first_exercise_id = $section_exercises->first()->id;
                    } else {
                        $section_first_exercise_id = 0;
                    }
                @endphp
                @if($section_exercises->count() > 0)
                <li class="nav-item" role="presentation">
                    @if($index-1 == 0)
                        <button 
                            class="nav-link section-btn active" 
                            id="{{ $section->underscore_name }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $section->underscore_name}}" 
                            type="button" 
                            role="tab" 
                            aria-controls="{{ $section->underscore_name }}" 
                            aria-selected="true"
                            data-first-exercise-id="{{ $section_first_exercise_id }}"
                        >
                            {{ $index . ". " . $section->name }}
                        </button>
                    @else
                        <button 
                            class="nav-link section-btn" 
                            id="{{ $section->underscore_name }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $section->underscore_name}}" 
                            type="button" 
                            role="tab" 
                            aria-controls="{{ $section->underscore_name }}" 
                            aria-selected="false"
                            data-first-exercise-id="{{ $section_first_exercise_id }}"
                        >
                            {{ $index . ". " . $section->name }}
                        </button>
                    @endif
                </li>
                @endif
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($unit->sections->sortBy('position') as $section)
                @php
                    $section_exercises = $section->exercises->sortBy('position');
                @endphp
                @if($section_exercises->count() > 0)
                    @if($loop->index == 0)
                        <div class="tab-pane fade show section-pane active m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                    @else
                        <div class="tab-pane fade section-pane m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                    @endif
                    <div class="d-flex align-items-start row mt-2">

                    {{-- (Optional) Additional Information --}}
                    @if(isset($section->instructions) and $section->instructions != '')
                    <div class="card pt-1 mb-2 pb-1 d-flex justify-content-center">
                        <p class="text-primary"><span class="material-symbols-outlined text-primary">info</span>&nbsp;{{ $section->instructions }}</p>
                    </div>
                    @endif
                    <div class="nav flex-column mt-2 nav-pills col-12 col-xl-2" id="v-pills-tab-{{ $section->underscore_name }}" role="tablist" aria-orientation="vertical">
                        @forelse($section->exercises->sortBy('position') as $e)
                            @php $index = $loop->index; @endphp
                            <button 
                                class="nav-link exercise-btn @if($e->category == 'metacognition') meta @elseif($e->category == 'engagement') engagement @endif @if($index == 0) active @endif"
                                id="{{ $e->exerciseType->underscore_name . $e->id }}-tab" 
                                data-bs-toggle="pill" 
                                data-bs-target="#{{ $e->exerciseType->underscore_name . $e->id }}" 
                                type="button" 
                                role="tab" 
                                aria-controls="{{ $e->exerciseType->underscore_name . $e->id }}" 
                                @if($index == 0)
                                    aria-selected="true"
                                @else
                                    aria-selected="false"
                                @endif
                                data-exercise-id="{{ $e->id }}">
                                    @if($e->title == '' or $e->title == null) 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="text-end">Activity #{{ $e->id }}</p>
                                                </div>
                                                <div>
                                                    <p>✅</p>
                                                </div>
                                            </div>
                                        @else
                                            Activity #{{ $e->id }}
                                        @endif
                                    @else 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            {{ $e->title }} ✅
                                        @else
                                            {{ $e->title }}
                                        @endif
                                    @endif
                            </button>
                        @empty
                            <p class="text-center text-secondary"><small>No exercises added yet.</small></p>    
                        @endforelse
                    </div>
                    <div class="tab-content container-fluid col-12 col-xl-10" id="v-pills-tabContent-{{ $section->underscore_name }}">
                        @foreach($section->exercises->sortBy('position') as $e)
                            @php
                                $feedback_content = array(
                                    'ids' => [],
                                    'names' => [],
                                    'text_based' => [],
                                );

                                if($e->feedbacks != null)
                                {
                                    foreach($e->feedbacks as $feedback)
                                    {
                                        array_push($feedback_content['ids'], $feedback->feedbackType->id);
                                        array_push($feedback_content['names'], $feedback->feedbackType->name);
                                        array_push($feedback_content['text_based'], $feedback->feedbackType->text_based);
                                    }
                                }
                            @endphp

                            @switch($e->exerciseType->underscore_name)
                            @case('drag_and_drop')
                                @include('exercises.drag_and_drop.drag_and_drop')
                                @break
                            @case('open_ended')
                                <div class="tab-pane exercise-pane fade @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        @include('layouts.tracking.tracking_complete')
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="open_ended_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'open_ended')">
                                            @csrf
                                            @if($e->subtype == 1 or $e->subtype == 99)
                                                @include('exercises.open_ended.single_text')
                                            @elseif($e->subtype == 991)
                                                @include('exercises.open_ended.double_text')
                                            @endif
                                            <x-exercise-forum-link :exercise="$e" />
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('voice_recognition')
                                @include('exercises.voice_recognition.asd')
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        @include('layouts.tracking.tracking_complete')

                                        @if(isset($e->video_name) and $e->video_name != null and $e->video_name != '')
                                            <video id="exercise-video-{{ $e->id }}" title="Video" allowfullscreen controls class="ratio ratio-16x9 mt-3 w-75">
                                                <source src="{{ asset('storage/files') . "/" . $e->video_name }}">
                                            </video>
                                        @endif

                                        @if(isset($e->image_name) and $e->image_name != null and $e->image_name != '')
                                            <div class="row m-3">
                                                <img src="{{ asset('storage/files'. "/" . $e->image_name) }}" class="img-fluid col-12 col-lg-8" alt="img">
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="multiple_choice_form_{{ $e->id }}">
                                            @csrf
                                            {{-- Subtype 1 = Predicting --}}
                                            @if($e->subtype == 1)
                                                @include('exercises.multiple_choice.predicting')

                                            {{-- Subtype 2 = What do you hear? --}}
                                            @elseif($e->subtype == 2)
                                                @include('exercises.multiple_choice.what_do_you_hear')

                                            {{-- Subtype 3 = Evaluating statements --}}
                                            @elseif($e->subtype == 3)
                                                @include('exercises.multiple_choice.evaluating_statements')

                                            {{-- Subtype 4 = Multiple Choice --}}
                                            @elseif($e->subtype == 4 or $e->subtype == 99)
                                                @include('exercises.multiple_choice.multiple_choice')
                                            @endif

                                            <x-exercise-forum-link :exercise="$e" />
                                            <br>
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{--  Dictation Cloze  --}}
                                        @if($e->subtype == 1) 
                                            @include('exercises.fill_in_the_gaps.dictation_cloze')

                                        {{-- Vocabulary Practice --}}
                                        @elseif($e->subtype == 2)
                                            @include('exercises.fill_in_the_gaps.vocabulary_practice')
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('form')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{-- Form --}}
                                        @include('exercises.form.dashboard')
                                        
                                    </div>
                                </div>
                                @break
                            @case('poll')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{-- Poll Likert 1-7 --}}
                                        @include('exercises.poll.likert')
                                    </div>
                                </div>
                                @break
                                @default
                            @endswitch
                        @endforeach
                    </div> {{-- Cierra tab-content --}}
                    </div> {{-- Cierra d-flex align-items-start row mt-2 --}}
                    </div> {{-- Cierra section-pane --}}
                @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- JavaScript modularizado y organizado --}}
<script src="{{ asset('js/student-exercises.js') }}"></script>
<script src="{{ asset('js/modules/videoHandler.js') }}"></script>

<script>
    // Inicializar variables necesarias desde PHP
    @if(isset($has_exercises) && $has_exercises)
    window.current_exercise_id = {{ json_encode($first_exercise_id) }};
    
    // Inicializar timer al cargar la página
    if (typeof startTimer === 'function') {
        startTimer();
    }
    @endif
    
    // Carga el progreso grupal vía AJAX
    function loadGroupProgress() {
        var groupBar = document.getElementById('group-progress-bar');
        if (!groupBar) return;
        fetch('{{ route("student.group_progress", $unit->id) }}', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var bar = document.getElementById('group-progress-bar');
            var text = document.getElementById('group-progress-text');
            if (bar) {
                bar.style.width = data.progress + '%';
                bar.setAttribute('aria-valuenow', data.progress);
            }
            if (text) text.textContent = data.progress + '%';
        })
        .catch(function() {
            var text = document.getElementById('group-progress-text');
            if (text) text.textContent = '—';
        });
    }

    // Función para actualizar la barra de progreso individual y refrescar la grupal
    function updateUnitProgress(progress, completed, total) {
        const progressBar = document.getElementById('unit-progress-bar');
        const progressText = document.getElementById('progress-text');
        
        if (progressBar) {
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
        }
        
        if (progressText) {
            progressText.textContent = completed + '/' + total;
        }

        loadGroupProgress();
    }
    
    // Hacer la función disponible globalmente
    window.updateUnitProgress = updateUnitProgress;
    
    // Inicializar manejo de eventos de video
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof VideoHandler !== 'undefined') {
            VideoHandler.init();
        }
        
        // Inicializar botones reset (verificar límite de 3 resets)
        if (typeof initResetButton === 'function') {
            // Buscar todos los botones reset en la página
            const resetButtons = document.querySelectorAll('[id^="reset-button-"]');
            resetButtons.forEach(function(button) {
                const exerciseId = button.id.replace('reset-button-', '');
                initResetButton(exerciseId);
            });
        }
        
        // Inicializar manejo de tabs de Bootstrap para secciones
        const sectionTabs = document.querySelectorAll('#sectionsTabs button[data-bs-toggle="tab"]');
        
        sectionTabs.forEach(function(tab) {
            tab.addEventListener('show.bs.tab', function(event) {
                // Ocultar TODOS los panes de sección ANTES de mostrar el nuevo
                const allSectionPanes = document.querySelectorAll('.section-pane');
                allSectionPanes.forEach(function(pane) {
                    pane.classList.remove('show', 'active');
                });
                
                // Ocultar TODOS los panes de ejercicios de todas las secciones
                const allExercisePanes = document.querySelectorAll('.exercise-pane');
                allExercisePanes.forEach(function(pane) {
                    pane.classList.remove('show', 'active');
                });
                
                // Desactivar TODOS los botones de ejercicios
                const allExerciseButtons = document.querySelectorAll('.exercise-btn');
                allExerciseButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
            });
            
            tab.addEventListener('shown.bs.tab', function(event) {
                // DESPUÉS de que Bootstrap haya mostrado la sección, activar el primer ejercicio
                const targetId = event.target.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                const firstExerciseId = event.target.getAttribute('data-first-exercise-id');
                
                if (targetPane && firstExerciseId) {
                    // Buscar el botón del primer ejercicio usando el data-exercise-id
                    const firstExerciseButton = targetPane.querySelector(`[data-exercise-id="${firstExerciseId}"]`);
                    
                    if (firstExerciseButton) {
                        // Obtener el data-bs-target del botón para encontrar el pane correspondiente
                        const exerciseTargetId = firstExerciseButton.getAttribute('data-bs-target');
                        const firstExercisePane = exerciseTargetId ? document.querySelector(exerciseTargetId) : null;
                        
                        if (firstExercisePane) {
                            // Activar el primer ejercicio
                            firstExerciseButton.classList.add('active');
                            firstExerciseButton.setAttribute('aria-selected', 'true');
                            firstExercisePane.classList.add('show', 'active');
                            
                            // Ejecutar funciones necesarias
                            if (typeof setCurrentExercise === 'function') {
                                setCurrentExercise(parseInt(firstExerciseId));
                            }
                            if (typeof onExerciseClicked === 'function') {
                                onExerciseClicked(parseInt(firstExerciseId));
                            }
                            if (typeof startTimer === 'function') {
                                startTimer();
                            }
                        } else {
                            console.warn(`No se encontró el pane para el ejercicio ${firstExerciseId}`);
                        }
                    } else {
                        // Fallback: buscar el primer ejercicio disponible en la sección
                        const fallbackButton = targetPane.querySelector('.exercise-btn');
                        const fallbackPane = targetPane.querySelector('.exercise-pane');
                        
                        if (fallbackButton && fallbackPane) {
                            fallbackButton.classList.add('active');
                            fallbackButton.setAttribute('aria-selected', 'true');
                            fallbackPane.classList.add('show', 'active');
                            
                            const fallbackExerciseId = fallbackButton.getAttribute('data-exercise-id');
                            if (fallbackExerciseId) {
                                if (typeof setCurrentExercise === 'function') {
                                    setCurrentExercise(parseInt(fallbackExerciseId));
                                }
                                if (typeof onExerciseClicked === 'function') {
                                    onExerciseClicked(parseInt(fallbackExerciseId));
                                }
                                if (typeof startTimer === 'function') {
                                    startTimer();
                                }
                            }
                        }
                    }
                }
            });
        });
        
        // Inicializar manejo de tabs de Bootstrap para ejercicios (pills)
        const exerciseTabs = document.querySelectorAll('.exercise-btn[data-bs-toggle="pill"]');
        exerciseTabs.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function(event) {
                // DESPUÉS de que Bootstrap haya activado el ejercicio, ejecutar funciones necesarias
                const exerciseId = event.target.getAttribute('data-exercise-id');
                if (exerciseId) {
                    if (typeof setCurrentExercise === 'function') {
                        setCurrentExercise(parseInt(exerciseId));
                    }
                    if (typeof onExerciseClicked === 'function') {
                        onExerciseClicked(parseInt(exerciseId));
                    }
                    if (typeof startTimer === 'function') {
                        startTimer();
                    }
                }
            });
        });

        // Cargar progreso grupal al iniciar
        loadGroupProgress();

        // Inicializar tooltips de Bootstrap
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
            new bootstrap.Tooltip(el);
        });
    });
</script>

@endsection
