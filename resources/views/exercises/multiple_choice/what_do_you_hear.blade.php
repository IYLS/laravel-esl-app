{{-- WHAT DO YOU HEAR? --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        @php 
        $statement = str_replace(";;","_______", $question->statement)
        @endphp
        <p>{!! $loop->index + 1 . ". " . $statement !!}</p>
        <br>
        <audio controls class="col-6">
            <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio>
        <div class="mt-2">
            <ol type="a">

                @php $gaps_number = substr_count($statement, "_______"); @endphp

                @if($gaps_number == 1)
                    @foreach($question->alternatives as $a)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                                <label class="form-check-label" for="{{ $a->id }}">{{ $a->title }}</label>
                            </div>
                        </li>
                    @endforeach

                @elseif($gaps_number == 2)

                    @php $alts = array(); @endphp
                    @foreach($question->alternatives as $a)
                        @php
                            $words = explode("/", $a->title);
                            array_push($alts, $words);
                        @endphp

                        @if(count($alts) == 2 and count($alts[0]) == 2 and count($alts[1]) == 2)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][0] }};{{ $alts[1][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][0] }}/{{ $alts[1][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][0] }};{{ $alts[1][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][0] }}/{{ $alts[1][1] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][1] }}</label>
                                </div>
                            </li>
                        @endif
                    @endforeach


                @elseif($gaps_number == 4)

                    @php $alts = array(); @endphp
                    @foreach($question->alternatives as $a)
                        @php
                            $words = explode("/", $a->title);
                            array_push($alts, $words);
                        @endphp

                        @if(count($alts) == 2 and count($alts[0]) == 2 and count($alts[1]) == 2 and count($alts[2]) == 2)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][0] }};{{ $alts[1][0] }};{{ $alts[2][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][0] }}/{{ $alts[1][0] }}/{{ $alts[2][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][0] }};{{ $alts[1][0] }};{{ $alts[2][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][0] }}/{{ $alts[1][0] }}/{{ $alts[2][1] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][0] }};{{ $alts[1][1] }};{{ $alts[2][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][0] }}/{{ $alts[1][1] }}/{{ $alts[2][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][1] }};{{ $alts[2][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][1] }}/{{ $alts[2][1] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][0] }};{{ $alts[2][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][0] }}/{{ $alts[2][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][0] }};{{ $alts[2][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][0] }}/{{ $alts[2][1] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][1] }};{{ $alts[2][0] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][1] }}/{{ $alts[2][0] }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $alts[0][1] }};{{ $alts[1][1] }};{{ $alts[2][1] }}">
                                    <label class="form-check-label" for="{{ $a->id }}">{{ $alts[0][1] }}/{{ $alts[1][1] }}/{{ $alts[2][1] }}</label>
                                </div>
                            </li>
                        @endif
                    @endforeach              
    
                @endif
            </ol>
        </div>

        <br>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>

@endforeach