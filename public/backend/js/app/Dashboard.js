var Dashboard = (function (w, $, undefined) {

    var charts = {};

    function init () {
        createCharts({
            'users': {
                label: 'Nuevos Usuarios',
                id: 'usersChart',
                dataProvider: [],
                type: 'bar'
            },
            /*
            'bestSellers' : {
                id: 'bestSellersChart',
                type: 'pie'
            },
            'unpopulars' : {
                id: 'unpopularsChart',
                type: 'pie'
            },
            'client' : {
                id: 'clientChart',
                type: 'pie'
            },
            'clientPurchases' : {
                id: 'clientPurchasesChart',
                type: 'pie'
            }
            */
        });

        chartsInit();

        listeners();

        $('#left-panel li[data-nav="dashboard"]').addClass('active');
    }

    function listeners () {
        $('.period-selector').on('change', function () {
            var chart = $(this).data('chart');
            getData(chart, $(this).val());
        });
    }

    function getData(chart, period) {
        $.ajax({
            url: '/admin/statistics/' + chart,
            type: 'get',
            data: {period: period || 1},
            success: function (data) {
                updateGraph(charts[chart], data);
            }
        });
    }

    function createCharts(options) {
        var defualtColor = "#1dc9b7";

        for (var i in options) {
            charts[i] = KameChart.create(options[i].type, options[i])
        }
    }

    function updateGraph (chart, dataProvider) {
        var type = chart.config.type;
        var updaters = {'bar' : 'updateBarChar', 'pie': 'updatePieChar'};
        eval(updaters[type]+'(chart, dataProvider)');
    }

    function updateBarChar(chart, dataProvider) {
        chart.data.datasets[0].data = dataProvider.data;
        chart.data.labels = dataProvider.labels;

        var max = Math.max.apply(null, dataProvider.data);
        var sum = dataProvider.data.length ? dataProvider.data.reduce(function(a, b) { return a*1 + b*1; }) : 0;
        var avg = sum / dataProvider.data.length * 0.1;
        var final = Math.ceil((max + avg)/100)*100

        chart.options.scales.yAxes[0].ticks.max = final;
        chart.update();
    }

    function updatePieChar(chart, dataProvider) {
        chart.data.datasets[0].data = dataProvider.map( item => item.sumatoria );
        chart.data.labels = dataProvider.map( item => item.name );
        chart.update();
    }

    function chartsInit () {
        for (var chart in charts) {
            getData(chart)
        }
    }

    return {
        init : function () {
            init();
        }
    }
})(window, jQuery, undefined);

$(document).ready(function () {
    Dashboard.init();
});
