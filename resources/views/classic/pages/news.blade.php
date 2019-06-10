@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.NEWS_TITLE')@stop
@section('meta_desc')@lang('seo.NEWS_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/news.png' }}@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/style.css') }}">
@stop
@section('scripts') 
<script src="{{ URL::asset('public/news-page/assets/js/slick.min.js') }}"></script> 
<script src="{{ URL::asset('public/news-page/assets/js/custom.js') }}"></script>
@stop
@section('content')
<div class="news-wrapper">
  <div class="row">
    <div class="col-md-8">
      <div class="slick_slider">
        @foreach($crypto_news as $news)
        <div class="single_iteam"> 
          <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}"> 
            @if(file_exists('public/storage/' . $news['urlToImage']))
            <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
            @else
            <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}" style="min-height: 450px;"> 
            @endif
          </a>
          <div class="slider_article">
            <h2>
              <a class="slider_tittle" href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}">{{ $news['title'] }}</a>
            </h2>
            <p>{{ str_limit(strip_tags($news['description']), 150, '...') }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-md-4">
      <div class="latest_post ui segment" style="margin-bottom: 20px;">
        <div class="latest_post_container" style="padding: unset; height: unset; background:none;border-top:unset">
          <ul class="latest_postnav">
            <form action="{{ makeUrl('crypto-coins-news-search') }}" method="GET">
              <input class="form-control news-search-input" type="text" name="q" placeholder="Search news"> 
              <input class="btn btn-primary" type="submit" value="Search" style="width:100%;margin-top:5px">
            </form>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4" style="float: right;">
      <div class="latest_post ui segment">
        <div class="box box-success table-heading-class">
            <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                <h3 class="box-title">@lang('headings.LATEST_NEWS')</h3>
            </div>
        </div>
        <div class="latest_post_container" style="height: unset;">
          <ul class="latest_postnav">
            @foreach($ccn_news as $news)
            <li style="margin-bottom: 10px;">
              <div class="media"> 
                <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                  @if(file_exists('public/storage/' . $news['urlToImage']))
                  <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}">
                  @else
                  <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                  @endif
                </a>
                <div class="media-body"> 
                  <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title" > 
                    {{ str_limit(strip_tags($news['title']), 60, '...') }}
                  </a> <br /><span class="ui label" style="margin-top: 5px;">
                  <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("Y-m-d", $news['publishedAt']) }}</span>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="single_post_content ui segment" style="margin-top: 10px;">
          <div class="box box-success table-heading-class" style="box-shadow: unset;">
              <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                  <h3 class="box-title">@lang('headings.MOST_READ_NEWS')</h3>
              </div>
          </div>
          <div class="single_post_content_left" style="padding: 10px 0px 10px 10px;">
            <ul class="business_catgnav  wow fadeInDown">
              @if(isset($btc_magazine_news['0']))
              <li>
                <figure class="bsbig_fig"> 
                  <a href="{{ URL::to('/crypto-news') }}/{{$btc_magazine_news['0']['id']}}/{{$btc_magazine_news['0']['alias']}}" class="featured_img" style="overflow: hidden;"> 
                    @if(file_exists('public/storage/' . $btc_magazine_news['0']['urlToImage']))
                    <img alt="{{{ $btc_magazine_news['0']['title'] }}}" title="{{{ $btc_magazine_news['0']['title'] }}}" src="{{{ URL::asset('public/storage/' . $btc_magazine_news['0']['urlToImage']) }}}"> 
                    @else
                    <img alt="{{{ $btc_magazine_news['0']['title'] }}}" title="{{{ $btc_magazine_news['0']['title'] }}}" src="{{{ $btc_magazine_news['0']['urlToImage'] }}}"> 
                    @endif
                    <span class="overlay"></span> 
                  </a>
                  <h3 style="font-size: 18px; margin-top: 10px;"> 
                    <a href="{{ URL::to('/crypto-news') }}/{{$btc_magazine_news['0']['id']}}/{{$btc_magazine_news['0']['alias']}}">
                      {{ str_limit(strip_tags($btc_magazine_news['0']['title']), 50, '...') }}
                    </a> 
                  </h3>
                </figure>
              </li>
              @endif
            </ul>
          </div>
          <div class="single_post_content_right" style="padding: 10px 10px 10px 0px">
            <ul class="spost_nav">
              @foreach($news_btc_news as $news)
              <li style="margin-bottom: 5px;">
                <div class="media wow fadeInDown"> 
                  <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                    @if(file_exists('public/storage/' . $news['urlToImage']))
                    <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                    @else
                    <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                    @endif
                  </a>
                  <div class="media-body"> 
                    <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title" > 
                      {{ str_limit(strip_tags($news['title']), 50, '...') }}
                    </a> <br />
                    <span class="ui label" style="margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", $news['publishedAt']) }}</span>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        @include(getCurrentTemplate() . '.ads.news_page_horizontal_ad')
      </div>
      <div class="col-md-4 news-page-ad" style="margin-top: 10px;">
        <div class="single_sidebar wow fadeInDown">
          @include(getCurrentTemplate() . '.ads.news_ad')
        </div>
      </div>
      <div class="col-md-4">
        <div class="single_sidebar wow fadeInDown">
          @if(setting('videos.news_page_video') != '' && setting('videos.news_page_video') != 'novideo')
            <div class="news-page-video">
            @if(strpos(setting('videos.news_page_video'), 'youtube.com') !== false)
              <iframe src="{!! setting('videos.news_page_video') !!}" frameborder="0" allowfullscreen></iframe>
            @else
              <iframe src="https://player.vimeo.com/video/{!! setting('videos.news_page_video') !!}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              <script src="https://player.vimeo.com/api/player.js"></script>
            @endif
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="left_content">
          <div class="fashion_technology_area" style="margin-bottom: 20px;">
            <div class="fashion" style="background-color: white;">
              <div class="single_post_content ui segment">
                <div class="box box-success table-heading-class" style="box-shadow: unset;">
                    <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                        <h3 class="box-title">@lang('headings.RELATED_NEWS')</h3>
                    </div>
                </div>
                <ul class="business_catgnav wow fadeInDown" style="padding: 10px;">
                  @if(isset($magnates_news[0]))
                  <li>
                    <figure class="bsbig_fig"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$magnates_news[0]['id']}}/{{$magnates_news[0]['alias']}}" class="featured_img"> 
                        @if(file_exists('public/storage/' . $magnates_news[0]['urlToImage']))
                        <img alt="{{{ $magnates_news[0]['title'] }}}" title="{{{ $magnates_news['title'] }}}" src="{{{ URL::asset('public/storage/' . $magnates_news[0]['urlToImage']) }}}"> 
                        @else
                        <img alt="{{{ $magnates_news[0]['title'] }}}" title="{{{ $magnates_news[0]['title'] }}}" src="{{{ $magnates_news[0]['urlToImage'] }}}"> 
                        @endif
                        <span class="overlay"></span> 
                      </a>
                      <h3 style="font-size: 18px; margin-top: 10px;"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$magnates_news[0]['id']}}/{{$magnates_news[0]['alias']}}">
                          {{ str_limit(strip_tags($magnates_news[0]['title']), 58, '...') }}
                        </a> 
                      </h3>
                      <p>
                        {{ str_limit(strip_tags($magnates_news[0]['description']), 80, '...') }}
                      </p>
                    </figure>
                  </li>
                  @endif
                </ul>
                <ul class="spost_nav" style="padding: 10px;">
                  @foreach($coin_desk_news as $news)
                  <li style="margin-bottom: 5px;">
                    <div class="media wow fadeInDown"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                        @if(file_exists('public/storage/' . $news['urlToImage']))
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                        @else
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                        @endif
                      </a>
                      <div class="media-body"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title"> 
                          {{ str_limit(strip_tags($news['title']), 40, '...') }}
                        </a> <br />
                        <span class="ui label" style="margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", $news['publishedAt']) }}</span>
                      </div>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="technology">
              <div class="single_post_content ui segment">
                <div class="box box-success table-heading-class" style="box-shadow: unset;">
                    <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                        <h3 class="box-title">@lang('headings.FEATURED_NEWS')</h3>
                    </div>
                </div>
                <ul class="business_catgnav wow fadeInDown" style="padding: 10px;">
                  @if(isset($trust_nodes_news[0]))
                  <li>
                    <figure class="bsbig_fig"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="featured_img"> 
                        @if(file_exists('public/storage/' . $trust_nodes_news[0]['urlToImage']))
                        <img alt="{{{ $trust_nodes_news[0]['title'] }}}" title="{{{ $trust_nodes_news[0]['title'] }}}" src="{{{ URL::asset('public/storage/' . $trust_nodes_news[0]['urlToImage']) }}}"> 
                        @else
                        <img alt="{{{ $trust_nodes_news[0]['title'] }}}" title="{{{ $trust_nodes_news[0]['title'] }}}" src="{{{ $trust_nodes_news[0]['urlToImage'] }}}"> 
                        @endif
                        <span class="overlay"></span> 
                      </a>
                      <h3 style="font-size: 18px; margin-top: 10px;"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$trust_nodes_news[0]['id']}}/{{$trust_nodes_news[0]['alias']}}">
                          {{ str_limit(strip_tags($trust_nodes_news[0]['title']), 58, '...') }}
                        </a> 
                      </h3>
                      <p>
                        {{ str_limit(strip_tags($trust_nodes_news[0]['description']), 80, '...') }}
                      </p>
                    </figure>
                  </li>
                  @endif
                </ul>
                <ul class="spost_nav" style="padding: 10px;">
                  @foreach($coin_telegraph_news as $news)
                  <li style="margin-bottom: 5px;">
                    <div class="media wow fadeInDown"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                        @if(file_exists('public/storage/' . $news['urlToImage']))
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                        @else
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                        @endif
                      </a>
                      <div class="media-body"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title"> 
                          {{ str_limit(strip_tags($news['title']), 40, '...') }}
                        </a> <br />
                        <span class="ui label" style="margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", $news['publishedAt']) }}</span>
                      </div>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <div class="single_post_content ui segment">
            <div class="box box-success table-heading-class" style="box-shadow: unset;">
                <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h3 class="box-title">@lang('headings.TRENDING_NEWS')</h3>
                </div>
            </div>
            <div class="single_post_content_left" style="padding: 10px 0px 10px 10px;">
              <ul class="business_catgnav">
                @if(isset($live_btc_news[0]))
                <li>
                  <figure class="bsbig_fig"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$live_btc_news[0]['id']}}/{{$live_btc_news[0]['alias']}}" class="featured_img"> 
                        @if(file_exists('public/storage/' . $trust_nodes_news[0]['urlToImage']))
                        <img alt="{{{ $live_btc_news[0]['title'] }}}" title="{{{ $live_btc_news[0]['title'] }}}" src="{{{ URL::asset('public/storage/' . $live_btc_news[0]['urlToImage']) }}}"> 
                        @else
                        <img alt="{{{ $live_btc_news[0]['title'] }}}" title="{{{ $live_btc_news[0]['title'] }}}" src="{{{ $live_btc_news[0]['urlToImage'] }}}"> 
                        @endif
                        <span class="overlay"></span> 
                      </a>
                      <h3 style="font-size: 18px; margin-top: 10px;"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$live_btc_news[0]['id']}}/{{$live_btc_news[0]['alias']}}">
                          {{ str_limit(strip_tags($live_btc_news[0]['title']), 58, '...') }}
                        </a> 
                      </h3>
                    </figure>
                </li>
                @endif
              </ul>
            </div>
            <div class="single_post_content_right" style="padding: 10px 10px 10px 0px;">
              <ul class="spost_nav">
                @foreach($the_merkle_news as $news)
                  <li style="margin-bottom: 5px;">
                    <div class="media wow fadeInDown"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                        @if(file_exists('public/storage/' . $news['urlToImage']))
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                        @else
                        <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                        @endif
                      </a>
                      <div class="media-body"> 
                        <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title"> 
                          {{ str_limit(strip_tags($news['title']), 50, '...') }}
                        </a> <br />
                        <span class="ui label" style="margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", $news['publishedAt']) }}</span>
                      </div>
                    </div>
                  </li>
                  @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <aside class="right_content">
          <div class="single_sidebar ui segment">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h3 class="box-title">@lang('headings.TOP_STORIES')</h3>
                </div>
            </div>
            <div class="latest_post_container" style="height: 560px;">
              <ul class="spost_nav">
                @foreach($bitcoinist_news as $news)
                <li style="margin-bottom: 10px;">
                  <div class="media wow fadeInDown"> 
                    <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                      @if(file_exists('public/storage/' . $news['urlToImage']))
                      <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                      @else
                      <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                      @endif
                    </a>
                    <div class="media-body"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title">
                        {{ str_limit(strip_tags($news['title']), 60, '...') }}
                      </a> <br /><span class="ui label" style="margin-top: 5px;">
                      <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("Y-m-d H:i:s", $news['publishedAt']) }}</span>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="single_sidebar ui segment">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h3 class="box-title">@lang('headings.EDITORS_PICK')</h3>
                </div>
            </div>
            <div class="latest_post_container" style="height: 337px;">
              <ul class="spost_nav">
                @foreach($crypto_globe_news as $news)
                <li style="margin-bottom: 10px;">
                  <div class="media wow fadeInDown"> 
                    <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="media-left"> 
                      @if(file_exists('public/storage/' . $news['urlToImage']))
                      <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}"> 
                      @else
                      <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}"> 
                      @endif
                    </a>
                    <div class="media-body"> 
                      <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title">
                        {{ str_limit(strip_tags($news['title']), 60, '...') }}
                      </a> <br /><span class="ui label" style="margin-top: 5px;">
                      <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("Y-m-d H:i:s", $news['publishedAt']) }}</span>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="single_sidebar wow fadeInDown ui segment">
            <div class="box box-success table-heading-class" style="box-shadow: unset;">
                <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h3 class="box-title">@lang('menu.USEFUL_LINKS')</h3>
                </div>
            </div>
            <ul style="padding: 12px;">
              <li style="padding: 5px;"><a href="{{ makeUrl('archive-news') }}">@lang('menu.ARCHIVE_NEWS')</a></li>
              <li style="padding: 5px;"><a href="{{ makeUrl('currencies') }}">@lang('menu.COINS_LIVE_WATCH')</a></li>
              <li style="padding: 5px;"><a href="{{ makeUrl('cryptocurrency-converter') }}">@lang('menu.CONVERTER')</a></li>
              <li style="padding: 5px;"><a href="{{ makeUrl('cryptocurrency-widgets') }}">@lang('menu.WIDGETS')</a></li>
              <li style="padding: 5px;"><a href="{{ URL::to('sitemap') }}.xml">Sitemap</a></li>
            </ul>
          </div>
        </aside>
      </div>
    </div>
  </div>
  <br />
@stop
