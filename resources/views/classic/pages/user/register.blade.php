@extends(getCurrentTemplate() . '.layouts.login')
@section('meta_title')@lang('user.REGISTRATION_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.REGISTRATION_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/register.png' }}@stop
@section('styles')
<style type="text/css">
.ui.ribbon.label {left: calc(-1rem - 1.4em);}
h1 {font-size: 15px;}
.ui.button.s{    width: 100%;border: 1px solid #ddd;background: #fff;}
</style>
@stop
@section('content')
<div class="container">
    <div class="row">
        @if($errors)
        <br />
        <div class="col-md-8 col-md-offset-8 profile-account-reg-msg">
            @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif
            @if($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
            @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
            @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
            @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
        </div>
        @endif
        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-6">
                <div class="login-panel panel panel-default">
                    <div class="panel-body cct-form-btn form-section">

                        <div class="ui teal large ribbon label">
                            <h1>@lang('user.REGISTER_HERE')</h1>
                        </div><br /><br />
                        <form role="form" method="post" accept="{{ makeUrl('user/register') }}">
                        	{{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="@lang('user.NAME')" name="name" type="text" value="{{ old('name') }}" autocomplete="off" autofocus>
                                </div>
                                <div class="form-group">
                                    <input value="3" name="role_id" type="hidden">
                                    <input class="form-control" placeholder="@lang('user.EMAIL')" name="email" type="text" value="{{ old('email') }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="@lang('user.PASSWORD')" name="password" autocomplete="off" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="newsletter" type="checkbox" value="1"><span style="margin-left:20px">@lang('user.SUBSCRIBE_NEWSLETTER')</span>
                                    </label>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    {!! Recaptcha::render() !!}
                                </div>
                                <input type="submit" name="submit_register" value="@lang('user.REGISTER')" class="btn btn-lg btn-primary btn-block"> 
                                <div class="account-text">
                                    @lang('user.TEXT_OR') <br /> @lang('user.HAVE_ACCOUNT')
                                    <a href="{{ makeUrl('user/login') }}">@lang('user.LOGIN_HERE')</a>
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
                            <h1>@lang('user.REGISTER_HERE')</h1>
                        </div><br /><br />
                        <fieldset>
                            <div class="form-group">
                                <a href="{{ makeUrl('user/login/facebook') }}" class="ui button s latest-block-btn">
                                    <i class="fa fa-facebook"></i> Register with Facebook
                                </a>
                            </div>
                            <div class="form-group">
                                <a href="{{ makeUrl('user/login/twitter') }}" class="ui button s latest-block-btn">
                                    <i class="fa fa-twitter"></i> Register with Twitter
                                </a>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class=" panel panel-default">
                    <div class="panel-body cct-form-btn form-section">
                      <h4 style="margin-top:0">@lang('user.IMPORTANT')</h4>
                        <p>
                            @lang('user.AGREE_ON_PRIVACY')
                        </p>
                        <p>
                            @lang('user.AGREE_ON_SEND_EMAILS')
                        </p>
                        <p>
                            @lang('user.DONT_SIGNUP')
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop