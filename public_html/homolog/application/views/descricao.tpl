{include file="header.tpl"}


<!-- PRODUTO / INFORMAÇÕES -->

<section class="pag-section pag-section-top page-produto">
    <div class="container">

        {* PRODUTO *}

        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="row">

                    {* FOTOS *}

                    <div class="col-sm-5">

                        <div class="produto-img">
                            <a href="#" class="produto-img-lupa fa fa-search"></a>
                            <div id="produto-slider" class="flexslider">
                                <ul class="slides">
                                    {counter assign=i start=1 print=false} 
                                    {foreach item=fful from=$fotos_full}
                                        {if $i == 1}
                                            {assign var="FOTO_SM" value="{$fful->FOTO_IT}"}
                                        {/if}
                                        <li>
                                            <a href="{$fful->FOTO_HLG}" class="fancybox-gallery" rel="gallery"><img src="{$fful->FOTO_IT}" alt="{$nome}" border="0" title="{$nome}" /></a>
                                        </li>
                                        {counter}
                                    {/foreach}
                                </ul>
                            </div>
                        </div>
                        <div id="produto-slider-thumbs" class="flexslider">
                            <ul class="slides">

                                {foreach item=fful from=$fotos_full}    
                                    <li>
                                        <img src="{$fful->FOTO_SM}" alt="{$nome}" border="0" title="{$nome}" />
                                    </li>
                                {/foreach}

                            </ul>
                        </div>


                        {*<div>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        </div>
                        <div>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        </div>
                        <div>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        </div>
                        <div>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        </div>
                        <div>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOff.gif' alt='' border='0'/>
                        </div>
                        <div>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        <img src='/web-files/img/CommentStarOn.gif' alt='' border='0'/>
                        </div>*}
                    </div>

                    {* INFORMAÇÕES *}

                    <div class="col-sm-7">

                        <h3 class="title-condensed">{$nome}</h3>
                        <p>{$descricao}</p>
                        <hr>
                        <label style="margin-bottom: 15px;">
                            <script src="../../web-files/js/default.js" type="text/javascript"></script>
                            Quantidade: <input type="tel" name="quantidade" id="quantidade"  class="form-control" style="width: 42px;text-align: center;padding: 0;" value="1" maxlength="3" />
                        </label>                        
                        {*                        <div>*}
                        <div class="label-outline label-outline-light pull-right" style="border:none;">Disponibilidade: <strong>{if $quantidade == "0"}Esgotado{else}Em Estoque{/if}</strong></div>
                        {*                        </div>                        *}
                        <hr>
                        <h2 class="title-lg produto-preco">{if $is_promocao eq 1}<span class="price-through" style="position: relative; top: -2px; color: #9a9a9a; font-size: 14px; font-size: 1.4rem; font-weight: 400; line-height: 1;">R$ {$de}</span>{/if} R$ {$preco}</h2>
                        <div class="produto-parcelamento">ou <strong>6x</strong> de <strong>R$ {$preco_6}</strong></div>
                        <hr>
                        {if $quantidade == "0"}
                            <label style="margin-bottom: 15px;">Avise me ao chegar: </label> 
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="hidden" class="form-control avise-me-ao-referencia" value="{$referencia}">
                                        <input type="text" class="form-control avise-me-ao-chegar" value="{$email_logon}" placeholder="E-mail">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default avise-me-ao-chegar-button" type="button"><i class="glyphicon glyphicon-envelope"></i></button>
                                        </span> 
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-3 avise-me-ao-chegar-error" style="color: #df5d65; font-weight: bold; line-height: 4;"></div>
                            </div>
                        {else}    
                            <button href="#" class="btn btn-primary comprar" data-params="{$lista_desejos}" data-id="{$produto->CODPRODUTO}" data-img="{$FOTO_SM}" data-redirect="/{$language}/produtos/checkout/" data-name="{$nome}">
                                ADOREI, QUERO COMPRAR
                            </button>

                            <!--
                            <a href="#" class="btn btn-heart fa fa-heart">
                                <span class="fa fa-heart"></span>
                            </a>
                            -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="avise-me-ao-chegar-error" style="color: #df5d65; font-weight: bold; line-height: 4;"></div>
                                </div>
                            </div>
                            <span class="Loader hide">
                                <img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..."/>
                            </span>

                        {/if}

                        {if (int)$quantidade > 0}

                            <hr>

                            {*                            <div class="panel-heading" style='font-family: "Roboto Condensed",sans-serif; color: #57574b; font-size: 16px; font-size: 1.6rem; padding: 0 15px; height: 40px; line-height: 40px; font-weight: 200; background-color: #e9e9e9;'>Estimar custo de envio deste produto.</div>*}

                            <table class="table" style="font-size: 11px;margin-top: 12px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Calcular frete e prazo: </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='width: 55%;'>
                                            <input type="hidden" class="form-control" id="total_peso" name="total_peso" value="{$peso}"/>
                                            <input type="hidden" class="form-control" id="cep_remetente" name="cep_remetente" value="{$cep_remetente}"/>
                                            <input type="text" class="form-control" id="cep_destinatario" name="cep_destinatario" maxlength="8" value="{$CEP}" onkeypress="return formataCEP(event, this);" placeholder="CEP" style="width: 95%;"/>
                                            <input type="hidden" class="form-control" id="total_parcial" name="total_parcial" maxlength="8" value="{$preco}" onkeypress="return formataCEP(event, this);" placeholder="CEP"/>
                                            <input type="hidden" class="form-control" id="total_impostos" name="total_impostos" maxlength="8" value="{$total_impostos}" onkeypress="return formataCEP(event, this);" placeholder="CEP"/>

                                            <div style='margin: 12px 0;'>
                                                <span id="msg_erro" style="color: #df5d65; font-weight: bold; line-height: 4;"></span>
                                                <span class="LoaderImg hide">
                                                    <img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/>
                                                </span>
                                            </div>
                                            <button type="button" id="btn_calc_cep_rapido" class="btn btn-light btn-sm" role="button">Calcular</button>
                                        </td>
                                        <td>
                                            <select id="forma_envio_rapido" class="form-control">
                                                <option value="total_express">Total Express - Transportadora</option>
                                                <option value="41106">Correios - PAC</option>
                                                <option value="40010">Correios - SEDEX</option>
                                                <option value="40215">Correios - SEDEX 10</option>
                                                <option value="40290">Correios - SEDEX hoje</option>
                                                {*<option value="81019">e-SEDEX</option>*}
                                            </select>
                                        </td>
                                    </tr>
                                <tbody>
                            </table>
                            <div id="table-frete" style="display: none;">
                                <hr>
                                <table style="width: 100%;">
                                    <thead style="border-bottom: solid 1px #e9e9e9;">
                                        <tr>
                                            <th><p style="color: #df5d65; font-weight: bold;">Entrega</p></th>
                                    <th><p style="color: #df5d65; font-weight: bold;">Frete</p></th>
                                    <th><p style="color: #df5d65; font-weight: bold;">Prazo</p></th>
                                    </tr>
                                    </thead>
                                    <tr>
                                        <td>
                                            <p id='entrega' style="font-weight: 400; margin: 12px 0;"></p>
                                        </td>
                                        <td>
                                            <p id='frete' style="font-weight: 400; margin: 12px 0;"></p>
                                        </td>
                                        <td>
                                            <p id='prazo' style="font-weight: 400; margin: 12px 0;"></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        {/if}
                        {*<hr>

                        <div class="panel panel-default">

                        <div class="panel-heading" style='font-family: "Roboto Condensed",sans-serif; color: #57574b; font-size: 16px; font-size: 1.6rem; padding: 0 15px; height: 40px; line-height: 40px; font-weight: 200; background-color: #e9e9e9;'>Por favor, avalie este produto!</div>

                        <table class="table" style="font-size: 11px">
                        <thead>
                        <tr>
                        <th>
                        <div style="float: left">
                        <img src="/web-files/img/ico-04.gif" border='0' alt="Pessoas Falando sobre este Produto" title="Pessoas Falando sobre este Produto"/> <span style="color: #df5d65; font-weight: bold; line-height: 1; font-size: 33px; position: relative; top: 5px;">0</span>
                        </div>
                        <div style="float: right">
                        {if $nome_logon != ""}
                        <label>Avaliação</label>
                        <select id="avaliacao" class="form-control">
                        <option value="NAO_GOSTEI">Não gostei deste produto!</option>
                        <option value="RAZOAVEL">Este produto é razoavelmente bom!</option>
                        <option value="BOM">Este produto é bom!</option>
                        <option value="EXCELENTE">Excelente produto!</option>
                        </select>
                        <div style='height: 40px; display: inline-block'>
                        <span id="msg_erro_avaliacao" style="color: #df5d65; font-weight: bold; line-height: 4;"></span>
                        <span class="LoaderAvaliacao hide">
                        <img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/>
                        </span>
                        </div>
                        <br>
                        <button type="button" id="btn_avaliacao" class="btn btn-primary btn-lg btn-primary-maria" role="button">Avaliar</button>
                        {else}
                        <div id="minhaAvaliacao">
                        <span id="btn_avaliacao_timer"></span>
                        <label>Realize o <a style="cursor: pointer" onclick="speed_login()" >"Login"</a> para avaliar este produto!</label>
                        </div>
                        {/if}
                        </div>
                        <div style="clear: both"> </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td style='width: 57%;'>
                        <label>Não gostei deste produto!</label>        
                        <div class="progress">
                        <div class="progress-bar progress-bar-danger" style="width: 0%">
                        <span class="sr-only">10% Complete (danger)</span>
                        </div>
                        </div>
                        <label>Este produto é razoavelmente bom!</label>
                        <div class="progress">
                        <div class="progress-bar progress-bar-danger" style="width: 0%">
                        <span class="sr-only">10% Complete (danger)</span>
                        </div>
                        </div>
                        <label>Este produto é bom!</label>        
                        <div class="progress">
                        <div class="progress-bar progress-bar-danger" style="width: 0%">
                        <span class="sr-only">10% Complete (danger)</span>
                        </div>
                        </div>
                        <label>Excelente produto!</label>        
                        <div class="progress">

                        <div class="progress-bar progress-bar-danger" style="width: 0%">
                        <span class="sr-only">10% Complete (danger)</span>
                        </div>
                        </div>
                        </td>
                        </tr>
                        <tbody>
                        </table>


                        </div>*} 




                    </div>
                </div>

                {* SOCIAL *}

                <div class="row">
                    <div class="col-lg-12">
                        {*
                        vvv Pegar o route atual vvv
                        *}
                        <p style="margin: 12px 0 28px;" class="social-block">
                            <span>Compartilhe: </span>
                            <a href="http://www.facebook.com/sharer.php?u={$site}{$language}/{$ctgr}/{$url_amigavel}?news=s&utm_source=fbBTshare" target="_blank" class="social social-fb fa fa-facebook"></a>
                            <a  href="http://twitter.com/share?text={$titulo}&url={$url}&via=maria_de_barro" target="_blank" target="_blank" class="social social-twitter fa fa-twitter"></a>
                        </p>
                    </div>
                </div>

                {* COMENTÁRIOS / FACEBOOK *}

                <div class="row">
                    <div class="col-lg-12">


                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active">
                                <a href="#mais-informacoes" role="tab" data-toggle="tab" >Mais Informações</a>
                            </li>
                            <li>
                                <a href="#comentarios" role="tab" data-toggle="tab" >Comentários</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="mais-informacoes">
                                {$especificacoes}
                            </div>
                            <div class="tab-pane" id="comentarios">
                                <div id="fb-root"></div>
                                <script>
                                    (function (d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id))
                                            return;
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=256162091228883&version=v2.0";
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));
                                </script>
                                <div class="fb-comments" data-width="100%" data-href="{$facebook}?href={$fb_post_url}" data-numposts="15" data-colorscheme="light"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {* SIDEBAR *}

            <div class="col-md-4 col-lg-3 produto-sidebar hidden-sm">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="thumbs-slider" style="margin-top: -8px;">
                            <div class="thumbs-slider-header">
                                <div class="thumbs-slider-controls pull-right">
                                    <ul class="nav nav-pills">
                                        <li><a href="#" class="btn btn-light btn-simple fa fa-chevron-left previous"></a></li>
                                        <li><a href="#" class="btn btn-light btn-simple fa fa-chevron-right next"></a></li>
                                    </ul>
                                </div>
                                <h3 class="thumbs-slider-title title-condensed">EM PROMOÇÃO</h3>
                            </div>
                            <ul class="slides">
                                {foreach item=promocao from=$promocoes} 
                                    <li>
                                        <div class="thumbnail">
                                            <div class="thumbnail-img">
                                                <a href="/{$language}/{$promocao->CATEGORIA}/{$promocao->URL_AMIGAVEL}">
                                                    {if $promocao->IS_NOVO eq "1"}
                                                        <span class="thumbnail-tag">Novo</span>
                                                    {/if}
                                                    <img src="{$promocao->CROP268}" alt="{$promocao->NOME}" border="0" title="{$promocao->NOME}" class="img-responsive" width="261" height="289"/>
                                                </a>
                                            </div>
                                            <div class="thumbnail-infos">
                                                <a href="/{$language}/{$promocao->CATEGORIA}/{$promocao->URL_AMIGAVEL}">
                                                    <div class="thumbnail-subtitle">{$promocao->NOME}</div>
                                                </a>
                                                <a href="/{$language}/{$promocao->CATEGORIA}/{$promocao->URL_AMIGAVEL}">
                                                    <div class="thumbnail-title">{if $promocao->IS_PROMOCAO eq 1}<span class="price-through">R$ {$promocao->DE}</span>{/if} R$ {$promocao->PRECO}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        {if $nome_logon != ""}
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span class="panel-title">Wishlist</span>
                                </div>
                                <div class="panel-body">

                                    <table class="table" style="font-size: 14px">

                                        {if $nenhum_produto == true}
                                            <tr>
                                                <th colspan="10">Nenhum produto!</th>
                                            </tr>
                                        {else}    
                                            {foreach item=lista_desejo from=$ld}  


                                                <tr style="font-size: 6px;">
                                                    <td>
                                                        <a href="/{$language}/descricao/categoria/{$lista_desejo->CATEG}/{$lista_desejo->URL_AMIGAVEL}">
                                                            <img src="{$lista_desejo->FOTO}" alt="{$lista_desejo->NOME}" title="{$lista_desejo->NOME}" border="0"/>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    {$lista_desejo->NOME}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    {$lista_desejo->REFERENCIA}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    {$lista_desejo->PRECO}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="quantidade" id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                            {/foreach} 
                                            <tr>
                                                <td colspan="4" valign="center">
                                                    <strong>Programa de fidelidade:</strong> Com esta compra você vai ganhar R$ <span class="bonus">{$bonus}</span> de bônus para utilizar nas próximas compras. <a href="/{$language}/informacoes/programa-fidelidade" target="_blank" style="color: #df5d65; font-style: italic;">Saiba como funciona</a>
                                                </td>
                                            </tr>
                                        {/if}
                                    </table>


                                    {*Nenhum produto*}
                                    <hr>
                                    <div class="text-right">
                                        <a href="/{$language}/conta/wishlist" class="btn-link">&raquo; Meus Desejos</a>
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /PRODUTO / INFORMAÇÕES -->
<!-- RELACIONADOS -->

<section class="pag-section">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="section-title">
                    <h2>
                        <strong>Produtos</strong> Relacionados
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            {foreach item=produto from=$arr} 
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
                            <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                            <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                <div class="thumbnail-subtitle">{$produto->NOME}</div>
                            </a>
                            <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                <div class="thumbnail-title">{if $produto->IS_PROMOCAO eq 1}<span class="price-through">R$ {$produto->DE}</span>{/if} R$ {$produto->PRECO}</div>
                            </a>
                            <span class="ou"></span>
                            <div class="thumbnail-infos-highlight"><strong>6x</strong> de <strong>R$ {$produto->PRECO_6}</strong></div>
                            {*<div class="thumbnail-btn">
                            <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light">Eu quero</a>
                            <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                            <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                            </span>
                            </div>*}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</section>

<!-- /RELACIONADOS -->

{include file="footer.tpl"}