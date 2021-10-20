var Image = (function () {
	var tpl = '\
			<span rel="tooltip" data-placement="top" data-original-title="<img width=\'120\' src=\'${path}\' class=\'online\'>" data-html="true">\
                 <img style="width:30px; border: solid 1px #ccc" src="${path}"\
            </span>\
		',
		settings = {},
		defaults = {
			src: 'imagen-no-disponible.jpg',
			path: false
		}
	;

	var callbacks = {
		fnDrawCallback: function (oSettings) {
			$('a[rel="tooltip"]').tooltip();
		}
	}

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else if (parameters.indexOf(':') != -1) { //filtro pasado como texto
			settings = {
				path: parameters.split(':')[1],
				src: defaults.src
			}
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters, ktSettigs) {
		try {
			var imagen = eval('row.' + prop);
		} catch {
			var imagen = settings.src;
		}
		var time = (new Date).getTime(), path;
		imagen = imagen || settings.src
        imagen += '?'+time;
        path = (settings.path) ? settings.path + imagen : '/content/' + ktSettigs.resource + '/thumb/' + imagen;
        return tpl.replace(/\$\{path\}/g, path);
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters, settings);
		},
		getName: function () {
			return 'image';
		},
		callbacks: callbacks,
	}
})()

KT.addFilter(Image);