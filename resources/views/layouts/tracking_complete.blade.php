@if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises))
    <div class="m-2 mt-4 row bg-light border rounded">
        <p class="text-success text-center mt-2">You have already completed this activity ✅</p>
    </div>
@endif