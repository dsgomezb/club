var Callback = (function () {
	var settings = {},
		defaults = {
			callback: function (row, prop, parameters) {
				return row[prop];
			}
		}
	;

	var callbacks = {}

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else if (parameters.indexOf(':') != -1) { //filtro pasado como texto
			settings = {
				callback: parameters.split(':')[1]
			}
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters) {
		return settings.callback(row, prop, parameters);
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters);
		},
		getName: function () {
			return 'callback';
		},
		callbacks: callbacks,
	}
})()

KT.addFilter(Callback);