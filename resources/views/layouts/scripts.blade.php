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

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

{{-- Inicializar popovers de Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });

    {{-- Funciones de ejercicios usando módulos organizados --}}
    {{-- Nota: Los módulos JS deben cargarse antes en student/show.blade.php --}}
    {{-- Por ahora mantenemos compatibilidad con código existente --}}
</script>

{{-- Inicializar popovers de Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>