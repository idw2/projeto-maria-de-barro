
<!-- FOOTER  -->

{include file="atendimento_online.tpl"}

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1404136649848973&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<footer class="footer">
    <div class="container">
        <a href="#" class="footer-borboleta"></a>
    </div>
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 footer-group">
                    <h2 class="footer-title">Institucional</h2>
                    <ul class="footer-lista">
                        <li><a href="/{$language}/informacoes/quem-somos">Quem somos</a></li>
{*                        <li><a href="http://blog.mariadebarro.com.br">Blog da Maria</a></li>*}
                            {*<li><a href="#">Nosso blog</a></li>*}
                        <li><a href="/{$language}/informacoes/politica-privacidade">Política de privacidade</a></li>
{*                        <li><a href="/{$language}/informacoes/entrega-devolucao">Política de entrega</a></li>*}
                        <li><a href="/{$language}/informacoes/procon-rj">Procon/RJ</a></li>
                    </ul>
                </div>
                <div class="col-sm-3 footer-group">
                    <h2 class="footer-title">Dúvidas</h2>
                    <ul class="footer-lista">
                        <li><a href="/{$language}/informacoes/contato">Atendimento</a></li>
                        <li><a href="/{$language}/informacoes/trocas-e-devolucoes">Trocas e devoluções</a></li>
                            {*<li><a href="/{$language}/informacoes/direito-de-arrependimento">Direito de arrependimento</a></li>*}
                        <li><a href="/{$language}/informacoes/termos-servicos">Termos de serviço</a></li>
                        <li><a href="/{$language}/informacoes/perguntas-frequentes">Perguntas frequentes</a></li>
                        <li><a href="/{$language}/informacoes/cuidados-produtos">Cuidados com os produtos</a></li>

                    </ul>
                </div>
                <div class="col-sm-3 footer-group">
                    <h2 class="footer-title">Eu quero!</h2>
                    <ul class="footer-lista">
                        <li><a href="/{$language}/novos-produtos/">Novos produtos</a></li>
                        <li><a href="/{$language}/informacoes/promocoes">Promoções</a></li>
                        {*<li><a href="/{$language}/informacoes/programa-vantagens">Programa de vantagens</a></li>
                        <li><a href="/{$language}/informacoes/programa-fidelidade">Programa de fidelidade</a></li>*}
                            {*<li><a href="#" class="tag-novo">Guia de presentes</a></li>*}
                    </ul>
                </div>
                <div class="col-sm-3 footer-group">
                    <div class="fb-box-out">
                        <div class="fb-box">
                            <div class="fb-like-box" data-href="https://www.facebook.com/mariadebarroacessorios" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-7 col-md-5 footer-group">
                    <h2 class="footer-title">Formas de pagamento</h2>
                    <p>
                        <img src="{$web_files}/img/assets/band_visa.png">
                        <img src="{$web_files}/img/assets/band_master.png">
                        <img src="{$web_files}/img/assets/band_american.png">
                        <img src="{$web_files}/img/assets/band_diners.png">
                        <img src="{$web_files}/img/assets/band_elo.png">
                        <img src="{$web_files}/img/assets/band_boleto.png">
                    </p>
                </div>
                <div class="col-sm-5 col-md-4 footer-group">
                    <h2 class="footer-title">Certificados</h2>
                    <div style="margin-bottom: 4px;">
                        <div style="display: inline-block;vertical-align: top;">
                            <a id="seloEbit" href="http://www.ebit.com.br/#maria-de-barro" target="_blank" onclick="redir(this.href);" style="display: inline-block;"></a> 
                            <script type="text/javascript" id="getSelo" src="https://imgs.ebit.com.br/ebitBR/selo-ebit/js/getSelo.js?58278">
                            </script>
                        </div>
                        <div style="display: inline-block;vertical-align: top;">
                            <div id="armored_website" style="display: block;margin-bottom: 4px;">
                                <param id="aw_preload" value="true" />
                            </div>
                            <script type="text/javascript" src="//selo.siteblindado.com/aw.js" async></script>
                            <a href="http://www.google.com/safebrowsing/diagnostic?site=http://www.mariadebarro.com.br/" target="_blank" style="display: block;"><img src="{$web_files}/img/assets/google_safe-browsing.png"></a>
                        </div>
                    </div>
                    {if $page eq "index"}<a href="javascript:window.open('http://abcomm.org/certificado.php?url=mariadebarro.com.br', 'c_TW', 'location=no, toolbar=no, width=600, height=670');"><img src="http://selocerto.com.br/selo.php" width="208" border="0"></a>{/if}
                </div>
                <div class="col-sm-12 col-md-3 footer-group">
                    <h2 class="footer-title" style="color: #fff;">Newsletter</h2>
                    <p style="color: #9a9a9a;font-size:13px;font-size:1.3rem;" id="erro_newsletter">Receba nossas novidades e promoções!</p>
                    <form class="" action="" method="post" onsubmit="return false">
                        <input type="email" name="email_newsletter" id="email_newsletter"  class="form-control" placeholder="Seu email" style="background: #3D3D3D;box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);border-radius: 2px;border: solid 1px #373737;color: #CFCFCF;font-weight: 300;">
                        <button type="button" class="btn btn-primary" onclick="javascript:newsletter_footer();" style="border-radius: 2px;float:right;margin-top: -40px">Enviar</button>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>
                        <strong>MARIA DE BARRO ACESSÓRIOS FEMININOS LTDA</strong>
                        <br>CNPJ: 18.611.490/0001-28
                        <br>&copy; Todos os direitos reservados - Edifício Global 7000 Offices - Estrada dos Bandeirantes nº 7000 Bloco C Sala 290, Rio de Janeiro / RJ - CEP: 22780-084 
                        <br>Atendimento ao cliente: maria@mariadebarro.com.br - 21 99576.5038 / 21 3283.5265
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class='footer-bottom'>
        <div class='container'>
            <div class='row'>
                <div class='col-sm-6 col-sm-push-6 text-right'>
                    <div class="redes-sociais">
                        <a target="_blank" href="http://instagram.com/mariadebarro" class="instagram"><i class="fa fa-instagram" style="position: relative; top: 16px;"></i></a>
                        <a target="_blank" href="https://www.facebook.com/mariadebarroacessorios" class="facebook"><i class="fa fa-facebook" style="position: relative; top: 16px;"></i></a>
                        <a target="_blank" href="https://twitter.com/Maria_de_barro" class="twitter"><i class="fa fa-twitter" style="position: relative; top: 16px;"></i></a>
                        <a target="_blank" href="https://plus.google.com/u/0/113176039094986209102/posts" class="gplus"><i class="fa fa-google-plus" style="position: relative; top: 16px;"></i></a>
                        <a target="_blank" href="http://blog.mariadebarro.com.br" class="icon-blogger"></a>
                    </div>
                </div>
                <div class='col-sm-6 col-sm-pull-6'>
                    <p class="copyright">Desenvolvido por <a href="http://designlab.com.br/ " target="_blank"><img src="{$web_files}/img/assets/dl.png" width="90" class="dl"></a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
{*<script language="javascript" src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>*}
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script language="javascript" src="{$web_files}/js/vendor/jquery.easing.1.3.js"></script>
{*<script language="javascript" src="/web-files/js/vendor/jquery.smoothscroll.min.js"></script>*}

