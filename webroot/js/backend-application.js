/*----------------------------------------------------*/
/*	Global Setting
/*----------------------------------------------------*/
var left_side_width = 220; //Sidebar width in pixels

$(function() {
    "use strict";
    //Enable sidebar toggle
    $("[data-toggle='offcanvas']").click(function(e) {
        e.preventDefault();

        //If window is small enough, enable sidebar push menu
        if ($(window).width() <= 992) {
            $('.row-offcanvas').toggleClass('active');
            $('.left-side').removeClass("collapse-left");
            $(".right-side").removeClass("strech");
            $('.row-offcanvas').toggleClass("relative");
        } else {
            //Else, enable content streching
            $('.left-side').toggleClass("collapse-left");
            $(".right-side").toggleClass("strech");
			$(".action-fixed-bottom").toggleClass("strech");
        }
    });

    //Sidebar tree view
    $(".sidebar .treeview").tree();

    //Make sure that the sidebar is streched full height
    function _fix() {
        //Get window height and the wrapper height
        var height = $(window).height() - $("body > .header").height();
        $(".wrapper").css("min-height", height + "px");
        var content = $(".wrapper").height();
        //If the wrapper height is greater than the window
        if (content > height)
            //then set sidebar height to the wrapper
            $(".left-side, html, body").css("min-height", content + "px");
        else {
            //Otherwise, set the sidebar to the height of the window
            $(".left-side, html, body").css("min-height", height + "px");
        }
    }
	
    //Fire upon load
    _fix();
	
    //Fire when wrapper is resized
    $(".wrapper").resize(function() {
        _fix();
        fix_sidebar();
    });

    //Fix the fixed layout sidebar scroll bug
    fix_sidebar();

});

function fix_sidebar() {
    //Make sure the body tag has the .fixed class
    if (!$("body").hasClass("fixed")) {
        return;
    }
}

/*----------------------------------------------------*/
/*	Sidebar Menu
/*----------------------------------------------------*/
(function($) {
    "use strict";

    $.fn.tree = function() {

        return this.each(function() {
            var btn = $(this).children("a").first();
            var menu = $(this).children(".treeview-menu").first();
            var isActive = $(this).hasClass('active');

            //initialize already active menus
            if (isActive) {
                menu.show();
                btn.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down");
            }
            //Slide open or close the menu on link click
            btn.click(function(e) {
                e.preventDefault();
                if (isActive) {
                    //Slide up to close menu
                    menu.slideUp();
                    isActive = false;
                    btn.children(".fa-angle-down").first().removeClass("fa-angle-down").addClass("fa-angle-left");
                    btn.parent("li").removeClass("active");
                } else {
                    //Slide down to open menu
                    menu.slideDown();
                    isActive = true;
                    btn.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down");
                    btn.parent("li").addClass("active");
                }
            });

            /* Add margins to submenu elements to give it a tree look */
            menu.find("li > a").each(function() {
                var pad = parseInt($(this).css("margin-left")) + 10;

                $(this).css({"margin-left": pad + "px"});
            });

        });

    };

}(jQuery));
/*----------------------------------------------------*/
/*	jQuery resize event
/*----------------------------------------------------*/
(function($, h, c) {
    var a = $([]), e = $.resize = $.extend($.resize, {}), i, k = "setTimeout", j = "resize", d = j + "-special-event", b = "delay", f = "throttleWindow";
    e[b] = 250;
    e[f] = true;
    $.event.special[j] = {setup: function() {
            if (!e[f] && this[k]) {
                return false;
            }
            var l = $(this);
            a = a.add(l);
            $.data(this, d, {w: l.width(), h: l.height()});
            if (a.length === 1) {
                g();
            }
        }, teardown: function() {
            if (!e[f] && this[k]) {
                return false
            }
            var l = $(this);
            a = a.not(l);
            l.removeData(d);
            if (!a.length) {
                clearTimeout(i);
            }
        }, add: function(l) {
            if (!e[f] && this[k]) {
                return false
            }
            var n;
            function m(s, o, p) {
                var q = $(this), r = $.data(this, d);
                r.w = o !== c ? o : q.width();
                r.h = p !== c ? p : q.height();
                n.apply(this, arguments)
            }
            if ($.isFunction(l)) {
                n = l;
                return m
            } else {
                n = l.handler;
                l.handler = m
            }
        }};
    function g() {
        i = h[k](function() {
            a.each(function() {
                var n = $(this), m = n.width(), l = n.height(), o = $.data(this, d);
                if (m !== o.w || l !== o.h) {
                    n.trigger(j, [o.w = m, o.h = l])
                }
            });
            g()
        }, e[b])
    }}
)(jQuery, this);

