<script src="{{ URL::asset('public/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('public/js/raphael/raphael.min.js') }}"></script>
<link href="{{ URL::asset('public/css/morris/morris.css') }}" rel="stylesheet">
<script src="{{ URL::asset('public/js/morrisjs/morris.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	cryptoDominanceDonut({!! $dominance_data !!});
});	
function cryptoDominanceDonut(response)
{
    $("#morris-donut-chart").html('');
    Morris.Donut({
        element: 'morris-donut-chart',
        data: response,
        resize: true
    });
}
</script>
<style type="text/css">
.trademark{text-align: center;border-top: 1px solid #ccc; padding: 10px;}
.trademark a {color: #3c8dbc; text-decoration: none;"}
</style>
<div class="ticker" style="border: 1px solid #ccc; border-radius: 5px;">
	<div id="morris-donut-chart"></div>
	<div class="small-text trademark">
		<a href="{{ URL::to('/') }}" target="_blank">Powered by @lang('constants.WEBSITE_NAME')</a>
	</div>
</div>