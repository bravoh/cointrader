@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $crypto_news->title }}@stop
@section('meta_desc'){{ str_limit(strip_tags($crypto_news->description), 300) }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image')
@if(file_exists('public/storage/' . $crypto_news->urlToImage)){{ URL::asset('public/storage/' . $crypto_news->urlToImage) }}@else{{ $crypto_news->urlToImage }}@endif
@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/style.css') }}">
<style>
@media  only screen and (min-width: 1650px)  {
  .news-wrapper {
    width: 70%; margin: 0 auto;
  }
}
@media  only screen and (max-width: 1650px)  {
  .news-wrapper {
    width: 100%; margin: 0 auto;
  }
}
@media  only screen and (min-width: 767px) {
.single-page-news li {
    width: 50%;
}
}

</style>
@stop
@section('scripts') 
<script src="{{ URL::asset('public/news-page/assets/js/slick.min.js') }}"></script> 
<script src="{{ URL::asset('public/news-page/assets/js/custom.js') }}"></script>
@stop
@section('content')
<div class="news-wrapper">
  <div class="row">
    <div class="col-lg-8"><div class="ui segment news">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
      @if($crypto_news->author!='')<span class="ui label">{{ $crypto_news->author }}</span>@endif 
      <span class="ui label"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ $crypto_news->publishedAt }} </span><div class="coin-detail-social-buttons">
        {!! Share::page(Request::url(), $crypto_news->title)->facebook()->twitter()->linkedin(str_limit(strip_tags($crypto_news->description), 280)) !!}
      </div>
      
      <h1 class="news-page-heading">
        <a class="slider_tittle" href="{{ URL::to('/crypto-news') }}/{{$crypto_news->id}}/{{$crypto_news->alias}}">{{ $crypto_news->title }}</a>
      </h1>
      <div class="slick_slider">
        <div class="single_iteam"> 
          <a href="{{ URL::to('/crypto-news') }}/{{$crypto_news->id}}/{{$crypto_news->alias}}"> 
            @if(file_exists('public/storage/' . $crypto_news->urlToImage))
            <img alt="{{$crypto_news->title}}" title="{{$crypto_news->title}}" src="{{URL::asset('public/storage/' . $crypto_news->urlToImage)}}"> 
            @else
            <img alt="{{$crypto_news->title}}" title="{{$crypto_news->title}}" src="{{$crypto_news->urlToImage}}"> 
            @endif
          </a>
        </div>
      </div>
      <div class="slider_articles">
        <p style="font-size: 16px;">{{ strip_tags($crypto_news->description) }}</p>
      </div>
      <div>
          <a target="_blank" href="{{$crypto_news->url}}">
            <button type="button" class="btn btn-primary">@lang('headings.READ_MORE')</button>
          </a>
      </div>
      <div class="share-at-btn"@lang('buttons.SHARE_AT'): </div>
      <div class="coin-detail-social-buttons">
       
      </div>
    </div></div>
  </div>
    <div class="col-lg-4 ui segment" style="max-width:421px">
      <div class="latest_post">
        <div class="box box-success table-heading-class">
            <div class="box-header with-border">
                <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
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
                  <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="catg_title"> 
                    {{ str_limit(strip_tags($news->title), 45, '...') }}
                  </a> <br />
                  <span class="ui label"><i class="fa fa-clock-o fa-fw"></i>{{ date("Y-m-d", strtotime($news->publishedAt)) }}</span>
                </div>
              </div>
            </li>
            @endforeach
           
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4" style="float: right;margin-top: 15px;">
      <div class="single_sidebar wow fadeInDown">
         @include(getCurrentTemplate() . '.ads.news_ad')
      </div>
    </div>
    <div class="col-md-8"><div>
         <div class="single_post_content ui segment news">
          <div class="box box-success table-heading-class" style="box-shadow: unset;">
              <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
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
                    <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}" class="catg_title"> 
                      {{ str_limit(strip_tags($news->title), 50, '...') }}
                    </a> <br />
                    <span class="ui label"><i class="fa fa-clock-o fa-fw"></i>{{ date("d M Y", strtotime($news->publishedAt)) }}</span>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
      </div>
    </div>
</div>
@include('default.includes.disqus') 
@stop
