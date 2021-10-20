@extends("front.layouts.blank")

@section("content")
    
    <div class="client-login-form d-flex" style="height: 100vh">
        <div class="bg-image h-100 d-none d-sm-inline-block" style="background-image: url(/img/backgrounds/bg-login.jpg)"></div>
        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
            <img style="max-width: 60%" src="/img/logo/logo.png" alt="">

            <form action="{{ route('perfil.login') }}" method="post" class="form mt-4" style="width: 80%;">
                @include('front.partials.errors')

                @csrf
                <div class="form-group mt-3">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="email" type="text" id="large-square-input" placeholder="Nombre de usuario" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="password" type="password" id="large-square-input" placeholder="Contraseña" value="">
                </div>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="ex-check-2">
                    <label class="custom-control-label" for="ex-check-2" {{ old('remember') ? 'checked' : '' }}>Recordarme</label>
                </div>

                <div class="form-group">
                    <button class="btn btn-white btn-square w-100 " type="submit">Acceder</button>
                </div>
            </form>

            <div class="row w-100 pl-3 pr-3 w-100 justify-content-center">
                <div class="col-md-12 text-center"><a class="btn btn-outline-secondary" href="{{ route('perfil.register') }}"><strong>Quiero ser miembro</strong></a></div>
                <div class="col-md-12 text-center mt-3"><a class="navi-link text-white" href="{{ route('perfil.password.update') }}">Recuperar Contraseña</a></div>
            </div>
        </div>
    </div>
@endsection