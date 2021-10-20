<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    @include('front.partials.head')
    @yield('head')
    @stack('styles')
</head>
<body>
    @include('front.partials.navbar')

        @yield('content')

        @include('front.partials.footer')

    {{-- </div> --}}

    @include('front.partials.scripts')

    @yield('scripts')
    
    @stack('scripts')
</body>
</html>
