@if($gateway->id == 13)
    <p style="padding: 15px">
        TBC is a community coin which is not yet listed in crypto market capitalisation,
        to enable us process your exchange for TBC to other crypto currency in capital markets there's a fees of
        25$ for private mining programmers to enable our contract speed up in exchange transaction.
        And every amount exchange 10% is deducted before exchange completed. Our exchange start from 200$ minimum and maximum of 1000$.
        TBC community are not allowed to transact more than 1000$ at a go.
        Our terms only allowed individual to exchange upto 1000$ per week..
    </p>
@else
    @foreach($pairings as $item)
        <a href="{{url("change",$item->id)}}" class="list-group-item">
            <img src="{{url("public/storage/".$item->receive->icon)}}" width="32px" height="32px">
            {{$item->receive->name}}
            <span class="pull-right text text-muted hidden-xs hidden-sm" style="font-size:11px;">
                <small>Reserve: {{$item->reserve}}<br/>Exchange rate: {{$item->rate}}</small>
            </span>
        </a>
    @endforeach
@endif