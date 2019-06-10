@if(Request::is(['*/login', '*/register', '*/forgot']))
<br />
@else
<div class="custom-header-ad" style="width: 100%;margin: 0 auto;text-align: center;padding: 15px;">
	{!! setting('ads.header_ad') !!}
</div>
@endif