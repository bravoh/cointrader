$(function() {
    $('#side-menu').metisMenu();
});
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            // $('.navbar-brand').css('padding', '3px 15px');
            $('div.navbar-collapse').addClass('collapse');
            $('.navbar-top-links').hide(); //custom change
            topOffset = 100; // 2-row-menu
            $('.ico-carousel').hide();
            $('.mobile-ico-carousel').show();
        } else {
            $('.ico-carousel').show();
            $('.navbar-top-links').show();  //custom change
            $('div.navbar-collapse').removeClass('collapse');
            $('.mobile-ico-carousel').hide();
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
            $(".navbar-collapse").addClass('collapse');  //custom change
            $('.navbar-top-links').hide(); //custom change
            $('.ico-carousel').hide();
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
