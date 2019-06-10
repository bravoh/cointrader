@if(Request::is(['*/login', '*/register', '*/forgot']))
@else
<div class="custom-header-ad banner-wrapper" style="width: 100%;margin: 0 auto;text-align: center;padding-bottom: 15px;">
	{!! setting('ads.header_ad') !!}
</div>
@endif