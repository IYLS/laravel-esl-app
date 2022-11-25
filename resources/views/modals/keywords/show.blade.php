<!-- Modal -->
<div class="modal" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="modal" 
                    aria-label="Close"

                    @if(isset($type))
                        onclick="onHelpOptionDismissed({{ json_encode($type) }});"
                    @else
                        onclick="onHelpOptionDismissed('');"
                    @endif
                    >
                </button>
            </div>
            <div class="modal-body">
                @if($modal_id == "transcriptModal")
                    @php $final_description = $description; @endphp

                    @foreach($unit->glossedWords as $word)
                        @php
                        $modal_id = "show_" . $word->id . "_glossed_word";
                        $button_string = "<a href='#' role='button' data-bs-toggle='popover' data-bs-content='$loop->index'>$word->word</a>";
                        $final_description = str_replace($word->word, $button_string, $final_description); 
                        @endphp 
                    @endforeach

                    @foreach($unit->glossedWords as $word)
                        @php
                            $final_description = str_replace("data-bs-content='$loop->index'", "data-bs-content='$word->description'", $final_description)
                        @endphp
                    @endforeach
                    
                    {!! $final_description !!}

                @else
                    {!! $description !!}
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".modal").each(function(i) {
            $(this).draggable({
                handle: ".modal-header"  
            });
        });
    });
</script>