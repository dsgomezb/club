<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.partials.head')
        @yield('head')
        @stack('styles')
        <link rel="stylesheet" media="screen, print" href="/backend/css/page-login.css">
    </head>
    <body>
        @yield('content')
        
        @include('admin.partials.scripts')
    </body>
</html>
