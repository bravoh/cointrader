@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.PROFILE_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.PROFILE_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/profile.png' }}@stop
@section('scripts')
<script type="text/javascript">
$('.delete-account').click(function(){
    if(confirm("{{ __('user.DELETE_ACCOUNT_CONFIRMATION') }}")) {
        window.location.href = "{{ makeUrl('user/delete-account') }}";
    }
});
</script>
@stop
@section('content')
<div class="container">
    <div class="row">
        @if($user->status == 0)
        <div class="col-md-8 col-md-offset-8 profile-account-reg-msg">
            <div class="alert alert-warning">
                @lang('user.ACCOUNT_REGISTRATION_MSG')
            </div>
        </div>
        @endif
        @if($errors)
        <div class="col-md-8 col-md-offset-8 profile-account-reg-msg">
            @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif
            @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
            @if($errors->first('old_password'))<div class="alert alert-danger">{{ $errors->first('old_password') }}</div>@endif
            @if($errors->first('about'))<div class="alert alert-danger">{{ $errors->first('about') }}</div>@endif
            @if($errors->first('skills'))<div class="alert alert-danger">{{ $errors->first('skills') }}</div>@endif
            @if($errors->first('profile_photo'))<div class="alert alert-danger">{{ $errors->first('profile_photo') }}</div>@endif
            @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
            @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
        </div>
        @endif
         <div class="col-md-3 col-md-offset-1">
          <div class="box box-primary table-heading-class">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ getProfileImage() }}" alt="User profile picture" width="100">
            </div>
          </div>
          @if(Auth::user()->about != '')
          <br />
          <div class="box box-primary table-heading-class">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <div class="box-body">
              <p class="text-muted" style="word-wrap: break-word;">
                {{ Auth::user()->about }}
              </p>
            </div>
          </div>
          @endif
          @if(Auth::user()->skills != '')
          <br />
            <div class="box box-primary table-heading-class">
                <div class="box-header with-border">
                  <h3 class="box-title">Skills</h3>
                </div>
                <div class="box-body">
                    <p>
                        <?php
                        $skills = explode(',', Auth::user()->skills);
                        foreach ($skills as $skill) {
                        ?>
                            <span class="btn btn-primary" style="padding:1px 5px 1px 5px !important;">{{ $skill }}</span>
                        <?php
                        }
                        ?>
                    </p>
                </div>
            </div>
           <br />
          @endif
            <div class="box box-primary table-heading-class">
                <hr />
                <div class="box-body">
                    <a href="{{ makeUrl('user/download-account-data') }}">@lang('user.DOWNLOAD_ACCOUNT')</a> <br />
                    <a class="delete-account" style="cursor: pointer;">@lang('user.DELETE_ACCOUNT')</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ui segment coins_page_headings">
              <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
              <h1>@lang('user.ACCOUNT_SETTINGS')</h1>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">@lang('user.PROFILE')</a></li>
                <li class=""><a href="#change_password" data-toggle="tab" aria-expanded="false">@lang('user.CHANGE_PASSWORD')</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="profile"> 
                    <p><h3>User @lang('user.PROFILE')</h3></p>
                    <form role="form" enctype="multipart/form-data" method="post" accept="{{ makeUrl('user/profile') }}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.NAME')" name="name" type="text" value="{{ $user->name }}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <input disabled="disabled" class="form-control" placeholder="@lang('user.EMAIL')" name="email" type="text" value="{{ $user->email }}" autocomplete="off" disabled="disabled">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="about" id="inputExperience" placeholder="About Me">{{ Auth::user()->about }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" name="skills" value="{{ Auth::user()->skills }}" autocomplete="off" class="form-control" id="inputSkills" placeholder="Skills">
                            <em>*comma separated</em>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="newsletter" type="checkbox" @if($user->newsletter == 1) checked="checked" @endif value="1"><span style="margin-left:20px">@lang('user.SUBSCRIBE_NEWSLETTER')</span>
                            </label>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            {!! Recaptcha::render() !!}
                        </div>
                        <input type="submit" name="update_profile" value="@lang('user.UPDATE_PROFILE')" class="btn btn-lg btn-primary btn-block">
                    </fieldset>
                    </form>
                </div>
                <div class="tab-pane fade" id="change_password">
                    <p><h3>@lang('user.CHANGE_PASSWORD')</h3></p>
                    <form role="form" method="post" action="{{ makeUrl('user/change_password') }}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.OLD_PASSWORD')" name="old_password" autocomplete="off" type="password" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="@lang('user.PASSWORD')" name="password" autocomplete="off" type="password" value="">
                        </div>
                        <input type="submit" name="change_password" value="@lang('user.CHANGE_PASSWORD')" class="btn btn-lg btn-primary btn-block">
                    </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><br />
@stop