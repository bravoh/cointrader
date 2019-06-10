@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v5.BLOG_PAGE_TITLE')@stop
@section('meta_desc')@lang('v5.BLOG_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blog.png' }}@stop
@section('styles') 
<style type="text/css">
.h1, .h2, .h3, h1, h2, h3 {margin-top: unset;margin: unset;padding: unset;}
.box-header {background-color: #337ab7;padding: 10px;color: white;}
.box-header h3 {font-size: 18px;}
.panel {border-top-left-radius: unset;border-top-right-radius: unset;}
</style>
@stop
@section('content')
<div class="ui segment coins_page_headings">
    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
    <h1>
        @lang('menu.BLOG_POSTS')
    </h1>
</div>
@foreach($posts as $post)
    <div style="float: left; padding-right: 5px;">
        @if(file_exists('public/storage/' . $post->image))
        <img src="{{URL::asset('public/storage/' . $post->image)}}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
        @else
        <img src="{{ $post->image }}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
        @endif
    </div>
    <div>
        <a href="{{ makeUrl('blog') }}/{{ $post->slug }}">{{$post->title}}</a> 
        <p>{!! str_limit(strip_tags($post->body), 300) !!}</p> 
        <p>
          <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>
          Published at: {{$post->created_at}}
        </p> 
    </div>
    <div style="clear: both;"></div><hr style="color: #ccc; border: 0.5px solid;" />
@endforeach()       
{{ $posts->links() }}
@stop