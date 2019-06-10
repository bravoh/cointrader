function loadTradingPairs(val)
{
	var html = '';
	$.get(APP_URL + '/ajax-load-trading-paris/'+val, function(response) { 
        $.each(response, function(data){
        	html += '<tr>'+
        		'<td>'+response[data]['symbol']+'-'+response[data]['pair']+'</td><td>'+response[data]['volume24h_from']+'</td><td>'+response[data]['volume24h_to']+'</td>'
        	+'</tr>';
        });
        $('tbody.top-currencies-trading-paires').html(html);
    });
}

function loadHistoricalData()
{
    var coin = $('.top-trading-coins-histo :selected').val();
    var time_frame = $('.time-frame :selected').val();
    var currency = $('.top-currency-dropdown .item.selected').attr('rel');
    $.getJSON(APP_URL + '/ajax-load-historical-data/'+coin+'/'+time_frame+'/'+currency, function(res_data) {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("price-area-chart", am4charts.XYChart);
        chart.data = res_data;
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.dateX = "date";
        series.dataFields.valueY = "visits";
        series.tooltipText = "${valueY.value}";
        chart.cursor = new am4charts.XYCursor();
        series.fillOpacity = 0.5;
        series.fill = am4core.color("#00b5ad");
        series.stroke = am4core.color("#00b5ad");
    }); 
}
