<a href="javascript:" id="return-to-top"><i class="angle up icon"></i></a> 
@include(getCurrentTemplate() . ".includes.footer-three-column" ) 
<div id="myModal" class="modal fade" role="dialog" style="z-index: 99999;">
    <div class="modal-dialog">
        <div class="modal-content" style="color: black; text-align: center;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><strong>Donate <span class="donate-coin">BTC</span></strong></h6></div>
            <div class="modal-body">
                <p class="donate-coin-addr" style="font-size: 20px;word-wrap: break-word;"></p>
                <p class="donate-coin-qr"></p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/metisMenu/metisMenu.min.js') }}" async></script>
<script src="{{ URL::asset('public/js/sb-admin-2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
<script src="{{ URL::asset('public/js/custom-js/common.js') }}"></script>
<script src="{{ URL::asset('public/js/scroll_top_button.js') }}"></script>
<script src="{{ URL::asset('public/js/cookieconsent/cookieconsent.min.js') }}" async></script> 
<script type="text/javascript">
$('.ui.dropdown').dropdown();
$(document).ready(function(){
  cookiePolicyDialog("{{ trans('constants.COOKIE_POLICY_TEXT') }}", "{{ trans('constants.COOKIE_POLICY_BUTTON') }}");
  $('.donate-coin-addrs').click(function(){
    var name = $(this).attr('name');
    var addr = $(this).attr('addr');
    $('.donate-coin').html(name);
    $('p.donate-coin-addr').html(addr);
    $('p.donate-coin-qr').html('<img width="80%" src="https://chart.googleapis.com/chart?chs=300x300&chld=L|2&cht=qr&chl='+addr+'" />');
  });
});
</script>
@yield('scripts')