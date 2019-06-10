function streaming(streaming_data)
{
    var currentPrice = {};
    var socket = io.connect('https://streamer.cryptocompare.com/');
    var subscription = streaming_data;
    socket.emit('SubAdd', { subs: subscription });
    socket.on("m", function(message) {
        var messageType = message.substring(0, message.indexOf("~"));
        var res = {};
        if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
            res = CCC.CURRENT.unpack(message);
            dataUnpack(res);
        }
    });

    var dataUnpack = function(data) {
        var from = data['FROMSYMBOL'];
        var to = data['TOSYMBOL'];
        var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
        var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
        var pair = from + to;
        // console.log(data);

        if (!currentPrice.hasOwnProperty(pair)) {
            currentPrice[pair] = {};
        }
        for (var key in data) {
            currentPrice[pair][key] = data[key];
        }
        if (currentPrice[pair]['LASTTRADEID']) {
            currentPrice[pair]['LASTTRADEID'] = parseInt(currentPrice[pair]['LASTTRADEID']).toFixed(0);
        }
        currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
        currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100).toFixed(2) + "%";
        displayData(currentPrice[pair], from, tsym, fsym);
    };

    var displayData = function(current, from, tsym, fsym) {
        // console.log(current);
        var color = 'red';
        $('.crypto-currencies-data tr').removeClass('up').removeClass('down');
        var priceDirection = current.FLAGS;
        for (var key in current) {
            if (key == 'CHANGE24HOURPCT') {
                if(current[key] != 'NaN%') {
                    if(current[key].slice(0, -1) > 0) {
                        color = 'green';
                    }
                    //$('#' + key + '_' + from).html("<span style='color: "+color+"'>"+current[key]+"</span>");
                }
            }
            else if (key == 'LASTVOLUMETO' || key == 'VOLUME24HOURTO') {
                //$('#' + key + '_' + from).text(CCC.convertValueToDisplay(tsym, current[key]));
            }
            else if (key == 'LASTVOLUME' || key == 'VOLUME24HOUR' || key == 'OPEN24HOUR' || key == 'OPENHOUR' || key == 'HIGH24HOUR' || key == 'HIGHHOUR' || key == 'LOWHOUR' || key == 'LOW24HOUR') {
                //$('#' + key + '_' + from).text(CCC.convertValueToDisplay(fsym, current[key]));
            }
            else if(key == 'PRICE') {
                var decimal = 5;
                var amount = current[key]*$(".top-currency-dropdown .selected").attr('value');
                if (amount >= 1) {
                    decimal = 2;
                }
                var formatted_amount = $(".top-currency-dropdown .selected").attr('id') + "" + formatAmount(amount, decimal, false);
                $('#' + key + '_' + from).text(formatted_amount);
            } else {
                $('#' + key + '_' + from).text(current[key]);
            }
        }

        $('#PRICE_' + from).removeClass("up").removeClass("down");
        $('#TABLE_ROW_' + from).removeClass("up").removeClass("down");
        if (priceDirection & 1) {
            $('#PRICE_' + from).addClass("up");
            $('#TABLE_ROW_' + from).addClass("up");
        } else if (priceDirection & 2) {
            $('#PRICE_' + from).addClass("down");
            $('#TABLE_ROW_' + from).addClass("down");
        }
    };
}
