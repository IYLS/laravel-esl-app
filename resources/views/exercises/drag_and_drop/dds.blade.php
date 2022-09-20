<div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @php
        $words = array();
        $definitions = array();
        @endphp
        @foreach($e->questions as $question)
            @php 
            array_push($words, $question->statement);
            array_push($definitions, $question->answer);
            @endphp
        @endforeach
        @php
            shuffle($words);
            shuffle($definitions);
        @endphp
        <div class="row mt-2 mb-2">
            <div class="col-3">
                <h5>Words</h5>
                <br>
                <div class="mt-1 mb-1">
                    @foreach($words as $word)
                    <div class="m-1" style="width: 200px; height: 35px;">  
                        <div style="display: inline-block; border-style: dashed !important; mb-2" draggable="true" id="div2-{{ $word }}" ondragstart="drag(event)" class="border ps-2 pe-2 mt-2">{{ $loop->index + 1 . ". " .$word }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-9">
                <h5>Definitions</h5>
                <br>
                @foreach($definitions as $definition)
                    <div class="row mt-1 mb-1 align-middle">
                        <div class="border col-3 mt-1 mb-1 align-middle" id="div1-{{ $definition }}" style="width: 200; height: 35px;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="col-9 align-middle mt-2 mb-1" style="height: 35px;">{{ $definition }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>