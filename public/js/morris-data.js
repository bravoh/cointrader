function cryptoDominanceDonut(response)
{
    $("#morris-donut-chart").html(''); //reset
    Morris.Donut({
        element: 'morris-donut-chart',
        data: response,
        resize: true,
        backgroundColor: '#fff',
		  labelColor: '#000000',
		  colors: [
		    '#00b5ad',
		  ]
    });
}
