<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        @if (isset($model))
            <li class="breadcrumb-item"><a href="/admin/{{ $model->getTable() }}">@yield('section')</a></li>
        @else
            <li class="breadcrumb-item">@yield('section')</li>
        @endif

        @if (isset($viewConfig['accion']))
            <li class="breadcrumb-item active">{{ $viewConfig['accion'] }}</li>
        @else
            <li class="breadcrumb-item active">@yield('action')</li>
        @endif
        
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-@yield('icon')'></i> @yield('section')
        </h1>
        <div class="subheader-block">
            @yield('header-buttons')
        </div>
    </div>
    
    @include('admin.partials.errors')

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2> @yield('section') </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @yield('widget-body')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('extra-content')
</main>