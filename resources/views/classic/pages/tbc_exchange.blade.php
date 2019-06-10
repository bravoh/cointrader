<?php
$user = auth()->user();
?>
@extends(getCurrentTemplate() . '.layouts.default')

@section('meta_title')
    @lang('seo.EXCHANGES_TITLE')
@stop

@section('meta_desc')
    @lang('seo.EXCHANGES_DESCRIPTION')
@stop

@section('meta_link')
    {{ Request::url() }}
@stop

@section('meta_image')
    {{ URL::asset('public/images/pages/images') . '/exchanges.png' }}
@stop

@section('styles')

@stop

@section('content')
    <input type="hidden" value="{{url("")}}" id="url">
    <div class="ui segment">
        <div class="ui teal large ribbon label">
            <i class="tag icon"></i>
        </div>
        <h1>GET TBC </h1>
    </div>

    <div class="row" style="margin-left: 0px;">
        <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">

            <div class="ui segment">

                <div class="coins_page_headings latest-block-btn">
                    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h2></h2>
                </div>
                <div class="ui divider"></div>

                <p>
                    TBC is a community coin which is not yet listed in crypto market capitalisation,
                    to enable us process your exchange for TBC to other crypto currency in capital markets there's a fees of 25$
                    for private mining programmers to enable our contract speed up in exchange transaction.
                </p>
                <p>
                    And every amount exchange 10% is deducted before exchange completed.
                    Our exchange start from 200$ minimum and maximum of 1000$.
                    TBC community are not allowed to transact more than 1000$ at a go.
                    Our terms allow an individual to exchange upto 1000$ per week..
                </p>
                <hr/>
                @if($user->tbc)
                    @include("partials.exchange_form")
                @else
                    <h1 style="text-align: center">Click the PayPal Payment button below to activate TBC Mining</h1>
                    <input type="hidden" name="uuu" class="uuu" value="{{auth()->user()->id}}">
                    <input type="hidden" class="product" name="product" value="tbc subscription">
                    <input type="hidden" class="amount" name="amount" value="25">
                    <!-- Set up a container element for the button -->
                    <div style="margin-left: auto !important;" id="paypal-button-container"></div>
                @endif
            </div>

        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="col-md-13">
                <div>
                    <div class="single_post_content ui segment">
                        <div class="box box-success table-heading-class" style="box-shadow: unset;">
                            <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                                <h3 class="box-title">How it works</h3>
                            </div>
                        </div>
                        <br/>
                        <ul class="spost_nav single-page-news" style="list-style: none;padding: 0px;margin:0px;">
                            <li>Pay $25 mining fee</li>
                            //////<br><br>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("scripts")
    @if(!$user->tbc)
    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AeUetr4mIaW3BgcaJeJcVZUx8Jy-OZlwPVC1mq2uLG8huJJPniREe5X8qESvdo4CBJmiwI6UNy8CiuJz&currency=USD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: $(".amount").val()
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    //console.log(details);
                    $.ajax({
                        method: "POST",
                        url: "{{url('api/callbacks/paypal-tbc')}}",
                        data: {
                            payment_details: details,
                            product: $('.product').val(),
                            uuu:$('.uuu').val()
                        },success: function (res,data) {
                            window.location.reload();
                        }
                    })
                });
            }
        }).render('#paypal-button-container');
    </script>
    @else
        <script src="{{ URL::asset('public/js/bitexchanger.js') }}"></script>
    @endif
@endsection
