<div 
    @php
        $image = $model->getImage();
    @endphp
    class="image-preview vista-previa" 
    id="imageUploader"
    @if($image)
        style="background-image: url('/content/{{$resource}}/thumb/{{$image->src}}"
    @endif
    >
    <label data-value="{{ $label ?? 'Imagen' }}">{{ $label ?? 'Imagen' }}</label>
    @if(!isset($showDeleteButton) || (isset($showDeleteButton) && $showDeleteButton ))
        <a class="btn btn-mini btn-danger" id="deleteImage" data-id="{{$image->id ?? ''}}"><i class="fal fa-trash text-white"></i></a>
    @endif
    <p class="message info">Agregar imagen</p>
    <p class="loader info" style="display: none"><i class="fa fa-circle-o-notch fa-spin"></i> Cargando...</p>
    {{-- <img class="img-responsive inputFileDispacher" src="/content/{{$resource}}/thumb/{{$model->images()->count() ? $model->thumb : $dropzone }}"> --}}
</div>
<input type="hidden" name="imageId" id="imageId" value="" />

@push('components')
    <form id="imageUploaderForm" action="/admin/images/upload" method="post" enctype="multipart/form-data">
        @csrf
        <input class="hidden" type="file" name="images[]" id="file">
        <input class="hidden" type="submit" value="Upload File to Server">
        <input type="hidden" name="resource" value="{{$resource}}" />
    </form>
@endpush

@push('styles')
    <style type="text/css">
        /* -----Upload Preview----- */
        .image-preview {
          width: 100%;
          position: relative;
          overflow: hidden;
          background-color: #e8e8e8;
          color: #ecf0f1;
          background-size: cover;
          background-position: center center;
          cursor: pointer;
          height: 300px;
        }
        .image-preview input {
          width: 100%;
          position: absolute;
          opacity: 0;
          z-index: 10;
          cursor: pointer;
        }
        .image-preview label {
          position: absolute;
          z-index: 5;
          opacity: 0.8;
          cursor: pointer;
          background-color: #bdc3c7;
          width: 200px;
          height: 50px;
          font-size: 20px;
          line-height: 50px;
          text-transform: uppercase;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          margin: auto;
          text-align: center;
        }

        .image-preview-delete {
            position: absolute;
            top: 10px;
            right: 10px
        }
    </style>
@endpush

@push('scripts')
<script>
    var ImageUploader = (function($) {
        var resource = "{{$resource}}";
        {{-- var dropzone = "{{$dropzone}}";--}}
        var $imageUploader = $('#imageUploader');
        var $form = $('#imageUploaderForm');
        var $deleteBtn = $('#deleteImage');

        function init () {
            upload();
            remove();
            $('#file').on('change', function () {
                $('#imageUploaderForm').submit();
            });
            $imageUploader.click(function () {
                $('#file').trigger('click');
            });
            if ($('#deleteImage').data('id')) {
                $('#deleteImage').show();
                $('#imageUploader .info').hide();
            } else {
                $('#deleteImage').hide();
                $('#imageUploader .info.message').show();
            }
        }
        
        function upload () {
            $form.ajaxForm({
                beforeSubmit: function(arr, $form, options) {
                    $('label', $imageUploader).html('<span class="fal fa-spin fa-spinner"></span> CARGANDO...');
                    $('#imageUploader .info.message').hide();
                    $('#imageUploader .info.loader').show();
                },
                success: function(data) {
                    $('#imageUploader .info').hide();
                    if (data) {
                         $('label', $imageUploader).text($('label', $imageUploader).data('value'));


                        image = data['images'][0];
                        $('#imageId').val(image.id);
                        
                        $(".image-preview").css("background-image", 'url(/content/' + resource + '/thumb/' + image.src+')')
                        $("#deleteImage").attr('data-id', image.id).fadeIn(400);
                        // $imageUploader.find('img')
                        //     .fadeOut(400, function() {
                        //         $(this).attr('src', '/content/' + resource + '/thumb/' + image.src);
                        //     })
                        //     .fadeIn(400, function() {
                        //         $(this).siblings('a').attr('data-id', image.id).show();
                        //     });
                    }
                }
            });
        }

        function remove() {
            $deleteBtn.click(function(event) {
                $('#imageUploader .info.loader').show();
                event.stopPropagation();
                $.ajax({
                    type: 'post',
                    url: '/admin/images/'+$deleteBtn.attr('data-id')+'/delete',
                    success: function() {
                        $('#imageId').val('');
                        $(".image-preview").css("background-image",'none')
                        $deleteBtn.hide();
                        $('#imageUploader .info.loader').hide();
                        $('#imageUploader .info.message').show();
                        // $deleteBtn.parent().find('img')
                        //         .fadeOut(400, function() {
                        //             $(this).attr('src', '/content/' + resource + '/thumb/' + dropzone);
                        //         })
                        //         .fadeIn(400, function() {
                        //             $deleteBtn.hide();
                        //             $('#imageUploader .info.loader').hide();
                        //             $('#imageUploader .info.message').show();
                        //         })
                    }
                })
            })
        }

        return {
            init: function() {
                init();
            }
        };
    })(jQuery);

    $(document).ready(function () {
        ImageUploader.init();
    })

</script>
@endpush
