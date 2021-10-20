var Label = (function () {

	function Wrapper (prop) {
	    this.prop = prop;
	    this.states = {};
	    this.setState = function (states) {
	        this.states = states;
	    }
	    this.render = function (index, row) {
	        var currentState = this.states[index];
	        var instace = this;
	        return '<span id="'+this.prop+row.id+'" data-id="'+row.id+'" data-estado="'+index+'" class="'+this.prop+' switch-state badge badge-'+currentState.label+'">'+currentState.value+'</span>'
	    }
	}

	var settings = {},
		defaults = {
			states: {
		        0:{label:'danger', value:'Oculto'},
		        1:{label:'success', value:'Visible'}
		    }
		}
	;

	function initializeSettings (parameters) {
		//filtro pasado como objeto
		if ($.isPlainObject(parameters)) {
			settings = $.extend( {}, defaults, parameters);
		} else {
			settings = defaults;
		}
	}

	function apply (row, prop, parameters, ktSetting) {
		var instace = new Wrapper(prop);
        instace.setState(settings.states);
        return instace.render(row[prop], row);
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters, settings);
		},
		getName: function () {
			return 'label';
		},
	}
})()

KT.addFilter(Label);