$(document).ready(function() {
    $('div.exchange-icon.fiat-to-crypto').click(function(){
        $(".fiat-to-crypto").hide();
        $(".crypto-to-fiat").show();
    });
    $('div.exchange-icon.crypto-to-fiat').click(function(){
        $(".fiat-to-crypto").show();
        $(".crypto-to-fiat").hide();
    });
    $('.fiat-dropdown .item').click(function() {
        $('.fiat-dropdown .item').removeClass('active selected');
        $('.fiat-dropdown .item.' + $(this).find('a').attr('symbol')).addClass('selected active');
        $('.fiat-dropdown .item').parent().parent().parent().find('.converter-custom-dropdown').html($(this).find('a').html());
        return true;
    });
    $('.crypto-dropdown .item').click(function() {
        $('.crypto-dropdown .item').removeClass('active selected');
        $('.crypto-dropdown .item.' + $(this).find('a').attr('symbol')).addClass('selected active');
        $('.crypto-dropdown .item').parent().parent().parent().find('.converter-custom-dropdown').html($(this).find('a').html());
        return true;
    });
    $('.fiat-to-crypto .fiat .fiat-dropdown div.item, .crypto-to-fiat .fiat .fiat-dropdown div.item').click(function() {
        var fiat = $(this).find('a').attr('value');
        var fiat_symbol = $(this).find('a').attr('symbol');
        $("div." + fiat_symbol).addClass('active selected');
        var crypto = $('.crypto-dropdown div.item.selected a').attr('value');
        var crypto_symbol = $('.crypto-dropdown div.item.selected a').attr('symbol');
        convert($('.amount').val(), fiat, crypto, fiat_symbol, crypto_symbol, true);
        convert($('.amount').val(), fiat, crypto, fiat_symbol, crypto_symbol, false);
    });
    $('.fiat-to-crypto .crypto .crypto-dropdown div.item, .crypto-to-fiat .crypto .crypto-dropdown div.item').click(function() {
        $("div." + crypto_symbol).addClass('active selected');
        var fiat = $('.fiat-dropdown div.item.selected a').attr('value');
        var fiat_symbol = $('.fiat-dropdown div.item.selected a').attr('symbol');
        var crypto = $(this).find('a').attr('value');
        var crypto_symbol = $(this).find('a').attr('symbol');
        convert($('.amount').val(), fiat, crypto, fiat_symbol, crypto_symbol, true);
        convert($('.amount').val(), fiat, crypto, fiat_symbol, crypto_symbol, false);
    });
    $('.amount').on('keyup', function() {
        var fiat = $('.ui.dropdown.fiat .selected a').attr('value');
        var fiat_symbol = $('.ui.dropdown.fiat .selected a').attr('symbol');
        var crypto = $('.ui.dropdown.crypto .selected a').attr('value');
        var crypto_symbol = $('.ui.dropdown.crypto .selected a').attr('symbol');
        convert($(this).val(), fiat, crypto, fiat_symbol, crypto_symbol, true);
        convert($(this).val(), fiat, crypto, fiat_symbol, crypto_symbol, false);
    });
    convert(100, 1, $('.ui.dropdown.crypto .selected a').attr('value'), 'USD', 'BTC', true);
    convert(100, 1, $('.ui.dropdown.crypto .selected a').attr('value'), 'USD', 'BTC', false);
});
function convert(amount, fiat, crypto, fiat_symbol, crypto_symbol, from_fiat)
{
    $('.fiat-to-crypto .amount, .crypto-to-fiat .amount').val(amount);
    if(from_fiat) {
        var conversion = (fiat*amount)/crypto;
        $('.fiat-to-crypto .convert-to').html(precisionRound(conversion, 8) + ' ' + crypto_symbol);
        $('.fiat-to-crypto .convert-from').html(amount + ' ' + fiat_symbol);
    } else {
        var conversion = crypto*amount/fiat;
        $('.crypto-to-fiat .convert-to').html(amount + ' ' + crypto_symbol);
        $('.crypto-to-fiat .convert-from').html(precisionRound(conversion, 8) + ' ' + fiat_symbol);
    }
}
function precisionRound(number, precision) {
    var factor = Math.pow(10, precision);
    return Math.round(number * factor) / factor;
}