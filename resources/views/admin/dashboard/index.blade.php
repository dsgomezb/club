@extends('admin.layouts.app')

@section('section', 'Dashboard')

@section('action', 'Estadísticas')

@section('icon', 'home')

@section('widget-body')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div>
                <label>Período: &nbsp;</label>
                <select data-chart="users" class="form-control period-selector" style="width: 200px; display: inline">
                    <option value="1" selected>Última semana</option>
                    <option value="2">Último mes</option>
                    <option value="3">Últimos tres meses</option>
                </select>
            </div>
        </div>
    </div>

    <canvas id="usersChart" height="120"></canvas>
@endsection

{{--
@section('extra-content')
    <div class="row">
        <div class="col-md-6">
            @component('admin.components.panel')
                @slot('title')
                    Productos más vendidos
                @endslot

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div>
                            <label>Período: &nbsp;</label>
                            <select data-chart="bestSellers" class="form-control period-selector" style="width: 200px; display: inline">
                                <option value="1">Última semana</option>
                                <option value="2">Último mes</option>
                                <option value="3">Últimos tres meses</option>
                                <option value="4">Últimos seis meses</option>
                                <option value="5">Último año</option>
                            </select>
                        </div>
                    </div>
                </div>

                <canvas id="bestSellersChart" height="120"></canvas>
            @endcomponent
        </div>

        <div class="col-md-6">
            @component('admin.components.panel')
                @slot('title')
                    Productos menos vendidos
                @endslot

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div>
                            <label>Período: &nbsp;</label>
                            <select data-chart="unpopulars" class="form-control period-selector" style="width: 200px; display: inline">
                                <option value="1">Última semana</option>
                                <option value="2">Último mes</option>
                                <option value="3">Últimos tres meses</option>
                                <option value="4">Últimos seis meses</option>
                                <option value="5">Último año</option>
                            </select>
                        </div>
                    </div>
                </div>

                <canvas id="unpopularsChart" height="120"></canvas>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @component('admin.components.panel')
                @slot('title')
                    Cliente que más gastó
                @endslot

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div>
                            <label>Período: &nbsp;</label>
                            <select data-chart="client" class="form-control period-selector" style="width: 200px; display: inline">
                                <option value="1">Última semana</option>
                                <option value="2">Último mes</option>
                                <option value="3">Últimos tres meses</option>
                                <option value="4">Últimos seis meses</option>
                                <option value="5">Último año</option>
                            </select>
                        </div>
                    </div>
                </div>

                <canvas id="clientChart" height="120"></canvas>
            @endcomponent
        </div>

        <div class="col-md-6">
            @component('admin.components.panel')
                @slot('title')
                    Cliente que compró más productos
                @endslot

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div>
                            <label>Período: &nbsp;</label>
                            <select data-chart="clientPurchases" class="form-control period-selector" style="width: 200px; display: inline">
                                <option value="1">Última semana</option>
                                <option value="2">Último mes</option>
                                <option value="3">Últimos tres meses</option>
                                <option value="4">Últimos seis meses</option>
                                <option value="5">Último año</option>
                            </select>
                        </div>
                    </div>
                </div>

                <canvas id="clientPurchasesChart" height="120"></canvas>
            @endcomponent
        </div>
    </div>
@endsection
--}}

@section('scripts')
    @include('admin.partials.scripts.kamechart')
    
    <script src="/backend/js/app/Dashboard.js"></script>
@endsection
