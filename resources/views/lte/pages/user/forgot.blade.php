@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.FORGOT_PASS_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.FORGOT_PASS_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/forgot.png' }}@stop
@section('styles')
<style type="text/css">
.alert {padding: 8px;margin: 5px;}
</style>
@stop
@section('content')
@if($errors)
<br />
<div class="col-md-8 col-md-offset-2 profile-account-reg-msg">
    @if($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
    @if($errors->first('forgot_password_email_sent'))<div class="alert alert-success">{{ $errors->first('forgot_password_email_sent') }}</div>@endif
    @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
    @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
</div>
@endif
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="login-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('user.FORGOT_PASSOWRD')</h3>
                </div>
            </div>
            <div class="panel-body cct-form-btn form-section">
                <form role="form" action="{{ makeUrl('user/forgot') }}" method="post">
                	{{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.EMAIL')" name="email" type="text" value="{{ old('name') }}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            {!! Recaptcha::render() !!}
                        </div>
                        <input type="submit" name="submit_login" value="@lang('user.SUBMIT')" class="btn btn-lg btn-primary btn-block">
                        <div class="account-text">
                            @lang('user.TEXT_OR') <br /> @lang('user.DONT_HAVE_ACCOUNT')
                            <a href="{{ makeUrl('user/register') }}">@lang('user.REGISTER_HERE')</a><br />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop