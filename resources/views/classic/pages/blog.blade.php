@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v5.BLOG_PAGE_TITLE')@stop
@section('meta_desc')@lang('v5.BLOG_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blog.png' }}@stop
@section('styles') 
<style type="text/css">
.h1, .h2, .h3, h1, h2, h3 {margin-top: unset;margin: unset;padding: unset;}
.box-header {background-color: #00b5ad;padding: 10px;color: white;}
</style>
@stop
@section('content')
<div class="ui segment">
    <div class="coins_page_headings latest-block-btn">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
        <h1>@lang('menu.BLOG_POSTS')</h1>
        <h2 class="sr-only">Cryptocurrency news</h2>
        <h2 class="sr-only">Bitcoin, Ethereum and Litecoin news</h2>
    </div>
</div>
<div class="ui segment">
  @foreach($posts as $post)
    <div class="ui items">
      <div class="item">
        <div class="image">
          @if(file_exists('public/storage/' . $post->image))
          <img src="{{URL::asset('public/storage/' . $post->image)}}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
          @else
          <img src="{{ $post->image }}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
          @endif
        </div>
        <div class="content">
          <h2 class="header"><a href="{{ makeUrl('blog') }}/{{ $post->slug }}">{{$post->title}}</a></h2>
          <div class="description" style="color: unset;">
            <p>{!! str_limit(strip_tags($post->body), 300) !!}</p>
          </div>
          <div class="extra" style="color: unset;">
            {{$post->created_at}}
          </div>
         </div>
      </div>
    </div>
  @endforeach()       
  {{ $posts->links() }}
</div><br />
@stop