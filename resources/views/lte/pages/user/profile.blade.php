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
    <section class="content">
      <div class="row">
        @if($user->status == 0)
        <div class="col-md-8 col-md-offset-2 profile-account-reg-msg">
            <div class="alert alert-warning">
                @lang('user.ACCOUNT_REGISTRATION_MSG')
            </div>
        </div>
        @endif
        @if($errors)
        <div class="col-md-8 col-md-offset-2 profile-account-reg-msg">
            @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif
            @if($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
            @if($errors->first('old_password'))<div class="alert alert-danger">{{ $errors->first('old_password') }}</div>@endif
            @if($errors->first('about'))<div class="alert alert-danger">{{ $errors->first('about') }}</div>@endif
            @if($errors->first('skills'))<div class="alert alert-danger">{{ $errors->first('skills') }}</div>@endif
            @if($errors->first('g-recaptcha-response'))<div class="alert alert-danger">{{ $errors->first('g-recaptcha-response') }}</div>@endif
            @if($errors->first('profile_updated'))<div class="alert alert-success">{{ $errors->first('profile_updated') }}</div>@endif
            @if($errors->first('wrong_credentials'))<div class="alert alert-danger">{{ $errors->first('wrong_credentials') }}</div>@endif
        </div>
        @endif
        <div class="col-md-3">
          <div class="box box-primary table-heading-class">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ getProfileImage() }}" alt="User profile picture">
              <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
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
                        <span class="btn label">{{ $skill }}</span>
                    <?php
                    }
                    ?>
                </p>
            </div>
          </div>
           <br />
          @endif
            <div class="box box-primary table-heading-class">
              <div class="box-header with-border">
                <h3 class="box-title">@lang('user.ACCOUNT_SETTINGS')</h3>
              </div>
              <div class="box-body">
                  <a href="{{ makeUrl('user/download-account-data') }}">@lang('user.DOWNLOAD_ACCOUNT')</a> <br />
                  <a class="delete-account" style="cursor: pointer;">@lang('user.DELETE_ACCOUNT')</a>
              </div>
            </div>
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">@lang('user.PROFILE')</a></li>
              <li><a href="#change_password" data-toggle="tab">@lang('user.CHANGE_PASSWORD')</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="settings">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ makeUrl('user/profile') }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input disabled="disabled" type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">About Me</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="about" id="inputExperience" placeholder="About Me">{{ Auth::user()->about }}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>
                    <div class="col-sm-10">
                      <input type="text" name="skills" value="{{ Auth::user()->skills }}" autocomplete="off" class="form-control" id="inputSkills" placeholder="Skills">
                      <em>*comma separated</em>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                      <input name="newsletter" type="checkbox" @if($user->newsletter == 1) checked="checked" @endif value="1">@lang('user.SUBSCRIBE_NEWSLETTER')
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                      {!! Recaptcha::render() !!}
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="update_profile" value="@lang('user.UPDATE_PROFILE')" class="btn btn-lg btn-primary">
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="change_password">
                  <form class="form-horizontal" role="form" method="post" action="{{ makeUrl('user/change_password') }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">@lang('user.OLD_PASSWORD')</label>
                    <div class="col-sm-10">
                      <input class="form-control" placeholder="@lang('user.OLD_PASSWORD')" name="old_password" autocomplete="off" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">@lang('user.NEW_PASSWORD')</label>
                    <div class="col-sm-10">
                      <input class="form-control" placeholder="@lang('user.PASSWORD')" name="password" autocomplete="off" type="password" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="change_password" value="@lang('user.CHANGE_PASSWORD')" class="btn btn-lg btn-primary">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@stop