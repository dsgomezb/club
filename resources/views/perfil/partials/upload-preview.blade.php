<div
    class="image-preview {{$extraClass ?? ''}} {{$model->$prop ? 'loaded' : ''}}"
    id="{{$prop}}-preview"
    @if ($model->$prop)
        style="background-image: url('/content/{{$resource}}/thumb/{{$model->$prop}}');"
    @endif
>
    <label for="{{$prop}}-upload" class="{{$prop}}-label" id="{{$prop}}-label"><i class="material-icons photo_camera"></i></label>
    <input type="file" name="uploadPreviews[files][{{$resource}}][{{$prop}}]" class="{{$prop}}-upload d-none" id="{{$prop}}-upload" />
    <input type="hidden" class="d-none" name="uploadPreviews[properties][{{$resource}}][{{$prop}}]" value="{{$prop}}">
    <input type="hidden" class="d-none" name="deleteProp" value="0">

    <a title="Remover Imagen" class="{{ $model->$prop ? '' : 'd-none' }} btn btn-danger btn-sm image-preview-delete z-index-space m-0 p-1" href="eliminar-imagen"><i class="material-icons">close</i></a>
</div>

@push('scripts')
    <script>
        var $container = $("#{{$prop}}-preview");
        $.uploadPreview({
            input_field: "#{{str_replace(':', '\\\:', $prop)}}-upload",
            preview_box: "#{{str_replace(':', '\\\:', $prop)}}-preview",
            label_field: "#{{str_replace(':', '\\\:', $prop)}}-label",
            label_default: "{{ $label }}",
            label_selected: "{{ $label }}",
            no_label: false,
            success_callback: function() {
                target = $($(this)[0].preview_box);
                target.addClass("loaded");
                $('.image-preview-delete', target).removeClass('d-none');
                $('input[name="deleteProp"]', target).val(0);
            }
        });

        $('.image-preview-delete', $container).on('click', function (e) {
            e.preventDefault();
            target = $(this).closest(".image-preview");
            target.find("label").html($('<i class="material-icons photo_camera"></i>'));
            target.removeClass("loaded");
            target.css('background-image', 'none');

            $('input[type="file"]', target).val('');
            $(this).addClass('d-none');
            $('input[name="deleteProp"]', target).val("{{$prop}}");
        });
    </script>
@endpush

@push('styles')
    <style type="text/css">
        /* -----Upload Preview----- */
        .image-preview {
          width: 100%;
          position: relative;
          overflow: hidden;
          /*background-color: #e8e8e8;*/
          color: #ecf0f1;
          background-size: cover;
          background-position: center center;
          cursor: pointer;
          border: 1px dashed #999;
          border-radius: 5px;
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
          max-width: 200px;
          height: 50px;
          font-size: 70px;
          line-height: 50px;
          text-transform: uppercase;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          margin: auto;
          text-align: center;
        }

        .image-preview.loaded label {
          font-size: 20px;
          background: rgba(33,33,33,.8);
        }

        .image-preview label i{
        	color: #999;
        }

        .image-preview-delete {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 50;
            height: 30px;
            line-height: 22px;
        }

        #{{$prop}}-preview {
            height: {{ $height ?? '150'  }}px
        }
        #{{$prop}}-preview input {
            line-height: {{ $height ?? '150'  }}px;
        }
    </style>
@endpush