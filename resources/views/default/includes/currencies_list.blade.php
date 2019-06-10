@include(getCurrentTemplate() . '.includes.available_languages')
<div class="btn-group"  style="z-index: 99999999;margin-right: -5px;">
  <div class="ui floating dropdown labeled icon button">
    <span class="text selected-currency">
        @if(isset($_COOKIE['SELECTED_CURRENCY'])) {{$_COOKIE['SELECTED_CURRENCY']}} @else USD @endif
    </span>
    <div class="menu"  style="z-index: 99999999">
      <div class="ui icon search input">
        <input type="text" placeholder="@lang('menu.SEARCH')...">
      </div>
      <div class="scrolling menu top-currency-dropdown">
        @if(isset($_COOKIE['SELECTED_CURRENCY'])) 
          @if($_COOKIE['SELECTED_CURRENCY'] === 'USD')
            <div class="item selected" value="1" id="$" rel="USD"><i class="us flag"></i>USD</div>
          @else
            <div class="item" value="1" id="$" rel="USD"><i class="us flag"></i>USD</div>  
          @endif 
        @else
          <div class="item selected" value="1" id="$" rel="USD"><i class="us flag"></i>USD</div>
        @endif
        @foreach($currencies_list as $currency)
            <div class="item @if(isset($_COOKIE['SELECTED_CURRENCY'])) @if($_COOKIE['SELECTED_CURRENCY'] === $currency->currency)selected @endif @endif" value="{{$currency->rate}}" id="{{$currency->icon}}" rel="{{$currency->currency}}">
              <i class="{{ $currency->flag }} flag"></i>{{$currency->currency}}
            </div>
        @endforeach
      </div>
    </div>
  </div>
</div>