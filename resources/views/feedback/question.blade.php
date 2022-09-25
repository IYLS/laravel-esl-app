@isset($e->feedbacks)

    {{ $e }}

    <div class="m-1 p-1 border border-success feedback question-feedback" hidden>
        @foreach($e->feedbacks as $feedback)

            <p>{{ $feedback }}</p>

            <p class="text-secondary">💡</p>
            
            {{-- <div class="row">
                <audio controls class="col-12">
                    <source src="{{ asset('storage/files/'.$feedback->audio_name) }}" type="audio/mpeg">
                </audio>
            </div> --}}

        @endforeach
    </div>

@endisset