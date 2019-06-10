@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.BLOCKEXPLORER_PAGE_TITLE')@stop
@section('meta_desc')@lang('seo.BLOCKEXPLORER_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/blockexplorer.png' }}@stop
@section('styles')
<style type="text/css">.search-btn{width: 150px;}th, td{border-left: unset!important;}</style>
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
@stop
@section('scripts')
<script type="text/javascript">$(document).ready(function(){$('.block-search-btn').on('click', function(){window.location = APP_URL + '/block-explorer?hash='+$('#block_hash').val();});});</script>
@stop
@section('content')
@if($errors)
<div class="col-md-8 col-md-offset-2 profile-account-reg-msg">
    @if($errors->first('no_block'))<div class="alert alert-danger">{{ $errors->first('no_block') }}</div>@endif
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="ui segment coins_page_headings">
          <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
          <h1>@lang('blockexplorer.BLOCK_EXPLORER_HEADING')</h1>
        </div>
        @include(getCurrentTemplate() . '.pages.block_explorer.block_search')
        <div class="panel-body">
            <div class="ui segment coins_page_headings">
              <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
              <h1>@lang('blockexplorer.LATEST_BLOCK_INFO_HEADING')</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover block-explorer-tbl">
                    <tbody>
                        <tr>
                            <th>@lang('blockexplorer.BLOCK_HASH')</th>
                            <td>
                                <a href="{{ makeUrl('block-explorer') }}?hash={{ $block->hash }}"> {{ $block->hash }} </a>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('blockexplorer.BLOCK_FOUND_TIME')</th>
                            <td>{{ $block->time }} / {{ $block->date_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('blockexplorer.BLOCK_HEIGHT')</th>
                            <td>{{ $block->height }}</td>
                        </tr>
                        <tr>
                            <th>@lang('blockexplorer.BLOCK_INDEX')</th>
                            <td>{{ $block->block_index }}</td>
                        </tr>
                        <tr>
                            <th>@lang('blockexplorer.BLOCK_TX_INDEXS')</th>
                            <td>{{ count($block->txIndexes) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
