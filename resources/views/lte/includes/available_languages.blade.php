<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="text selected-language">
        	<i class="fa fa-language"> </i>
        	<span class="lang-code">ENG</span>
    	</span>
    </a>
    <ul class="dropdown-menu top-language-dropdown" style="width: 150px;">
        <li>
            <ul class="menu">
            	@foreach($available_languages as $language)
               	<li>
                    <a href="{{ URL::to('/') . '/' . $language->code . '/' . substr(Request::path(), 3) }}" name="{{$language->name}}" value="{{$language->code}}" class="item @if(LaravelLocalization::getCurrentLocale() === $language->code)selected active @endif">
                        <i class="{{ $language->flag }} flag"></i><span class="lang-code">{{ strtoupper($language->short_name) }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>

