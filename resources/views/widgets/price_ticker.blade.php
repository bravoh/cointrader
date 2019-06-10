<style type="text/css">
.ticker {width: 80%;border: 1px solid #ccc; border-radius: 5px;}
.header {background-color: #<?php echo $_GET['hcolor'] ?? '232323'; ?>;color: #<?php echo $_GET['tcolor'] ?? 'ffffff'; ?>;border-top-left-radius: 5px;border-top-right-radius: 5px;}
.inner{text-align: center;border-top: 1px solid #ccc;}
span.image img {width: 35px;float: left;}
.small-text {font-size: 12px;padding: 10px;}
.trademark{text-align: center;border-top: 1px solid #ccc; padding: 10px;}
.detail{padding: 8px;display: inline-block;text-align: center;width: 20%;height: 50px;vertical-align: middle;}
.border-right {border-right: 1px solid #ccc;}
.trademark a {color: #<?php echo $_GET['hcolor'] ?? '232323'; ?>; text-decoration: none;"}
</style>
<div class="ticker">
	<div class="header" style="padding: 10px;">
		<span class="image">
			<img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ str_replace("/thumbs", "", $market->image) }}' />
		</span>
		<span style="padding: 10px;">{{ $market->name }} ({{ $market->symbol }})</span> <br />
		<span class="small-text">
			24h Vol: 
			@if(number_format($market->volume_usd_day/1000000000, 2) > 0)
				${{ number_format($market->volume_usd_day/1000000000, 2) }} B
			@else
				${{ number_format($market->volume_usd_day) }} 
			@endif 
		</span>
	</div>
	<div class="inner">
		<span class="detail border-right">
			Rank <br />
			<span class="small-text">#{{ $market->rank }}</span>
		</span>
		<span class="detail border-right">
			Price <br />
			<span class="small-text">{{ formatHistoricalPrices($market->price_usd) }}</span>
		</span>
		<span class="detail border-right">
			Market Cap <br />
			<span class="small-text">
				@if(number_format($market->market_cap_usd/1000000000, 2) > 0)
					${{ number_format($market->market_cap_usd/1000000000, 2) }} B
				@else
					${{ $market->market_cap_usd}}
				@endif
			</span>
		</span>
		<span class="detail">
			24h Change <br />
			<span class="small-text">
				@if($market->percent_change_day > 0)
					<span style="color: green;">{{ $market->percent_change_day }}% &uarr;</span>
				@else
					<span style="color: red;">{{ $market->percent_change_day }}% &darr;</span>
				@endif
			</span>
		</span> 
	</div>
	<div class="small-text trademark">
		<a href="{{ URL::to('/') }}" target="_blank">Powered by @lang('constants.WEBSITE_NAME')</a>
	</div>
</div>
