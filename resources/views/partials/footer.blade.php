@auth
@if(Auth::user())

<div class="mt-auto text-white-50 bg-dark p-3">
    <div class="">
        <footer class="d-flex justify-content-center">
            <p>Website developed for <a href="#" class="text-light">ESL</a>, by <a href="https://github.com/bigmouthstrks" class="text-light">@bigmouthstrks</a>.</p>
        </footer>
    </div>    
</div>

@endif
@endauth