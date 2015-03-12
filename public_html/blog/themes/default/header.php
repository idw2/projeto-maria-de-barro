<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo page_title('Página não encontrada!'); ?><?php echo site_name(); ?></title>

        <meta name="description" content="<?php echo site_description(); ?>">

        <link rel="stylesheet" href="<?php echo theme_url('/css/font-awesome.css'); ?>">
        <link rel="stylesheet" href="<?php echo theme_url('/css/theme.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo theme_url('/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php echo theme_url('/css/small.css'); ?>" media="(max-width: 400px)">

        <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo rss_url(); ?>">
        <link rel="shortcut icon" href="<?php echo theme_url('img/favicon.png?=v2'); ?>">

        <!--[if lt IE 9]>
              <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script>var base = '<?php echo theme_url(); ?>';</script>
        <script src="<?php echo asset_url('/js/zepto.js'); ?>"></script>
        <script src="<?php echo theme_url('/js/main.js'); ?>"></script>

        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="generator" content="Maria de Barro">

        <meta property="og:title" content="<?php echo article_title(); ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(base_url() . current_url()); ?>">
        <meta property="og:image" content="<?php echo theme_url('img/og_image.gif'); ?>">
        <meta property="og:site_name" content="<?php echo site_name(); ?>">
        <meta property="og:description" content="<?php echo site_description(); ?>">

        <?php if (customised()): ?>
            <!-- Custom CSS -->
            <style><?php echo article_css(); ?></style>

            <!--  Custom Javascript -->
            <script><?php echo article_js(); ?></script>
        <?php endif; ?>
    </head>
    <body style="padding-top: 100px" class="blog theme-default <?php echo body_class(); ?>">

        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: 'your-app-id',
                    xfbml: true,
                    version: 'v2.1'
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <header class="header navbar navbar-fixed-top navbar-default" id="stt_logado_print">
            <div class="container">
                <div class="navbar-header">
                    <a href="http://blog.mariadebarro.com.br" class="brand"><img src="<?php echo theme_url('img/logo.png'); ?>" alt="Maria de Barro" border="0" title="" class="img-responsive"/></a>
                </div>
                <nav class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo maria_url('novos-produtos'); ?>">Novos produtos</a></li>
                        <li><a href="<?php echo maria_url('informacoes/promocoes'); ?>">Promoções</a></li>
                        <li><a href="<?php echo maria_url('contato'); ?>">Atendimento</a></li>
                        <li class="divider"></li>
                        <li class="social"><a href="<?php echo site_meta('instagram'); ?>" target="_blank"><span class="fa fa-instagram"></a></li>
                        <li class="social"><a href="<?php echo site_meta('facebook'); ?>" target="_blank"><span class="fa fa-facebook"></a></li>
                        <li class="social"><a href="<?php echo site_meta('twitter'); ?>" target="_blank"><span class="fa fa-twitter"></a></li>
                        <li class="social"><a href="<?php echo site_meta('google-plus'); ?>" target="_blank"><span class="fa fa-google-plus"></a></li>
                    </ul>
                </nav>
            </div>
        </header>
