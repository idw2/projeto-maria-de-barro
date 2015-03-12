{include file="header.tpl"}

<section class="pag-section pag-section-top" style="margin-bottom: 50px;">
    <div class="container">
         {include file="navbar2.tpl"}
        <h3 class="title-md">Minha lista de desejos</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default"> 
                            <table class="table" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Nome do Produto</th>
                                        <th>Referência</th>
                                        <th>Preço Unitário</th>
                                        <th style="width: 11%;">Quantidade</th>
                                        {*<th style="width: 8%;">Total</th>*}
                                        <th>#</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    {if $nenhum_produto == true}
                                        <tr>
                                            <th colspan="10">Nenhum produto na sua Lista de Desejos!</th>
                                        </tr>
                                    {else}    
                                        {foreach item=lista_desejo from=$ld}  

                                            <tr>
                                                <td>
                                                    <a href="/{$language}/descricao/categoria/{$lista_desejo->CATEG}/{$lista_desejo->URL_AMIGAVEL}">
                                                        <img src="{$lista_desejo->FOTO}" alt="{$lista_desejo->NOME}" title="{$lista_desejo->NOME}" border="0"/>
                                                    </a>
                                                </td>
                                                <td style="text-transform: uppercase;">{$lista_desejo->NOME}</td>
                                                <td>{$lista_desejo->REFERENCIA}</td>
                                                <td>{$lista_desejo->PRECO}</td>
                                                <td id="n_input">
                                                    <table>
                                                        <tr>
                                                            <td><span style="cursor: pointer;" class="minus" onclick="javascript:plus_wishlist2('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=menos&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Menos item"><i class="fa fa-minus-square"></i></span>&nbsp;</td>
                                                            <td><input type="text" name="quantidade" id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/></td>
                                                            <td>&nbsp;<span style="cursor: pointer;" class="plus" onclick="javascript:plus_wishlist2('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=mais&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Mais item"><i class="fa fa-plus-square"></i></span></td>
                                                        </tr>
                                                    </table>                
                                                </td>
{*                                                <td  id="preco_total_produto_{$lista_desejo->CODLISTADESEJOS}"> {if $lista_desejo->TOTAL eq ""}0,00{else}{$lista_desejo->TOTAL}{/if}</td>*}
                                                <td><span style="cursor: pointer;" onclick="javascript:del_row_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}')"><i class="fa fa-times"></i></span></td>
                                            </tr>

                                        {/foreach} 
                                        <tr>
                                            <td colspan="10" valign="center">
                                                <strong>Programa de fidelidade:</strong> Com esta compra você vai ganhar R$ <span class="bonus">{$bonus}</span> de bônus para utilizar nas próximas compras. <a href="/{$language}/informacoes/programa-fidelidade" target="_blank" style="color: #df5d65; font-style: italic;">Saiba como funciona</a>
                                            </td>
                                        </tr>
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div>
                    <ul class="list-unstyled">
                        <li class="next pull-right"><a href="/{$language}/produtos/checkout/" class="btn btn-primary">Finalizar compra &rarr;</a></li>
                    </ul>
                </div> 
            </div>
        </div>

    </div>
</section>

{include file="footer.tpl"}
