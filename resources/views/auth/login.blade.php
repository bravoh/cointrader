{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-8 col-md-offset-2">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="panel-heading">Login</div>--}}

{{--                <div class="panel-body">--}}
{{--                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
{{--                        {{ csrf_field() }}--}}

{{--                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
{{--                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}

{{--                                @if ($errors->has('email'))--}}
{{--                                    <span class="help-block">--}}
{{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
{{--                            <label for="password" class="col-md-4 control-label">Password</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control" name="password" required>--}}

{{--                                @if ($errors->has('password'))--}}
{{--                                    <span class="help-block">--}}
{{--                                        <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <div class="col-md-6 col-md-offset-4">--}}
{{--                                <div class="checkbox">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <div class="col-md-8 col-md-offset-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    Login--}}
{{--                                </button>--}}

{{--                                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                    Forgot Your Password?--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}


@extends(getCurrentTemplate() . '.layouts.login')
@section('meta_title')@lang('user.LOGIN_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.LOGIN_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/login.png' }}@stop
@section('styles')
    <style type="text/css">
        .ui.ribbon.label {left: calc(-1rem - 1.4em);}
        h1 {font-size: 15px;}
        .ui.button.s{ width:100%;border: 1px solid #ddd;background: #fff;}
    </style>
@stop
@section('content')
    <div class="container">
        <div class="row">
            @if($errors)
                <br />
                <div class="col-md-8 col-md-offset-8 profile-account-reg-msg">
                    @if($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
                    @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
                    @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
                    @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
                    @if($errors->first('blockfolio_msg'))<div class="alert alert-warning"><i class="icon fa fa-info"></i>{{ $errors->first('blockfolio_msg') }}</div>@endif
                    @if($errors->first('watchlist_msg'))<div class="alert alert-warning"><i class="icon fa fa-info"></i>{{ $errors->first('watchlist_msg') }}</div>@endif
                </div>
            @endif
            <div class="col-md-8 col-md-offset-2">
                <div class="col-md-6">
                    <div class="login-panel panel panel-default">
                        <div class="panel-body cct-form-btn form-section">
                            <div class="ui teal large ribbon label">
                                <h1>@lang('user.PLEASE_LOGIN')</h1>
                            </div><br /><br />
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
                                            <input name="remember" type="checkbox" value="Remember Me"><span style="margin-left:20px">@lang('user.REMEMBER_ME')</span>
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
                        <div class="panel-body cct-form-btn form-section">
                            <div class="ui teal large ribbon label">
                                <h1>@lang('user.SOCIAL_LOGIN')</h1>
                            </div><br /><br />
                            <fieldset>
                                <div class="form-group">
                                    <a href="{{ makeUrl('user/login/facebook') }}" class="ui button s latest-block-btn">
                                        <i class="fa fa-facebook"></i> Login with Facebook
                                    </a>
                                </div>
                                <div class="form-group">
                                    <a href="{{ makeUrl('user/login/twitter') }}" class="ui button s latest-block-btn">
                                        <i class="fa fa-twitter"></i> Login with Twitter
                                    </a>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
