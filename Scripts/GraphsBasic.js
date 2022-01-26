var DepartureAirportStatsRatings = new Highcharts.chart('DepartureAirportStatsRatings', {
    chart: {
        type: 'column',
	width: 960
    },
    title: {
        text: 'Airport Departure Stats and Ratings'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Flight Segments Flown'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Number of Segments: <b>{point.y:.0f}</b>'
    }
});

var AltitudeWeirdness = new Highcharts.chart('AltitudeWeirdness', {
    chart: {
        type: 'scatter',
	zoomType: 'xy',
	width: 960
    },
    title: {
        text: 'Airport Altitude vs. Rating'
    },
    xAxis: {
    },
    yAxis: {
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
	        pointFormat: 'Altitude: <b>{point.x:.0f} ft.</b><br>Rating: <b>{point.y:.2f}</b>'
            }
        }
    },
    legend: {
        enabled: false
    }
});
