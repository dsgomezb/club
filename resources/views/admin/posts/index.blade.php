@extends('admin.layouts.app')

@section('section', 'Posts')

@section('action', 'Listar')

@section('icon', 'file-alt')

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Autor</th>
                <th>Fecha</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Imagen</th>
                <th>Autor</th>
                <th>Fecha</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script src="/backend/js/app/Posts.js"></script>
@endsection
