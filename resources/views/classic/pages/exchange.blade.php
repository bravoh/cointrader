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
    <style>
        .scroll_box {
            height: 300px;
            max-height: 300px;
            overflow-y: auto;
        }

        .listings-grid__body>h5,
        .listings-grid__body>small {
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .header__recommended .listings-grid {
            margin: 0 auto;
            max-width: 1300px
        }

        @media (min-width:700px) {
            .header__recommended .listings-grid {
                padding: 0 70px
            }
        }

        .header__recommended .listings-grid__item {
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
            margin: 0 12px 0 13px
        }

        .header__recommended .listings-grid__main {
            border: 3px solid #fff
        }

        .listings-grid__item {
            background-color: #fff;
            display: block;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
            border-radius: 2px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
            -webkit-transition: background-color;
            -o-transition: background-color;
            transition: background-color;
            -webkit-transition-duration: .3s;
            transition-duration: .3s
        }

        .listings-grid__item:hover {
            background-color: #fffdee
        }

        .listings-grid__item.listings-grid__item--sold:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: url(../img/sold.png) bottom 15px right 30px no-repeat;
            background-size: 100px;
            z-index: 10
        }

        .listings-grid__body {
            padding: 18px 20px 13px
        }

        .listings-grid__body>small {
            color: #9c9c9c;
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
            font-weight: 500;
            line-height: 16px
        }

        .listings-grid__body>h5 {
            font-size: 13px;
            margin: 0 0 5px
        }

        .listings-grid__body>h5,
        .listings-grid__body>small {
            overflow: hidden
        }

        .listings-grid__main.pull-left {
            padding-right: 0
        }

        .listings-grid__main>img {
            width: 100%;
            -webkit-transition: opacity;
            -o-transition: opacity;
            transition: opacity;
            -webkit-transition-duration: .2s;
            transition-duration: .2s
        }

        .listings-grid__price {
            position: absolute;
            font-weight: 500
        }

        .listings-grid__attrs {
            margin: 0;
            list-style: none;
            padding: 13px 12px 13px 18px;
            border-top: 1px solid rgba(0, 0, 0, .04)
        }

        .listings-grid__attrs>li {
            display: inline-block;
            vertical-align: top;
            padding: 0;
            font-size: 13px;
            font-weight: 500;
            color: #828282;
            margin-right: 13px
        }

        .listings-grid__attrs>li>a {
            display: block
        }

        .listings-grid__icon {
            height: 16px;
            background-repeat: no-repeat;
            background-position: center;
            display: inline-block;
            vertical-align: top;
            margin-top: 1px;
            opacity: .9;
            filter: alpha(opacity=90)
        }

        .listings-grid__icon--bed {
            background-image: url(../img/icons/bed.png);
            width: 22px
        }

        @media only screen and (-webkit-min-device-pixel-ratio:2),
        only screen and (min--moz-device-pixel-ratio:2),
        only screen and (-o-min-device-pixel-ratio:2/1),
        only screen and (min-device-pixel-ratio:2),
        only screen and (min-resolution:192dpi),
        only screen and (min-resolution:2dppx) {
            .listings-grid__icon--bed {
                background-image: url(../img/icons/bed@2x.png);
                background-size: 22px 16px
            }
        }

        .listings-grid__icon--bath {
            background-image: url(../img/icons/bath.png);
            width: 21px
        }

        @media only screen and (-webkit-min-device-pixel-ratio:2),
        only screen and (min--moz-device-pixel-ratio:2),
        only screen and (-o-min-device-pixel-ratio:2/1),
        only screen and (min-device-pixel-ratio:2),
        only screen and (min-resolution:192dpi),
        only screen and (min-resolution:2dppx) {
            .listings-grid__icon--bath {
                background-image: url(../img/icons/bath@2x.png);
                background-size: 21px 16px
            }
        }

        .listings-grid__icon--parking {
            background-image: url(../img/icons/parking.png);
            width: 24px
        }

        @media only screen and (-webkit-min-device-pixel-ratio:2),
        only screen and (min--moz-device-pixel-ratio:2),
        only screen and (-o-min-device-pixel-ratio:2/1),
        only screen and (min-device-pixel-ratio:2),
        only screen and (min-resolution:192dpi),
        only screen and (min-resolution:2dppx) {
            .listings-grid__icon--parking {
                background-image: url(../img/icons/parking@2x.png);
                background-size: 24px 16px
            }
        }

        .listings-grid .listings-grid__main {
            position: relative
        }

        .listings-grid .listings-grid__price {
            bottom: 0;
            left: 0;
            background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
            background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=0);
            width: 100%;
            color: #fff;
            padding: 30px 20px 15px;
            font-size: 17px
        }

        .listings-grid__favorite {
            position: absolute;
            z-index: 1;
            bottom: 6px;
            right: 10px
        }

        @media (min-width:992px) {
            .listings-list .listings-grid__body {
                padding-right: 105px
            }
            .listings-list .listings-grid__price {
                top: 18px;
                right: 22px
            }
        }

        @media (min-width:768px) {
            .listings-list:not(.listings-list--alt) .listings-grid__main {
                width: 175px;
                border: 3px solid #Fff
            }
            .listings-list.listings-list--alt .listings-grid__main {
                width: 155px
            }
        }

        @media (max-width:991px) {
            .listings-list .listings-grid__main {
                position: relative
            }
            .listings-list .listings-grid__main .listings-grid__price {
                bottom: 0;
                left: 0;
                background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
                background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
                background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, .5) 100%);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=0);
                width: 100%;
                color: #fff;
                padding: 30px 20px 15px;
                font-size: 15px
            }
        }

        @media (max-width:767px) {
            .listings-list {
                border-radius: 3px 3px 2px 2px
            }
            .listings-list .listings-grid__main,
            .listings-list .media-body {
                width: 100%
            }
        }

        .listings-list .listings-grid__price {
            color: #2e353b;
            font-weight: 700
        }

        .listings-list--alt .listings-grid__item {
            padding: 20px;
            margin: 0;
            box-shadow: none;
            border-radius: 0
        }

        .listings-list--alt .listings-grid__item:not(:last-child) {
            border-bottom: 1px solid #eee
        }

        .listings-list--alt .listings-grid__main>img {
            border-radius: 2px
        }

        .listings-list--alt .listings-grid__main .listings-grid__price {
            border-radius: 0 0 3px 3px
        }

        .listings-list--alt .listings-grid__attrs {
            padding: 0 0 0 20px;
            border: 0
        }

        @media (max-width:767px) {
            .listings-list--alt .listings-grid__attrs,
            .listings-list--alt .listings-grid__body {
                padding-left: 0;
                padding-right: 0
            }
        }

        /* Let's get this party started */
        ::-webkit-scrollbar {
            width: 1px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 1px #fafafa;
            -webkit-border-radius: 1px;
            border-radius: 1px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #fafafa;
            -webkit-box-shadow: inset 0 0 1px #fafafa;
        }
        ::-webkit-scrollbar-thumb:window-inactive {
            background: #fafafa;
        }

        .list-group-item:first-child {
            border-top-left-radius: 0px !important;
            border-top-right-radius: 0px !important;
        }

        .list-group-item:last-child {
            margin-bottom: 0;
            border-bottom-right-radius: 0px !important;
            border-bottom-left-radius: 0px !important;
        }
    </style>
