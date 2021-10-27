@extends("front.layouts.blank")

@section("content")

    <div class="client-register-form d-flex" style="height: 100vh">
        <div class="bg-image h-100 d-none d-sm-inline-block" style="background-image: url(/img/backgrounds/bg-login.png)"></div>
        <div style="overflow-y: scroll">
            <img style="margin: 30px auto 0; display: block;" width="150px" src="/img/logo/logo.png" alt="{{ config('app.name') }}">

            <form action="{{ route('perfil.register') }}" method="post" class="form mt-4 row " style="width: 80%; margin: 0 auto" autocomplete="off">
                @csrf
                @include('front.partials.errors')

                <div class="form-group col-md-6 mt-3">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="username" type="text" id="large-square-input" placeholder="Nombre de usuario" value="{{ old('username') }}" autofocus>
                </div>

                <div class="form-group col-md-6 mt-3">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="email" type="email" id="large-square-input" placeholder="E-mail" value="{{ old('email') }}">
                </div>

                <div class="form-group col-md-6">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="password" type="password" id="large-square-input" placeholder="Contraseña" value="">
                </div>

                <div class="form-group col-md-6">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="password_confirmation" type="password" id="large-square-input" placeholder="Repetir Contraseña" value="">
                </div>

                <div class="form-group col-md-12">
                    <textarea class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="reason" placeholder="¿Por qué querés ser parte de Comunidad Fichap?">{{ old('reason') }}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <textarea class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="reference" placeholder="¿Cómo te enteraste de Comunidad Fichap?">{{ old('reference') }}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <button class="btn btn-outline w-100 bg-green login-btn" type="submit">Registrarme</button>
                </div>
            </form>

            <div class="row w-100 pl-3 pr-3 w-100 justify-content-center mb-3">
                <div class="col-md-12 text-center"><strong>¿Ya eres miembro? <a class="color-green" style="text-decoration: none;" href="{{ route('perfil.login') }}">Iniciar sesión</a></strong></div>
            </div>
                
        </div>
    </div>
@endsection