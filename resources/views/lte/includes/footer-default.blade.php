<style type="text/css">.socialMedia-footer a{margin-right: 5px;}.donate-coin-addrs{word-wrap: break-word; cursor: pointer;}</style>
<div style="position: relative;z-index: 99999;background-color: white;text-align: center; padding: 20px;">
    <h4>@lang('constants.WEBSITE_NAME')</h4>
    <p>@lang('constants.WEBSITE_ABOUT')</p>
    <div class="footer-bottom-layout">
      <div class="footer-menu-items">
          <a href="{{ makeUrl('top-gainers-crypto-currencies') }}" class="">@lang('menu.TOP_GAINERS')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('crypto-ico/active') }}" class="">@lang('menu.ACTIVE_ICOS')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('crypto-ico/upcoming') }}" class="">@lang('menu.UPCOMING_ICOS')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('crypto-mining-equipment') }}" class="">@lang('menu.MINING_EQUIPMENT')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('blog') }}" class="">@lang('menu.BLOG')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('page/privacy-policy') }}" class="">@lang('menu.PRIVACY_POLICY')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('page/terms-conditions') }}" class="">@lang('menu.TERMS_CONDITIONS')</a> <i class="fa fa-angle-double-right fa-fw"></i>
          <a href="{{ makeUrl('page/frequently-asked-questions') }}" class="">@lang('menu.FAQS')</a>
      </div> <br />
      <div class="socialMedia-footer"> 
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
          @if(setting('social.google_plus') != 'N/A')
          <a href="{{ setting('social.google_plus') }}" target="_blank" class="gplus-ic">
            <img title="google plus" alt="google plus icon" src="{{ URL::asset('public/images/social_icons/google.png') }}">
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
            <img title="rss feed" alt="rss feed icon" src="{{ URL::asset('public/images/social_icons/rss_feed.png') }}">
          </a>
          @endif
      </div>
      @if(setting('site.donate') == 1)
          <h4 style="padding: unset;">Donate us - to let us keep good work</h4>
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
      <span class="google-play-icon">
        <a href="{{ setting('social.play_store') }}" target="_blank">
          <img alt="download cryptocurrency mobile app" title="download cryptocurrency mobile app" src="{{ URL::asset('public/images/google-play.png') }}" width="180" />
        </a>
      </span>
       @endif
      <div class="copyright-tag">@lang('menu.COPYRIGHT') © {{date("Y")}} @lang('constants.WEBSITE_NAME'). @lang('menu.ALL_RIGHTS').</div>
    </div>
</div>
