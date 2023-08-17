@if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises))
    <p class="text-success text-end mt-1"><small>You have already completed this activity ✅</small></p>
@endif