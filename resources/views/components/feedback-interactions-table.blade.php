{{-- Componente reutilizable para mostrar tabla de feedback interactions --}}
{{-- Parámetros: feedbackUsage (collection) --}}
@if($feedbackUsage->count() > 0)
    <tr>
        <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
    </tr>
    <th>Name</th>
    <th colspan=2>Interactions count</th>
    @foreach($feedbackUsage as $feedbackUsageItem)
        <tr>
            <td>{{ $feedbackUsageItem->feedback_type }}</td>
            <td colspan=2>{{ $feedbackUsageItem->open_count }}</td>
        </tr>
    @endforeach
@endif