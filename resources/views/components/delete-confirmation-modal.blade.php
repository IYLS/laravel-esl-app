{{-- Componente reutilizable para modal de confirmación de eliminación elegante --}}
{{-- Parámetros: modalId, title, itemName, route, deleteButtonText (opcional) --}}
@php
    $deleteButtonText = $deleteButtonText ?? 'Delete';
@endphp

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="mb-3">
                    <span class="material-symbols-outlined text-danger" style="font-size: 64px;">warning</span>
                </div>
                <h5 class="modal-title mb-3" id="{{ $modalId }}Label">{{ $title }}</h5>
                <p class="text-muted mb-4">Are you sure you want to delete <strong>{{ $itemName }}</strong>? This action cannot be undone.</p>
                <form action="{{ $route }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">delete</span>
                            {{ $deleteButtonText }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
