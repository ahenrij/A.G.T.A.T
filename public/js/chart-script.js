/*
 * Trending line chart
 */
//var randomScalingFactor = function(){ return Math.round(Math.random()*10)};
var trendingLineChart;
var stats = $('#stats_badges').children();
var stats_macarons = $('#stats_macarons').children();
var nombre_badges = $('#nombre_badges').html();
var nombre_macarons = $('#nombre_macarons').html();

var data = {
  labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
  datasets: [
    {
      label: "Vente des badges",
      fillColor: "rgba(173, 20, 87, 0.9)",
      strokeColor: "#e0e0e0",
      pointColor: "#1976d2",
      pointStrokeColor: "#1976d2",
      pointHighlightFill: "#e0e0e0",
      pointHighlightStroke: "#e0e0e0",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    },
    {
      label: "Vente des macarons",
      fillColor: "rgba(38, 198, 218, 0.3)",
      strokeColor: "#e0e0e0",
      pointColor: "white",
      pointStrokeColor: "#80deea",
      pointHighlightFill: "#80deea",
      pointHighlightStroke: "#80deea",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    }
  ]
};

//
window.setInterval(function () {
  // Get a random index point
  var stats = $('#stats_badges').children();
  var stats_macarons = $('#stats_macarons').children();

  for (var i = 0; i < stats.length; i++) {
    var indexToUpdate = parseInt(parseInt(stats[i].id) - 1);

    // console.log(trendingLineChart);

    if (typeof trendingLineChart != "undefined") {
      // Update one of the points in the second dataset

      trendingLineChart.datasets[0].points[indexToUpdate].value = parseInt(stats[i].innerHTML);
      trendingLineChart.update();
    }
  }

  for (var i = 0; i < stats_macarons.length; i++) {
    var indexToUpdate = parseInt(parseInt(stats_macarons[i].id) - 1);

    // console.log(trendingLineChart);

    if (typeof trendingLineChart != "undefined") {
      // Update one of the points in the second dataset

      trendingLineChart.datasets[1].points[indexToUpdate].value = parseInt(stats_macarons[i].innerHTML);
      trendingLineChart.update();
    }
  }

}, 1);

/*
 Polor Chart Widget
 */

var doughnutData = [
  {
    value: nombre_badges,
    color: "#F7464A",
    highlight: "#FF5A5E",
    label: "Badges"
  },
  {
    value: nombre_macarons,
    color: "#46BFBD",
    highlight: "#5AD3D1",
    label: "Macarons"
  }
];


window.onload = function () {

  console.log(typeof document.getElementById("trending-line-chart"))

  if (typeof document.getElementById("trending-line-chart") !== "undefined") {
    var trendingLineChart = document.getElementById("trending-line-chart").getContext("2d");
    window.trendingLineChart = new Chart(trendingLineChart).Line(data, {
      scaleShowGridLines: true,///Boolean - Whether grid lines are shown across the chart
      scaleGridLineColor: "#d0d0d0",//String - Colour of the grid lines
      scaleGridLineWidth: 1,//Number - Width of the grid lines
      scaleShowHorizontalLines: true,//Boolean - Whether to show horizontal lines (except X axis)
      scaleShowVerticalLines: false,//Boolean - Whether to show vertical lines (except Y axis)
      bezierCurve: true,//Boolean - Whether the line is curved between points
      bezierCurveTension: 0.4,//Number - Tension of the bezier curve between points
      pointDot: true,//Boolean - Whether to show a dot for each point
      pointDotRadius: 3,//Number - Radius of each point dot in pixels
      pointDotStrokeWidth: 2,//Number - Pixel width of point dot stroke
      pointHitDetectionRadius: 20,//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      datasetStroke: true,//Boolean - Whether to show a stroke for datasets
      datasetStrokeWidth: 3,//Number - Pixel width of dataset stroke
      datasetFill: true,//Boolean - Whether to fill the dataset with a colour
      animationSteps: 15,// Number - Number of animation steps
      animationEasing: "easeOutQuart",// String - Animation easing effect
      tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",// String - Tooltip title font declaration for the scale label
      scaleFontSize: 12,// Number - Scale label font size in pixels
      scaleFontStyle: "normal",// String - Scale label font weight style
      scaleFontColor: "#9e9e9e",// String - Scale label font colour
      tooltipEvents: ["mousemove", "touchstart", "touchmove"],// Array - Array of string names to attach tooltip events
      tooltipFillColor: "rgba(255,255,255,0.8)",// String - Tooltip background colour
      tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",// String - Tooltip title font declaration for the scale label
      tooltipFontSize: 12,// Number - Tooltip label font size in pixels
      tooltipFontColor: "#000",// String - Tooltip label font colour
      tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",// String - Tooltip title font declaration for the scale label
      tooltipTitleFontSize: 14,// Number - Tooltip title font size in pixels
      tooltipTitleFontStyle: "bold",// String - Tooltip title font weight style
      tooltipTitleFontColor: "#000",// String - Tooltip title font colour
      tooltipYPadding: 8,// Number - pixel width of padding around tooltip text
      tooltipXPadding: 16,// Number - pixel width of padding around tooltip text
      tooltipCaretSize: 10,// Number - Size of the caret on the tooltip
      tooltipCornerRadius: 6,// Number - Pixel radius of the tooltip border
      tooltipXOffset: 10,// Number - Pixel offset from point x to tooltip edge
      responsive: true
    });
  }


  var doughnutChart = document.getElementById("doughnut-chart").getContext("2d");
  window.myDoughnut = new Chart(doughnutChart).Doughnut(doughnutData, {
    segmentStrokeColor: "#fff",
    tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",// String - Tooltip title font declaration for the scale label
    percentageInnerCutout: 50,
    animationSteps: 15,
    segmentStrokeWidth: 4,
    animateScale: true,
    percentageInnerCutout: 60,
    responsive: true
  });


  if (typeof getContext != "undefined") {
    var polarChartCountry = document.getElementById("polar-chart-country").getContext("2d");
    window.polarChartCountry = new Chart(polarChartCountry).PolarArea(polarData, {
      segmentStrokeWidth: 1,
      responsive: true
    });
  }
};
