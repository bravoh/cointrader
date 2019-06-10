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
        <h1>YOUR PAYMENT WAS RECEIVED </h1>
    </div>

    <div class="row" style="margin-left: 0px;">
        <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">

            <div class="ui segment">

                <div class="coins_page_headings latest-block-btn">
                    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h2>RECEIPT NO: {{$payment->ref_no}}</h2>
                </div>
                <div class="ui divider"></div>

                    <table class="table table-striped" style="font-size:16px;">
                        <tbody>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>{{explode(' ',$payment->order->bit_pair->send->name)[1]}} »»»» {{explode(' ',$payment->order->bit_pair->receive->name)[1]}}</td>
                            <td>{{$payment->order->send_amount}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Total</th>
                            <th>{{$payment->order->send_amount}}</th>
                        </tr>
                        </tbody>
                    </table>
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
                            {{$payment->order->receive_amount}} {{explode(' ',$payment->order->bit_pair->receive->name)[1]}} will be send to the address you provided: {{$payment->order->crypto_address}}
                            <br><br>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("scripts")

@endsection
