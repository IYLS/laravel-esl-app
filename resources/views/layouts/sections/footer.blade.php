@auth
@if(Auth::user())

<div class="mt-auto text-white-50 bg-dark p-3">
    <div class="">
        <footer class="d-flex justify-content-center">
            <p class="mb-0 text-center">
                &#169; 2025 www.ideasforlistening.com
                <span class="mx-1">·</span>
                Developed by <a href="https://maberc.com" class="text-white-50 text-decoration-none" target="_blank" rel="noopener noreferrer">Maberc</a>
            </p>
        </footer>
    </div>    
</div>

@endif
@endauth