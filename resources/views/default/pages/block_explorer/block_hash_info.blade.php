@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.BLOCKEXPLORER_HASH_PAGE_TITLE')@stop
@section('meta_desc')@lang('seo.BLOCKEXPLORER_HASH_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/block_hash_info.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
<style type="text/css">.search-btn{width: 165px;}div.table-responsive {overflow-x: hidden !important;}</style>
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "iDisplayLength": 25,
        "bFilter": true,
        "bLengthChange": false,
        "bInfo" : false,
        bFilter: false,
        "aaSorting": [],
        "language": {
            "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
        }
    });
    $('.block-search-btn').on('click', function(){
        window.location = APP_URL + '/block-explorer?hash='+$('#block_hash').val();
    });
});
</script>
@stop 
@section('content')
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
	          <h1>@lang('blockexplorer.BLOCK_SUMMARY')</h1>
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
			                <th>@lang('blockexplorer.PREV_BLOCK_HASH')</th>
			                <td>
			                	<a href="{{ makeUrl('block-explorer') }}?hash={{ $block->prev_block }}"> {{ $block->prev_block }} </a>
			                </td>
			            </tr>
			            <tr>
			                <th>@lang('blockexplorer.MERKLE_HASH')</th>
			                <td>{{ $block->mrkl_root }}</td>
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
			                <th>@lang('blockexplorer.BLOCK_TXS')</th>
			                <td>{{ $block->n_tx }}</td>
			            </tr>
			            <tr>
			                <th>@lang('blockexplorer.BLOCK_BITS')</th>
			                <td>{{ $block->bits }}</td>
			            </tr>
			            <tr>
			                <th>@lang('blockexplorer.BLOCK_SIZE')</th>
			                <td>{{ $block->size }}</td>
			            </tr>
			            <tr>
			                <th>@lang('blockexplorer.BLOCK_VERSION')</th>
			                <td>{{ $block->ver }}</td>
			            </tr>
			            <tr>
			                <th>@lang('blockexplorer.BLOCK_NONCE')</th>
			                <td>{{ $block->nonce }}</td>
			            </tr>
		            </tbody>
		        </table>
		    </div>
		    <div class="ui segment coins_page_headings">
	          <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
	          <h1>@lang('blockexplorer.BLOCK_TXS')</h1>
	        </div>
		    <div class="table-responsive">
		        <table style="width: 100%;" class="table dataTable no-footer dtr-inline collapsed" id="dataTables-example">
		        	<thead>
		        		<tr>
		        			<th width="25">@lang('blockexplorer.BLOCK_TX')</th>
		        			<th class="align-right">@lang('blockexplorer.BLOCK_TX_INDEX')</th>
		        			<th class="align-right">@lang('blockexplorer.BLOCK_IO')</th>
		        			<th class="align-right">@lang('blockexplorer.BLOCK_WEIGHT')</th>
		        			<th class="align-right">@lang('blockexplorer.BLOCK_SIZE')</th>
		        			<th class="align-right">@lang('blockexplorer.BLOCK_BT')</th>
		        		</tr>
		        	</thead>
		            <tbody>
		            	@php
						$i = 0
						@endphp
		            	@foreach($block->tx as $transactions)
		            	@if($i == 100)
		            	@php continue @endphp
		            	@endif
		            	<tr>
		            		<td>
		            			<a href="https://blockchain.info/tx/{{ $transactions->hash }}" rel="nofollow" target="_blank"> 
		            				{{ str_limit($transactions->hash, 20) }} 
		            			</a>
		            		</td>
		            		<td class="align-right">{{ $transactions->tx_index }}</td>
		            		<td title="inputs / outputs" class="align-right">
		            			<span class="badge bg-green" style="width: 50px;background-color: #00a65a;">
		            				{{ $transactions->vin_sz }} / {{ $transactions->vout_sz }}
		            			</span>
		            		</td>
		            		<td class="align-right">{{ $transactions->weight }}</td>
		            		<td class="align-right">{{ $transactions->size }}</td>
		            		<td class="align-right">{{ date("F j, Y g:i:s a", $transactions->time) }}</td>
		            	</tr>   	
		            	@php $i++ @endphp
		    			@endforeach
		            </tbody>
		        </table>
		    </div>
		</div>
    </div>
</div>
@stop
