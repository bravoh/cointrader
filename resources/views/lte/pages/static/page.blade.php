@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{{ $data->title or '' }}}@stop
@section('meta_desc'){{{ $data->meta_description or '' }}}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/static_pages.png' }}@stop
@section('content')
@if(isset($data->title))
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $data->title }}
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
		<div class="panel panel-default" style="border: unset;">
		    <div class="panel-body">
				<div class="static-page">
					{!! $data->body !!}
				</div>
		    </div>
		</div>
	</div>
</div>
@else
	<p>Content Coming Soon!</p> 
@endif
@stop