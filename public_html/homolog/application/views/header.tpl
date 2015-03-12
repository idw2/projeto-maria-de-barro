<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">

    <head>
        <title>{$title}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="pragma" content="no-cache" />

            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

            {if $og_title != ""}<meta property="og:title" content="{$og_title}" />{/if}
            {if $og_type != ""}<meta property="og:type" content="{$og_type}" />{/if}
            {if $og_site_name != ""}<meta property="og:site_name" content="{$og_site_name}" />{/if}
            {if $og_descripition != ""}
                <meta property="og:description" content="{$og_descripition}" />
                <meta  name="description" content="{$og_descripition}" />
            {/if}
            {if $og_email != ""}<meta property="og:email" content="{$og_email}"/>{/if}
            {if $og_phone_number != ""}<meta property="og:phone_number" content="{$og_phone_number}"/>{/if}
            {if $og_street_address != ""}<meta property="og:street-address" content="{$og_street_address}"/>{/if}
            {if $og_locality != ""}<meta property="og:locality" content="{$og_locality}"/>{/if}
            {if $og_region != ""}<meta property="og:region" content="{$og_region}"/>{/if}
            {if $og_country_name != ""}<meta property="og:country-name" content="{$og_country_name}"/>{/if}
            {if $og_postal_code != ""}<meta property="og:postal-code" content="{$og_postal_code}"/>{/if}

            <link rel="icon" type="image/vnd.microsoft.icon" href="{$web_files}/img/favicon.png"/>
            <link rel="shortcut icon" type="image/x-icon" href="{$web_files}/img/favicon.png"/>

            <link rel="stylesheet" href="{$web_files}/font-awesome-4.1.0/css/font-awesome.min.css"/>
            <link rel="stylesheet" href="{$web_files}/plugins/rs-plugin/css/settings.css"/>
            <link rel="stylesheet" href="{$web_files}/plugins/flexslider/flexslider.css"/>
            <link rel="stylesheet" href="{$web_files}/plugins/fancybox/jquery.fancybox.css"/>
            <link rel="stylesheet" href="{$web_files}/pongstagr.am-master/source/pongstagr.am.css"/>		
            <link rel="stylesheet" href="{$web_files}/css/plugins/magnific-popup.css"/>		
            <link rel="stylesheet" href="{$web_files}/css/plugins/fancyselect.css"/>		
            {*    <link rel="stylesheet" href="/web-files/bootstrap/css/bootstrap-theme.css"/>		*}
            {*        <link rel="stylesheet" href="/web-files/css/docs.min.css"/>*}
            {*        <link rel="stylesheet" href="/web-files/css/style.css?v=3"/>*}
            <link rel="stylesheet" href="{$web_files}/css/joker.css?v=2"/>

            <script src="{$web_files}/js/vendor/modernizr.min.js"></script>

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

    </head>
    <body style="padding-top: 52px" class="theme-default">

        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-56768389-1', 'auto');
            ga('send', 'pageview');

            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date()
                        ;
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-59097133-1', 'auto');
            ga('send', 'pageview');

        </script>

        <header class="header" id="stt_logado_print">
            {include file="top.tpl"}
        </header>
