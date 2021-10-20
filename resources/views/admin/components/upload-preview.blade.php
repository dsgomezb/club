<div
    class="image-preview"
    id="{{$prop}}-preview"
    @if ($model->$prop)
        style="background-image: url('/content/{{$resource}}/thumb/{{$model->$prop}}');"
    @endif
>
    <label for="{{$prop}}-upload" class="{{$prop}}-label" id="{{$prop}}-label">{{$label}}</label>
    <input type="file" name="uploadPreviews[files][{{$resource}}][{{$prop}}]" class="{{$prop}}-upload" id="{{$prop}}-upload" />
    <input type="hidden" name="uploadPreviews[properties][{{$resource}}][{{$prop}}]" value="{{$prop}}">
    <input type="hidden" name="deleteProp" value="0">

    <a title="Remover Imagen" class="{{ $model->$prop ? '' : 'd-none' }} btn btn-danger image-preview-delete z-index-space" href="eliminar-imagen"><i class="fal fa-trash"></i></a>
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
                $('.image-preview-delete', $container).removeClass('d-none');
                $('input[name="deleteProp"]', $container).val(0);
            }
        });

        $('.image-preview-delete', $container).on('click', function (e) {
            e.preventDefault();
            $container.css('background-image', 'none');
            $('input[type="file"]', $container).val('');
            $(this).addClass('d-none');
            $('input[name="deleteProp"]', $container).val("{{$prop}}");
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
          background-color: #e8e8e8;
          color: #ecf0f1;
          background-size: cover;
          background-position: center center;
          cursor: pointer;
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

        #{{$prop}}-preview {
            height: {{ $height  }}px
        }
        #{{$prop}}-preview input {
            line-height: {{ $height  }}px;
        }
    </style>
@endpush