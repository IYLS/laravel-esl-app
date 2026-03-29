{{-- Campos: enlace al foro al crear ejercicio ($suffix = sufijo único para ids) --}}
@php $s = $suffix ?? 'default'; @endphp
<input type="hidden" name="show_forum_link" value="0">
<div class="form-check mt-2">
    <input type="checkbox" class="form-check-input" name="show_forum_link" id="show_forum_link_{{ $s }}" value="1">
    <label class="form-check-label" for="show_forum_link_{{ $s }}">Show forum link for students</label>
</div>
<label class="form-label mt-2 mb-0" for="forum_button_label_{{ $s }}">Forum button text (optional)</label>
<input type="text" class="form-control" name="forum_button_label" id="forum_button_label_{{ $s }}" maxlength="255" placeholder="Leave empty for &quot;Go to Forum&quot;">
