@extends('admin.layouts.app')

@section('section', 'Admisiones')

@section('action', 'Listar')

@section('icon', 'users-plus')

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Usuario</th>
                <th>Email</th>
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
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>

    <form id="form" action="/admin/admissions" method="post">
        @method('PUT')
        @csrf
    </form>
@endsection

@section('scripts')
    <script src="/backend/js/app/Admissions.js"></script>
@endsection
