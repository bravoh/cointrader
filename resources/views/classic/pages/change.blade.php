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
        <h1>Exchange {{$pair->send->name}} to {{$pair->receive->name}}</h1>
    </div>

    <div class="row" style="margin: 0px;">
        <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">
            <div class="card">
                @include("partials.exchange_form")
            </div>
        </div>

        <div class="col-lg-4 col-sm-12" style="padding-right: 0px;">
            <div class="single_post_content ui segment">
                <div class="box box-success table-heading-class" style="box-shadow: unset;">
                    <div class="box-header with-border">
                        <div class="ui teal large ribbon label">
                            <i class="tag icon"></i>
                        </div>
                        <h3 class="box-title">How to exchange?</h3>
                    </div>
                </div>
                <ul class="spost_nav single-page-news" style="list-style: none;padding: 0px;margin:0px;">
                    <li>
                        <br/>
                        1. Enter your amount in "Send" section
                    </li>
                    <li>2. Fill fields required by us</li>
                    <li>3. Press "Exchange" button</li>
                    <li>4. Make payment</li>
                    <li>5. When payment is confirmed we will process your exchange.</li>
                    <li>
                        <br><br>
                        If you need help please <b><a href="#">contact us</a></b>.
                        <br><br>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop

@section("scripts")
    <script src="{{ URL::asset('public/js/bitexchanger.js') }}"></script>
@endsection
