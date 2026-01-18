{{-- Componente reutilizable para encabezado de páginas --}}
{{-- Parámetros: title, backRoute, backRouteParams (opcional) --}}
<div class="d-flex justify-content-between mt-2 p-2">
    <h2>{{ $title }}</h2>
    <a href="{{ $backRoute }}" class="btn btn-link">Go back</a>
</div>