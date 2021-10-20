var Actions = (function () {
	var tpl = '\
            ${edit}\
            ${extraButtons}\
            ${delete}\
        ',
        editTpl = '<a data-id="${id}" href="${editRoute}" data-html="false" data-placement="top" data-original-title="Editar" rel="tooltip" class="edit btn btn-primary btn-sm btn-icon waves-effect waves-themed"><i class="fal fa-pencil"></i></a>',
        deleteTpl = '<a data-id="${id}" href="borrar" data-html="false" data-placement="top" data-original-title="Borrar" rel="tooltip" class="delete btn btn-danger btn-sm btn-icon waves-effect waves-themed"><i class="fal fa-trash"></i></a>',
        settings = {},
		defaults = {
			extraButtons: false,
			onDelete: onDelete,
			delete: true,
			edit: true
		}
	;

	var callbacks = {
		fnDrawCallback: function (oSettings) {
			//$('.btn[rel="tooltip"]').tooltip();
		}
	}

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters, ktSettings) {
		var response = tpl;

		if (settings.edit) {
			response = response.replace('${edit}', editTpl)
				.replace('${editRoute}', settings.editRoute || ktSettings.resource + '/' + row.id + '/edit')
			;
		} else {
			response = response.replace('${edit}', '');
		}

		if (settings.delete) {
			response = response.replace('${delete}', deleteTpl);
		} else {
			response = response.replace('${delete}', '');
		}

		response = response.replace(/\$\{id\}/g, row.id)

		if (settings.extraButtons) {
			response = response.replace('${extraButtons}', extraButtons(response, row, ktSettings));
		}

		//Events
		if (settings.delete && !Actions.applied) {
			$(ktSettings.selector).on('click', '.delete', function (e) {
				e.preventDefault();
				settings.onDelete(this, row, ktSettings);
			});
		}

		Actions.applied = true;

		return response.replace(/\$\{[a-zA-Z_-]+\}/g, '');
	}

	function showIf(button, row) {
		if (!!button.showIf) {
			if (typeof button.showIf === 'string') {
				try {
					response = eval(button.showIf);
				} catch {
					response = false;
				}
			}

			if (typeof button.showIf === 'function') {
				try {
					response = button.showIf(row);
				} catch {
					response = false;
				}
			}
		} else {
			response = true;
		}

		return response;
	}

	function extraButtons (tpl, row, ktSettings) {
		var button, value, i, attr, matches, response = '', regex = /\$\{row\.([a-zA-Z0-9_\.]+)\}/g;
        var anchor = '\
        	<a rel="tooltip" data-placement="top" data-original-title="${title}" class="${selector} btn btn-${class} btn-sm btn-icon waves-effect waves-themed" ${attr}>\
        		<i class="fal ${icon}"></i>\
        	</a>\
        ';
        for (i in settings.extraButtons) {
            button = settings.extraButtons[i];

            response += showIf(button, row) ? anchor : '';
            for (attr in button) {
                value = button[attr];
                if (attr == 'class' || attr == 'icon' || attr == 'title') {
                    response = response.replace('${'+attr+'}', value);
                } else {
                    response = response.replace('${attr}', attr+'="'+value+'" '+'${attr}');
                }
                response = response.replace('${selector}', slugify(button.title));
            }
            while ((matches = regex.exec(response)) !== null) {
                response = response.replace(matches[0], eval('row.' + matches[1]));
            }
            if (button.onPress && !Actions.applied) {
        		$(ktSettings.selector).on('click', '.'+slugify(button.title), function (e) {
        			e.preventDefault();
        			button.onPress(this, row);
        		});
            }
            response = response.replace(/\$\{[a-zA-Z_-]+\}/g, '');
        }
        return response;
	}

	//Eventos
	function onDelete (target, row, ktSettings) {
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

		var dialog = bootbox.confirm({
        	title: "Borrar",
            message: "¿Está seguro que desea borrar este elemento?",
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
		                type:'delete',
		                url: ktSettings.resource+'/'+row.id,
		                success: function (response) {
		                	$('.modal-header .fal', dialog).removeClass('fa-spinner fa-spin').addClass('fa-times');
		                	dialog.modal('hide');

		                    if (response.success) {
		                        $(target).parents('tr').fadeOut(
		                            500,
		                            function () {
		                                $(target).parents('tr').remove();
		                                if ($(ktSettings.selector + ' tbody tr').length == 0) {
		                                    KT.getDataTable().ajax.reload();
		                                }
		                            }
		                        );
		                    } else {
		                        toastr.error(response.error, "Error")
		                    }
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

	//Helpers
	function slugify (str) {
	    str = str.replace(/^\s+|\s+$/g, ''); // trim
	    str = str.toLowerCase();
	  
	    // remove accents, swap ñ for n, etc
	    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
	    var to   = "aaaaeeeeiiiioooouuuunc------";
	    for (var i=0, l=from.length ; i<l ; i++) {
	        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	    }

	    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
	        .replace(/\s+/g, '-') // collapse whitespace and replace by -
	        .replace(/-+/g, '-'); // collapse dashes

	    return str;
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters, settings);
		},
		getName: function () {
			return 'actions';
		},
		callbacks: callbacks,
	}
})()

KT.addFilter(Actions);