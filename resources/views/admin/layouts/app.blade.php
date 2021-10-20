<!DOCTYPE html>
<html lang="{{ config('app.lang') }}">
<head>
    @include('admin.partials.head')
    @yield('head')
    @stack('styles')
</head>
<body class="mod-bg-1 ">
    <script src="/backend/js/settings.js"></script>
    <div class="page-wrapper">
        <div class="page-inner">
            @include('admin.partials.nav')
            <div class="page-content-wrapper">
                @include('admin.partials.header')

                @include('admin.partials.main')

                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>

                @include('admin.partials.footer')
            </div>
        </div>
    </div>

    @stack('components')

    @include('admin.partials.scripts')
    
    @yield('scripts')
    
    @stack('scripts')
</body>
</html>
