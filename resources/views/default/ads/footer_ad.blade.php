@if(Request::is(['*/login', '*/register', '*/forgot']))
@else
<div class="custom-footer-ad" style="width: 100%;margin: 0 auto;text-align: center;padding: 15px;background: white;">
	{!! setting('ads.footer_ad') !!}
</div>
@endif