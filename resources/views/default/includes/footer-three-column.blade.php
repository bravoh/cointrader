@include(getCurrentTemplate() . '.ads.footer_ad')
<div class="ui message newsletter" style="margin: unset;padding: unset;">
    <div class="ui center aligned basic segment newsletter-class">
        <div class="ui huge right pointing label">@lang('v6.NEWSLETTER')</div>
        <div class="ui action input">
            <input id="newsletter_email" type="text" placeholder="@lang('v6.ENTER_EMAIL')">
            <button onclick="saveNewsLetter()" class="btn btn-primary" style="border-radius: unset; border-top-right-radius: 3px;border-bottom-right-radius: 3px;">@lang('v6.SUBSCRIBE')</button> 
        </div>    
        <span class="newsletter-msg"></span>
    </div>
</div>
<div class="ui four item borderless menu footer-stats" style="padding-top: 0; padding-bottom: 0;">
    <div class="col-sm-3 border-right item"><i class="big dollar sign icon"></i>
        <div class="description-block">
            <div class="description-header top-bar-market-cap"><span></span></div>
            <span class="description-text">@lang('menu.MARKET_CAP')</span>
        </div>
    </div>
    <div class="col-sm-3 border-right item"><i class="big signal icon"></i>
        <div class="description-block">
            <div class="description-header top-bar-day-vol"><span></span></div>
            <span class="description-text">@lang('menu.24h_VOLUME')</span>
        </div>
    </div>
    <div class="col-sm-3 border-right item"><i class="big chart pie icon"></i>
        <div class="description-block">
            <div class="description-header">{{{ $global_data->bitcoin_percentage_of_market_cap or 0  }}}%</div>
            <span class="description-text">@lang('v6.BITCOIN_SHARE')</span>
        </div>
    </div>
    <div class="col-sm-3 item"><i class="big newspaper outline icon"></i>
        <a href="{{ makeUrl('archive-news') }}/{{ date('Y-m-d') }}" style="text-decoration: none;color: rgba(0,0,0,.87);">
            <div class="description-block">
                <div class="description-header">{{ $today_news }}</div><span class="description-text">@lang('v6.TODAY_NEWS')</span>
            </div>
        </a>
    </div>
</div>
<div class="ui segment keterangan disclaimer">
    <a href="{{ makeUrl('page/terms-conditions') }}" title="Read the Disclaimer" alt="Read the Disclaimer">
        <i class="exclamation triangle icon"></i> @lang('v6.DISCLAIMER')
    </a>: @lang('constants.WEBSITE_ABOUT2')
