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
        <h1>Exchange </h1>
    </div>

    <div class="row" style="margin-left: 0px;">
        <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">

            <div class="ui segment">

                <div class="coins_page_headings latest-block-btn">
                    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h2>Order #85BD5F7A8FE6043B50D2</h2>
                </div>
                <div class="ui divider"></div>
                <form id="orderForm" action="{{route('checkout.post')}}" method="POST">
                    {{csrf_field()}}
                    <table class="table table-striped" style="font-size:16px;">
                        <tbody>
                        <tr>
                            <td><b>From:</b> <span class="pull-right">{{$order->bit_pair->send->name}}</span></td>
                            <td><span class="pull-right">{{$order->send_amount}} {{explode(" ",$order->bit_pair->send->name)[1]}}</span></td>
                        </tr>
                        <tr>
                            <td><b>To:</b> <span class="pull-right">{{$order->bit_pair->receive->name}}</span></td>
                            <td><span class="pull-right">{{$order->receive_amount}} {{explode(" ",$order->bit_pair->receive->name)[1]}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Your email address:</b></td>
                            <td><span class="pull-right">{{$order->email_address}}</span></td>
                        </tr>
                        <tr>
                            <td><span class="pull-left"><b>Your {{$order->bit_pair->receive->name}} address:</b></span></td>
                            <td><span class="pull-right">{{$order->crypto_address}}</span></td>
                        </tr>											<tr>
                            <td><span class="pull-left"><b>PayPal fee:</b></span></td>
                            <td><span class="pull-right">0</span></td>
                        </tr>
                        <tr>
                            <td><span class="pull-left"><b>Total Amount:</b></span></td>
                            <td><span class="pull-right">{{$order->send_amount}} {{explode(" ",$order->bit_pair->send->name)[1]}}</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" class="order" name="order" value="{{$order->id}}">
                                <input type="hidden" class="amount" name="amount" value="{{$order->send_amount}}">
                                <!-- Set up a container element for the button -->
                                <div id="paypal-button-container"></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
                <p></p>
            </div>

        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="col-md-13">
                <div>
                    <div class="single_post_content ui segment">
                        <div class="box box-success table-heading-class" style="box-shadow: unset;">
                            <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                                <h3 class="box-title">What Next</h3>
                            </div>
                        </div>
                        <br/>
                        <ul class="spost_nav single-page-news" style="list-style: none;padding: 0px;margin:0px;">
                            1. Verify information of the order<br>
                            2. Click on button "Pay order"<br>
                            3. Make payment<br>
                            4. When payment was confirmed we will process exchange.<br><br>
                            If do not want to process this order click on button "Cancel".<br>
                            If you need help please <b><a href="#">contact us</a></b>.
                            <br><br>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("scripts")
    <script src="{{ URL::asset('public/js/bitexchanger.js') }}"></script>

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
                        url: "{{url('api/callbacks/paypal')}}",
                        data: {
                            payment_details: details,
                            order: $('.order').val()
                        },success: function (res,data) {
                            window.location.replace("{{url('receipt')}}"+"/"+res);
                        }
                    })
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
