var KameChart = (function () {
	var charts = [];

	function create(chart, options) {
        return charts[chart].create(options);
    }

	return {
		addChart: function(chart) {
			charts[chart.getName()] = chart;
		},
		create: function(chart, options) {
			return create(chart, options)
		}
	}
})();