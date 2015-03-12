/*
 Author : Joao Ahmad
 Date   : 14/09/2014 11h
 */

// GLOBAL VARIABLES

'use strict';

var App = null;
var Mobile = null;
var Plugins = null;
var Actions = null;
var User = null;
var ajax = null;

(function () {

// MOBILE

    Mobile = {
        init: function () {
//            this.menu();
            return this;
        },
        menu: function () {

            // MOBILE 

            var menu_items = $('.navbar .navbar-collapse .navbar-nav').html();
            var menu_list = $('<div class="mobile-menu-list" />').html($('<ul class="list-unstyled" />').html(menu_items));
            var menu_header = $('<div class="mobile-menu-header" />').html();

            var menu = $('<div class="mobile-menu" />').html(menu_header).append(menu_list);

            // FIXED TOPS

            var menu_fixed_list = '';
            var menu_fixed_list_total = 0;
            $('.header .navbar-collapse .navbar-nav a').each(function (i) {
                menu_fixed_list_total++
            });
            $('.header .navbar-collapse .navbar-nav a').each(function () {
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

            $('.hamburger').click(function () {
                $('body').toggleClass('menu-open');
            });
        }
    }

// PLUGINS

    Plugins = {
        init: function () {
//            this.slider();
//            this.lightbox();
            this.mask();
            return this;
        },
        slider: function () {
            $('.flexslider').flexslider({
                animation: "slide"
            });
        },
        lightbox: function () {
            $('a').nivoLightbox({
                effect: 'slide'
            });
        },
        mask: function () {
             
            var maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
                    options = {onKeyPress: function (val, e, field, options) {
                            field.mask(maskBehavior.apply({}, arguments), options);
                        }
                    };

            $('.mask_phone').mask(maskBehavior, options);
            $('.mask_money').mask('000.000.000.000.000,00', {reverse: true});
        }
    }

// ACTIONS

    Actions = {
        init: function () {
//            this.navbar();
            this.fastclick();
            this.ajax_form();
            return this;
        },
        fastclick: function () {
            $(function () {
                FastClick.attach(document.body);
            });
        },
        ajax_form: function () {
            $('.ajax-form').submit(function (e) {
                e.preventDefault();

                var valid = true;
                $("[required]").each(function () {
                    if (!this.checkValidity()) {
                        $(this).addClass('invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('invalid');
                    }
                });

                if (!valid) {
                    alert('Por favor, preencha os campos corretamente.');
                    return;
                }

                var action = this.action;
                var data = new FormData();
                $('input, textarea, select').each(function () {
                    data.append(this.name, this.value);
                });
                
                $('.loader').show();

                $.ajax({
                    type: 'post',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: action,
                    success: function (res) {
                        console.log(res);
                        var data = JSON.parse(res);
                        $('.loader').hide();
                        
                        if(data.status == 'success'){
                            var response = $('#tpt-form-response-success').html();
                        }
                        if(data.status == 'error'){
                            var response = $('#tpt-form-response-error').html();
                        }
                        if(data.status == 'error_conexao'){
                            var response = $('#tpt-form-response-error_conexao').html();
                        }
                        
                        $('#form').before(response);
                        $('#form').remove();
                    }
                });
                return false;
            });
        }
    }


// GENERAL APP

    App = {
        init: function () {
//            Mobile.init();
            Plugins.init();
            Actions.init();
        }
    }
})();


$(function () {
    App.init();
});
