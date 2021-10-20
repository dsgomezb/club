var Limit = (function () {
	var tpl = '\
			<span rel="tooltip" data-placement="top" data-original-title="${text}" data-html="false">\
				${shortText}...\
			</span>\
		',
		settings = {},
		defaults = {
			length: 34
		}
	;

	var callbacks = {
		fnDrawCallback: function (oSettings) {
			if ($('span[rel="tooltip"]').length) $('span[rel="tooltip"]').tooltip();
		}
	}

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else if (parameters.indexOf(':') != -1) { //filtro pasado como texto
			settings = {
				length: parameters.split(':')[1]
			}
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters) {
		try {
			var response = eval('row.' + prop) + '';
		} catch {
			var response = '';
		}
		if (response.length > settings.length) {
			response = tpl.replace('${text}', response).replace('${shortText}', response.substring(0, settings.length));
		}
		return response;
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters);
		},
		getName: function () {
			return 'limit';
		},
		callbacks: callbacks,
	}
})()

KT.addFilter(Limit);