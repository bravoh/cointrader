<div class="panel-body form-section" style="text-align: center;">
	<h2>@lang('blockexplorer.BLOCK_EXPLORER_HEADING')</h2>
    <p class="lead">@lang('blockexplorer.BLOCK_EXPLORER_SEARCH_HEADING')</p>
    <div class="col-md-8 col-md-offset-2">
        <div class="input-group input-group-lg">
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary">BTC</button>
            </div>
            <input style="height: 46px;" class="form-control" id="block_hash" name="block_hash" value="{{ $block->hash }}" type="text">
        </div> <br />
        <button type="submit" class="btn btn-primary btn-lg block-search-btn search-btn"><i class="fa fa-search"></i>&nbsp;@lang('blockexplorer.SEARCH')</button>
        @if($hash != '')
        	<a href="{{ makeUrl('block-explorer') }}">
				<button type="button" class="btn btn-primary btn-lg search-btn">@lang('blockexplorer.VIEW_LATEST_BLOCK')</button>
			</a>
        @endif
    </div>
</div>