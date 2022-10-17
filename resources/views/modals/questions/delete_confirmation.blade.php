<!-- Modal -->
<div class="modal fade" id="{{ $button_target_id }}" tabindex="-1" aria-labelledby="{{ $button_target_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="alertLabel">{{ $title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>{{ $body }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="{{ $route }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary">Confirm</button>
            </form>
        </div>
        </div>
    </div>
</div>