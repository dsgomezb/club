@php
    $attributes = \App\VariantAttribute::all() ?? [];
@endphp

<div class="col-md-12" id="variants-selector">
    <div class="panel">
        <div class="panel-hdr">
            <h2>Opciones </h2>
            <div class="panel-toolbar">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Agregar</button>
                    <div class="dropdown-menu  dropdown-sm dropdown-menu-right">
                        @foreach ($attributes as $attr)
                            <button data-attribute="{{ $attr->id }}" {!! $model->hasAttr($attr->value)  ? 'style="display: none;"' : '' !!} class="dropdown-item add-attribute" type="button">{{ $attr->value }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row variants-content">
                    <div class="col-auto">
                        <div class="nav flex-column nav-pills" id="pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($attributes as $attr)
                                <a {!! $model->hasAttr($attr->value)  ? '' : 'style="display: none;"' !!} class="nav-link {{ $model->hasAttr($attr->value) ? 'active' : '' }}" id="pills-{{ $attr->id }}-tab" data-toggle="pill" href="#pills-{{ $attr->id }}" role="tab" aria-controls="pills-{{ $attr->id }}" aria-selected="true">
                                    <span class="hidden-sm-down ml-1"> {{ $attr->value }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col">
                        <div class="tab-content" id="pills-tabContent">
                            @foreach ($attributes as $attr)
                                <div class="tab-pane fade {!! $model->hasAttr($attr->value)  ? 'active show' : '' !!}" id="pills-{{ $attr->id }}" role="tabpanel" aria-labelledby="pills-{{ $attr->id }}-tab">
                                    <h3 style="margin-bottom: 20px">{{ $attr->value }}</h3>
                                    @foreach ($attr->values as $value)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" name="variants[{{$attr->id}}][]" value="{{$attr->value}}-{{ $value->id }}" class="custom-control-input" id="value{{ $value->id }}" {{ $model->hasValue($attr->value, $value->value) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="value{{ $value->id }}">{{ $value->value }}</label>
                                        </div>
                                    @endforeach
                                    <p class="text-right">
                                        <button data-attribute="{{ $attr->id }}" type="button" class="remove-attribute btn btn-sm btn-outline-danger waves-effect waves-themed">
                                            <span class="fal fa-times mr-1"></span>
                                            Quitar {{ $attr->value }}
                                        </button>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row empty">
                    <div class="col-md-12">
                        <div class="panel-tag" style="width: 100%">
                            El producto no posee variantes
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var $el = $('#variants-selector');

        //quitar el exceso de actives
        $('.nav-link.active', $el).each(function (i) {
            if (i > 0) {
                $(this).removeClass('active')
            }
        });
        $('.tab-pane.active.show', $el).each(function (i) {
            if (i > 0) {
                $(this).removeClass('active')
            }
        });

        refreshStatus();

        $('.add-attribute', $el).on('click', function () {
            var id = $(this).data('attribute');
            $(this).parents('.btn-group').find('.dropdown-toggle').dropdown('hide');
            $(this).hide();

            //remuevo el active al actual
            $('.nav-link.active', $el).removeClass('active');
            $('.tab-pane.active.show', $el).removeClass('active show');

            //agrego el active al seleccionado
            $('#pills-'+ id +'-tab').addClass('active').show();
            $('#pills-'+id).addClass('active show');

            refreshStatus();
        });

        $('.remove-attribute', $el).on('click', function () {
            var id = $(this).data('attribute');

            $('.add-attribute[data-attribute="'+id+'"]').show();
            $('#pills-'+ id +'-tab').removeClass('active').hide();
            $('#pills-'+id).removeClass('active show');

            $('#pills-'+id).find('input[type="checkbox"]').attr('checked', false);

            $('#pills-tab .nav-link', $el).each(function () {
                if ($(this).attr('style') != 'display: none;') {
                    id = $(this).attr('id').replace('-tab', '');
                    $(this).addClass('active').show();
                    $('#' + id).addClass('active show');
                    return false;
                }
            });

            refreshStatus();
        });

        function refreshStatus() {
            var atLeastOneTabVisible = false;

            $('#pills-tab .nav-link', $el).each(function () {
                if($(this).hasClass('active')) {
                    return atLeastOneTabVisible = true;
                }
            });

            if (atLeastOneTabVisible) {
                $('.variants-content', $el).show();
                $('.empty', $el).hide();
            } else {
                $('.variants-content', $el).hide();
                $('.empty', $el).show();
            }

            var dropdownItemsVisibles = 0;
            $('.dropdown-menu .dropdown-item', $el).each(function () {
                if ($(this).attr('style') != 'display: none;') {
                    dropdownItemsVisibles++;
                }
            });

            if (dropdownItemsVisibles > 0) {
                $('.btn-group', $el).show();
            } else {
                $('.btn-group', $el).hide();
            }
        }
    </script>
@endpush