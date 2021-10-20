<div id="images-uploader" class="col-md-12">
    <div class="panel">
        <div class="panel-hdr">
            <h2>Imágenes</h2>
            <div class="panel-toolbar">
                <label form="imagesUploader" class="btn btn-sm btn-primary waves-effect waves-themed" for="fileInput"><i class="fal fa-upload"></i> Cargar</label>
                {{--
                &nbsp;&nbsp;
                <button class="btn btn-sm btn-primary waves-effect waves-themed">
                    <i class="fal fa-film"></i> Video
                </button>
                --}}
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content flex-row d-flex flex-wrap" id="sliderImagenes">
                @if (!$model->images()->count())
                    <div class="panel-tag empty" style="width: 100%">
                        No hay ninguna imagen cargada
                    </div>
                @endif
                @php $data = [] @endphp
                @foreach ($model->images as $image)
                    <div style="display: none" class="card border m-auto m-lg-0 sortable" style="width: 18%; margin: 1% !important; display: none">
                        <img src="/content/{{$resource}}/thumb/{{ $image->src }}" class="card-img-top">
                        <div class="card-body">
                            <a href="#" class="btn btn-icon btn-primary waves-effect waves-themed" data-id="{{ $image->id }}" style="display: none">
                                <i class="fal fa-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-danger waves-effect waves-themed" data-id="{{ $image->id }}">
                                <i class="fal fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    @php $data[$image->id] = $image->toArray(); @endphp
                @endforeach
                <script>var Imagenes = {!!json_encode($data)!!}</script>
            </div>
            <!-- panel footer with utility classes -->
            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                <div class="progress progress-sm w-100 shadow-inset-2" style="visibility: hidden;">
                    <div class="progress-bar bg-success-300 bg-success-gradient" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('components')
    <form id="imagesUploader" action="/admin/images/upload" method="post" enctype="multipart/form-data" style="display: none">
        <input class="hidden" id="fileInput" onchange="ImageUploader.forceUpload(this);" type="file" name="images[]" multiple>
        <input class="hidden" type="submit" value="Upload">
        <input type="hidden" name="resource" value="{{$resource}}" />
    </form>
@endpush

<textarea class="hidden" id="superboxItem" style="display: none">
    <div class="card border m-auto m-lg-0 sortable" style="width: 18%; margin: 1% !important; display: none">
        <img src="${src}" class="card-img-top">
        <div class="card-body">
            <a href="#" class="btn btn-icon btn-primary waves-effect waves-themed" data-id="${id}" style="display: none">
                <i class="fal fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-icon btn-danger waves-effect waves-themed" data-id="${id}">
                <i class="fal fa-trash"></i>
            </a>
        </div>
    </div>
</textarea>

@php $editable = isset($editable) ? 1 : 0; @endphp

@push('scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 100,
        "timeOut": 0,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var ImageUploader = (function ($, w, undefined) {

        var Imagenes = {};
        var resource = "{{$resource}}";
        var superboxItem =  $('#superboxItem').val();
        var formImagen =  $('#formImagen').val();
        var $el = $('#images-uploader');

        function init (images) {
            Imagenes = images
            ajaxFileUpload();
            $('#sliderImagenes').sortable({
                start: function(e, ui){ui.placeholder.height(100);},
                stop: function (e, ui) {ordenar();},
                items: '.sortable'
            });
            $('#sliderImagenes').on('click', '.btn-danger', function (e) {
                e.preventDefault();
                borrar($(this));
            });
            $('#sliderImagenes').on('click', '.btn-primary', function () {
                editar($(this));
            });
            $('#sliderImagenes .card').show();
            if ( {{$editable}} ) $('.card .btn-primary').show();
        }

        function ajaxFileUpload () {
            var html, images;
            $('#imagesUploader').ajaxForm({
                beforeSend: function() {
                    $('.progress', $el).css('visibility', 'visible');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    if (percentVal == '100%') percentVal = '99%';
                    $('.progress-bar', $el).width(percentVal);
                },
                success: function (data) {
                    images = data.images;
                    if (images.length) {
                        html = '';
                        for (var i=0, l=images.length; i<l; i++) {
                            html += superboxItem.replace('${src}', '/content/'+resource+'/thumb/'+images[i].src)
                                .replace(/\$\{id\}/g, images[i].id);
                            $('#form').append('<input type="hidden" name="imagesIds[]" value="'+images[i].id+'" />');
                            Imagenes[images[i].id] = images[i];
                        }
                        $('#sliderImagenes').append(html);
                        if ( {{$editable}} ) $('.card .btn-primary').show();
                        $('#sliderImagenes').find('.card:hidden').fadeIn();
                        if ($('#sliderImagenes .card').length) $('#sliderImagenes .empty').hide();
                    }
                    $('.progress', $el).css('visibility', 'hidden');
                    $('.progress-bar').width('0%');
                },
                error: function (a, b, c) {
                    toastr.error('La imagen es demasiado pesada o el formato no es el correcto', "Error")

                    $('.progress', $el).css('visibility', 'hidden');
                    $('.progress-bar').width('0%');
                }
            });
        }

        //ordenar
        function ordenar () {
            var data = '', id;
            $('#sliderImagenes .sortable').each(function (i) {
                data += '&order[]='+i;
                data += '&id[]='+$(this).attr('data-id');
            })
            $.ajax({
                type:'POST',
                url:'/backend/sort/images',
                data: 'data'+data
            })
        }

        //borrar
        function borrar ($this) {
            var id = $this.data('id');

            var dialog = bootbox.confirm({
                title: "Borrar",
                message: "¿Está seguro que desea borrar esta imagen?",
                buttons: {
                    confirm: {
                        label: 'Borrar',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancelar',
                    }
                },
                callback: function(result) {
                    if (result === true) {
                        $('.modal-header .fal', dialog).removeClass('fa-times').addClass('fa-spinner fa-spin');
                        $.ajax({
                            type:'post',
                            url: '/admin/images/'+id+'/delete',
                            success: function () {
                                $('.modal-header .fal', dialog).removeClass('fa-spinner fa-spin').addClass('fa-times');
                                dialog.modal('hide');
                                $this.parents('.card').fadeOut(
                                    500,
                                    function () {
                                        $this.parents('.card').remove();
                                        if (!$('#sliderImagenes .card').length) $('#sliderImagenes .empty').show();
                                    }
                                );
                            },
                            error: function () {
                                dialog.modal('hide');
                                toastr.error('Ocurrió un error. Vuelva a intentarlo', "Error")
                            }
                        });

                    } else {
                        dialog.modal('hide');
                    }

                    return false;
                }
            });
        }

        //editar
        function editar ($this) {
            editModalInit($this);
            $('#modalEdit').modal('show');
            $('#modalEdit button.action').unbind('click').click(function () {
                var data = $('#modalEdit form').serialize();
                loaderModalInit();
                $.ajax({
                    type:'patch',
                    url: '/backend/images/'+$this.data('id'),
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            Imagenes[$this.data('id')] = response.image;
                        }
                        $('#modalEdit').modal('hide');
                    }
                })
            })
        }

        return {
            forceUpload: function (el) {
                $(el).parents('form').find('input[type="submit"]').trigger('click');
            },
            init: function (images) {
                init(images);
            }
        }

    })(jQuery, window);
    ImageUploader.init(Imagenes);
</script>
@endpush
