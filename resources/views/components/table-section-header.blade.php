{{-- Componente reutilizable para encabezados de secciones en tablas --}}
{{-- Parámetros: title, colspan (default: 3) --}}
@php
    $colspan = $colspan ?? 3;
@endphp

<tr>
    <td colspan="{{ $colspan }}"><small class="text-secondary">{{ $title }}:</small></td>
</tr>