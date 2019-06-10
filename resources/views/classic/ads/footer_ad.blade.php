@if(Request::is(['*/login', '*/register', '*/forgot']))
@else
<div class="custom-footer-ad" style="width: 100%;margin: 0 auto;text-align: center;padding-bottom: 15px;">
	{!! setting('ads.footer_ad') !!}
</div>
@endif