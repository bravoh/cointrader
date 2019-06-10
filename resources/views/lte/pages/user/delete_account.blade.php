@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title') Delete user account @stop
@section('meta_desc') User account delete account page. @stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/forgot.png' }}@stop
@section('content')
<div class="container">
    <div class="row">
        @if($errors)
        <div class="col-md-8 col-md-offset-2 profile-account-reg-msg">
            @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
            @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
            @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-success table-heading-class">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('user.DELETE_ACCOUNT')</h3>
                    </div>
                </div>
                <div class="login-panel panel panel-default">
                    <div class="panel-body cct-form-btn form-section">
                        <form role="form" action="{{ makeUrl('user/delete-account') }}" method="post">
                        	{{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="@lang('user.PASSWORD')" name="password" type="text" autocomplete="off" autofocus>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    {!! Recaptcha::render() !!}
                                </div>
                                <input type="submit" name="submit_login" value="@lang('user.SUBMIT')" class="btn btn-lg btn-primary btn-block">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop