(function () {
	$.fn.datepicker.dates['es'] = {
	    days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	    daysShort: ['do', 'lu', 'ma', 'mi', 'ju', 'vi', 'sá'],
	    daysMin: ['do', 'lu', 'ma', 'mi', 'ju', 'vi', 'sá'],
	    months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	    monthsShort: ['Ene','Feb','Mar','Abril','Mayo','Jun','Jul','Ago','Sept','Oct','Nov','Dic'],
	    today: "Hoy",
	    clear: "Borrar",
	    format: "dd-mm-yyyy",
	    titleFormat: "MM yyyy", //Leverages same syntax as 'format'
	    weekStart: 0
	};

    $('.datepicker').datepicker({
    	language: 'es'
    });

    if ($('[data-bind]').length) {
        var name, $this;
        $('[data-bind]').each(function () {
            $this = $(this);
            name = $(this).data('bind');
            $('label[for="'+$this.attr('name')+'"]').append($('<i></i>').attr('class', 'fal fa-spin fa-spinner').hide())
            $('[name="' + name + '"]').on('change', function () {
                addOptions($this, name, $(this).val());
            });
            addOptions($this, name, $('select[name="'+name+'"]').val());
        });
    }

    //Toggle
    $('[data-toggle-triger]').on('change', function () {
        var triger = $(this).data('toggle-triger');
        var prop = $(this).data('toggle-prop');
        toggle[prop]($(this), $('[data-toggle-target="'+triger+'"]'));
    });
    
    var toggle = {
        disabled: function ($triger, $target) {
            $target.attr('disabled', !$triger.is(':checked'));
        },
        visibility: function ($triger, $target) {
            if ($triger.is(':checked')) {
                $target.show();
            } else {
                $target.hide();
            }
        }
    }
    //------

    function addOptions ($select, name, value) {
        $.ajax({
            url: '/admin/form/toSelect',
            type: 'GET',
            data: {
                name: name,
                value: value,
            },
            success: function (response) {
                $select.empty(); // remove old options

                $select.append($("<option></option>").attr("value", 0).text('Seleccionar'));

                $(response).each(function() {
                  $select.append($("<option></option>")
                     .attr("value", this.val).text(this.text));
                });

                if (window.model) {
                    $('option[value="'+window.model.id+'"]', $select).prop('selected', true);
                }
            }
        });
    }

    $(document).ready(function() {
        //init default
        $('.wysiwyg').summernote({
            height: 200,
            tabsize: 2,
            dialogsFade: true,
            toolbar: [
                //['style', ['style']],
                //['font', ['strikethrough', 'superscript', 'subscript']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                //['fontsize', ['fontsize']],
                //['fontname', ['fontname']],
                //['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ['table', ['table']],
                //['insert', ['link', 'picture', 'video']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
        });
    });
})();