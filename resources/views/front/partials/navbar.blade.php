<!-- Navbar-->
<header class="navbar navbar-sticky bg-dark">
  <!-- Site Branding-->
  <div class="site-branding"><a class="site-logo hidden-xs-down" href="/"><img src="/img/logo/logo.png" alt="{{ config('app.name') }}"></a><a class="site-logo logo-sm hidden-sm-up" href="/"><img src="/img/logo/logo.png" alt="{{ config('app.name') }}"></a>
  </div>
  <!-- Main Navigation-->
  <nav class="site-menu">
    <ul>
      <li class="{{request()->is("/") ? 'active' : ''}}"><a href="/"><span>Experiencias</span></a></li>
      <li class="{{request()->is("negocios") ? 'active' : ''}}"><a href="/negocios"><span>Negocios</span></a></li>
      <li class="{{request()->is("contacto") ? 'active' : ''}}"><a href="/contacto"><span>Contacto</span></a></li>
    </ul>
  </nav>
  <!-- Toolbar-->
  <div class="toolbar user-logued">

    <div class="inner">

    	<a href="/perfil/post/create" class="d-none d-md-block btn btn-dark mr-0 rounded btn-rounded btn-pill btn-sm bg-green text-capitalize text-white"><i class="material-icons create mr-2"></i>Nueva entrada</a>
    	<a class="toolbar-toggle for-user bg-dark text-white" href="#user"><i class="text-white" style="font-size: 15px"><span class="d-none d-sm-inline-block">Hola, </span>{{ \Auth('user')->user()->username }}</i></a>
    	<a class="toolbar-toggle bg-green" href="#search"><i class="material-icons search text-dark"></i></a>
    	<a class="toolbar-toggle mobile-menu-toggle bg-dark" style="display: table-cell" href="#mobileMenu"><i class="material-icons menu text-white"></i></a>
    </div>
    <!-- Toolbar Dropdown-->
    <div class="toolbar-dropdown bg-dark">
      <!-- Mobile Menu Section-->
      <div class="toolbar-section " id="mobileMenu">
        
        <!-- Slideable (Mobile) Menu-->
        <nav class="slideable-menu">
          <ul class="menu">
            <li class="{{request()->is("/") ? 'active' : ''}}"><span><a href="/" class="text-white"><span>Experiencias</span></a></span></li>
            <li class="{{request()->is("negocios") ? 'active' : ''}}"><span><a href="/negocios" class="text-white"><span>Negocios</span></a></span></li>
            <li class="{{request()->is("contacto") ? 'active' : ''}}"><span><a href="/contacto" class="text-white"><span>Contacto</span></a></span></li>
          </ul>
        </nav>
      </div>
      <!-- Search Section-->
      <div class="toolbar-section" id="search">
        <form action="/busqueda" class="search-form mb-2" method="get">
          <input name="q" type="search" placeholder="Buscar..."><i class="material-icons search color-green"></i>
        </form>
      </div>

      <!-- User Section-->
      <div class="toolbar-section" id="user">
        <!-- Slideable (Mobile) Menu-->
        <nav class="slideable-menu mt-0">
          <ul class="menu">
            <li>
              <a href="#" class="row pl-3 pr-3 align-items-center d-flex">
                <div class="col-md-3">
                  <img class="rounded-circle border border-white" style="width: 50px;max-width: 100%" src="/content/users/thumb/{{ \Auth('user')->user()->thumb }}" alt="{{ \Auth('user')->user()->full_name }}">
                </div>
                <div class="col-md-9">
                  <p class="color-green mb-0 mt-1 " style="line-height: 1">{{ \Auth('user')->user()->full_name }}</p>
                  {{--<small class="text-muted">/ma.quiroga</small>--}}
                </div>
              </a>
            </li>
            <li class="{{request()->is("perfil") ? 'active' : ''}}"><span><a href="/perfil" class="text-white"><span><i class="material-icons person_outline color-green mr-3"></i>Mi perfil</span></a></span></li>
            <li><span><a href="/perfil/post/create" class="text-white"><span><i class="material-icons create color-green mr-3"></i>Nueva entrada</span></a></span></li>
            <li><span><a href="{{ route('perfil.logout') }}" class="text-white"><span><i class="material-icons exit_to_app color-green mr-3"></i>Cerrar sesión</span></a></span></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>