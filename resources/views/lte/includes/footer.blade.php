<a href="javascript:" id="return-to-top"><i class="fa fa-angle-up"></i></a>
@include(getCurrentTemplate() . ".includes.footer-three-column")
<div id="myModal" class="modal fade" role="dialog" style="z-index: 99999;">
  <div class="modal-dialog">
    <div class="modal-content" style="color: black; text-align: center;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Donate <span class="donate-coin">BTC</span></strong></h4>
      </div>
      <div class="modal-body">
        <p class="donate-coin-addr" style="font-size: 20px;word-wrap: break-word;"></p>
        <p class="donate-coin-qr"></p>
      </div>
    </div>
  </div>
</div>
<script src="{{ URL::asset('public/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('public/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button);</script>
<script src="{{ URL::asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<script src="{{ URL::asset('public/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ URL::asset('public/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ URL::asset('public/dist/js/adminlte.js') }}"></script>
<script src="{{ URL::asset('public/js/semantic-ui/semantic.min.js') }}"></script>
<script src="{{ URL::asset('public/dist/js/demo.js') }}"></script>
<script src="{{ URL::asset('public/js/cookieconsent/cookieconsent.min.js') }}"></script>
<script src="{{ URL::asset('public/js/lte/custom-js/common.js') }}"></script>
<script src="{{ URL::asset('public/js/scroll_top_button.js') }}"></script>
<script type="text/javascript">
$('.ui.dropdown').dropdown();
$(document).ready(function() {
cookiePolicyDialog("{{ trans('constants.COOKIE_POLICY_TEXT') }}", "{{ trans('constants.COOKIE_POLICY_BUTTON') }}");
$('.donate-coin-addrs').click(function(){
	var name = $(this).attr('name');
	var addr = $(this).attr('addr');
	$('.donate-coin').html(name);
	$('p.donate-coin-addr').html(addr);
	$('p.donate-coin-qr').html('<img width="80%" src="https://chart.googleapis.com/chart?chs=350x350&chld=L|2&cht=qr&chl='+addr+'" />');
});
});
</script>
@yield('scripts')