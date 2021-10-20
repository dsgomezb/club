<!-- BEGIN Left Aside -->
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center" data-toggle="modal" data-target="#modal-shortcut">
            <span class="page-logo-text mr-1  text-center">Administrador</span>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="/admin" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="/content/admins/thumb/{{ \Auth::user()->thumb }}" class="profile-image rounded-circle" alt="">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                        
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm">{{ config('app.name') }}</span>
            </div>
            <img src="/backend/img/card-backgrounds/cover-7-lg.jpg" class="cover" alt="{{ config('app.name') }}">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li>
                <a href="/admin" title="Dashboard " data-filter-tags="home dashboard">
                    <i class="fal fa-home"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Dashboard </span>
                </a>
            </li>
            <li>
                <a href="/admin/posts" title="Publicaciones" data-filter-tags="publicaciones posts blog">
                    <i class="fal fa-file-alt"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Publicaciones</span>
                </a>
            </li>
            <li>
                <a href="/admin/categories" title="Categorías" data-filter-tags="categorías categorias">
                    <i class="fal fa-tags"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Categorías</span>
                </a>
            </li>
            <li>
                <a href="/admin/users" title="Usuarios" data-filter-tags="usuarios miembros clientes">
                    <i class="fal fa-users"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Usuarios</span>
                </a>
            </li>
            <li>
                <a href="/admin/admissions" title="Admisiones" data-filter-tags="admisiones solicitudes">
                    <i class="fal fa-user-plus"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Admisiones</span>
                </a>
            </li>
            <li>
                <a href="/admin/newsletter" title="Newsletter" data-filter-tags="newsletter correos">
                    <i class="fal fa-envelope"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Newsletter</span>
                </a>
            </li>
            <li class="nav-title">Suscripciones</li>
            <li>
                <a href="/admin/payments/paid" title="Pagos realizados" data-filter-tags="suscripciones pagos realizados abonados">
                    <i class="fal fa-credit-card"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Pago realizados</span>
                </a>
            </li>
            <li>
                <a href="/admin/payments/pending" title="Pagos pendientes" data-filter-tags="suscripciones pagos pendientes próximos">
                    <i class="fal fa-calendar-alt"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Pago pendientes</span>
                </a>
            </li>
            <li>
                <a href="/admin/payments/overdue" title="Pagos vencidos" data-filter-tags="suscripciones pagos vencidos mora">
                    <i class="fal fa-exclamation-triangle"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Pago vencidos</span>
                </a>
            </li>
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
</aside>
<!-- END Left Aside -->
