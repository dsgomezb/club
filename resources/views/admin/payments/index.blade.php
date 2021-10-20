@extends('admin.layouts.app')

@section('section', $pageTitle)

@section('action', 'Listado')

@section('icon', $pageIcon)

@section('widget-body')
    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
        <thead>
            <tr>
                <th>Vencimiento</th>
                <th>Monto</th>
                <th>Usuario</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Vencimiento</th>
                <th>Monto</th>
                <th>Usuario</th>
                <th>Email</th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script>
        var state = "{{ request()->route('state') }}";
    </script>
    <script src="/backend/js/app/Payments.js"></script>
@endsection
