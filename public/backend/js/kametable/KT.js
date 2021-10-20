var KT = (function (w, $, undefined) {

    var dataTable, settings, defaults = {
        responsive: true,
        serverSide: true,
        language: dtLanguage
    }

    var filters = [];

    var callbacks = {
        fnDrawCallback: []
    };

    function create(selector, data) {
        data.selector = selector;
        options = generateOptions(data);
        settings = $.extend( {}, defaults, options);
        dataTable = $(selector).DataTable(settings);
    }

    function generateOptions(settings) {
        return {
            ajax: {
                url: settings.ajax || '/admin/'+settings.resource+'/json',
                data: function(d) {
                    if (settings.data) {
                        for (var i in settings.data)
                        d[i] = settings.data[i];
                    }
                }
            },
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['data'];
                });
            },
            fnDrawCallback: function(oSettings) {
                callbacks.fnDrawCallback.forEach(function (callback) {
                    callback(oSettings);
                });
            },
            aoColumns: getColumns(settings),
            columnDefs: generateColumns(settings),
        }
    }

    function getColumns (settings) {
        var result = [], column;
        for (var i in settings.columns) {
            if (typeof settings.columns[i] === 'string') {
                column = settings.columns[i].split('|', 1).join('');
            } else {
                column = settings.columns[i].column
            }
            result.push({mData: column});
        }
        return result;
    }

    function generateColumns(settings) {
        var result = [], column;

        for (var i=0, l=settings.columns.length; i<l; i++) {
            var item = {};
            column = settings.columns[i];
            item['targets'] = i;
            item['render'] = (function (column) {
                return function (d, type, row) {
                    if (typeof column === 'string' && (column.indexOf('|') == -1)) {
                        try {
                            response = eval('row.'+column);
                        } catch {
                            response = '';
                        }
                    } else {
                        response = applyFilter(column, row, settings);
                    }
                    return response;
                };
            })(column);
            result.push(item);
        }

        return result;
    }

    // title|limit:50

    function applyFilter(column, row, settings) {
        var options, filter;
        if (typeof column === 'string') {
            options = column.split('|');
            filter = (options[1].indexOf(':') != -1)?options[1].split(':')[0]:options[1];
        } else {
            options = [column.column, column.setting];
            filter = column.filter;
        }
        return filters[filter].apply(row, options[0], options[1], settings);
    }

    //TOGGLE
    function Toggle (prop) {
        this.prop = prop;
        this.render = function (row) {
            var checked = (row[this.prop]) ? 'checked' : '';
            return '\
                <div class="smart-form">\
                    <label class="toggle">\
                        <input id="'+this.prop+row.id+'" data-id="'+row.id+'" type="radio" name="radio-toggle" '+checked+'>\
                        <i data-swchon-text="SI" data-swchoff-text="NO"></i>\
                    </label>\
                </div>\
            ';
        }
        this.onChange = function(row) {
            var data = {}, instace = this, waiting = false;
            $('#datatable').off('change', '#'+instace.prop+row.id).on('change', '#'+instace.prop+row.id, function () {
                $this = $(this);
                if (!waiting) {
                    waiting = true;
                    data[prop] = $(this).is(':checked') * 1;
                    data['id'] = $this.data('id');
                    $.ajax({
                        type:'put',
                        url:settings.resource+'/'+$this.data('id'),
                        data:data,
                        success: function () {
                            waiting = false;
                        }
                    });
                }
            });
        }
    }
    //------

    return {
        create : function (selector, data) {
            create(selector, data);
        },
        addFilter: function (filter) {
            filters[filter.getName()] = filter;
            $.each(filter.callbacks, function (name, callback) {
                callbacks[name].push(callback);
            });
        },
        getDataTable: function () {
            return dataTable;
        }
    }
})(window, jQuery, undefined);
