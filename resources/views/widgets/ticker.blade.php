<style type="text/css">
.ticker {width: 100%;}
table {width: 100%;}
thead tr {height: 40px;background-color: #<?php echo $_GET['hcolor'] ?? '232323'; ?>; color: #<?php echo $_GET['tcolor'] ?? 'fff'; ?>;}
td, th {padding: 5px;}
tbody td {text-align: left; vertical-align: middle;}
tbody tr td {border-top: 1px solid #ccc; }
span.image img {width: 32px;float: left;}
.small-text {font-size: 12px;padding: 5px;}
.left {text-align: left;}
.right{text-align: right;}
.trademark{text-align: center;border: 1px solid #ccc; border-radius:5px; padding: 10px;}
.trademark a {color: #<?php echo $_GET['hcolor'] ?? '232323'; ?>; text-decoration: none;"}
</style>


<div class="ticker">
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="left">Rank</th>
				<th class="left">Coin</th>
				<th class="right">Price</th>
				<th class="right">24h</th>
			</tr>
		</thead>
		<tbody>
			@foreach($markets as $market)
			<tr>
				<td> {{ $market->rank }} </td>
				<td>
					<span class="image">
						<img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ str_replace("/thumbs", "", $market->image) }}' />
					</span>
					<span style="padding: 5px;">{{ $market->name }} ({{ $market->symbol }})</span> <br />
					<span class="small-text">
						24h Vol: ${{ number_format($market->volume_usd_day/1000000000, 2) }} B
					</span>
				</td>
				<td class="right">
					@if($market->price_usd < 0.0999)
						${{ number_format($market->price_usd, 4) }}
					@else
						${{ number_format($market->price_usd, 3) }}
					@endif
					<br />
					<span class="small-text">
						{{ number_format($market->price_btc, 6) }} BTC
					</span>
				</td>
				<td class="right">
					@if($market->percent_change_day > 0)
						<span style="color: green;">{{ $market->percent_change_day }}% &uarr;</span>
					@else
						<span style="color: red;">{{ $market->percent_change_day }}% &darr;</span>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="small-text trademark">
		<a href="{{ URL::to('/') }}" target="_blank">Powered by @lang('constants.WEBSITE_NAME')</a>
	</div>
</div>
