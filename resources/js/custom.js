jQuery(document).ready(function ($) {
    var UI = {
        uiParalax: function () {
            var paralax = function () {
                $('.prl').each(function (index, el) {
                    var num = 4;
                    if ($(el).hasClass('prl-1')) num = 6;
                    if ($(el).hasClass('prl-2')) num = 8;
                    if ($(el).hasClass('prl-3')) num = 10;
                    if ($(el).hasClass('prl-4')) num = 12;
                    if ($(el).hasClass('prl-5')) num = 14;

                    var he = $(el).innerHeight(),
                        vtop = $(el).offset().top,
                        top = $(window).scrollTop();

                    if (top > vtop && $(window).scrollTop() < vtop + he - 70) {
                        if ($(el).hasClass('prl-left')) {
                            $(el).css({
                                transform: 'translateX(' + -(top - vtop) / num + 'px)',
                            });
                        }
                        if ($(el).hasClass('prl-right')) {
                            $(el).css({
                                transform: 'translateX(' + (top - vtop) / num + 'px)',
                            });
                        }
                        if (!$(el).hasClass('prl-left') && !$(el).hasClass('prl-right')) {
                            $(el).css({
                                transform: 'translateY(' + (top - vtop) / num + 'px)',
                            });
                        }
                    }
                });

                $('.word-prl > div').each(function (index, el) {
                    var num = 0.4;
                    if ($(el).hasClass('prl-w0')) num = 0.5;
                    if ($(el).hasClass('prl-w1')) num = 0.7;
                    if ($(el).hasClass('prl-w2')) num = 0.8;
                    if ($(el).hasClass('prl-w3')) num = 0.9;
                    if ($(el).hasClass('prl-w4')) num = 1;
                    if ($(el).hasClass('prl-w5')) num = 1.5;
                    if ($(el).hasClass('prl-w6')) num = 2;

                    var he = $(el).innerHeight(),
                        vtop = $(el).offset().top,
                        top = $(window).scrollTop();

                    if (top > vtop - 100 && $(window).scrollTop() < vtop + he - 100) {
                        $(el).css({
                            transform: 'translateY(' + (top - vtop) / num + 'px)',
                            opacity: vtop / top - 0.2,
                        });
                        if ($(el).hasClass('prl-wl')) {
                            $(el).css({
                                transform: 'translate(-' + (top - vtop) * 2 + 'px,' + (top - vtop) / num + 'px)',
                            });
                        }
                    }
                });
            };

            paralax();

            var mask_flag = false;
            win.scroll(function (e) {
                paralax();

                $('.mask').each(function (index, el) {
                    var num = 0.6;
                    if ($(el).hasClass('c')) num = 0.7;
                    if ($(el).hasClass('e')) num = 0.8;

                    var he = $(el).innerHeight(),
                        vtop = $(el).offset().top,
                        top = $(window).scrollTop();

                    if (top > vtop + he / 3) {
                        $(el).removeClass('act_').addClass('act');
                        mask_flag = true;
                    } else {
                        if (mask_flag) $(el).removeClass('act').addClass('act_');
                    }
                });
            });
        },
        init: function () {
            UI.uiParalax();
        },
    };

    if ($('.slider-nav').length > 0) {
        $('.slider-home').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            infinite: true,
            arrows: false,
            asNavFor: '.slider-nav',
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-home',
            dots: false,
            // centerMode: true,
            focusOnSelect: true,
            verticalSwiping: true,
            vertical: true,
            adaptiveHeight: true,
        });

        if ($(window).scrollTop() > 0) {
            $('#decor').addClass('fixed');
            $('header .logo').addClass('act');
        }
        $(window).scroll(function (event) {
            if ($(window).scrollTop() > 1) {
                $('#decor').addClass('fixed');
                $('header .logo').addClass('act');
            } else {
                $('#decor').removeClass('fixed');
                $('header .logo').removeClass('act');
            }
        });
    }
});
$(window).on('load', function (event) {
    if ($(window).width() > 1199 && $('#decor').length > 0) {
        var he = $('#decor .slider-nav').offset().top - $('#decor .slide-logo').offset().top;
        // $('#decor .slide-logo').css('height', he - 10);
    }
});
$(window).resize(function (e) {
    if ($('#decor .slider-nav') == 0) return;
    if ($(window).width() > 1199 && $('#decor').length > 0) {
        var he = $('#decor .slider-nav').offset().top - $('#decor .slide-logo').offset().top;
        // $('#decor .slide-logo').css('height', he - 10);
    } else {
        $('#decor .slide-logo').css('height', '');
    }
});
