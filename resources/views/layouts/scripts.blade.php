@if (session('success') || session('error'))
  @include('modals.exercises.message', [
      'message' => session('success') ?? session('error'),
      'type'    => session('success') ? 'success' : 'error'
  ])

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('alert-modal');
      if (!el) return;

      // Bootstrap 5: use the native API
      var modal = bootstrap.Modal.getOrCreateInstance(el); // no double init
      if (!el.classList.contains('show')) modal.show();

      setTimeout(function(){ modal.hide(); }, 1500);
    });
  </script>
@endif

<!-- Lottie -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

{{-- Bootstrap ya está cargado en head.blade.php - NO duplicar (causa que collapse/dropdown no se replieguen) --}}

{{-- Inicializar popovers de Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (popoverTriggerEl) {
            new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>