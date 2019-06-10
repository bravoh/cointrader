@lang('constants.EMAIL_HI'), {{ $username }}
<br /><br />

@lang('constants.SOCIAL_REGISTRATION_TEXT')
<br /><br />
@lang('user.EMAIL'): {{ $email }}<br />
@lang('user.PASSWORD'): {{ $password }}
<br />
<a href="{{ makeUrl('user/login') }}" style="color: #337ab7;">@lang('user.LOGIN_HERE')</a>
<br /><br />
<span style="font-size: 12px;"><em>@lang('constants.EMAIL_ATTENTION_TEXT')</em></span> <br />

<br />
Thank you. <br />
@lang('constants.WEBSITE_NAME')
