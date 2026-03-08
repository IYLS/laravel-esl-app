<!-- Modal -->
<div class="modal" id="{{ $modal_id }}" data-bs-backdrop="false" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
                <button type="button" id="sdf-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $description !!}
            </div>
        </div>
    </div>
</div>