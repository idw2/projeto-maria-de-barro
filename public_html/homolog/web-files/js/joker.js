//funcao que configura folder raiz do site
//function getMyFolderRoot(){
//    return "/homolog";
//}

/*
 Author : Joao Ahmad
 Date   : 14/09/2014 11h
 */

// GLOBAL VARIABLES

var App = null;
var Mobile = null;
var Plugins = null;
var User = null;
var ajax = null;

(function() {

// MOBILE

    Mobile = {
        init: function() {
            this.menu();
            return this;
        },
        menu: function() {

            // MOBILE 

            var menu_items = $('.header .navbar-collapse .navbar-nav').html();
            var menu_list = $('<div class="mobile-menu-list" />').html($('<ul class="list-unstyled" />').html(menu_items));
            var carrinho = $('<a />').append($('#shopping-cart').clone().addClass('mobile-shopping-cart').empty()).html();
            var search = $('<form />').append($('.search-wrap').clone().addClass('mobile-search-wrap')).html();
            var login = $('<a />').append($('.navbar-fixed-top .navbar-nav #nav-login').clone()).html();
            var brand = $('<a />').append($('.brand').clone().addClass('mobile-brand')).html();
            var menu_header = $('<div class="mobile-menu-header" />').html(login);

            var menu = $('<div class="mobile-menu" />').html(menu_header).append(menu_list);

            // FIXED TOPS

            var menu_fixed_list = '';
            var menu_fixed_list_total = 0;
            $('.header .navbar-collapse .navbar-nav a').each(function(i) {
                menu_fixed_list_total++
            });
            $('.header .navbar-collapse .navbar-nav a').each(function() {
                var href = $(this).attr('href');
                var icone = 'icone-home';

                // ICONES DO MENU

                if (href.match(/aneis/g)) {
                    icone = 'icone-anel';
                } else if (href.match(/brincos/g)) {
                    icone = 'icone-brinco';
                } else if (href.match(/colares/g)) {
                    icone = 'icone-colar';
                } else if (href.match(/pulseiras/g)) {
                    icone = 'icone-pulseira';
                } else if (href.match(/promo/g)) {
                    icone = 'icone-desconto';
                }

                menu_fixed_list += "<li style='width: " + 100 / menu_fixed_list_total + "%'><a href='" + href + "'><div class='icon'><span class='icone " + icone + "'></span></div>" + $(this).html() + "</a></li>";
            });

            var menu_fixed_top = $('<div class="menu-fixed-top" />').html('<div class="container"><ul class="list-unstyled nav">' + menu_fixed_list + '</ul></div>');

            // SET

            $('body').append(menu).append(menu_fixed_top);
            $('.mobile-menu-header').find('#item_carrinho').remove();
            $('.navbar-header').append(carrinho).append(brand);
            $('.col-brand').append(search).append('<span class="mobile-phones fa fa-phone"></span>');

            $('.mobile-phones').click(function() {
                $('.header').toggleClass('open-phones');
            });

            $('.hamburger').click(function() {
                $('body').toggleClass('menu-open');
            });

//            $('body')[0].addEventListener('swl',function(){
//                alert();
//                $('body.menu-open').removeClass('menu-open');
//            },false);
        }
    }

// USER

    User = {
        init: function() {
            return this;
        }
    }

// PLUGINS

    Plugins = {
        init: function() {
            this.slider();
            this.pongstagr();
            this.mask();
            return this;
        },
        slider: function() {
            $('#slider').revolution({
                delay: 10000,
                startheight: 480,
                startwidth: 1200,
                hideThumbs: 1000,
                navigationType: 'none',
                navigationArrows: 'nexttobullets',
                touchenabled: 'on',
                onHoverStop: 'on',
                navOffsetHorizontal: 0,
                navOffsetVertical: 0,
                dottedOverlay: 'none',
                shadow: 0,
                fullWidth: 'on'
            });
        },
        pongstagr: function() {
            $('#instagram').pongstgrm({
                accessId: '389988437',
                accessToken: '389988437.129db92.2c2af18014ee4ce89483e7fc8a7d8493',
                count: 6,
                column: 'col-sm-4 col-md-2 thumbnail-instagram',
                buttontext: 'Mais imagens',
                button: 'btn btn-light margin-center'
            });
        },
        mask: function() {
            $('.to_mask').each(function() {
                console.log('to_mask');
                var data_mask = $(this).attr('data-mask');
                $(this).mask(data_mask);
            });
        }
    }

// ACTIONS

    Actions = {
        init: function() {
            this.menu();
            this.onready();
            this.onload();
            //this.cart();
            this.slider_products();
            this.slider_thumbs();
            this.comprar();
            this.comprar_btn();
            this.checkout_panel();
            this.search();
            return this;
        },
        menu: function() {

            var header = $('.header').height();
            var lastScrollTop = 0;

            $(window).scroll(function() {

                var scrollTop = $(this).scrollTop();
                if (scrollTop >= header) {
                    $('body').addClass('scrolling');
                } else {
                    if (!$('body').hasClass('menu-fixed-open'))
                        $('body').removeClass('scrolling');
                }

                if (scrollTop > lastScrollTop) {
                    $('body').removeClass('scrolling-up');
                } else {
                    $('body').addClass('scrolling-up');
                }

                lastScrollTop = scrollTop;
            });

            $('.brand-circle').click(function(e) {
                e.preventDefault();
                $('body').toggleClass('menu-fixed-open');
            });

        },
        onready: function() {
            $(function() {
                $('body').css('visibility', 'visible');

                $('.radio-switch').click(function() {
                    var parents = $('input[name=' + $(this).attr('name') + '][type=radio]');
                    var checked = this.checked;

                    if (checked) {
                        parents.parents('.radio-block').removeClass('active');
                        $(this).parents('.radio-block').addClass('active');
                    }

                    console.log(checked);
                });

//                $('select').fancySelect();

            });
        },
        onload: function() {
            $('img').each(function() {
                $(this).load(function() {
                    $(this).css('opacity', '1');
                });
            });
            $(window).load(function() {
                $('img').css('opacity', '1');
            });
        },
        cart: function() {
            $('.eu-quero').unbind('click').click(function(e) {
                e.preventDefault();
                console.log('click');
                var parent = $(this).parents('.thumbnail');
                var offsetTop = parent.offset().top;
                var offsetLeft = parent.offset().left;
                var thumbnail = parent.clone();
                thumbnail.css('position', 'absolute');
                thumbnail.css('left', offsetLeft);
                thumbnail.css('top', offsetTop);
                thumbnail.css('opacity', '1');

                $('body').append(thumbnail);

                var opacity = 1;

                var anim = setInterval(function() {
                    var left = thumbnail.offset().left;
                    var top = thumbnail.offset().top;
                    opacity = opacity - 0.1;
                    thumbnail.css('left', left + 10 + 'px');
                    thumbnail.css('top', top - 10 + 'px');
                    thumbnail.css('opacity', opacity);
                    thumbnail.css('z-index', '12000');
                }, 25);

                setTimeout(function() {
                    clearInterval(anim);
                    thumbnail.remove();
                    console.log('limpo');
                }, 1000);
            });
        },
        slider_products: function() {
            $('#produto-slider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#produto-slider-thumbs"
            });
            $('#produto-slider-thumbs').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 80,
                itemMargin: 15,
                asNavFor: '#produto-slider'
            });
            $(".fancybox-gallery").fancybox({
                nextEffect: 'fade',
                prevEffect: 'fade'
            });
            $('.produto-img-lupa').click(function(e) {
                e.preventDefault();
                $(this).next('#produto-slider').find('.flex-active-slide > a').click();
            });
        },
        slider_thumbs: function() {
            $('.thumbs-slider').flexslider({
                animation: "slide",
                directionNav: false,
                controlNav: false,
                animationLoop: true,
                slideshow: false
            });

            $('.thumbs-slider-controls .nav .previous').click(function() {
                $('.thumbs-slider').flexslider('prev');
                return false;
            });

            $('.thumbs-slider-controls .nav .next').click(function() {
                $('.thumbs-slider').flexslider('next');
                return false;
            });
        },
        comprar: function() {

            var obj = {}
            obj.a = $('<div class="comprar_borboleta size1" />');
            obj.b = $('<div class="comprar_borboleta size2" />');

            for (var key in obj) {
                $('body').append(obj[key]);
            }

            $('.comprar').each(function() {

                var id = $(this).attr('data-id');
                var img = $(this).attr('data-img');
                var name = $(this).attr('data-name');
                var redirect = $(this).attr('data-redirect');
                var params = $(this).attr('data-params');

                var icone = '<img src="' + getMyFolderRoot() + '/web-files/img/assets/icon-approved.png" style="width: 46px;opacity: 1;margin-right: 6px;" />';

                var html = "";
                html += "<div class='comprar-popup'>";
                html += "<div class='comprar-popup-left'>";
                html += "<img src='" + img + "'  width='170'>";
                html += "</div>";
                html += "<div class='comprar-popup-right'>";
                html += "<h3>" + icone + " ADICIONADO AO CARRINHO!</h3>";
                html += "<div style='line-height: 0;margin-bottom: 20px;'>__________</div>";
                html += "<h2 class='title-tinny'>" + name + "</h2>";
                html += "</div>";
                html += "</div>";

                html += "<div class='comprar-popup-footer text-center'>";
                html += "<a class='btn btn-dark mfp-close' style='margin-right: 26px'>VER OUTROS PRODUTOS</a>";
                html += "<a href='" + redirect + "' class='btn btn-primary'>CONCLUIR COMPRA</a>";
                html += "</div>";



                $(this).click(function(e) {

                    if ($("#quantidade").val() == null || $("#quantidade").val() == "") {
                        $(".avise-me-ao-chegar-error").html("Quantidade requerida!");
                        return false;
                    }

                    e.preventDefault();

                    var $this = $(this);

                    $this.attr('disabled', 'disabled');
                    var pos = {};

                    pos.y = ($this.offset().top - 60);
                    pos.x = ($this.offset().left + $this.width()) - 20;

                    $('.comprar_borboleta').remove();

                    var obj = {}
                    obj.a = $('<div class="comprar_borboleta size1" style="left: ' + pos.x + 'px; top: ' + pos.y + 'px;" />');
                    obj.b = $('<div class="comprar_borboleta size2" style="left: ' + pos.x + 'px; top: ' + pos.y + 'px;" />');

                    for (var key in obj) {
                        $('body').append(obj[key]);
                        obj[key].addClass('animar');
                    }

                    var qntdd = parseInt($("#quantidade").val());
                    var quantidade = "&QUANTIDADE=" + qntdd;
                    var valores = params + quantidade;
                    var val = parseInt($('#shopping-cart .label').html());
                    $('#shopping-cart .label').html(val + 1);

                    $.ajax({
                        type: 'post',
                        data: valores,
                        url: getMyFolderRoot() + '/web-files/server/add_lista_desejos.php',
                        success: function(data) {
                            $this.removeAttr('disabled');
                            if (data == "error") {

                                $(".avise-me-ao-chegar-error").html("* Quantidade solicitada não está disponível neste momento!");
                            } else {
                                console.log(data);
                                $this.removeAttr('disabled');

                                $.magnificPopup.open({
                                    items: {
                                        src: '<div class="white-popup">' + html + '</div>',
                                        type: 'inline'
                                    },
                                    showCloseBtn: false
                                });
                            }
                        }
                    });
//                
                });


            });
        },
        comprar_btn: function() {

        },
        checkout_panel: function() {
            $(function() {
//                Plugins.init();
            });
            $(window).scroll(function() {
                var $el = $('.checkout-panel');
                var pos = $(window).scrollTop();
                var footer = $('.footer').offset().top;
                var height = $el.height();
                var offset = 125;
                (pos > (footer - height - offset)) ? $el.addClass('onFooter') : $el.removeClass('onFooter');
            });
            return;
//            var checkout_panel_offset = $('#checkout-panel-2').offset().top - 50;

            $(window).scroll(function() {
                var position = $('body').scrollTop();
                if (position > checkout_panel_offset) {
                    $('#checkout-panel-2').addClass('active');
                } else {
                    $('#checkout-panel-2').removeClass("active");
                }
            });
        },
        search: function() {

//            $(document).click(function(){
//                $(".sugestao").hide();
//            });

            $('input[type=search]').bind('keyup', _.debounce(function() {
                console.log('AJAX');
                var search = this.value;
                $.ajax({
                    type: 'post',
                    data: "search=" + search,
                    url: getMyFolderRoot() + "/pt/produtos/sugestao",
                    success: function(data) {
                        $(".sugestao").html(data);
                    }
                });
            }, 250));
            $('input[type=search]').blur(function() {
                setTimeout(function() {
                    $('.sugestao').empty();
                }, 250);
            });
        }
    }


// GENERAL APP

    App = {
        init: function() {
            Mobile.init();
            User.init();
            Plugins.init();
            Actions.init();
        }
    }
})();


$(function() {
    App.init();
});
