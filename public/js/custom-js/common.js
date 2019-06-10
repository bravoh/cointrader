$(document).ready(function() {
    $('.ui.search').search({
        minCharacters : 3,
        maxResults: 50,
        apiSettings: {
            url: APP_URL + '/ajax-load-coin-data?q={query}'
        }
    });
    $('.day-night-mode').click(function() {
        if(($(this).attr('type').trim()) == 'night') {
            if($('#color-scheme-css').attr('gel') == 'new') {
                $('#color-scheme-css').attr('href', APP_URL + '/public/lct/css/color_schemes/' + ($(this).attr('type').trim()) + '.css');
            } else {
                $('#color-scheme-css').attr('href', APP_URL + '/public/css/color_schemes/' + ($(this).attr('type').trim()) + '.css');
            }
            setCookie('THEME_COLOR', ($(this).attr('type').trim()), 30); //set cookie
            $(this).attr('type', 'default');
            $(this).css('background', 'black').css('color', 'white');  
        } else {
            $('#color-scheme-css').attr('href', '');
            setCookie('THEME_COLOR', 'default', 30); //set cookie
            $(this).attr('type', 'night');
            $(this).css('background', 'white').css('color', '#337ab7');  
        }
    });
    $('.selected-language').html($('.top-language-dropdown .item.selected').html());
    $('.top-currency-dropdown .item').click(function() {
        calulate(this);
    });
    $('.top-currency-dropdown .item.selected').trigger('click');
    $(".top-language-dropdown .item").click(function() {
        window.location.href = $(this).attr('url');
    });
});
function cookiePolicyDialog(text, button_text) {
    window.addEventListener("load", function() {
        window.cookieconsent.initialise({
          "palette": {
            "popup": {
              "background": "#337ab7"
            },
            "button": {
              "background": "#d9534f"
            }
          },
          "showLink": false,
          "position": "bottom-left",
          "content": {
            "message": text,
            "dismiss": button_text
          }
        })
    });
}
function calulate(obj)
{
    var selected_currency = 'USD';
    if($(obj).attr('rel') != "undefined") {
        selected_currency = $(obj).attr('rel');
    }
    var symbol = $(obj).attr('id');
    var value = $(obj).attr('value');
    $('.btn-group .dropdown .selected-currency').html(selected_currency);
    setCookie('SELECTED_CURRENCY', selected_currency, 30); //set cookie
    setCookie('SELECTED_CURRENCY_PRICE', value, 30); //set cookie
    var currency = (selected_currency).toLowerCase();
    calulateAmounts(value, symbol, 'td.price', false, currency);
    calulateAmounts(value, symbol, 'td.market_cap_usd', true);
    calulateAmounts(value, symbol, 'td.volume_usd_day', true);
    calulateAmounts(value, symbol, 'td.latest_low', false);
    calulateAmounts(value, symbol, 'td.latest_high', false);
    calulateAmounts(value, symbol, 'td.all_time_low', false);
    calulateAmounts(value, symbol, 'td.all_time_high', false);
}

function calulateAmounts(value, symbol, column, formatted_amount, currency)
{
    calculateGolablData(value, symbol);
    $('tbody.crypto-currencies-data ' + column).each(function(element) {
        var amount = $(this).attr('val');
        if(amount > 0) {
            var calculatedAmount = amount*value;
            if (currency && typeof ($(this).attr(currency)) != "undefined") {
                amount = $(this).attr(currency);
                calculatedAmount = amount*1;
            }
            var decimal = 5;
            if (amount >= 1) {
                decimal = 2;
            }
            $(this).text(symbol + "" + formatAmount(calculatedAmount, decimal, formatted_amount));
        } else {
            $(this).text('N/A');
        }
    });
}

function calculateGolablData(value, symbol)
{
    var global_market_cap = $(".top-bar-market-cap span").attr("rel")*value;
    var global_market_cap_day = $(".top-bar-day-vol span").attr("rel")*value;
    $(".top-bar-market-cap span, .dashboard-total-market-cap").html(symbol + formatAmount(global_market_cap, 2, true));
    $(".top-bar-day-vol span, .dashboard-total-market-cap-day").html(symbol + formatAmount(global_market_cap_day, 2, true));
}

function formatAmount(amount, decimal, formatted_amount)
{
    if(formatted_amount) {
        formatted_amount = (parseFloat(amount, 10).toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()).split(".");
        return formatted_amount[0];
    }
    return parseFloat(amount, 10).toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}

function dayHourChange(column, currency)
{
    $('tbody.crypto-currencies-data ' + column).each(function(element) {
        var percentage = $(this).attr('val');
        if (currency && typeof ($(this).attr(currency)) != "undefined") {
            percentage = $(this).attr(currency);
        }
        var color = 'red';
        if (percentage >= 0) {
            color = 'green';
        }
        $(this).text(percentage + " %").css('color', color);
    });
}
function saveNewsLetter()
{
    var email = $("#newsletter_email").val();
    if(email == '') {
        $('.newsletter-msg').html('enter email!').css('color', 'red').fadeIn('slow').fadeOut(4000);
        return false;
    }
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.post(APP_URL + '/ajax-save-newsletter', {_token: CSRF_TOKEN, email: email}, function(response) { 
        if(response == 'false') {
            $('.newsletter-msg').html('enter valid email!').css('color', 'red').fadeIn('slow').fadeOut(4000);
            return false;
        } else {
            $('.newsletter-msg').html('subscribed!').css('color', 'green').fadeIn('slow').fadeOut(4000);
            return false;
        }
    });
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/;";
}