</div>
<style type="text/css">
footer.custom-footer {background-color: #222d32 !important;}
footer.custom-footer .container {padding: 5px;}
footer.custom-footer .social-icosn-wrapper {text-align: center;}
footer.custom-footer .container h6 {font-size: 18px;color: white;} 
footer.custom-footer .container .social-icons{font-size: 18px;padding-left: 15px;padding-right: 15px;margin-top: 10px;margin-bottom: 10px;}
footer.custom-footer .footer-inner p {color: white;}
footer.custom-footer .footer-inner a {color: #b8c7ce;}
footer.custom-footer .footer-inner a:hover {color: white;}
footer.custom-footer .footer-copyright {padding: 0px; border-top: 2px solid;}
footer.custom-footer .footer-copyright span{color: white;}
.custom-footer-wrapper {border-bottom: 2px solid #337ab7;}
footer.custom-footer .footer-copyright{border-color: #337ab7;}
.social-icosn-wrapper a{text-decoration: none !important;}
.donate-coin-addrs{word-wrap: break-word; cursor: pointer;}
footer.custom-footer .container .social-icons a {padding-left: 10px;color: white;}
@media (max-width: 767px) {
    footer.custom-footer .container .social-icons a {padding-left: 2px;}
}
</style>
<div style="position: relative;z-index: 999;">
    <footer class="page-footer font-small unique-color-dark pt-0 custom-footer">
        <div class="custom-footer-wrapper">
            <div class="container">
                <div class="row social-icosn-wrapper">
                    <div class="col-md-6">
                        <h6 style="margin-top: 13px;">@lang('menu.GET_SOCIAL_CONNECTED')</h6>
                    </div>
                    <div class="col-md-6 social-icons">
                        @if(setting('social.facebook') != 'N/A')
                            <a href="{{ setting('social.facebook') }}" target="_blank" class="fb-ic ml-0">
                              <img title="facebook" alt="facebook icon"  src="{{ URL::asset('public/images/social_icons/facebook.png') }}">
                            </a>
                            @endif
                            @if(setting('social.twitter') != 'N/A')
                            <a href="{{ setting('social.twitter') }}" target="_blank" class="tw-ic">
                              <img title="twitter" alt="twitter icon" src="{{ URL::asset('public/images/social_icons/twitter.png') }}">
                            </a>
                            @endif
                            @if(setting('social.telegram') != 'N/A')
                            <a href="{{ setting('social.telegram') }}" target="_blank" class="li-ic">
                              <img title="telegram" alt="telegram icon" src="{{ URL::asset('public/images/social_icons/telegram.png') }}">
                            </a>
                            @endif
                            @if(setting('social.linkedin') != 'N/A')
                            <a href="{{ setting('social.linkedin') }}" target="_blank" class="ins-ic">
                              <img title="linkedin" alt="linkedin icon" src="{{ URL::asset('public/images/social_icons/linkedin.png') }}">
                            </a>
                            @endif
                            @if(setting('social.instagram') != 'N/A')
                            <a href="{{ setting('social.instagram') }}" target="_blank" class="ins-ic">
                              <img title="instagram" alt="instagram icon" src="{{ URL::asset('public/images/social_icons/instagram.png') }}">
                            </a>
                            @endif
                            @if(setting('social.reddit') != 'N/A')
                            <a href="{{ setting('social.reddit') }}" target="_blank" class="ins-ic">
                                <img title="reddit" alt="reddit icon" src="{{ URL::asset('public/images/social_icons/reddit.png') }}">
                            </a>
                            @endif
                            @if(setting('social.vk') != 'N/A')
                            <a href="{{ setting('social.vk') }}" target="_blank" class="ins-ic">
                              <img title="vk" alt="vk icon" src="{{ URL::asset('public/images/social_icons/vk.png') }}">
                            </a>
                            @endif
                            @if(setting('social.youtube') != 'N/A')
                            <a href="{{ setting('social.youtube') }}" target="_blank" class="ins-ic">
                              <img title="youtube" alt="youtube icon" src="{{ URL::asset('public/images/social_icons/youtube.png') }}">
                            </a>
                            @endif
                            @if(setting('social.rss_feed') != 'N/A')
                            <a href="{{ setting('social.rss_feed') }}" target="_blank" class="ins-ic">
                                <img title="rss" alt="rss icon" src="{{ URL::asset('public/images/social_icons/rss_feed.png') }}">
                            </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5 mb-4 text-center text-md-left footer-inner">
            <div class="row mt-3">
                <div class="col-md-6">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>@lang('constants.WEBSITE_NAME')</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p style="text-align: justify;">@lang('constants.WEBSITE_ABOUT')</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>@lang('menu.COINS')</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="{{ makeUrl('currencies') }}">@lang('menu.COINS_LIVE_WATCH')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('top-gainers-crypto-currencies') }}">@lang('menu.TOP_GAINERS')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('top-losers-crypto-currencies') }}">@lang('menu.TOP_LOSERS')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('high-low-crypto-currencies') }}">@lang('menu.HIGH_LOW_COINS')</a>
                    </p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>@lang('menu.USEFUL_LINKS')</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="{{ makeUrl('crypto-ico/active') }}">@lang('menu.ACTIVE_ICOS')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('cryptocurrency-converter') }}">@lang('menu.CONVERTER')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('user/blockfolio') }}">@lang('user.USER_BLOCKFOLIO')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('buy-sell-cryptocoins') }}">@lang('menu.BUY_SELL')</a>
                    </p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>@lang('menu.MORE')</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="{{ makeUrl('page/terms-conditions') }}">@lang('menu.TERMS_CONDITIONS')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('page/privacy-policy') }}">@lang('menu.PRIVACY_POLICY')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('contact-us') }}">@lang('v7.CONTACT_US')</a>
                    </p>
                    <p>
                        <a href="{{ makeUrl('page/frequently-asked-questions') }}">@lang('menu.FAQS')</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-copyright py-3 text-center">
            @if(setting('site.donate') == 1)
                <h4 style="padding: unset;color: white;">@lang('constants.DONATE_CRYPTO')</h4>
                @foreach($donate_coins as $coin)
                 <span>
                  <strong>{{ $coin->coin }}:&nbsp;</strong>
                  <a class="donate-coin-addrs" addr="{{ $coin->address }}" name="{{ $coin->coin }}" data-toggle="modal" data-target="#myModal">
                    {{ $coin->address }}
                  </a>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                </span>
                @endforeach
                <br />
            @endif
            @if(setting('social.play_store') != 'N/A')
            <a href="{{ setting('social.play_store') }}" target="_blank">
                <img alt="download cryptocurrency mobile app" title="download cryptocurrency mobile app" src="{{ URL::asset('public/images/google-play.png') }}" width="165">
            </a>
            <br />
            @endif
            <span>@lang('menu.COPYRIGHT') © {{date("Y")}} @lang('constants.WEBSITE_NAME'). @lang('menu.ALL_RIGHTS').</span>
        </div>
    </footer>                   
</div>
