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
                            <div class="widget-title">
                                <strong>Instagram</strong> da Maria
                            </div>
                            <script src="http://snapwidget.com/js/snapwidget.js"></script>
                            <iframe src="http://snapwidget.com/in/?u=bWFyaWFkZWJhcnJvfGlufDEyNXwyfDJ8fG5vfDV8bm9uZXxvblN0YXJ0fG5vfHllcw==&ve=081214" title="Instagram Widget" class="snapwidget-widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%;"></iframe>
                        </div>
                        <div class="widget">
                            <div class="widget-title"><strong>Siga-nos</strong> no Facebook</div>
                            <div class="fb-like-box" data-href="https://www.facebook.com/mariadebarroacessorios" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
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

                <section class="content wrap" id="article-<?php echo article_id(); ?>" style="margin-bottom: 50px;">
                    <article>
                        <h1><?php echo article_title(); ?></h1>
                        <div class="data">
                            <span class="post-timestamp">Postado dia <?php echo article_date(); ?></span> —
                        </div>
                        <?php echo article_markdown(); ?>
                    </article>

                    <!--                    
                    <section class="footnote">
                        Unfortunately, CSS means everything's got to be inline. 
                       <p>This article is my <?php echo numeral(total_articles()); ?> oldest. It is <?php echo count_words(article_markdown()); ?> words long<?php if (comments_open()): ?>, and it’s got <?php echo total_comments() . pluralise(total_comments(), ' comment'); ?> for now.<?php endif; ?> <?php echo article_custom_field('attribution'); ?></p>
                   </section>
                    -->

                </section>

                <?php if (comments_open()): ?>
                    <div id="disqus_thread"></div>
                    <script type="text/javascript">
                        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                        var disqus_shortname = 'mariadebarro'; // required: replace example with your forum shortname

                        /* * * DON'T EDIT BELOW THIS LINE * * */
                        (function () {
                            var dsq = document.createElement('script');
                            dsq.type = 'text/javascript';
                            dsq.async = true;
                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php theme_include('footer'); ?>