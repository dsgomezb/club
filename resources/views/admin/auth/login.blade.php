@extends('admin.layouts.auth')

@section('content')
    <div class="blankpage-form-field">
        @include('admin.partials.errors')
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <span class="page-logo-text mr-1">Login</span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input name="email" type="email" id="username" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Contraseña">
                </div>
                <div class="form-group text-left">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="rememberme"> Recordarme</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-default float-right">Login</button>
            </form>
        </div>
        <div class="blankpage-footer text-center">
            <a href="{{ route('admin.password.update') }}"><strong>Recuperar Contraseña</strong></a>
        </div>
    </div>
    <video poster="/backend/img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
        <source src="/backend/media/video/cc.webm" type="video/webm">
        <source src="/backend/media/video/cc.mp4" type="video/mp4">
    </video>
@endsection