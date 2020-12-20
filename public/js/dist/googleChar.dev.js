"use strict";

google.charts.load('current', {
  'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart(table, id) {
  var data = google.visualization.arrayToDataTable(table);
  var options = {
    title: 'Les statistiques du sondage numéro :  ' + id
  };
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}

function desplay() {
  var div = document.getElementById('piechart');
  div.style.display = true;
}

$.ajax({
  method: 'GET'
});