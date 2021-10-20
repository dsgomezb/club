@extends('admin.layouts.app')

@section('section', 'Newsletter')

@section('action', 'Listar')

@section('icon', 'envelope')

@section('header-buttons')
    <a href="/admin/newsletter/export" data-toggle="tooltip" data-placement="top" title="Exportar" class="btn btn-primary btn-lg btn-icon rounded-circle waves-effect waves-themed">
        <i class="fal fa-download"></i>
    </a>
@endsection

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script src="/backend/js/app/Newsletter.js"></script>
@endsection
