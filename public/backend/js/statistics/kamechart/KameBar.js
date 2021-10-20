var KameBar = (function () {
	function create(options) {
		var defualtColor = "#1dc9b7";
		var chart = null;

		if (checkDependencies()) {
			chart = new Chart(document.getElementById(options.id), {
                type: 'bar',
                data: {
                    labels: options.dataProvider.labels || [],
                    datasets: [{
                        label: options.label,
                        backgroundColor: options.color || defualtColor,
                        data: options.dataProvider.data || []
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: false
                    },
                    label: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: Math.max.apply(null, options.dataProvider.data)
                            }
                        }]
                    }
                }
            });
		}

		return chart;
	}

	function checkDependencies () {
		var valid = true;
		if (Chart === undefined) {
			console.error('KameBar hace uso de la librería chartjs.bundle.js. Es necesario incluirla antes de usar KameBar');
			valid = false;
		}
		return valid;
	}

	return {
		create: function (options) {
			return create(options)
		},
        getName: function () {
            return 'bar';
        },
	}
})();

KameChart.addChart(KameBar);