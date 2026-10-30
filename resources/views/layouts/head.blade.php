{{-- Title --}}
<title>@yield('title', 'Ideas for Listening')</title>

{{-- Favicon --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}">

{{-- Critical metas first --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="ESL">
<meta name="keywords" content="english,second,language,teacher,student,learning,listening">
<meta name="author" content="Benjamin Caceres">

{{-- Preconnect para CDNs (reduce latencia) --}}
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- Preload de recursos críticos --}}
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" as="style" crossorigin>
<link rel="preload" href="{{ asset('/css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" as="style">

{{-- Styles (Bootstrap bloqueante para evitar FOUC; app.css crítico) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous">

{{-- Fuentes: display=swap evita texto invisible; cargamos async para no bloquear --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"></noscript>

{{-- Material Symbols (Google) --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"></noscript>

{{-- jQuery UI CSS: no bloqueante (solo para modales draggable) --}}
<link rel="stylesheet" href="{{ asset('jquery/jquery-ui.min.css') }}" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="{{ asset('jquery/jquery-ui.min.css') }}"></noscript>

<link rel="stylesheet" href="{{ asset('/css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
@yield('style')

{{-- Bootstrap 5 JS (modals, dropdowns; defer para no bloquear render) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous" defer></script>
{{-- jQuery y jQuery UI se cargan al final del body para no bloquear el render inicial --}}

{{-- TinyMCE --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" defer></script>
<script defer>
  document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('textarea.mce-editor');
    if (!el) return;

    tinymce.init({
      selector: 'textarea.mce-editor:not(.mce-editor-lazy)',
      statusbar: false,
      license_key: 'gpl',
      plugins: 'advlist lists link',
      toolbar: 'undo redo | bold italic underline | link | checklist numlist bullist',
      menubar: false,
      height: 200,
      relative_urls: false,
    });
  });
</script>
