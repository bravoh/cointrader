@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{{ $data->title or '' }}}@stop
@section('meta_desc'){{{ $data->meta_description or '' }}}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/static_pages.png' }}@stop
@section('content')
@if(isset($data->title))

    <div class="ui segment"><div class="ui teal large ribbon label"><i class="tag icon"></i></div><h1> {{ $data->title }}</h1>
    </div>

<div class="ui segment">
   
		    <div >
				<div class="static-page">
					{!! $data->body !!}
				</div>
		    </div>
	
</div>
@else
	<p>Content Coming Soon!</p> 
@endif
@stop