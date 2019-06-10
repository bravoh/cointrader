$(document).ready(function() {
    $("#list-group-1 a").click(function() {
        $("#list-group-1 a").removeClass("active");
        $(this).addClass("active");
    });

    bit_load_receive_list(8);
});

function bit_load_receive_list(gateway_id) {
    $("#list-group-2").html("");
    $("#list_loading").show();
    var url = $("#url").val();
    var data_url = url + "/crypto-receive-rates";//"requests/bit_load_receive_list.php?gateway_id="+gateway_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        data: {
            gateway_id: gateway_id
        },
        success: function (data) {
            $("#list_loading").hide();
            $("#list-group-2").html(data);
        }
    });
}

function bit_calculator() {
    var currency_from = $("#bit_currency_from").val();
    var currency_to = $("#bit_currency_to").val();
    var rate_from = $("#bit_rate_from").val();
    var rate_to = $("#bit_rate_to").val();
    var amount_send = $("#bit_amount_send").val();
    if(isNaN(amount_send)) {
        var data = '0';
    } else {
        if(isCrypto(currency_from) && isCrypto(currency_to)) {
            var sum = amount_send * rate_to;
            var data = sum.toFixed(8);
        } else if(isCrypto(currency_to)) {
            var sum = amount_send / rate_from;
            var data = sum.toFixed(8);
        } else if(rate_from > 1) {
            var sum = amount_send / rate_from;
            var data = sum.toFixed(2);
        } else {
            var sum = amount_send * rate_to;
            var data = sum.toFixed(2);
        }
        //var sum = amount_send / rate_from;
        //var data = sum.toFixed(8);
        //var sum = amount_send * rate_to;
        //var data = sum.toFixed(2);
    }
    $("#bit_amount_receive").val(data);
    $("#bit_amount_receive2").val(data);
}

function bit_exchange_step_3() {
    var url = $("#url").val();
    var data_url = url + "requests/bit_exchange_step_3.php";
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#bit_exchange_form").serialize(),
        dataType: "json",
        success: function (data) {
            if(data.status == "success") {
                $("#bit_exchange_box").html(data.msg);
            } else {
                $("#bit_exchange_results").html(data.msg);
            }
        }
    });
}

function bit_make_exchange(id) {
    var url = $("#url").val();
    var data_url = url + "requests/bit_make_exchange.php?id="+id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            $("#bit_exchange_box").html(data);
        }
    });
}

function bit_cancel_exchange(id) {
    var url = $("#url").val();
    var data_url = url + "requests/bit_cancel_exchange.php?id="+id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            $("#bit_exchange_box").html(data);
        }
    });
}

function bit_confirm_transaction(id) {
    var url = $("#url").val();
    var data_url = url + "requests/bit_confirm_transaction.php?id="+id;
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#bit_confirm_transaction").serialize(),
        dataType: "json",
        success: function (data) {
            if(data.status == "success") {
                $("#bit_confirm_transaction").hide();
                $("#bit_transaction_results").html(data.msg);
            } else {
                $("#bit_transaction_results").html(data.msg);
            }
        }
    });
}

function bit_decode_company(value) {
    if(value == "Bitcoin") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else if(value == "Litecoin") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else if(value == "Dogecoin") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else if(value == "Dash") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else if(value == "Peercoin") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else if(value == "Ethereum") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    }  else if(value == "TheBillioncoin") {
        $("#bit_company").html(value);
        $("#bit_account").hide();
        $("#bit_address").show();
    } else {
        $("#bit_company").html(value);
        $("#bit_account").show();
        $("#bit_address").hide();
    }
}


function bit_l_acc_fields(val) {
    var url = $("#url").val();
    var wallet_id = $("#wallet_id").val();
    bit_get_wallet_exchange_rate(val,wallet_id);
    var data_url = url + "requests/load_account_fields.php?gateway="+val;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            $("#account_fields").html(data);
        }
    });
}

