@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.BLOCKFOLIO_TXS_HISTORY_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.BLOCKFOLIO_TXS_HISTORY_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blockfolio_trans.png' }}@stop
@section('styles')
<style type="text/css">
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 8px 15px !important;}
</style>
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="ui segment coins_page_headings">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
          <h1>@lang('user.BLOCKFOLIO_TRANSACTIONS_PAGE_HEADING')</h1>
          <a href="{{ makeUrl('user/add-blockfolio') }}" style="float: right;">
            <i class="fa fa-fw fa-plus-circle"></i> @lang('user.ADD_BLOCKFOLIO_COIN')
          </a>
      </div>
      <div class="row">
        <div class="col-lg-12">     
          <div class="loader"></div>                   
            <div class="table-responsive">
            <table width="100%" class="table dataTable no-footer dtr-inline collapsed table-hover">
              <thead>
                  <tr>
                      <th>@lang('tbl_headings.TRANSACTION_ID')</th>
                      <th class="align-right">@lang('tbl_headings.COIN')</th>
                      <th class="align-right">@lang('tbl_headings.EXCHANGE')</th>
                      <th class="align-right">@lang('tbl_headings.PAIR')</th>
                      <th class="align-right">@lang('tbl_headings.QUANTITY')</th>
                      <th class="align-right">@lang('tbl_headings.PRICE')</th>
                      <th class="align-right">@lang('tbl_headings.TYPE')</th>
                      <th class="align-right">@lang('tbl_headings.TRANSACTION_TIME')</th>
                  </tr>
              </thead>
              <tbody class="blockfolio-records">
                @if(count($coins) > 0)
                  @foreach ($coins as $coin)
                    <tr exchange="{{ $coin->exchange }}" pair="{{ str_replace('/', '-', $coin->pair) }}" quantity="{{ $coin->total_quantity }}">
                        <td>{{ $coin->transaction_id }}</td>
                        <td class="align-right">{{ $coin->coin }}</td>
                        <td class="align-right">{{ ucwords($coin->exchange) }}</td>
                        <td class="align-right">{{ $coin->pair }}</td>
                        <td class="align-right">{{ formatBTCPrice($coin->quantity) }} {{ $coin->coin }}</td>
                        <td class="align-right">{{ formatBTCPrice($coin->price) }}</td>
                        <td class="align-right">
                          @if($coin->type == 1)
                            <span class="badge bg-green" style="width: 80px;background: #00a65a;">@lang('user.HOLDING')</span>
                          @elseif($coin->type == 2)  
                            <span class="badge bg-red" style="width: 80px;background: #dd4b39;">@lang('user.SOLD')</span>
                          @else
                            <span class="badge bg-yellow" style="width: 80px;background: #f39c12;">@lang('user.WATCH_ONLY')</span>
                          @endif
                        </td>
                        <td class="align-right">{{ $coin->created_at }}</td>
                    </tr>
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
