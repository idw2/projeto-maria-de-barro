{include file="header.tpl"}


<!-- PRODUTO / INFORMAÇÕES -->

<section class="pag-section pag-section-top">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">

                    {* FOTOS *}

                    <div class="col-sm-6">

                        <img src="{$foto_550}" alt="{$nome}" border="0" title="{$nome}" class="img-responsive" />
                        {*<ul>
                        {foreach item=fful from=$fotos_full}  
                            
                        <li>
                        <img src="{$fful->FOTO_SM}" alt="{$nome}" border="0" title="{$nome}" class="img-responsive" data-img-sm="{$fful->FOTO_SM}" data-img-md="{$fful->FOTO_MD}" data-img-it="{$fful->FOTO_IT}" data-img-lg="{$fful->FOTO_LG}"/>
                        </li>
                        
                        {/foreach}
                        </ul>*}
                    </div>

                    {* INFORMAÇÕES *}

                    <div class="col-sm-6">

                        <h3 class="title-condensed">{$nome}</h3>
                        <p>{$descricao}</p>

                        <hr>
                        <label class="col-sm-3">Quantidade: </label>
                        <input type="text" name="quantidade" id="quantidade"  class="form-control" style="width: 44px;" value="1" maxlength="3" />
                        <div>
                            
                            <table> 
                                <tr>
                                    <td><strong style="color: #57574b;">Quantidade:</strong>&nbsp;</td>
                                    {*<td><span class="minus" onclick="javascript:plus('menos');" title="Menos item"><i class="fa fa-minus-square"></i></span></td>*}
                                    {*<td><input type="text" name="quantidade" id="quantidade"  class="form-control" style="width: 44px;" value="1" maxlength="3" /></td>*}
                                    {*<td><span class="plus" onclick="javascript:plus('mais');" title="Mais item"><i class="fa fa-plus-square"></i></span></td>*}
                                </tr>
                            </table>  
                        </div>
                        <div>
                            {if $quantidade == "0"}
                                <div class="btn btn-white no-btn">Disponibilidade: <strong>Esgotado</strong></div>
                            {else}
                                <div class="btn btn-white no-btn">Disponibilidade: <strong>Em Estoque</strong></div>
                            {/if}

                        </div>

                        <hr>
                        <h2 class="title-big">R$ {$preco}</h2>
                        <hr>

                        <div>
                            {if $quantidade != "0"}
                                <a onclick="javascript:add_checkout('{$lista_desejos}', '/{$language}/produtos/checkout/')" class="btn btn-light">ADOREI, EU QUERO</a>
                                <a class="btn btn-heart fa fa-heart"  onclick="javascript:add_lista_desejos('{$lista_desejos}')" title="Adicionar a minha Lista de Desejos">
                                    <span class="fa fa-heart"></span>
                                </a>
                                <span class="Loader hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>
                                {/if}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li {if $abas eq "mais_informacoes"} class="active" {/if}><a href="/{$language}/descricao/categoria/{$categoria_default}/{$url_amigavel}/mais_informacoes">Mais Informações</a></li>
                                    <li {if $abas eq "comentarios"} class="active" {/if}><a href="/{$language}/descricao/categoria/{$categoria_default}/{$url_amigavel}/comentarios">Comentários</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <p>
                                    Peças com 1 ano de garantia com 7 milesimos em banho de ouro.<br>
                                    *Troca de produtos nao vendidos prazo de 30 dias<br>
                                    <br>
                                    *Devido a configuração do seu monitor, pode ser que haja uma variação na cor e não representar com fidelidade a tonalidade real do produto.
                                </p>
                            </div>
                        </div>

                        {*{if $abas eq "mais_informacoes"}            
                        {$especificacoes}
                        {else}
                        <br/>
                        <br/>
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
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

                        {/if}    *}        

                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-lg-12">                    
                        <img src="/web-files/img/assets/interna_01.jpg">
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
                <div class="col-sm-4 col-md-3">
                    <div class="thumbnail">
                        <div class="thumbnail-img">
                            <a href="/{$language}/descricao/categoria/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                {if $produto->IS_NOVO eq "1"}
                                    <span class="thumbnail-tag">Novo</span>
                                {/if}
                                <img src="{$produto->CROP268}" alt="{$produto->NOME}" border="0" title="{$produto->NOME}" class="img-responsive" width="261" height="289"/>
                            </a>
                        </div>
                        <div class="thumbnail-infos">
                            <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                            <a href="/{$language}/descricao/categoria/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                <div class="thumbnail-title">R$ {$produto->PRECO}</div>
                                <a href="/{$language}/descricao/categoria/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-subtitle">{$produto->NOME}</div>
                                </a>
                                <div class="thumbnail-btn">
                                    <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light">Eu quero</a>
                                    <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                                        <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                                    </span>
                                </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</section>

<!-- /RELACIONADOS -->

{include file="footer.tpl"}

<script>

    function plus(valor) {
        var qntdd = parseInt($("#quantidade").val());
        if (valor == "mais") {
            qntdd = (qntdd + 1);
            $("#quantidade").val(qntdd);
            return false;
        } else {
            if ($("#quantidade").val() == 1) {
                return false;
            } else {
                qntdd = (qntdd - 1);
                $("#quantidade").val(qntdd);
                return false;
            }
        }
    }

    function add_lista_desejos(params) {
        $(".Loader").removeClass('hide');
        var qntdd = parseInt($("#quantidade").val());
        var quantidade = "&QUANTIDADE=" + qntdd;
        var valores = params + quantidade;

        $.ajax({
            type: 'post',
            data: valores,
            url: '/web-files/server/add_lista_desejos.php',
            success: function(data) {
                //alert(data);
                $("#list-drop-desejos").html(data);
                $(".Loader").addClass('hide');

                var carrinho = $("#item_carrinho").html();
                var limpa_1 = carrinho.replace("Itens", "");
                var limpa_2 = limpa_1.replace("Item", "");
                var limpa_3 = limpa_2.replace("(Vazio)", "");
                var str = limpa_3.trim();

                if (str == "") {
                    if (qntdd == 1) {
                        var resultado = qntdd + " Item";
                        $("#item_carrinho").html(resultado);
                    } else {
                        var resultado = qntdd + " Itens";
                        $("#item_carrinho").html(resultado);
                    }
                } else {

                    var valor = parseInt(str) + qntdd;
                    var resultado = valor + " Itens";
                    $("#item_carrinho").html(resultado);
                }

                //window.location.reload();
                //$("a[title=Close]").click();
                //$(".myload_crop_" + indice).html("<strong style='color: #395aa4'>" + data + "</strong>");
            }
        });
    }

    function add_checkout(params, url) {
        $(".Loader").removeClass('hide');
        var qntdd = parseInt($("#quantidade").val());
        var quantidade = "&QUANTIDADE=" + qntdd;
        var valores = params + quantidade;

        $.ajax({
            type: 'post',
            data: valores,
            url: '/web-files/server/add_lista_desejos.php',
            success: function(data) {
                //alert(data);
                //$("#list-drop-desejos").html(data);
                $(".Loader").addClass('hide');
                window.location = url;

                //window.location.reload();
                //$("a[title=Close]").click();
                //$(".myload_crop_" + indice).html("<strong style='color: #395aa4'>" + data + "</strong>");
            }
        });
    }


</script>