function bit_get_wallet_exchange_rate(gateway_id,wallet_id) {
    var url = $("#url").val();
    var data_url = url + "requests/bit_get_wallet_exchange_rate.php?gateway_id="+gateway_id+"&wallet_id="+wallet_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function (data) {
            if(data.status == "success") {
                $("#rate_from").val(data.rate_from);
                $("#rate_to").val(data.rate_to);
                $("#currency_from").val(data.currency_form);
                $("#currency_to").val(data.currency_to);
                $("#bit_rate_from").html(data.rate_from);
                $("#bit_rate_to").html(data.rate_to);
                $("#bit_currency_from").html(data.currency_form);
                $("#bit_currency_to").html(data.currency_to);
                $("#bitexc_exchange_rate").show();
            } else {
                $("#rate_from").val(data.rate_from);
                $("#rate_to").val(data.rate_to);
                $("#currency_from").val(data.currency_form);
                $("#currency_to").val(data.currency_to);
                $("#bitexc_exchange_rate").hide();
            }
        }
    });
}

function bit_exch_cal(val) {
    var currency_from = $("#currency_from").val();
    var currency_to = $("#currency_to").val();
    var rate_from = $("#rate_from").val();
    var rate_to = $("#rate_to").val();
    var amount_send = val;
    if(isNaN(amount_send)) {
        var data = '0';
    } else {
        if(isCrypto(currency_from) && isCrypto(currency_to)) {
            var sum = amount_send * rate_to;
            var data = sum.toFixed(6);
        } else if(isCrypto(currency_to)) {
            var sum = amount_send / rate_from;
            var data = sum.toFixed(6);
        } else if(rate_from > 1) {
            var sum = amount_send / rate_from;
            var data = sum.toFixed(2);
        } else {
            var sum = amount_send * rate_to;
            var data = sum.toFixed(2);
        }
        //var sum = amount_send / rate_from;
        //var data = sum.toFixed(8);
        //var sum = amount_send * rate_to;
        //var data = sum.toFixed(2);
    }
    $("#amount_receive").val(data);
    $("#amount_receive2").val(data);
}


function btc_gateway_update_status(boxID,exchangeID) {
    var url = $("#url").val();
    var payment_div = $("#PaymentStatus_"+boxID);
    var data_url = url + "requests/bitcoin_ipn.php?exchange_id="+exchangeID;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            payment_div.html(data);
        }
    });
}

function ltc_gateway_update_status(boxID,exchangeID) {
    var url = $("#url").val();
    var payment_div = $("#PaymentStatus_"+boxID);
    var data_url = url + "requests/litecoin_ipn.php?exchange_id="+exchangeID;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            payment_div.html(data);
        }
    });
}

function doge_gateway_update_status(boxID,exchangeID) {
    var url = $("#url").val();
    var payment_div = $("#PaymentStatus_"+boxID);
    var data_url = url + "requests/dogecoin_ipn.php?exchange_id="+exchangeID;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "html",
        success: function (data) {
            payment_div.html(data);
        }
    });
}

function isCrypto(name) {
    if(name == "BTC") {
        return true;
    }
    else if(name == "LTC") {
        return true;
    }
    else if(name == "TBC") {
        return true;
    }
    else if(name == "DASH") {
        return true;
    }
    else if(name == "DOGE") {
        return true;
    }
    else if(name == "PPC") {
        return true;
    }
    else if(name == "TBC") {
        return true;
    }
    else {
        return false;
    }
}

function bit_exchange_step_2() {
    var url = $("#url").val();
    var data_url = url + "requests/bit_exchange_step_2.php";
    $.ajax({
        type: "POST",
        url: data_url,
        data: $("#bit_exchange_form").serialize(),
        dataType: "json",
        success: function (data) {
            if(data.status == "success") {
                $("#bit_exchange_box").html(data.msg);
            } else {
                $("#bit_exchange_results").html(data.msg);
            }
        }
    });
}