<script language="javascript" src="{$web_files}/plugins/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script language="javascript" src="{$web_files}/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script language="javascript" src="{$web_files}/plugins/flexslider/jquery.flexslider-min.js"></script>
<script language="javascript" src="{$web_files}/plugins/fancybox/jquery.fancybox.js"></script>

<script language="javascript" src="{$web_files}/js/vendor/underscore-min.js"></script>
<script language="javascript" src="{$web_files}/js/vendor/fancyselect.min.js"></script>
<script language="javascript" src="{$web_files}/js/funcoes.js"></script>
<script language="javascript" src="{$web_files}/js/jQuery-Mask-Plugin.js"></script>
<script language="javascript" src="{$web_files}/bootstrap/js/bootstrap.js"></script>
<script language="javascript" src="{$web_files}/js/vendor/jquery.payment.js"></script>
<script language="javascript" src="{$web_files}/js/vendor/jquery.mask.min.js"></script>
<script language="javascript" src="{$web_files}/pongstagr.am-master/source/pongstagr.am.js"></script>
<script language="javascript" src="{$web_files}/js/vendor/jquery.magnific-popup.min.js"></script>
<script language="javascript" src="{$web_files}/js/joker.js"></script>
<script language="javascript" src="{$web_files}/js/default.js"></script>

{*<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">*}

{*<script> var link = window.location.href;
if (link.indexOf('https://')) {
window.location = 'https://www.mariadebarro.com.br/';
}</script>
*}

</body>
</html>