(function($) {
    "use strict";

    //Sidebar-Menu selected event

}(jQuery));

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    
    if($(window).width() > 797 && !$().length){

        if($(window).scrollTop() > 0){
            $('.action-fixed-bottom').addClass('animated bounceInUp');
        }else{
            $('.action-fixed-bottom').removeClass('animated bounceInUp');
        }
    }
});


$(function(){
    $("#frm-default-save").click(function(){
        //ajaxSyncData.abort();

        $("#frm-default-add").trigger('submit');

        var container = $('#app-main-content');
        var scrollTo = $('ul.list-unstyled');
        if($('ul').hasClass('list-unstyled')) {
            container.scrollTop(
                scrollTo.offset().top - container.offset().top + container.scrollTop() - 100
            );
        }
        
    });

    /*Treatment form*/
    $("#consultation_with_treatment").click(function(){
        var thisCheck = $(this);

        if( thisCheck.is(':checked') ){
            $('#consultation_without_treatment').prop('checked', false);
        }
    });

    $("#consultation_without_treatment").click(function(){
        var thisCheck = $(this);

        if( thisCheck.is(':checked') ){
            $('#consultation_with_treatment').prop('checked', false);
        }
    });

    $("#payment_hmo").click(function(){
        var thisCheck = $(this);

        if( thisCheck.is(':checked') ){
            //$('#payment_cash').prop('checked', false);
            $("#hmo_name").removeAttr('disabled');
            $("#health_card_number").removeAttr('disabled');
        }else{
            $("#hmo_name").attr('disabled','disabled');
            $("#health_card_number").attr('disabled','disabled');
        }
    });

    /*$("#payment_cash").click(function(){
        var thisCheck = $(this);

        if( thisCheck.is(':checked') ){
            //$('#payment_hmo').prop('checked', false);
            $("#hmo_name").attr('disabled','disabled');
            $("#health_card_number").attr('disabled','disabled');
        }
    });*/
    /* End treatment form */


    $('#payment_hmo').change(function(){
        if($(this).is(':checked')) {
            $('.checkbox-payment-type').removeAttr("required");
        }else{
            if(!$('#payment_cash').is(':checked')) {
                $('.checkbox-payment-type').attr("required","required");
            }    
        }
    });

    $('#payment_cash').change(function(){
        if($(this).is(':checked')) {
            $('.checkbox-payment-type').removeAttr("required");
        }else{
            if(!$('#payment_hmo').is(':checked')) {
                $('.checkbox-payment-type').attr("required","required");
            }    
        }
    });

    $('#consultation_with_treatment').change(function(){
        if($(this).is(':checked')) {
            $('.checkbox-consultation').removeAttr("required");
        }else{
            if(!$('#consultation_without_treatment').is(':checked')) {
                $('.checkbox-consultation').attr("required","required");
            }    
        }
    });

    $('#consultation_without_treatment').change(function(){
        if($(this).is(':checked')) {
            $('.checkbox-consultation').removeAttr("required");
        }else{
            if(!$('#consultation_with_treatment').is(':checked')) {
                $('.checkbox-consultation').attr("required","required");
            }    
        }
    });


});


