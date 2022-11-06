<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.head')
    </head>
    <body class="d-flex flex-column min-vh-100">
        @include('layouts.sections.navbar')
        @yield('main')
        @include('layouts.sections.footer')
        @include('layouts.scripts')
        @yield('scripts')
    </body>
</html>