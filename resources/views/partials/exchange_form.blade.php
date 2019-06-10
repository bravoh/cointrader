<form action="{{route('bitChange')}}" method="POST">
    {{csrf_field()}}
    <div class="card__body">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th colspan="2">You will send to us</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="10%">
                    <img src="{{url("public/storage/".$pair->send->icon)}}" width="60px" height="60px" class="img-circle" style="background:#ffffff;border:2px solid #c1c1c1;">
                </td>
                <td>
                    <div class="form-group">
                        <label>Amount which will send to us</label>
                        <input type="text" class="form-control" placeholder="Example: 100" id="bit_amount_send" name="bit_amount_send" onkeyup="bit_calculator();" onkeydown="bit_calculator();">
                        <br>
                        <span class="pull-left text-muted">
                            Exchange rate: {{$pair->rate}} {{$pair->send->name}} = 1 {{$pair->receive->name}}
                            <input type="hidden" name="bit_rate_from" id="bit_rate_from" value="{{$pair->rate}}">
                            <input type="hidden" name="bit_rate_to" id="bit_rate_to" value="1">
                            <input type="hidden" name="bit_currency_from" id="bit_currency_from" value="{{explode(" ",$pair->send->name)[1]}}">
                            <input type="hidden" name="bit_currency_to" id="bit_currency_to" value="{{explode(" ",$pair->receive->name)[1]}}">
                            <input type="hidden" name="bit_pair" id="bit_pair" value="{{$pair->id}}">
                            <br>
                        </span>
                        <span class="pull-right text-muted">
                            Minimal amount: 20 {{explode(" ",$pair->send->name)[1]}}<br>
                            Maximum amount: 10000 {{explode(" ",$pair->send->name)[1]}}
                        </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="table table-stripped">
            <thead>
            <tr>
                <th colspan="2">We will send to you</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="10%">
                    <img src="{{url("public/storage/".$pair->receive->icon)}}" width="60px" height="60px" class="img-circle" style="background:#ffffff;border:2px solid #c1c1c1;">
                </td>
                <td>
                    <div class="form-group">
                        <label>The amount you will receive from us</label>
                        <input type="text" class="form-control" disabled="" id="bit_amount_receive">
                        <input type="hidden" name="bit_amount_receive" id="bit_amount_receive2">
                        <br>
                        <span class="pull-right text-muted">Reserve: 2611.15844985 {{explode(" ",$pair->receive->name)[1]}}</span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="table table-stripped">
            <thead>
            <tr>
                <th>We require from you</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="form-group">
                        <label>Your email address</label>
                        <input type="text" class="form-control" name="bit_u_field_1">
                    </div>
                    <div class="form-group">
                        <label>Your {{$pair->receive->name}} address</label>
                        <input type="text" class="form-control" name="bit_u_field_2">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" name="bit_gateway_send" value="11">
        <input type="hidden" name="bit_gateway_receive" value="32">
        <span class="pull-left">
            By pressing button "Exchange" you automatically accept our <a href="https://ecurrencyexchange.info/pages/terms-of-services">Terms of services</a>.
        </span>
        <span class="pull-right">
            <button type="submit" class="btn btn-primary" name="bit_exchange">Exchange</button>
        </span>
        <br><br><br>
    </div>
</form>