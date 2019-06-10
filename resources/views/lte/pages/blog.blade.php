@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v5.BLOG_PAGE_TITLE')@stop
@section('meta_desc')@lang('v5.BLOG_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blog.png' }}@stop
@section('styles') 
<style type="text/css">
.panel {border-top-left-radius: unset;border-top-right-radius: unset;}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box box-success table-heading-class">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('menu.BLOG_POSTS')</h3>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
      @foreach($posts as $post)
        <div style="padding: 0px;float: left;width: 16%;">
            @if(file_exists('public/storage/' . $post->image))
            <img src="{{URL::asset('public/storage/' . $post->image)}}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
            @else
            <img src="{{ $post->image }}" width="175" title="{{$post->title}}" alt="{{$post->title}}" />
            @endif
        </div>
        <div style="float: left;width: 80%">
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
    </div>
</div>
@stop