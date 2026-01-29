@auth
@if(Auth::user())

<div class="mt-auto text-white bg-dark p-3">
    <div class="">
        <footer class="d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex align-items-center mb-2" style="opacity: 0.9;">
                <img src="{{ asset('logo.png') }}" alt="Ideas for Listening Logo" style="max-width: 28px; height: auto; margin-right: 0.75rem;">
                <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.9); font-weight: 500; letter-spacing: 0.3px;">Ideas for Listening</span>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center" style="gap: 1rem;">
                <span style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.8);">Fondecyt regular 1251060</span>
                <span style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.8);">&#169; <script>document.write(/\d{4}/.exec(Date())[0])</script> www.ideasforlistening.com</span>
            </div>
        </footer>
    </div>    
</div>

@endif
@endauth