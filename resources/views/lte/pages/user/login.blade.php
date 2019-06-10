@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.LOGIN_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.LOGIN_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/login.png' }}@stop
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
    @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
    @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
    @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
    @if($errors->first('blockfolio_msg'))<div class="alert alert-warning"><i class="icon fa fa-info"></i>{{ $errors->first('blockfolio_msg') }}</div>@endif
    @if($errors->first('watchlist_msg'))<div class="alert alert-warning"><i class="icon fa fa-info"></i>{{ $errors->first('watchlist_msg') }}</div>@endif
</div>
@endif
<div class="row">
    <div class="col-md-6">
        <div class="login-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('user.PLEASE_LOGIN')</h3>
                </div>
            </div>
            <div class="panel-body cct-form-btn form-section">
                <form role="form" action="{{ makeUrl('user/login') }}" method="post">
                	{{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.EMAIL')" name="email" type="text" value="{{ old('name') }}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.PASSWORD')" name="password" type="password" autocomplete="off" value="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">@lang('user.REMEMBER_ME')
                            </label>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            {!! Recaptcha::render() !!}
                        </div>
                        <input type="submit" name="submit_login" value="@lang('user.LOGIN')" class="btn btn-lg btn-primary btn-block">
                        <div class="account-text">
                            @lang('user.TEXT_OR') <br /> @lang('user.DONT_HAVE_ACCOUNT')
                            <a href="{{ makeUrl('user/register') }}">@lang('user.REGISTER_HERE')</a><br />
                            <a href="{{ makeUrl('user/forgot') }}">@lang('user.FORGOT_PASSOWRD')?</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="login-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('user.SOCIAL_LOGIN')</h3>
                </div>
            </div>
            <div class="panel-body cct-form-btn form-section">
                <fieldset>
                    <div class="form-group">
                        <a href="{{ makeUrl('user/login/facebook') }}" class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> Login with Facebook
                        </a>
                    </div>
                    <div class="form-group">
                        <a href="{{ makeUrl('user/login/twitter') }}" class="btn btn-block btn-social btn-twitter">
                            <i class="fa fa-twitter"></i> Login with Twitter
                        </a>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@stop