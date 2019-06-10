<div class="ui message newsletter" style="margin: unset;padding: unset;">
    <div class="ui center aligned basic segment">
        <div class="ui huge right pointing label">@lang('v6.NEWSLETTER')</div>
        <div class="ui action input">
            <input id="newsletter_email" type="text" placeholder="@lang('v6.ENTER_EMAIL')">
            <button onclick="saveNewsLetter()" class="ui large teal button">@lang('v6.SUBSCRIBE')</button> 
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
            <div class="description-header">{{{ $global_data->bitcoin_percentage_of_market_cap or 0 }}}%</div>
            <span class="description-text">@lang('v6.BITCOIN_SHARE')</span>
        </div>
    </div>
    <div class="col-sm-3 item"><i class="big newspaper outline icon"></i>
        <a href="{{ makeUrl('archive-news') }}/{{ date('Y-m-d') }}" style="text-decoration: none;color: rgba(0,0,0,.87);line-height: 1;">
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
<div class="ui segment">
    <footer class="page-footer font-small unique-color-dark pt-0 custom-footer">
        <div class="mt-5 mb-4 text-justify text-md-left footer-inner">
            <div class="row mt-3">
                <div class="col-md-6">
                    <h5 class="text-uppercase font-weight-bold"><strong>@lang('constants.WEBSITE_NAME')</strong></h5>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="margin:5px 0">
                    <p>@lang('constants.WEBSITE_ABOUT')</p>
                </div>
                <div class="col-md-2">
                    <h5 class="text-uppercase font-weight-bold"><strong>@lang('menu.COINS')</strong></h5>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="margin:5px 0">
                    <p><a title="@lang('menu.COINS_LIVE_WATCH')" href="{{ makeUrl('currencies') }}">@lang('menu.COINS_LIVE_WATCH')</a></p>
                    <p><a title="@lang('menu.TOP_GAINERS')" href="{{ makeUrl('top-gainers-crypto-currencies') }}">@lang('menu.TOP_GAINERS')</a></p>
                    <p><a title="@lang('menu.TOP_LOSERS')" href="{{ makeUrl('top-losers-crypto-currencies') }}">@lang('menu.TOP_LOSERS')</a></p>
                    <p>
                        <a href="{{ makeUrl('high-low-crypto-currencies') }}">@lang('menu.HIGH_LOW_COINS')</a>
                    </p>
                </div>
                <div class="col-md-2">
                    <h5 class="text-uppercase font-weight-bold"><strong>@lang('menu.USEFUL_LINKS')</strong></h5>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="margin:5px 0">
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
                    <h5 class="text-uppercase font-weight-bold"><strong>@lang('menu.MORE')</strong></h5>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="margin:5px 0">
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
        <div class="footer-copyright py-3 text-center"> @if(setting('site.donate') == 1)
            <h6 class="support">@lang('v7.SUPPORT') {{ setting('site.site_name') }}</h6>
            <p style="border-bottom: 1px solid #ddd;margin-bottom: 10px;"> @foreach($donate_coins as $coin) <span><strong>{{ $coin->coin }}:&nbsp;</strong><a class="donate-coin-addrs" addr="{{ $coin->address }}" name="{{ $coin->coin }}" data-toggle="modal" data-target="#myModal"> {{ $coin->address }} </a> &nbsp;&nbsp;&nbsp;&nbsp; </span> @endforeach </p> @endif @if(setting('social.play_store') != 'N/A') @endif
            <div class="row social-icosn-wrapper text-center">
                <div class="social-icons"> 
                    @if(setting('social.facebook') != 'N/A') 
                        <a href="{{ setting('social.facebook') }}" target="_blank" class="fb-ic ml-0"><i class="facebook square big icon"></i></a> 
                    @endif 
                    @if(setting('social.twitter') != 'N/A') 
                        <a href="{{ setting('social.twitter') }}" target="_blank" class="tw-ic"><i class="twitter square big icon"></i></a> 
                    @endif 
                    @if(setting('social.telegram') != 'N/A') 
                        <a href="{{ setting('social.telegram') }}" target="_blank" class="li-ic"><i class="telegram big icon"></i></a> 
                    @endif 
                    @if(setting('social.linkedin') != 'N/A')
                        <a href="{{ setting('social.linkedin') }}" target="_blank" class="ins-ic"><i class="linkedin square big icon"></i></a> 
                    @endif 
                    @if(setting('social.instagram') != 'N/A')
                        <a href="{{ setting('social.instagram') }}" target="_blank" class="ins-ic"><i class="instagram square big icon"></i></a> 
                    @endif 
                    @if(setting('social.reddit') != 'N/A')
                        <a href="{{ setting('social.reddit') }}" target="_blank" class="ins-ic"><i class="reddit square big icon"></i></a> 
                    @endif 
                    @if(setting('social.vk') != 'N/A')
                        <a href="{{ setting('social.vk') }}" target="_blank" class="ins-ic"><i class="vk square big icon"></i></a> 
                    @endif 
                    @if(setting('social.youtube') != 'N/A')
                        <a href="{{ setting('social.youtube') }}" target="_blank" class="ins-ic"><i class="youtube square big icon"></i></a> 
                    @endif 
                    @if(setting('social.rss_feed') != 'N/A') 
                        <a href="{{ setting('social.rss_feed') }}" target="_blank" class="ins-ic"><i class="rss square big icon"></i></a> 
                        @endif 
                </div>
            </div>
            @if(setting('social.play_store') != 'N/A')
            <a href="{{ setting('social.play_store') }}" target="_blank" style="text-decoration: none;">
                <img alt="download cryptocurrency mobile app" title="download cryptocurrency mobile app" src="{{ URL::asset('public/images/google-play.png') }}" width="165">
            </a>
            <br />
            @endif
            <span>@lang('menu.COPYRIGHT') © {{date("Y")}} @lang('constants.WEBSITE_NAME'). @lang('menu.ALL_RIGHTS').</span></div>
    </footer>
</div>