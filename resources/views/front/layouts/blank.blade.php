<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    @include('front.partials.head')
    @yield('head')
</head>
<body>
    @yield('content')

    @include('front.partials.scripts')

    @yield('scripts')
</body>
</html>
