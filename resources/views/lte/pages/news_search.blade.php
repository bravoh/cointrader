@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.NEWS_TITLE')@stop
@section('meta_desc')@lang('seo.NEWS_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/news_search.png' }}@stop
@section('styles')
<style type="text/css">
.news-search-input{width: 50%;display: inline;margin-right: 5px;height: 32.48px;vertical-align: middle;}
.news-search-bar{text-align: center;margin: 10px;}
</style>
@stop
@section('content')
<div class="news-search-bar">
  <form action="{{ makeUrl('crypto-coins-news-search') }}" method="GET">
    <input class="form-control news-search-input" type="text" name="q" value="{{{ $query }}}" placeholder="Search news"> 
    <input class="btn btn-primary" type="submit" value="Search">
  </form>
</div>
<div class="panel panel-default" style="border: unset;">
    <div class="panel-body">
      @if(count($crypto_news) > 0)
        @foreach($crypto_news as $news)
          <div class="news">
          <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}">{{$news->title}}</a> 
          <p>
            {{ str_limit(strip_tags($news->description), 150, '...') }} <br />
            <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>
            Published at: {{ date("d M Y", $news->publishedAt) }}
          </p> 
        </div>
        <div style="clear: both;"></div><hr style="color: #ccc; border: 0.5px solid;" />
      @endforeach() 
    @else
      No news..
    @endif  
    </div>
</div>
@stop
