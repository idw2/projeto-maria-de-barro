{include file="header.tpl"}


<!--[if lt IE 9]>
    <script type="text/javascript">
        alert('Atenção: Você está usando um navegador obsoleto!');
    </script>
<![endif]-->

<!-- SLIDER  -->

<section class="container-slider">
    <div id="slider">
        <ul>

            <li data-transition="fade" data-slotamount="7">
                <img src="{$web_files}/img/slider/slider4/slide_03.jpg" alt="-" />
                <div class="caption lfl str" data-x="165" data-hoffset="0" data-y="40" data-speed="1500" data-start="45" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slider4/liquida_01.png" alt="-" width="796" />
                </div>
                <div class="caption lfr str" data-x="125" data-hoffset="0" data-y="290" data-speed="1500" data-start="45" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slider4/liquida_02.png" alt="-" width="531" />
                </div>
                <div class="caption lft str" data-x="45" data-hoffset="0" data-y="370" data-speed="1500" data-start="45" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slider4/liquida_03.png"  width="626" />
                </div>
                <div class="caption lft str" data-x="700" data-hoffset="120" data-y="275" data-speed="1500" data-start="45" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slider4/liquida_04.png"  width="448" />
                </div>

            </li>

            {*<li data-transition="fade" data-slotamount="7">
                <img src="{$web_files}/img/slider/slide_03.jpg" alt="-" />
                <div class="caption lfl str" data-x="center" data-hoffset="0" data-y="30" data-speed="500" data-start="300" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03/img-4_boho.png" alt="-" width="390" />
                </div>
                <div class="caption lfl str" data-x="45" data-hoffset="0" data-y="110" data-speed="500" data-start="500" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03/img-3_boho.png" alt="-" width="429" />
                </div>
                <div class="caption lfr str" data-x="700" data-hoffset="-80" data-y="110" data-speed="500" data-start="700" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03/img-1_boho.png" alt="-" width="404" />
                </div>
                <div class="caption lft str" data-x="center" data-hoffset="0" data-y="225" data-speed="500" data-start="900" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03/img-2_boho.png"  width="240" />
                </div>
            </li>*}

           {* <li data-transition="fade" data-slotamount="7">
                <img src="{$web_files}/img/slider/slide_03.jpg" alt="-" />
                <div class="caption lfl str" data-x="705" data-hoffset="-30" data-y="380" data-speed="500" data-start="500" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03_carna-item-1.png" alt="-" width="490" />
                </div>
                <div class="caption lfr str" data-x="650" data-hoffset="-30" data-y="0" data-speed="500" data-start="700" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03_carna-item-2.png" alt="-" width="578" />
                </div>
                <div class="caption lft str" data-x="25" data-hoffset="0" data-y="25" data-speed="500" data-start="900" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03_carna-item-3.png"  width="696" />
                </div>
                <div class="caption lfl str" data-x="65" data-hoffset="-30" data-y="205" data-speed="500" data-start="200" data-easing="easeOutExpo">
                    <img src="{$web_files}/img/slider/slide_03_carna-item-4.png" alt="-" width="607" />
                </div>
            </li>*}



        </ul>	      
    </div>
</section>

<!-- /SLIDER  -->
<!-- 3 PRODUTOS  -->

<section class="pag-section hide-mobile">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="{$web_files}/img/b-1.png" alt="" border="0" title="" class="img-responsive" style="width:360px;height:185px;" />
            </div>
            <div class="col-sm-4">
                <img src="{$web_files}/img/slider/banner-menor-central2.jpg" alt="Frete grátis nas compras acima de R$149,00" border="0" title="" class="img-responsive" />
            </div>
            <div class="col-sm-4">
                <img src="{$web_files}/img/b-2.png" alt="" border="0" title="" class="img-responsive" style="width:360px;height:185px;" />
            </div>
        </div>
    </div>
</section>

<!-- /3 PRODUTOS  -->
<!-- RECEM CHEGADOS  -->

<section class="pag-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>
                        <a href="/{$language}/novos-produtos">
                            <strong>Novos</strong> Produtos
                        </a>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            {foreach item=produto from=$arr}
                {if $produto->CODPRODUTO != ""}
                    <div class="col-thumb col-xs-6 col-sm-3">
                        <div class="thumbnail">
                            <div class="thumbnail-img">
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    {if $produto->IS_NOVO eq "1"}
                                        <span class="thumbnail-tag">Novo</span>
                                    {/if}
                                    <img src="{$produto->CROP268}" alt="{$produto->NOME}" title="{$produto->NOME}"/>
                                </a>
                            </div>
                            <div class="thumbnail-infos">

                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-subtitle">{$produto->NOME}</div>
                                </a>

                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-title">{if $produto->IS_PROMOCAO eq 1}<span class="price-through">R$ {$produto->DE}</span>{/if} R$ {$produto->PRECO}</div>
                                </a>
                                <span class="ou"></span>
                                <div class="thumbnail-infos-highlight"><strong>6x</strong> de <strong>R$ {$produto->PRECO_6}</strong></div>

                                {*<div class="thumbnail-btn">
                                <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light eu-quero" data-id="{$produto->CODPRODUTO}">
                                <span>Eu quero</span>
                                </a>
                                <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                                <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                                </span>
                                </div>*}
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}
        </div>
        {*<div class="row">
        <div class="col-lg-12">
        <ul class="pagination">
        <li class="disabled"><a href="#">«</a></li>

        {counter assign=i start=1 print=false} 
        {foreach item=pgn from=$paginacao}  
        {if $acao == "geral"}
        {if $compara_paginacao == $pgn}
        <li class="active"><a href="/{$language}/categoria/{$acao}/mais_produtos/{$pgn}">{$i}</a></li>
        {else}
        <li><a href="/{$language}/categoria/{$acao}/mais_produtos/{$pgn}">{$i}</a></li>
        {/if}   
        {/if}   
        {counter}    
        {/foreach}
        </ul>
        </div>
        </div>*}
    </div>
