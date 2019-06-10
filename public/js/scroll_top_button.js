$(document).ready(function() {
$(window).scroll(function() {if ($(this).scrollTop() >= 350) {$('#return-to-top').fadeIn(200);} else {$('#return-to-top').fadeOut(200);}});$('#return-to-top').click(function() {$('body,html').animate({scrollTop : 0}, 500);});
});