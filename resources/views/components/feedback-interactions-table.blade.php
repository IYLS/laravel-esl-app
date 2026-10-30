{{-- Componente reutilizable para mostrar tabla de feedback interactions --}}
{{-- Parámetros: feedbackUsage (collection) --}}
@if($feedbackUsage->count() > 0)
    <div style="margin-top: 1rem; margin-bottom: 1.5rem;">
        <div style="font-size: 0.9rem; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <span class="material-symbols-outlined" style="font-size: 18px;">feedback</span>
            <span>Feedback Interactions</span>
        </div>
        <table class="tracking-table">
            <thead>
                <tr>
                    <th>Feedback Type</th>
                    <th>Interactions Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbackUsage as $feedbackUsageItem)
                    <tr>
                        <td><strong>{{ $feedbackUsageItem->feedback_type }}</strong></td>
                        <td>{{ $feedbackUsageItem->open_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif