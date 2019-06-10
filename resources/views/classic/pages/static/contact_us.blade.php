@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v7.CONTACT_US')@stop
@section('meta_desc')@lang('v7.CONTACT_SEO_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/contact.png' }}@stop
@section('styles')
<style>.card {
    box-shadow: 1px 3px 15px 0px rgba(0, 0, 0, 0.14);
    border: none;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}.card-body {
    flex: 1 1 auto;
    padding: 0 .25rem;
    text-align: center;
    font-weight: 700;
}.mb-3, .my-3 {
    margin-bottom: 1.5rem !important;
}.pool-detail img{width: 115px;float: left;margin: 0 10px 0 0;border: 1px solid #eee;}
.pool-detail p {font-size: 20px; font-weight: 500;line-height: 29px;}
.pool-detail button {color: white!important;} 
</style>
@stop
@section('content')
<div class="ui segment">
   <div class="coins_page_headings latest-block-btn">
      <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
      <h1>@lang('v7.CONTACT_US')</h1>
   </div>
</div>
<div class="row" style="margin: 0px;">
  <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">
    <div class="ui segment">
  	<p>
      @lang('v7.CONTACT_US_DESC_1') <a href="{{ makeUrl('advertise') }}">@lang('v7.CONTACT_US_DESC_2')</a>.
    </p>
    <p>
      @lang('v7.CONTACT_US_DESC_3') <a href="mailto:{{ setting('site.contact_email') }}">{{ setting('site.contact_email') }}</a>
    </p>
    <div class="row">
      @if($errors)
      <br />
      <div class="col-md-8 col-md-offset-8 profile-account-reg-msg">
          @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif
          @if($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
          @if($errors->first('message'))<div class="alert alert-danger">{{ $errors->first('message') }}</div>@endif
          @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
          @if($errors->first('success'))<div class="alert alert-success">{{ $errors->first('success') }}</div>@endif
      </div>
      @endif
      <div class="col-md-8">
        <form role="form" method="post" accept="{{ makeUrl('contact-us') }}">
          {{ csrf_field() }}
            <fieldset>
                <div class="form-group">
                  @lang('user.NAME') <br />
                  <input class="form-control" placeholder="@lang('user.NAME')" name="name" type="text" value="{{ old('name') }}" autocomplete="off" autofocus>
                </div>
                <div class="form-group">
                  @lang('user.EMAIL') <br />
                  <input class="form-control" placeholder="@lang('user.EMAIL')" name="email" type="text" value="{{ old('email') }}" autocomplete="off">
                </div>
                <div class="form-group">
                  @lang('v7.INQUIRY_TYPE') <br />
                  <select class="form-control" name="inquiry_type">
                    <option>@lang('v7.GENERAL')</option>
                    <option>@lang('v7.AD')</option>
                    <option>@lang('v7.BUG_REPORT')</option>
                  </select>
                </div>
                <div class="form-group">
                  @lang('v7.MESSAGE') <em>(@lang('v7.MAX'))</em> <br />
                  <textarea class="form-control" rows="8" name="message">{{ old('message') }}</textarea>
                </div>
                <div class="form-group" style="text-align: center;">
                    {!! Recaptcha::render() !!}
                </div>
                <input type="submit" name="submit_contact" value="@lang('v7.SUBMIT')" class="btn btn-lg btn-primary btn-block">
            </fieldset>
        </form> <br /> <br />
      </div> 
    </div>
    </div>
</div>
<div class="col-lg-4 col-sm-12" style="padding-right: 0px;">
   <div class="single_post_content ui segment">
    <div class="box box-success table-heading-class" style="box-shadow: unset;">
        <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h3 class="box-title">@lang('v7.UPCOMING_EVENTS')</h3>
        </div>
    </div>
    <ul class="spost_nav single-page-news" style="list-style: none;padding: 0px;margin:0px;">
      @foreach($events as $event)
      <li style="padding-top: 20px;">
        <div class="media wow fadeInDown"> 
          <a href="{{ makeUrl('events') }}/{{ $event->alias }}" class="media-left" style="height: unset;"> 
            @if(file_exists('public/storage/' . $event->screenshot))
            <img style="height: 50px;width: 120px;border: 1px solid #eee;" alt="{{$event->title}}" title="{{$event->title}}" src="{{URL::asset('public/storage/' . $event->screenshot)}}"> 
            @else
            <img style="height: 50px;width: 120px;border: 1px solid #eee;" alt="{{$event->title}}" title="{{$event->title}}" src="{{$event->screenshot}}"> 
            @endif
          </a>
          <div class="media-body"> 
            <a href="{{ makeUrl('events') }}/{{ $event->alias }}" class="catg_title"> 
              {{ str_limit(strip_tags($event->title), 30, '...') }}
            </a> <br />
            <span class="ui label"><i class="fa fa-clock-o fa-fw"></i>{{ date("d M Y", strtotime($event->start_date)) }}</span>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>
</div><br />
@stop