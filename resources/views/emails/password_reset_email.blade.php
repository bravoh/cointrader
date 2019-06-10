@lang('constants.EMAIL_HI'), {{ $user->name }}
<br /><br />

@lang('constants.PASSWORD_RESET_TEXT')
<br /><br />
@lang('user.PASSWORD'): {{ $new_password }}
<br />
<a href="{{ makeUrl('user/login') }}" style="color: #337ab7;">@lang('user.LOGIN_HERE')</a>
<br /><br />
<span style="font-size: 12px;"><em>@lang('constants.EMAIL_ATTENTION_TEXT')</em></span> <br />

<br />
Thank you. <br />
@lang('constants.WEBSITE_NAME')
