@extends('admin.layouts.app')

@section('section', 'Eventos')

@section('icon', 'calendar')

@push('styles')
    <link rel="stylesheet" media="screen, print" href="/backend/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
@endpush

@section('widget-body')
    {!! KameForm::model($model, $formOptions) !!}

        <div class="col-md-12 mb-3">
            @include('admin.components.single-uploader', ['resource' => 'events','showDeleteButton'=>false])
        </div>

        {!! KameForm::text('title')->col(8) !!}
        
        {!! KameForm::select('notify', [0 => 'No', 1 => 'Si'])->col(4)->label('Enviar notificación')->help('Notificar al celular') !!}

        {!! KameForm::text('range')->col(6)->label('Inicio y fin') !!}

        {!! KameForm::text('address', ['placeholder' => 'Dirección'])->col(6) !!}

        {!! KameForm::editable('description') !!}

        {!! KameForm::select('category_id', \App\Category::toSelect())->col(6) !!}
        
        {!! KameForm::select('localidad_id', \App\Localidad::toSelect())->col(6) !!}
        
        {!! KameForm::select('instalation_id', \App\Instalation::toSelect())->col(6) !!}
        
        {!! KameForm::select('outstanding', [0 => 'No', 1 => 'Si'])->col(3) !!}
        
        {!! KameForm::select('is_free', [0 => 'No', 1 => 'Si'])->col(3) !!}

        <div class="col-md-12">
            <label class="form-label">Público</label>
        </div>
        
        <div class="col-12 mb-3">
            @foreach (\App\Target::toSelect() as $id => $value)
                <div class="custom-control custom-checkbox custom-control-inline">
                    {!! \Form::checkbox('targets[]', $id, null, ['class' => 'custom-control-input', 'id' => "target$id"]) !!}
                    <label class="custom-control-label" for="target{{ $id }}">{{ $value }}</label>
                </div>
            @endforeach
        </div>

        <div class="col-md-12 mb-2">
            <label class="form-label">Apto para el clima</label>
        </div>

        <div class="col-md-12">
            <div class="row justify-content-around" style="align-items: baseline">
                @foreach (\App\WeatherType::all() as $type)
                    <div class="col-lg-1 col-md-1 col-sm-3 col-4">
                        {!! \Form::checkbox('weathers[]', $type->id, null, ['class' => 'custom-control-input', 'id' => 'weather' . $type->id]) !!}
                        <label class="weather-label" for="weather{{ $type->id }}">
                            <img src="/images/weather/{{ $type->icon_day }}" class="img-fluid">
                        </label>
                        <p>{{ $type->value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {!! \Form::hidden('lat', null, ['id' => 'lat']) !!}
        {!! \Form::hidden('lng', null, ['id' => 'lng']) !!}

        {!! KameForm::submit('Enviar') !!}

    {!! KameForm::close() !!}
@endsection

@section('scripts')
    <script src="/backend/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJH8I4-QPHZIGlpc8Yl60J9ySkiEivDMk&libraries=places&callback=initAutocomplete" async defer></script>

    <script>
        var autocomplete;

        function initAutocomplete() {
            var input = document.getElementById('address');
            autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['geocode', 'establishment'],
                bounds: new google.maps.LatLngBounds({lat: -37.049279, lng: -56.875134}, {lat: -36.273512, lng: -56.591705}),
                strictBounds: true
            });

            autocomplete.setFields(['geometry']);

            autocomplete.addListener('place_changed', setPosition);
        }

        function setPosition() {
            var place = autocomplete.getPlace();
            $('#lat').val(place.geometry.location.lat().toFixed(6));
            $('#lng').val(place.geometry.location.lng().toFixed(6));
        }

        $('#address').on("keyup paste", function() {
            $('#lat, #lng').val('');
        });

    </script>

    <script>
        $('#range').daterangepicker({
            timePicker: true,
            locale: {
                format: 'DD/MM/YY hh:mm A',
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Personalizado",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sá"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
            }
        });
    </script>
@endsection
