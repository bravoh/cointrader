<li class="dropdown notifications-menu top-currency-dropdown">
  <div class="ui dropdown" style="padding: 15px;">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;">
          <span class="text selected-currency">
            <i class="fa fa-money"> </i> 
            <span class="currency-code">@if(isset($_COOKIE['SELECTED_CURRENCY'])) {{$_COOKIE['SELECTED_CURRENCY']}} @else USD @endif</span>
          </span>
      </a>
    <div class="menu">
      <div class="ui search icon input">
        <i class="search icon"></i>
        <input type="text" name="search" placeholder="@lang('menu.SEARCH')...">
      </div>
      <div class="item">
        @if(isset($_COOKIE['SELECTED_CURRENCY'])) 
          @if($_COOKIE['SELECTED_CURRENCY'] === 'USD')
            <a href="#" class="selected" value="1" id="$" rel="USD"><i class="us flag"></i> USD </a>
          @else
            <a href="#" class="" value="1" id="$" rel="USD"><i class="us flag"></i> USD </a>
          @endif 
        @else
          <a href="#" class=" selected" value="1" id="$" rel="USD"><i class="us flag"></i> USD </a>
        @endif
      </div>
      @foreach($currencies_list as $currency)
        <div class="item">
            <a href="#" class="@if(isset($_COOKIE['SELECTED_CURRENCY'])) @if($_COOKIE['SELECTED_CURRENCY'] === $currency->currency)selected @endif @endif" value="{{$currency->rate}}" id="{{$currency->icon}}" rel="{{$currency->currency}}">
              <i class="{{ $currency->flag }} flag"></i> <span class="currency-code">{{$currency->currency}}</span>
            </a>
        </div>
      @endforeach
    </div>
  </div>
</li>