@stop

@section('content')
    <input type="hidden" value="{{url("")}}" id="url">
    <div class="ui segment">
        <div class="ui teal large ribbon label">
            <i class="tag icon"></i>
        </div>
        <h1>@lang('headings.EXCHANGES_PAGE')</h1>
    </div>

    <div class="listings-grid">
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <div class="listings-grid__item">
                    <ul class="listings-grid__attrs">
                        <li>Send</li>
                    </ul>

                    <div class="scroll_box">
                        <div class="list-group" id="list-group-1">
                            @foreach($gateways as $item)
                            <a href="javascript:void(0);" onclick="bit_load_receive_list({{$item->id}});" class="list-group-item">
                                <img src="{{url("public/storage/".$item->icon)}}" width="32px" height="32px">
                                {{$item->name}}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8">
                <div class="listings-grid__item">
                    <ul class="listings-grid__attrs">
                        <li>Receive</li>
                    </ul>
                    <div class="scroll_box">
                        <div class="list-group">
                            <span id="list-group-2"></span>
                            <a class="list-group-item" id="list_loading" style="display: none;" href="#"><i class="fa fa-spin fa-spinner"></i> Loading list... Please wait.</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="ui segment coins_page_headings">
                    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                    <h1>Latest <b>Exchanges</b></h1>
                </div>

                <div class="card__body">
                    <div class="list-group">
                        <a href="javascript:void(0);" class="list-group-item" style="min-height:45px;">
                            <span class="pull-left">
                                <img src="https://ecurrencyexchange.info/uploads/1546024952_icon.jpg" width="18px" height="18px">
                                <i class="fa fa-exchange"></i>
                                <img src="https://ecurrencyexchange.info/uploads/1529514995_icon.png" width="18px" height="18px">
                            </span>
                            <span class="pull-left" style="margin-left:10px;">Exchange <b>#295714D51C***************</b> for 1 TBC (1.00 BCC)</span>
                            <span class="pull-right">
                                <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Canceled">
                                    <i class="fa fa-times"></i>
                                </span>
                            </span>
                            <span class="hidden-lg hidden-md"><br><br><br><br></span>
                        </a>
                        <a href="javascript:void(0);" class="list-group-item" style="min-height:45px;">
                            <span class="pull-left">
                                <img src="https://ecurrencyexchange.info/uploads/1546024952_icon.jpg" width="18px" height="18px">
                                <i class="fa fa-exchange"></i>
                                <img src="https://ecurrencyexchange.info/assets/icons/Ethereum.png" width="18px" height="18px">
                            </span>
                            <span class="pull-left" style="margin-left:10px;">
                                Exchange <b>#0FAE64B23E***************</b> for 0.000116 TBC (0.06 ETH)
                            </span>
                            <span class="pull-right">
                                <span class="label label-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Processed">
                                    <i class="fa fa-check"></i>
                                </span>
                            </span>
                            <span class="hidden-lg hidden-md">
                                <br><br><br><br>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card__header card__header--minimal">
                    <h2><b>Testimonials</b></h2>
                </div>

                <div style="font-size: 14px" class="card__body">
                    <p>
                        E-currency Exchange, the best exchangers among others and around the world, I got my BTC within 30 mins I vouch for them 100% very fast , reliable and trusted!!!!<br>
                        <small>from <a href="javascript:void(0);">Steve K</a></small>
                    </p>

                    <p>
                        TBC finally got a trusted exchanger, just did it in a minute, great job guys, i'll recommend you any day to the whole world<br>
                        <small>from <a href="javascript:void(0);">Jack Wilha</a></small>
                    </p>

                </div>
            </div>
        </div>

    </div>

@stop

@section("scripts")
    <script src="{{ URL::asset('public/js/bitexchanger.js') }}"></script>
@endsection
