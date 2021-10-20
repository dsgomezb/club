@extends('admin.layouts.auth')

@section('content')
    <div class="blankpage-form-field">
        @include('admin.partials.errors')
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <span class="page-logo-text mr-1">Envío de link para recuperar contraseña</span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form action="{{ route('admin.password.email') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input name="email" type="email" id="username" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus>
                </div>
                <button type="submit" class="btn btn-default float-right">Enviar link</button>
            </form>
        </div>
        <div class="blankpage-footer text-center">
            <a href="{{ route('admin.login') }}"><strong>Volver al login</strong></a>
        </div>
    </div>
    <video poster="/backend/img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
        <source src="/backend/media/video/cc.webm" type="video/webm">
        <source src="/backend/media/video/cc.mp4" type="video/mp4">
    </video>
@endsection
