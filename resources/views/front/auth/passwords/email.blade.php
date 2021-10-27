@extends("front.layouts.blank")

@section("content")
    <div class="client-login-form d-flex" style="height: 100vh">
        <div class="bg-image h-100 d-none d-sm-inline-block img-fluid" alt="Silverfox" style="background-image: url(/img/backgrounds/bg-login.png); background-repeat: no-repeat;"></div>
        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
            <img width="150px" src="/img/logo/logo.png" alt="">

            <form action="{{ route('admin.password.email') }}" method="post" class="form mt-4" style="width: 80%;">
                @include('front.partials.errors')
                
                <h5 style="color: #606060;" class="mt-3 text-center text-uppercase">Olvidé mi contraseña</h5>
                @csrf

                <div class="form-group">
                    <input class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="email" type="email" id="large-square-input" placeholder="E-mail" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group">
                    <button class="btn btn-outline w-100 bg-green login-btn" type="submit">Recuperar contraseña</button>
                </div>
            </form>
        </div>
    </div>
@endsection