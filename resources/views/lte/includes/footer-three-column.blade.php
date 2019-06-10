<style type="text/css">
footer.custom-footer {background-color: #222d32 !important;}
footer.custom-footer .container {padding: 5px;}
footer.custom-footer .social-icosn-wrapper {text-align: center;}
footer.custom-footer .container h6 {font-size: 18px;color: white;} 
footer.custom-footer .container .social-icons{font-size: 18px;padding-left: 15px;padding-right: 15px;margin-top: 10px;margin-bottom: 10px;}
footer.custom-footer .container .social-icons a {padding-left: 12px;color: white;}
footer.custom-footer .footer-inner p {color: white;}
footer.custom-footer .footer-inner a {color: #b8c7ce;}
footer.custom-footer .footer-inner a:hover {color: white;}
footer.custom-footer .footer-copyright {padding: 0px; border-top: 2px solid;}
footer.custom-footer .footer-copyright span{color: white;}
.donate-coin-addrs{word-wrap: break-word; cursor: pointer;}
</style>
<div style="position: relative;z-index: 99999;">
    <div class="ui message newsletter" @if(Request::is(['*/dashboard'])) style="margin: 15px;border-radius: unset;border: unset;" @else style="margin: unset;border-radius: unset;border: unset;"  @endif>
        <div class="ui center aligned basic segment">
            <div class="ui huge right pointing label">@lang('v6.NEWSLETTER')</div>
            <div class="ui action input">
                <input id="newsletter_email" type="text" placeholder="@lang('v6.ENTER_EMAIL')">
                <button onclick="saveNewsLetter()" class="ui large teal button custom-footer-wrapper">@lang('v6.SUBSCRIBE')</button> 
            </div>    
            <span class="newsletter-msg"></span>
        </div>
    </div>
    <div class="ui segment keterangan disclaimer" style="margin: unset;border: unset;border-radius: unset;">
        <a href="{{ makeUrl('page/terms-conditions') }}" title="Read the Disclaimer" alt="Read the Disclaimer">
            <i class="exclamation triangle icon"></i> @lang('v6.DISCLAIMER')
        </a>: @lang('constants.WEBSITE_ABOUT2')
    </div>
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
                            <i class="fa fa-facebook white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.twitter') != 'N/A')
                        <a href="{{ setting('social.twitter') }}" target="_blank" class="tw-ic">
                            <i class="fa fa-twitter white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.telegram') != 'N/A')
                        <a href="{{ setting('social.telegram') }}" target="_blank" class="li-ic">
                            <i class="fa fa-telegram white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.linkedin') != 'N/A')
                        <a href="{{ setting('social.linkedin') }}" target="_blank" class="ins-ic">
                            <i class="fa fa-linkedin white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.instagram') != 'N/A')
                        <a href="{{ setting('social.instagram') }}" target="_blank" class="ins-ic">
                            <i class="fa fa-instagram white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.reddit') != 'N/A')
                        <a href="{{ setting('social.reddit') }}" target="_blank" class="ins-ic">
                            <i class="fa fa-reddit white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.vk') != 'N/A')
                        <a href="{{ setting('social.vk') }}" target="_blank" class="ins-ic">
                            <i class="fa fa-vk white-text mr-lg-4"> </i>
                        </a>
                        @endif
                        @if(setting('social.rss_feed') != 'N/A')
                        <a href="{{ setting('social.rss_feed') }}" target="_blank" class="ins-ic">
                            <i class="fa fa-rss white-text mr-lg-4"> </i>
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
