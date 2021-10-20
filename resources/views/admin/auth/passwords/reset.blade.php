@extends('layouts.app')

@section('content')
    <div class="blankpage-form-field">
        @include('admin.partials.errors')
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <span class="page-logo-text mr-1">Resetear Password</span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form action="{{ route('admin.password.update') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input name="email" type="email" id="username" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="contraseña">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Confirmar Contraseña</label>
                    <input type="password" id="password" class="form-control" name="password_confirmation" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default float-right">Resetear Contraseña</button>
            </form>
        </div>
    </div>
    <video poster="/backend/img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
        <source src="/backend/media/video/cc.webm" type="video/webm">
        <source src="/backend/media/video/cc.mp4" type="video/mp4">
    </video>
@endsection
