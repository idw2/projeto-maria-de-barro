<?php theme_include('header'); ?>


<section class="pag-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-push-8">
                <aside>
                    <div class="sidebar">
                        <div class="widget">
                            <div class="widget-title"><strong>Buscar</strong> na Maria</div>
                            <form class="navbar-form search-wrap" role="search" action="https://mariadebarro.com.br/pt/novos-produtos" method="post">
                                <input type="search" name="search" id="search" class="form-control" placeholder="BUSCAR" autocomplete="off">
                                <button type="submit" class="btn eu-quero"><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                        <div class="widget">
                            <div class="widget-title"><strong>Siga-nos</strong> no Facebook</div>
                            <div class="fb-like-box" data-href="https://www.facebook.com/mariadebarroacessorios" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                        </div>
                        <div class="widget">
                            <div class="widget-title">
                                <strong>Instagram</strong> da Maria
                            </div>
                            <script src="http://snapwidget.com/js/snapwidget.js"></script>
                            <iframe src="http://snapwidget.com/in/?u=bWFyaWFkZWJhcnJvfGlufDEyNXwyfDJ8fG5vfDV8bm9uZXxvblN0YXJ0fG5vfHllcw==&ve=081214" title="Instagram Widget" class="snapwidget-widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%;"></iframe>
                        </div>
                        <div class="widget">
                            <div class="widget-title"><strong>Categorias</strong></div>
                            <ul class="list">
                                <?php while (categories()) { ?>
                                    <li><a href=""><?php echo category_title(); ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-sm-8 col-sm-pull-4">

                <?php if (has_posts()): ?>
                    <ul class="items">
                        <?php posts(); ?>
                        <li>
                            <article class="wrap">
                                <h1>
                                    <a href="<?php echo article_url(); ?>" title="<?php echo article_title(); ?>"><?php echo article_title(); ?></a>
                                </h1>
                                <div class="data">
                                    <span class="post-timestamp">Postado dia <?php echo article_date(); ?></span> —
                                </div>
                                <div class="content">
                                    <?php echo article_markdown(); ?>
                                </div>

                                <footer>
                                    <!--Posted <time datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo relative_time(article_time()); ?></time> by <?php echo article_author('real_name'); ?>.-->
                                    <ul class="social-post list-inline">
                                        <li>
                                            <a class="fb-share-button" data-href="<?php echo article_url(); ?>" data-layout="button_count" style="display: inline-block;"></a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo article_url(); ?>">Tweet</a>
                                            <script>!function (d, s, id) {
                                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                                    if (!d.getElementById(id)) {
                                                        js = d.createElement(s);
                                                        js.id = id;
                                                        js.src = p + '://platform.twitter.com/widgets.js';
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                    }
                                                }(document, 'script', 'twitter-wjs');</script>
                                        </li>    
                                    </ul>
                                </footer>
                            </article>
                        </li>
                        <?php
                        $i = 0;
                        while (posts()):
                            ?>
                            <article class="wrap">
                                <h1>
                                    <a href="<?php echo article_url(); ?>" title="<?php echo article_title(); ?>"><?php echo article_title(); ?></a>
                                </h1>
                                <div class="data">
                                    <span class="post-timestamp">Postado dia <?php echo article_date(); ?></span> —
                                </div>
                                <div class="content">
                                    <?php echo article_markdown(); ?>
                                </div>

                                <footer>
                                    <!--Posted <time datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo relative_time(article_time()); ?></time> by <?php echo article_author('real_name'); ?>.-->
                                    <ul class="social-post list-inline">
                                        <li>
                                            <a class="fb-share-button" data-href="<?php echo article_url(); ?>" data-layout="button_count" style="display: inline-block;"></a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo article_url(); ?>">Tweet</a>
                                            <script>!function (d, s, id) {
                                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                                    if (!d.getElementById(id)) {
                                                        js = d.createElement(s);
                                                        js.id = id;
                                                        js.src = p + '://platform.twitter.com/widgets.js';
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                    }
                                                }(document, 'script', 'twitter-wjs');</script>
                                        </li>    
                                    </ul>
                                </footer>
                            </article>
                        <?php endwhile; ?>
                    </ul>

                    <?php if (has_pagination()): ?>
                        <nav class="pagination">
                            <div class="wrap">
                                <?php echo posts_prev(); ?>
                                <?php echo posts_next(); ?>
                            </div>
                        </nav>
                    <?php endif; ?>

                <?php else: ?>
                    <p>Looks like you have some writing to do!</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php theme_include('footer'); ?>
