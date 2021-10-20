@extends('admin.layouts.app')

@section('section', 'Categorías')

@section('action', 'Listar')

@section('icon', 'tags')

@section('header-buttons')
    <a href="/admin/categories/create" data-toggle="tooltip" data-placement="top" title="Cargar Categoría" class="btn btn-primary btn-lg btn-icon rounded-circle waves-effect waves-themed">
        <i class="fal fa-plus"></i>
    </a>
@endsection

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Publicaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Categoría</th>
                <th>Publicaciones</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script src="/backend/js/app/Categories.js"></script>
@endsection
