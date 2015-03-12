<?php
$seo = new SEO();
$page = $seo->get_slug();
$title = $seo->get_title();
$description = $seo->get_description();
$author = SEO::author;
?>
<!DOCTYPE html>
<html class="no-js">
    <head>

        <title><?php echo $title; ?></title>
        <meta name="title" content="<?php echo $title; ?>">
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="author" content="<?php echo $author; ?>">

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="shortcut icon" href="<?php echo SITE; ?>/static/img/favicon.png">

        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/style.min.css" />

        <script src="<?php echo SITE; ?>/static/js/modernizr.custom.js"></script>
        <!--[if IE 8]>
              <link href="css/ie8.css" rel="stylesheet" />
              <script src="js/respond.js"></script>	
        <![endif]-->
    </head>
    <body>

        <header id="header">
            <div class="container text-center">
                <a class="brand" href="https://mariadebarro.com.br"><img src="<?php echo SITE; ?>/static/img/logo.png" width="250px"></a>
            </div>
        </header>