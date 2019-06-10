$(document).ready(function() {
    $('.ui.search').search({
        minCharacters : 3,
        maxResults: 50,
        apiSettings: {
            url: APP_URL + '/ajax-load-coin-data?q={query}'
        }
    });
    $('.selected-language .lang-code').html($('.top-language-dropdown .item.selected span.lang-code').html());
    $('.top-currency-dropdown .item a').click(function() {
        $('.top-currency-dropdown .item a').removeClass('selected');
        $(this).addClass('selected');
        calulate(this);
    });
    $('.top-currency-dropdown .item a.selected').trigger('click');

    $('.sidebar-toggle').click(function() {
        if (!$('body').hasClass('sidebar-collapse')) {
            setCookie('LEFT_SIDEBAR', 'sidebar-collapse', 30);
        } else {
            setCookie('LEFT_SIDEBAR', 'sidebar-open', 30);
        }
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
    $('.dropdown .selected-currency .currency-code').html(selected_currency);
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
    var global_market_cap = $(".dashboard-total-market-cap").attr("rel")*value;
    var global_market_cap_day = $(".dashboard-total-market-cap-day").attr("rel")*value;
    $(".dashboard-total-market-cap").html(symbol + formatAmount(global_market_cap, 2, true));
    $(".dashboard-total-market-cap-day").html(symbol + formatAmount(global_market_cap_day, 2, true));

    var global_market_cap = $(".top-bar-market-cap span").attr("rel")*value;
    var global_market_cap_day = $(".top-bar-day-vol span").attr("rel")*value;
    $(".top-bar-market-cap span").html(symbol + formatAmount(global_market_cap, 2, true));
    $(".top-bar-day-vol span").html(symbol + formatAmount(global_market_cap_day, 2, true));
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
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/;";
}