</section>

<!-- /RECEM CHEGADOS  -->
<!-- MAIS VENDIDOS  -->

<section class="pag-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>
                        <a href="/{$language}/mais-vendidos">
                            <strong>Mais</strong> Vendidos
                        </a>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">

            {foreach item=produto from=$arr_mais_vendidos}
                {if $produto->CODPRODUTO != ""}
                    <div class="col-thumb col-xs-6 col-sm-3">
                        <div class="thumbnail">
                            <div class="thumbnail-img">
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    {if $produto->IS_NOVO eq "1"}
                                        <span class="thumbnail-tag">Novo</span>
                                    {/if}
                                    <img src="{$produto->CROP268}" alt="{$produto->NOME}" border="0" title="{$produto->NOME}" class="img-responsive" width="261" height="289"/>
                                </a>
                            </div>
                            <div class="thumbnail-infos">
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-subtitle">{$produto->NOME}</div>
                                </a>
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-title">{if $produto->IS_PROMOCAO eq 1}<span class="price-through">R$ {$produto->DE}</span>{/if} R$ {$produto->PRECO}</div>
                                </a>
                                <span class="ou"></span>
                                <div class="thumbnail-infos-highlight"><strong>6x</strong> de <strong>R$ {$produto->PRECO_6}</strong></div>

                                {*<div class="thumbnail-btn">
                                <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light eu-quero" data-id="{$produto->CODPRODUTO}">
                                <span>Eu quero</span>
                                </a>
                                <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                                <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                                </span>
                                </div>*}
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}


        </div>
    </div>
</section>

<!-- /MAIS VENDIDOS  -->
<!-- EM PROMOCÃO  -->

<section class="pag-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>
                        <a href="/{$language}/promocoes">
                            <strong>Itens</strong> em Promoção
                        </a>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">

            {foreach item=produto from=$arr_promocoes}
                {if $produto->CODPRODUTO != ""}
                    <div class="col-thumb col-xs-6 col-sm-3">
                        <div class="thumbnail">
                            <div class="thumbnail-img">
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    {if $produto->IS_NOVO eq "1"}
                                        <span class="thumbnail-tag">Novo</span>
                                    {/if}
                                    <img src="{$produto->CROP268}" alt="{$produto->NOME}" border="0" title="{$produto->NOME}" class="img-responsive" width="261" height="289"/>
                                </a>
                            </div>
                            <div class="thumbnail-infos">

                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-subtitle">{$produto->NOME}</div>
                                </a>
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-title">{if $produto->IS_PROMOCAO eq 1}<span class="price-through">R$ {$produto->DE}</span>{/if} R$ {$produto->PRECO}</div>
                                </a>
                                <span class="ou"></span>
                                <div class="thumbnail-infos-highlight"><strong>6x</strong> de <strong>R$ {$produto->PRECO_6}</strong></div>
                                {*<div class="thumbnail-btn">
                                <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light eu-quero" data-id="{$produto->CODPRODUTO}">
                                <span>Eu quero</span>
                                </a>
                                <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                                <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                                </span>
                                </div>*}
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}


        </div>
    </div>
</section>

<!-- /EM PROMOCÃO  -->
<!-- INSTAGRAM  -->

<section class="pag-section hide-mobile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="section-title">
                    <h2>
                        <a href="#">
                            <strong>Instagram da</strong> Maria
                        </a>
                    </h2>
                </div>

            </div>
        </div>                        
        <div id="instagram" data-type="liked" class="pongstagrm row"></div>  
    </div>
</section>

<!-- /INSTAGRAM  -->


{if $float_banner eq true }
    <style> 
        .mfp-iframe-scaler iframe{
            background: none;
            box-shadow: none;
        }
        .mfp-iframe-holder .mfp-content{
            max-width: 649px;
            height: 461px;
        }
    </style>
    <script type="text/javascript">
        window.onload = function() {
            $.magnificPopup.open({
                items: {
                    src: '/web-files/emails/float_banner_20150205/index.html',
                    type: 'iframe'
                },
                callbacks: {
                    close: function() {
                        
                    }
                }
            });
        }
    </script>
{/if}

{include file="footer.tpl"}