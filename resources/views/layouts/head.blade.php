@yield('style')
<meta charset="UTF-8">
<meta name="description" content="ESL">
<meta name="keywords" content="english,second,language,teacher,student,learning,listening">
<meta name="author" content="Benjamin Caceres">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootrstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;600&display=swap" rel="stylesheet"> 

<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">

<link rel="stylesheet" href="{{ asset('all.css') }}" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<script src="{{ asset('jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('jquery/jquery-ui.min.js') }}" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>

{{-- TinyMCE Rich Text Editor --}}
<script src="https://cdn.tiny.cloud/1/22wxdv2g7v8j7kmvusmhk2uclbvw4einqvtkoaujelsv2o6x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea.mce-editor',
        plugins: 'advlist lists link',
        statusbar: false,
        toolbar: 'undo redo | bold italic underline | link | checklist numlist bullist',
        mode: "specific_textareas",
        editor_selector: "mce-editor",
        menubar: false,
        height: 200,
        advlist_number_styles: "default,lower-alpha,upper-roman"
    });
</script>

@php 
if (isset(app()->view->getSections()['title'])) {
    $title = app()->view->getSections()['title'];
} else {
    $title = 'Ideas for Listening';
}
@endphp

<title>{{ $title }}</title>