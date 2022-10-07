<!-- Modal -->
<div class="modal fade" id="alert-modal" tabindex="-1" aria-labelledby="alert-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Message</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @if($type == 'success')
            <div class="d-flex justify-content-center p-2">
              <p class="text-center text-success">✅ {{ $message }}</p>
            </div>
          @elseif($type == 'error')
            <div class="d-flex justify-content-center p-2">
              <p class="text-center text-danger">❗ {{ $message }}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
</div>