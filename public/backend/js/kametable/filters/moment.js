var Moment = (function () {
	var settings = {},
		defaults = {
			format: 'DD-MM-YYYY'
		}
	;

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else if (parameters.indexOf(':') != -1) { //filtro pasado como texto
			settings = {
				format: parameters.split(':')[1]
			}
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters) {
        var localTime = moment.utc(row[prop]).toDate();
        return moment(row[prop]).format(settings.format)
        //return moment(localTime).format(settings.format)
	}

	return {
		apply: function (row, prop, parameters, settings) {

			initializeSettings(parameters);
			return apply(row, prop, parameters);
		},
		getName: function () {
			return 'moment';
		}
	}
})()

KT.addFilter(Moment);