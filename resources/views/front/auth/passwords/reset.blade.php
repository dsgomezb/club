@extends("front.layouts.blank")

@section("content")
    <div class="client-login-form d-flex" style="height: 100vh">
        <div class="bg-image h-100 d-none d-sm-inline-block" style="background-image: url(/img/backgrounds/login.jpg)"></div>
        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
            <img style="max-width: 60%" src="/img/logo/logo.png" alt="">

            <form action="{{ route('admin.password.update') }}" method="post" class="form mt-4" style="width: 80%;">
                @include('front.partials.errors')
                
                <h6 class="text-white mt-3 text-center text-uppercase">Cambiar contraseña</h6>
                @csrf

                <div class="form-group">
                    <input name="email" type="email" id="username" class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" placeholder="Email" value="{{ old('email') }}" autofocus>
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="password" placeholder="contraseña">
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="form-control form-control-square form-control-lg border-top-0 border-left-0 border-right-0" name="password_confirmation" placeholder="Password">
                </div>

                <div class="form-group">
                    <button class="btn btn-white btn-square w-100 " type="submit">Resetear contraseña</button>
                </div>
            </form>
        </div>
    </div>
@endsection