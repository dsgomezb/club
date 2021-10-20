var Tags = (function (w, $, undefined) {
	var target;

    function init (name) {
        target = $('select[name="'+name+'"]');
        initSelect();
        listeners();
    }

    function initSelect(){
    	target.select2({
            multiple: true,
            ajax:{
                url: "/admin/tags/autocomplete",
                dataType: 'json',
                delay: 150,
                data: function(params){
                    return {
                        term: params.term
                    };
                },
                processResults: function(data, params){
                    items = data;

                    if (!items.find(x => x.value == params.term)) {
                        // Si no existe una etiqueta == term agregar
                        // New tag
                        items.push({
                            id:params.term,
                            value:params.term,
                            newTag:true,
                        })
                    }

                    return {
                        results: items.map(function(item) {
                            return {
                                id : item.value,
                                value : item.value,
                                newTag : item.newTag || false,
                            }
                        })
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup){
                return markup;
            }, 
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
        });

        afterInit();
    }

    function afterInit(){
    	 // Append existing tags with id as value
        $.each(target.find("option"),function(i,el){
            $(el).remove()
            target.append(new Option(el.text, el.text, true, true)).trigger('change');
        })
    }

   	function listeners(){
   		// Cuando se repite un tag que ya esta cargado no lo elimino (por defecto lo elimina)
       target.on("select2:select",function(e){
           forceOpen();
           // console.log(e)

       })

        target.on("select2:unselecting", function (e) { 
            term = e.params.args.data.id;
            elem = e.params.args.data;
            if (!elem.element && (target.select2("data")).find(x => x.value == term || x.text == term)) {
                // forceOpen();
                return e.preventDefault();
            }
        });

        // target.on("change.select2",forceOpen)
   	}

    function forceOpen(){
        var select2SearchField = 
            target.parent().find('.select2-search__field'),
            setfocus = setTimeout(function() {
                    target.select2("close");
                    target.select2("open");
                    select2SearchField.focus();
            }, 100);
    }

   	function formatRepo(repo){
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository clearfix d-flex'>" +
            "<div class='select2-result-repository__meta'>"+
            "<div class='select2-result-repository__title fs-lg fw-500'>" + repo.value+ "<br></div>";
            if (repo.newTag) {
                markup += "<div class='select2-result-repository__forks mr-2'><small>Nueva etiqueta</small></div>";
            }
            markup += "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo){
        return repo.value || repo.text;
    }

    return {
        init : function (name="tags[]") {
            init(name);
        }
    }
})(window, jQuery, undefined);
