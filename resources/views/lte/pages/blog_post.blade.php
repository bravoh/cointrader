@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $post->title }}@stop
@section('meta_desc'){{ $post->meta_description }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/storage/' . $post->image) }}@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/style.css') }}">
<style type="text/css">
.coin-detail-social-buttons ul li{float: left;font-size: 25px; padding-left: 8px;}
.single_post_content_right{padding: 10px 10px 10px 0px;}
.single_post_content_left{padding: 10px 0px 10px 10px;}
.news-page-heading{line-height: 35px; font-size: 26px;}
.latest_post_container{padding: 10px; background-color: #fff;height: unset !important;}
.share-at-btn{float: left; padding: 2px;font-size: 20px;font-weight: 700;}
.hr{border: 1px solid #ccc;clear: both;}
.author a {color: white !important;}
.single_iteam img {height: 650px;}
.single-page-news li {width: 50%;}
.slider_articles img {width: 100%;height: auto;}
.slider_articles h2 {font-size: 24px; margin-bottom: 10px;margin-top: 10px;}
.slider_articles p, .slider_articles em, .slider_articles h2, .slider_articles strong, .slider_articles b {font-style: normal;}
@media only screen and (min-width: 1650px)  {
  .news-wrapper {
    width: 80%; margin: 0 auto;
  }
}
@media only screen and (max-width: 1650px)  {
  .news-wrapper {
    width: 100%; margin: 0 auto;
  }
}
iframe {width: 100%;height: auto;}
</style>
@stop
@section('scripts') 
<script src="{{ URL::asset('public/news-page/assets/js/slick.min.js') }}"></script> 
<script src="{{ URL::asset('public/news-page/assets/js/custom.js') }}"></script>
@stop
@section('content')
<div class="news-wrapper">
  <div class="row">
    <div class="col-lg-8">
    	<span class="badge bg-red btn"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ $post->created_at }} </span>
    	<h1 class="news-page-heading">
      	<a class="slider_tittle" href="{{ URL::to('/blog') }}/{{$post->slug}}">{{ $post->title }}</a>
    	</h1>
      @if(file_exists('public/storage/' . $post->image))
      <div class="slick_slider">
        <div class="single_iteam"> 
          <a href="{{ URL::to('/blog') }}/{{$post->slug}}">
            <img alt="{{$post->title}}" title="{{$post->title}}" src="{{URL::asset('public/storage/' . $post->image)}}"> 
          </a>
        </div>
      </div>
      @endif
      <div class="slider_articles">
        <p style="font-size: 16px;">{!! $post->body !!}</p>
      </div>
      <div>
	        <a target="_blank" href="{{$post->url}}">
				    <button type="button" class="btn btn-info">@lang('headings.READ_MORE')</button>
			    </a>
  		</div>
      <div class="share-at-btn">Share at: </div>
      <div class="coin-detail-social-buttons">
      	{!! Share::page(Request::url(), $post->title)->facebook()->twitter()->linkedin($post->meta_description) !!}
    	</div>
    </div>
    <div class="col-lg-4">
      <div class="latest_post">
        <div class="box box-success table-heading-class">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('headings.MOST_READ_NEWS')</h3>
            </div>
        </div>
        <div class="latest_post_container">
          <ul class="latest_postnav">
            @foreach($crypto_most_read_news as $news)
            <li style="margin-bottom: 10px;">
              <div class="media"> 
                <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="media-left"> 
                  @if(file_exists('public/storage/' . $news->urlToImage))
                  <img alt="{{$news->title}}" title="{{$news->title}}" src="{{URL::asset('public/storage/' . $news->urlToImage)}}"> 
                  @else
                  <img alt="{{$news->title}}" title="{{$news->title}}" src="{{$news->urlToImage}}"> 
                  @endif
                </a>
                <div class="media-body"> 
                  <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="catg_title" style="color: #3c8dbc;"> 
                    {{ str_limit(strip_tags($news->title), 45, '...') }}
                  </a> <br />
                  <span class="badge bg-green btn" style="border-radius: 10px; margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("Y-m-d", strtotime($news->publishedAt)) }}</span>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4" style="margin-top: 15px;">
      <div class="single_sidebar wow fadeInDown">
         @include(getCurrentTemplate() . '.ads.news_ad')
      </div>
    </div>
    <div class="col-md-8">
    	<div class="single_post_content" style="background-color: white; ">
          <div class="box box-success table-heading-class" style="box-shadow: unset;">
              <div class="box-header with-border">
                  <h3 class="box-title">@lang('headings.RELATED_NEWS')</h3>
              </div>
          </div>
            <ul class="spost_nav single-page-news">
              @foreach($crypto_related_news as $news)
              <li style="padding: 10px;">
                <div class="media wow fadeInDown"> 
                  <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="media-left"> 
                    @if(file_exists('public/storage/' . $news->urlToImage))
                    <img alt="{{$news->title}}" title="{{$news->title}}" src="{{URL::asset('public/storage/' . $news->urlToImage)}}"> 
                    @else
                    <img alt="{{$news->title}}" title="{{$news->title}}" src="{{$news->urlToImage}}"> 
                    @endif
                  </a>
                  <div class="media-body"> 
                    <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="catg_title" style="color: #3c8dbc;"> 
                      {{ str_limit(strip_tags($news->title), 50, '...') }}
                    </a> <br />
                    <span class="badge bg-green btn" style="border-radius: 10px; margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", strtotime($news->publishedAt)) }}</span>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
      </div>
    </div>
    @include('default.includes.disqus')
</div>
@stop
