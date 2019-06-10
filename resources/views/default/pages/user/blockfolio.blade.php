@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.BLOCKFOLIO_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.BLOCKFOLIO_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blockfolio.png' }}@stop
@section('styles')
<style type="text/css">
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 8px 15px !important;}
.blockfolio-records .green {color: #00a65a !important;}
.blockfolio-records .red {color: #dd4b39 !important;}
.align-right {text-align: right;}
</style>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/loader.css') }}">
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
@stop
@section('scripts')
<script type="text/javascript">
$('.loader').show();
$(document).ready(function() {
  updateBlockfolio();
  setTimeout(function(){$('.loader').hide()}, 2000);
});
function updateBlockfolio(){
  $('tbody.blockfolio-records tr').each(function(element) {
    var data = {
      exchange : $(this).attr('exchange'), 
      pair : $(this).attr('pair'),
      quantity : $(this).attr('quantity'),
      price : $(this).attr('price')
    };
     $.getJSON(APP_URL + '/ajax-get-price/'+$(this).attr('exchange')+'/'+$(this).attr('pair'), data, function(result) {
        var decimal = profit_loss_decimal = price_decimal = 8;
        if(result >= 1) {
          decimal = 2;
        }
        if(data.price >= 1) {
          price_decimal = 2;
        }
        $('.price_' + data.exchange + '_' + data.pair).html(formatAmount(result, decimal, false) + '/' + formatAmount(data.price, price_decimal, false));
        $('.pair_value_' + data.exchange + '_' + data.pair).html(formatAmount(result*data.quantity, decimal, false) + ' ' + (data.pair).split('-')[1]);
        var profit_loss = result*data.quantity - data.price*data.quantity;
        var class_name = 'red';
        if(profit_loss > 0) {
          class_name = 'green';
        }
        if(profit_loss >= 1) {
          profit_loss_decimal = 2;
        } else if(profit_loss == 0) {
          profit_loss_decimal = 2;
           class_name = 'green';
        } else if(profit_loss*-1 < 0.00001) {
          profit_loss_decimal = 8;
        } else if(profit_loss*-1 > 1) {
          profit_loss_decimal = 2;
        }
        updateFiat(profit_loss, data.quantity, data.pair, data.exchange);
        var percentage = ((result-data.price)/result)*100;
        $('.profit_loss_' + data.exchange + '_' + data.pair).html(formatAmount(profit_loss, profit_loss_decimal, false) + ' ' + (data.pair).split('-')[1] + '<br />' + '<span style="font-size:12px;">' + formatAmount(percentage, 2, false) + ' %</span>').addClass(class_name);
     });
  });
}
function updateFiat(profit_loss, quantity, pair, exchange)
{
  var data = {
    profit_loss: profit_loss,
    pair : pair,
    quantity: quantity,
    fiat_currency: $('.top-currency-dropdown .item.selected').attr('value')
  };
  $.getJSON(APP_URL + '/ajax-get-pair-price', data, function(result) {
    var class_name = 'red';
    if(result > 0) {
      class_name = 'green';
    }
    $('.profit_loss_fiat_' + exchange + '_' + pair).html($('.top-currency-dropdown .item.selected').attr('id') + result).addClass(class_name);
  });
}
$('.top-currency-dropdown .item').click(function() {
    updateBlockfolio();
});
function removeCoin(id, tx_id)
{
    $.get(APP_URL + '/user/remove-coin/'+id+'/'+tx_id, function(response) {
      location.reload();
    });
}
</script>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="ui segment coins_page_headings">
          <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h1> @lang('user.BLOCKFOLIO_PAGE_HEADING') </h1>
            <a href="{{ makeUrl('user/add-blockfolio') }}" style="float: right;">
              <i class="fa fa-fw fa-plus-circle"></i> @lang('user.ADD_BLOCKFOLIO_COIN')
            </a>
      </div>
      <div class="row">
        <div class="col-lg-12">     
          <div class="loader"></div>                   
            <div class="table-responsive">
            <table width="100%" class="table table-hover" id="dataTables-example">
              <thead>
                  <tr>
                      <th>@lang('tbl_headings.COIN')</th>
                      <th>@lang('tbl_headings.EXCHANGE')</th>
                      <th>@lang('tbl_headings.PAIR')</th>
                      <th class="align-right">@lang('tbl_headings.QUANTITY')</th>
                      <th class="align-right">@lang('tbl_headings.BLOCKFOLIO_CURRENT_BUY_PRICE')</th>
                      <th class="align-right">@lang('tbl_headings.VALUE')</th>
                      <th class="align-right">@lang('tbl_headings.PROFIT_LOSS')</th>
                      <th class="align-right">@lang('tbl_headings.FIAT_PROFIT_LOSS')</th>
                      <th class="align-right">@lang('tbl_headings.TYPE')</th>
                      <th class="align-right"></th>
                  </tr>
              </thead>
              <tbody class="blockfolio-records">
                @if(count($coins) > 0)
                  <a href="{{ makeUrl('user/blockfolio') }}">
                    <i class="fa fa-fw fa-refresh "></i> @lang('user.REFRESH_PRICES')
                  </a> <br />
                  <a href="{{ makeUrl('user/transactions-history') }}">
                    <i class="fa fa-fw fa-th-list"></i> @lang('user.SEE_TXS')
                  </a> 
                  @foreach ($coins as $coin)
                    @if($coin->total_quantity > 0)
                      <tr exchange="{{ $coin->exchange }}" pair="{{ str_replace('/', '-', $coin->pair) }}" quantity="{{ $coin->total_quantity }}" price="{{ $coin->price }}">
                          <td>{{ $coin->coin }}</td>
                          <td>{{ ucwords($coin->exchange) }}</td>
                          <td>{{ $coin->pair }}</td>
                          <td class="align-right">{{ $coin->total_quantity }} {{ $coin->coin }}</td>
                          <td class="align-right price_{{ $coin->exchange }}_{{ str_replace('/', '-', $coin->pair) }}">0</td>
                          <td class="align-right pair_value_{{ $coin->exchange }}_{{ str_replace('/', '-', $coin->pair) }}">0</td>
                          <td class="align-right profit_loss_{{ $coin->exchange }}_{{ str_replace('/', '-', $coin->pair) }}">0</td>
                          <td class="align-right">
                            <span class="price profit_loss_fiat_{{ $coin->exchange }}_{{ str_replace('/', '-', $coin->pair) }}">
                              0
                            </span>
                          </td>
                          <td class="align-right">
                            @if($coin->type == 1)
                              <span class="badge bg-green" style="width: 80px;background: #00a65a;">@lang('user.HOLDING')</span>
                            @else
                              <span class="badge bg-yellow" style="width: 80px;background: #f39c12;">@lang('user.WATCH_ONLY')</span>
                            @endif
                          </td>
                          <td class="right">
                            <a style="cursor: pointer;" onclick="removeCoin('{{ $coin->id }}', '{{ $coin->transaction_id }}')">
                              <i class="fa fa-times-circle"></i> Remove
                            </a>
                          </td>
                      </tr>
                    @endif
                  @endforeach
                  @else
                  <tr>
                    <td>
                      @lang('user.NO_COIN_IN_BLOCKFOLIO')
                      <a href="{{ makeUrl('user/add-blockfolio') }}">
                        <i class="fa fa-fw fa-plus-circle"></i> @lang('user.ADD_BLOCKFOLIO_COIN')
                      </a>
                    </td>
                  </tr>
                  @endif
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
