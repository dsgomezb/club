function Wrapper (prop) {
    this.addEvent = false;
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
    this.onChange = function(row, ktSetting) {
        var $this, estado_id, state, waiting = false, data = {}, instace = this;
        $(ktSetting.selector).on('click', '#'+this.prop+row.id, function () {
            $this = $(this);
            estado_id = instace.nextState($this.data('estado'));
            data[prop] = estado_id;
            data['id'] = $this.data('id');
            if (!waiting) {
                waiting = true;
                $.ajax({
                    type:'put',
                    url:'/admin/'+ktSetting.resource+'/'+$this.data('id'),
                    data:data,
                    success: function (object) {
                        $this.replaceWith(instace.render(estado_id, object));
                        waiting = false;
                    }
                });
            }
        });
    }
    this.nextState = function (index) {
        var indexes = [], i = 0, currentIndex, state;
        for (var key in this.states) {
            indexes.push(key);
            if (key == index) currentIndex = i;
            i++;
        }
        return (++currentIndex >= i)?indexes[0]:indexes[currentIndex];
    }
}

function nextState(index) {
    var indexes = [], i = 0, currentIndex, state;
    for (var key in stateSwitcher.states) {
        indexes.push(key);
        if (key == index) currentIndex = i;
        i++;
    }
    return (++currentIndex >= i)?indexes[0]:indexes[currentIndex];
}

var StateSwitcher = (function () {
	var settings = {},
		defaults = {
			states: {
		        0:{label:'danger', value:'Oculto'},
		        1:{label:'success', value:'Visible'}
		    }
		},
        instances = {}
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
        var instance;
        if (instances[prop+row.id]) {
            instance = instances[prop+row.id]
        } else {
            instance = new Wrapper(prop);
            instance.setState(settings.states);
            instance.onChange(row, ktSetting);
            instances[prop+row.id] = instance;
        }
        return instance.render(row[prop], row);
	}

	return {
		apply: function (row, prop, parameters, settings) {
			initializeSettings(parameters);
			return apply(row, prop, parameters, settings);
		},
		getName: function () {
			return 'stateSwitcher';
		},
	}
})()

KT.addFilter(StateSwitcher);