var money = (function () {
	var settings = {},
		defaults = {
			params: {
				decimals: 2,
				dec_point: ',',
				thousands_point: '.',
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
				params: parameters.split(':')[1]
			}
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters) {
		var response = '';


		if (settings.params) {
			var params = settings.params;
			response = number_format(row[prop], params.decimals, params.dec_point, params.thousands_point);
		} else {
			response = number_format(row[prop]);
		}

		return '$' + response;
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters);
		},
		getName: function () {
			return 'money';
		},
		callbacks: callbacks,
	}
})()

KT.addFilter(money);