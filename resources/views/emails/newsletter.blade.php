<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ZURBemails</title>
<style type="text/css">
*,.collapse{padding:0}.btn,.social .soc-btn{text-align:center;font-weight:700}.btn,ul.sidebar li a{text-decoration:none;cursor:pointer}.container,table.footer-wrap{clear:both!important}*{margin:0;font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%}.content table,table.body-wrap,table.footer-wrap,table.head-wrap{width:100%}a{color:#2BA6CB}.btn{color:#FFF;background-color:#666;padding:10px 16px;margin-right:10px;display:inline-block}p.callout{padding:15px;background-color:#ECF8FF;margin-bottom:15px}.callout a{font-weight:700;color:#2BA6CB}table.social{background-color:#ebebeb}.social .soc-btn{padding:3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color:#FFF;display:block}a.fb{background-color:#3B5998!important}a.tw{background-color:#1daced!important}a.gp{background-color:#DB4A39!important}a.ms{background-color:#000!important}.sidebar .soc-btn{display:block;width:100%}.header.container table td.logo{padding:15px}.header.container table td.label{padding:15px 15px 15px 0}.footer-wrap .container td.content p{border-top:1px solid #d7d7d7;padding-top:15px;font-size:10px;font-weight:700}h1,h2{font-weight:200}h1,h2,h3,h4,h5,h6{font-family:HelveticaNeue-Light,"Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;line-height:1.1;margin-bottom:15px;color:#000}h1 small,h2 small,h3 small,h4 small,h5 small,h6 small{font-size:60%;color:#6f6f6f;line-height:0;text-transform:none}h1{font-size:44px}h2{font-size:37px}h3,h4{font-weight:500}h3{font-size:27px}h4{font-size:23px}h5,h6{font-weight:900}h5{font-size:17px}h6,p,ul{font-size:14px}h6{text-transform:uppercase;color:#444}.collapse{margin:0!important}p,ul{margin-bottom:10px;font-weight:400;line-height:1.6}p.lead{font-size:17px}p.last{margin-bottom:0}ul li{margin-left:5px;list-style-position:inside}ul.sidebar li,ul.sidebar li a{display:block;margin:0}ul.sidebar{background:#ebebeb;display:block;list-style-type:none}ul.sidebar li a{color:#666;padding:10px 16px;border-bottom:1px solid #777;border-top:1px solid #FFF}.column tr td,.content{padding:15px}ul.sidebar li a.last{border-bottom-width:0}ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p{margin-bottom:0!important}.container{display:block!important;max-width:600px!important;margin:0 auto!important}.content{max-width:600px;margin:0 auto;display:block}.column{width:300px;float:left}.column-wrap{padding:0!important;margin:0 auto;max-width:600px!important}.column table{width:100%}.social .column{width:280px;min-width:279px;float:left}.clear{display:block;clear:both}@media only screen and (max-width:600px){a[class=btn]{display:block!important;margin-bottom:10px!important;background-image:none!important;margin-right:0!important}div[class=column]{width:auto!important;float:none!important}table.social div[class=column]{width:auto!important}}a{cursor: pointer!important; text-decoration: none;}	
</style>
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table class="head-wrap" style="background-image: radial-gradient(#777, #444, #333);background-color: #666;">
	<tr>
		<td></td>
		<td class="header container" align="">
			<div class="content">
				<table >
					<tr>
						<td style="text-align: center;">
							<img src="{{ env('SITE_URL') }}/public/storage/{{ setting('site.logo')  }}" height="42" /> <br />
							<h3 style="margin: unset;">
								<a style="color: white;" href="">@lang('constants.WEBSITE_NAME')</a>
							</h3>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>
	</tr>
</table>
<table class="body-wrap" bgcolor="">
	<tr>
		<td></td>
		<td class="container" align="" bgcolor="#FFFFFF">
			<div class="content">
				<table>
					<tr>
						<td>
							<p class="lead" style="margin: unset;">
								<a style="margin: unset;padding: unset;color: #2ba6cb;" href="{{ env('SITE_URL') }}/blog/{{ $post->slug }}"> 
									{{ $post->title }} 
									<p><img src="{{ $post->image }}" /></p>
								</a>
							</p>
							<p style="color: black;">{{ str_limit($post->excerpt, 200) }}</p>
						</td>
					</tr>
				</table>
			</div>
			
			@foreach($news as $single_news)
			<div class="content">
				<table bgcolor="">
					<tr>
						<td style="padding: unset;margin: unset;">
							<h5>
								<a style="color: #2ba6cb;" href="{{ env('SITE_URL') }}/crypto-news/{{ $single_news->id }}/{{ $single_news->alias }}">
									{{ $single_news->title }}
								</a>
							</h5>
							<p style="color: black;">{{ str_limit($single_news->description, 100) }}</p>
						</td>
					</tr>
				</table>
			</div>
			@endforeach
			<div class="content">
				<table bgcolor="">
					<tr>
						<td>
							<table bgcolor="" class="social" width="100%">
								<tr>
									<td>
										<div class="column">
											<table bgcolor="" cellpadding="" align="left">
												<tr>
													<td>
														<h5 class="">Connect with us:</h5>
														<p class="">
															<a href="{{ setting('social.facebook') }}" class="soc-btn fb">Facebook</a> 
															<a href="{{ setting('social.twitter') }}" class="soc-btn tw">Twitter</a> 
														</p>														
													</td>
												</tr>
											</table>
										</div>
										<div class="column">
											<table bgcolor="" cellpadding="" align="left">
												<tr>
													<td>
														<h5 class="">Explore more</h5>	
														<p style="font-size: 15px;font-weight: bold;">
															<a href="{{ env('SITE_URL') }}/currencies">Coins Live Prices</a><br/>
															<a href="{{ env('SITE_URL') }}/crypto-coins-news-headlines">Today Latest News</a><br/>
															<a href="{{ env('SITE_URL') }}/buy-sell-cryptocoins">Buy / Sell Instantly</a>
														</p>
													</td>
												</tr>
											</table>
										</div>
										<div class="clear"></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			<div class="content">
				<table>
					<tr>
						<td align="center">
							<p>
								<a href="{{ env('SITE_URL') }}/page/terms-conditions">Terms</a> |
								<a href="{{ env('SITE_URL') }}/page/privacy-policy">Privacy</a> |
								<a href="{{ env('SITE_URL') }}/page/terms-conditions"><unsubscribe>Unsubscribe</unsubscribe></a>
							</p>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>