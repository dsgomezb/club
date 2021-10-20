@extends('admin.layouts.app')

@section('section', 'Usuarios')

@section('action', 'Listar')

@section('icon', 'users')

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Imagen</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>

    @include('admin.users.modal-ban')

    <form id="unband-form" action="/admin/users/unband" method="post">
        @method('PUT')
        @csrf
    </form>
@endsection

@section('scripts')
    <script src="/backend/js/app/Users.js"></script>
@endsection
