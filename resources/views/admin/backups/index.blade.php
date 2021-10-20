@extends('admin.layouts.app')

@section('section', 'Buckups')

@section('action', 'Listar')

@section('icon', 'database')

@section('widget-body')
    <!-- datatable start -->
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Tamaño</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($backups as $backup)
                <tr>
                    <td>
                        {{ $backup['last_modified']->format('d-m-Y') }}
                    </td>
                    <td>{{ $backup['file_name'] }}</td>
                    <td>{{ $backup['file_size'] }}</td>
                    <td>
                        {{ $backup['last_modified']->locale('es')->diffForHumans() }}
                    </td>
                    <td class="text-right">
                        <a href="/admin/backup/download/{{ $backup['file_name'] }}" data-html="false" data-placement="top" data-original-title="Descargar" rel="tooltip" class="btn btn-primary btn-sm btn-icon waves-effect waves-themed"><i class="fal fa-download"></i></a>
                        <a href="/admin/backup/delete/{{ $backup['file_name'] }}" data-html="false" data-placement="top" data-original-title="Borrar" rel="tooltip" class="btn btn-danger btn-sm btn-icon waves-effect waves-themed"><i class="fal fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Tamaño</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
    <!-- datatable end -->
@endsection

@section('scripts')
    <script>
        $('#datatable').DataTable();
    </script>
@endsection
