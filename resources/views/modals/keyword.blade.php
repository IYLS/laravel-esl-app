    <!-- Modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{ $description }}
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