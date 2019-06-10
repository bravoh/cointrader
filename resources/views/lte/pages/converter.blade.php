@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.CONVERTER_PAGE_TITLE')@stop
@section('meta_desc')@lang('seo.CONVERTER_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/converter.png' }}@stop
@section('styles')
<style type="text/css">
.alert {padding: 8px;margin: 5px;}
.ui.dropdown .menu>.item>.image, .ui.dropdown .menu>.item>img, .ui.dropdown>.text>.image, .ui.dropdown>.text>img {vertical-align: middle !important;}
.item .currency-code {padding-left: 3px;}
.converter-custom-dropdown {border: 1px solid #d2d6de; padding: 6px;width: 100%;}
.ui.dropdown.labeled{width: 100%;}
.exchange-icon{text-align: center;vertical-align: middle;margin-top: 4px;font-size: 18px;cursor: pointer;}
.convert-from{margin-right: 10px;}
.exchange-icon span {padding: 5px 15px 5px 15px;}
.convert-to{margin-left: 10px;}
.conversion-box{text-align: center;font-size: 15px;}
.text.converter-custom-dropdown {height: 35px;}
.fiat-to-crypto .text.converter-custom-dropdown img {margin-right: 9px !important;}
.crypto-to-fiat .text.converter-custom-dropdown img {margin-right: 4px !important;}
</style>
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/custom-js/converter.js') }}"></script>
@stop
@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="login-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('headings.CRYPTO_CONVERTER')</h3>
                </div>
            </div>
            <div class="panel-body cct-form-btn form-section">
                <form role="form">
                    <fieldset>
                        <div class="fiat-to-crypto">
                            <div class="form-group">
                                <input class="form-control amount" placeholder="@lang('converter.AMOUNT')" name="amount" type="text" value="100" autocomplete="off" autofocus>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="ui dropdown labeled fiat">
                                          <span class="text converter-custom-dropdown">
                                            <i class="us flag"></i>USD
                                          </span>
                                          <div class="menu">
                                            <div class="ui icon search input">
                                              <i class="search icon"></i>
                                              <input placeholder="Search tags..." type="text">
                                            </div>
                                            <div class="scrolling menu fiat-dropdown">
                                                <div class="item active selected USD">
                                                    <a href="#" class="" value="1" symbol="USD" id="us">
                                                        <i class="us flag"></i> <span class="currency-code">USD</span>
                                                    </a>
                                                </div>
                                                @foreach($currencies_list as $currency)
                                                    <div class="item {{$currency->currency}}">
                                                        <a href="#" class="" value="{{$currency->usd_rate}}" id="{{$currency->icon}}"  symbol="{{$currency->currency}}">
                                                          <i class="{{ $currency->flag }} flag"></i> <span class="currency-code">{{$currency->currency}}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 exchange-icon fiat-to-crypto">
                                        <span class="btn"><i class="fa fa-exchange"></i></span>
                                    </div>
                                    <div class="col-xs-5">
                                      <div class="ui dropdown labeled crypto">
                                          <span class="text converter-custom-dropdown">
                                            <img alt="bitcoin icon" title="bitcoin" src="{{ URL::asset('public/images/coins_icons/thumbs/btc_.png') }}" width="20">BTC
                                          </span>
                                          <div class="menu">
                                            <div class="ui icon search input">
                                              <i class="search icon"></i>
                                              <input placeholder="Search tags..." type="text">
                                            </div>
                                            <div class="scrolling menu crypto-dropdown">
                                                @foreach($markets as $market)
                                                    <div class="item {{$market->symbol}} @if($market->symbol == 'BTC') active selected @endif">
                                                        <a href="#" class="" value="{{$market->price_usd}}" symbol="{{$market->symbol}}">
                                                         <img alt=" icon" title="" src="{{ $market->image }}" width="20">
                                                         <span class="currency-code"> {{$market->symbol}}</span>
                                                        </a>
                                                    </div>
                                                  @endforeach
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="row conversion-box">
                                <div class="col-xs-5 text-right"> <span class="convert-from"></span></div>
                                <div class="col-xs-2  text-center"> = </div>
                                <div class="col-xs-5 text-left"><span class="convert-to"></span></div>
                            </div>
                        </div>
                        <div class="crypto-to-fiat" style="display: none;">
                            <div class="form-group">
                                <input class="form-control amount" placeholder="@lang('converter.AMOUNT')" name="amount" type="text" value="100" autocomplete="off" autofocus>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="ui dropdown labeled crypto">
                                          <span class="text converter-custom-dropdown">
                                            <img alt="bitcoin icon" title="bitcoin" src="{{ URL::asset('public/images/coins_icons/thumbs/btc_.png') }}" width="20">
                                            BTC
                                          </span>
                                          <div class="menu">
                                            <div class="ui icon search input">
                                              <i class="search icon"></i>
                                              <input placeholder="Search tags..." type="text">
                                            </div>
                                            <div class="scrolling menu crypto-dropdown">
                                                @foreach($markets as $market)
                                                    <div class="item {{$market->symbol}} @if($market->symbol == 'BTC') active selected @endif">
                                                        <a href="#" class="" value="{{$market->price_usd}}" symbol="{{$market->symbol}}">
                                                         <img alt=" icon" title="" src="{{ $market->image }}" width="20">
                                                         <span class="currency-code">{{$market->symbol}}</span>
                                                        </a>
                                                    </div>
                                                  @endforeach
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 exchange-icon crypto-to-fiat">
                                        <span class="btn"><i class="fa fa-exchange"></i></span>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="ui dropdown labeled fiat">
                                          <span class="text converter-custom-dropdown">
                                            <i class="us flag"></i>USD
                                          </span>
                                          <div class="menu">
                                            <div class="ui icon search input">
                                              <i class="search icon"></i>
                                              <input placeholder="Search tags..." type="text">
                                            </div>
                                            <div class="scrolling menu fiat-dropdown">
                                                <div class="item active selected USD">
                                                    <a href="#" class="" value="1" symbol="USD" id="us">
                                                        <i class="us flag"></i> <span class="currency-code">USD</span>
                                                    </a>
                                                </div>
                                                @foreach($currencies_list as $currency)
                                                    <div class="item  {{$currency->currency}}">
                                                        <a href="#" class="" value="{{$currency->usd_rate}}" id="{{$currency->icon}}"  symbol="{{$currency->currency}}">
                                                          <i class="{{ $currency->flag }} flag"></i> <span class="currency-code">{{$currency->currency}}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="row conversion-box">
                                <div class="col-xs-5 text-right"><span class="convert-to"></span></div>
                                <div class="col-xs-2  text-center"> = </div>
                                <div class="col-xs-5 text-left"><span class="convert-from"></span></div>
                            </div>
                        </div>
                        <br />
                        <a href="{{ makeUrl('buy-sell-cryptocoins') }}">
                          <input type="button" value="@lang('buttons.BUY')" class="btn btn-lg btn-primary btn-block">
                        </a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
