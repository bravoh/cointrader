@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.ADD_BLOCKFOLIO_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.ADD_BLOCKFOLIO_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/add_blockfolio.png' }}@stop
@section('styles')
<style type="text/css">.blockfolio-table tr td{text-align: left;width: 50%;border-top: unset !important;}</style>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/loader.css') }}">
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/blockfolio.js') }}"></script>
@stop
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="box box-success table-heading-class">
                  <div class="box-header with-border">
                      <h3 class="box-title"> @lang('user.ADD_BLOCKFOLIO_PAGE_HEADING') </h3>
                  </div>
              </div>
            <div class="panel-body">
              <div class="col-md-12">
              <div class="loader"></div>
                <form role="form" method="POST" action="{{ makeUrl('user/add-coin') }}">
                  {{ csrf_field() }}
                  <div class="box-body">
                    <div class="form-group">
                      <label>@lang('user.SELECT_COIN')</label>
                      <select name="coin" class="form-control select-coin" onchange="getExchanges(this.value)">
                        <option value="-1">@lang('user.SELECT_COIN')</option>
                        @foreach($coins as $coin)
                          <option value="{{ strtoupper($coin->symbol) }}">
                            {{ ucwords($coin->name) }} : {{ ucwords($coin->symbol) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('user.SELECT_EXCHANGE')</label>
                      <select name="exchange" disabled="disabled" class="form-control select-exchange" onchange="getPairs(this.value)"></select>
                    </div>
                    <div class="form-group">
                      <label>@lang('user.SELECT_PAIR')</label>
                      <select name="pair" disabled="disabled" class="form-control select-pair" onchange="getPrice(this.value)"></select>
                    </div>
                    <div class="form-group">
                      <label>@lang('user.PRICE')</label>
                      <input name="price" disabled="disabled" class="form-control add-price" id="coin_price" onkeyup="calculatePrice(this.value)" placeholder="@lang('user.PRICE')" type="number" step="0.000000000000001">
                    </div>
                    <div class="form-group">
                      <label>@lang('user.QUANTITY')</label>
                      <input name="quantity" disabled="disabled" class="form-control quantity get-quan" onkeyup="calculateValue(this.value)" placeholder="add quantity" type="number" step="0.000000000000001">
                    </div>
                    <div class="form-group">
                      <label>@lang('user.TYPE')</label>
                      <select name="type" class="form-control">
                      <option value="1">@lang('user.BUY')</option>
                      <option value="2">@lang('user.SELL')</option>
                      <option value="3">@lang('user.WATCH_ONLY')</option>
                      </select>
                    </div>
                    <!-- <input type="hidden" name="price" value="" id="coin_price"> -->
                    <div class="form-group">
                      <button disabled="disabled" type="submit" class="add-coin-btn btn btn-primary">@lang('user.ADD_BLOCKFOLIO_COIN')</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
              <div class="col-md-12">
                <table class="blockfolio-table table table-hover">
                  <tr>
                  <td><strong>@lang('user.COIN')</strong></td>
                  <td class="coin">@lang('user.SELECT_COIN')</td>
                </tr>
                <tr>
                  <td><strong>@lang('user.EXCHANGE')</strong></td>
                  <td class="exchange">---</td>
                </tr>
                <tr>
                  <td><strong>@lang('user.PAIR')</strong></td>
                  <td class="pair">---</td>
                </tr>
                <tr>
                  <td><strong>@lang('user.PRICE')</strong></td>
                  <td class="price">---</td>
                </tr>
                <tr>
                  <td><strong>@lang('user.QUANTITY')</strong></td>
                  <td class="quantity">---</td>
                </tr>
                <tr>
                  <td><strong>@lang('user.VALUE')</strong></td>
                  <td class="value">---</td>
                </tr>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
@stop
