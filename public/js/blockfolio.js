function getExchanges(val)
{
    $('.select-exchange, .select-pair, .quantity, .blockfolio-table .coin, .blockfolio-table .exchange, .blockfolio-table .pair, .blockfolio-table .price, .blockfolio-table .value').html('---').val('');
    $('.select-exchange, .select-pair, .quantity, .add-coin-btn').prop('disabled', true);
    if(val != -1) {
        $('.blockfolio-table .coin').html(val);
        $('.loader').show();
    	var html = '<option value="-1">Select Exchange</option>';
    	$.get(APP_URL + '/ajax-get-exchanges/'+val, function(response) { 
            $.each(response, function(data){
            	html += '<option value="'+response[data]['exchange']+'">'+capitalizeFirstLetter(response[data]['exchange'])+'</option>';
            });
            $('.select-exchange').html(html).prop('disabled', false);
            $('.loader').hide('slow');
        });
    }
}

function getPairs(val)
{
    $('.loader').show();
    if(val != -1) {
        $('.blockfolio-table .exchange').html(capitalizeFirstLetter(val));
    }
    var coin = $(".select-coin option:selected").val();
	var html = '<option value="-1">Select Pair</option>';
	$.get(APP_URL + '/ajax-get-pairs/'+coin+'/'+val, function(response) { 
        $.each(response, function(data){
        	html += '<option value="'+response[data]['pair']+'">'+response[data]['pair']+'</option>';
        });
        $('.select-pair').html(html).prop('disabled', false);
        $('.loader').hide('slow');
    });
}

function getPrice(val)
{
    $('.loader').show();
    if(val != -1) {
        $('.blockfolio-table .pair').html(val);
    }
    var exchange = $(".select-exchange option:selected").val();
	var html = '';
	$.get(APP_URL + '/ajax-get-price/'+exchange+'/'+val.replace('/', '-'), function(response) { 
        $('.blockfolio-table .price').html(response);
        $('#coin_price').val(response);
        $('.blockfolio-table .quantity, .blockfolio-table .value, .quantity').val('').html('---');
        $('.loader').hide('slow');
    });
    $(".add-price").prop('disabled', false);
    $('.quantity').prop('disabled', false);
}

function calculateValue(quantity)
{
    
    var pair = ($(".select-pair option:selected").val()).split('/');
    $('.blockfolio-table .quantity').html(quantity + ' ' + pair[0]);
    $('.blockfolio-table .value').html(formatAmount(quantity*$('.blockfolio-table .price').html(), 5, false) + ' ' + pair[1]);
    $('.add-coin-btn').prop('disabled', false);
}

function calculatePrice(price)
{

    $('.blockfolio-table .quantity, .blockfolio-table .value, .quantity, .blockfolio-table .price').val('').html('---');
    $('.blockfolio-table .price').html(price);
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
