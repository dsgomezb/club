var KamePie = (function () {
	function create(options) {
		var defualtColor = "#DAB4B4";
		var chart = null;

		if (checkDependencies()) {
			chart = new Chart(options.id, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [],
                        backgroundColor: options.backgroundColor || ['#F7E3DA','#66BDCC','#DAB4B4','#473857','#7A94C7'],
                        label: options.label || 'Label 1'
                    }],
                    labels: []
                },
                options: {
                    responsive: true
                }
            });
		}

		return chart;
	}

	function checkDependencies () {
		var valid = true;
		if (Chart === undefined) {
			console.error('KamePie hace uso de la librería chartjs.bundle.js. Es necesario incluirla antes de usar KamePie');
			valid = false;
		}
		return valid;
	}

	return {
		create: function (options) {
			return create(options)
		},
        getName: function () {
            return 'pie';
        },
	}
})();

KameChart.addChart(KamePie);