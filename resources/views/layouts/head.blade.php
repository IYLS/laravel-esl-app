{{-- Title --}}
<title>@yield('title', 'Ideas for Listening')</title>

{{-- Critical metas first --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="ESL">
<meta name="keywords" content="english,second,language,teacher,student,learning,listening">
<meta name="author" content="Benjamin Caceres">

{{-- Styles --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- Material Symbols (Google) --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

{{-- jQuery UI CSS (only if you actually use draggable/sortable/etc.) --}}
<link rel="stylesheet" href="{{ asset('jquery/jquery-ui.min.css') }}">

<link rel="stylesheet" href="{{ asset('/css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
@yield('style')

{{-- Scripts --}}
{{-- jQuery (only needed if you use jQuery or jQuery UI) --}}
<script src="{{ asset('jquery/jquery-3.3.1.min.js') }}"></script>

{{-- jQuery UI (needs jQuery; remove integrity/crossorigin for local files) --}}
<script src="{{ asset('jquery/jquery-ui.min.js') }}"></script>

{{-- Bootstrap 5 JS (for modals, dropdowns, etc.; independent of jQuery) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous" defer></script>

{{-- TinyMCE --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" defer></script>
<script defer>
  document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('textarea.mce-editor');
    if (!el) return;

    tinymce.init({
      selector: 'textarea.mce-editor',
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
