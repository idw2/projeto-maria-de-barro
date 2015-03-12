{include file="header.tpl"}

<section class="pag-section pag-section-top" style="margin-bottom: 50px;">
    <div class="container">
        <h2 class="title-lg">SEUS PRODUTOS</h2>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default"> 
                            <table class="table table-update" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Nome do Produto</th>
                                        <th>Referência</th>
                                        <th>Preço</th>
                                        <th style="width: 11%;">Quantidade</th>
                                        <th style="width: 8%;">Total</th>
                                        <th>#</th>
                                    </tr>
                                </thead>

                                <tbody class="tbody-update">

                                    {if $nenhum_produto == true}
                                        <tr>
                                            <th colspan="10">Nenhum produto na sua Lista de Desejos!</th>
                                        </tr>
                                    {else}    
                                        {foreach item=lista_desejo from=$ld}  

                                            <tr>
                                                <td><a href="/{$language}/descricao/categoria/{$lista_desejo->CATEG}/{$lista_desejo->URL_AMIGAVEL}"><img src="{$lista_desejo->FOTO}" alt="{$lista_desejo->NOME}" title="{$lista_desejo->NOME}" border="0"/></a><br/></td>
                                                <td style="text-transform: uppercase;">{$lista_desejo->NOME}</td>
                                                <td>{$lista_desejo->REFERENCIA}</td>
                                                <td>{$lista_desejo->PRECO}</td>
                                                <td id="n_input">
                                                    <table>
                                                        <tr>
                                                            <td><span style="cursor: pointer;" class="minus" onclick="javascript:plus_wishlist_checkout('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=menos&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Menos item"><i class="fa fa-minus-square"></i></span>&nbsp;</td>
                                                            <td><input type="text" name="quantidade" id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/></td>
                                                            <td>&nbsp;<span style="cursor: pointer;" class="plus" onclick="javascript:plus_wishlist_checkout('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=mais&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Mais item"><i class="fa fa-plus-square"></i></span></td>
                                                        </tr>
                                                    </table>                
                                                </td>
{*                                                <td id="n_input">*}
                                                    {*                                                    <span class="minus" onclick="javascript:plus_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=menos&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Menos item"><i class="fa fa-minus-square"></i></span>*}
{*                                                    <input type="text" name="quantidade" {*id="quantidade"* } id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center; border: 0; color: #777; cursor: text; padding: 0px 0px 17px 20px;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/>*}
                                                    {*                                                    <span class="plus" onclick="javascript:plus_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=mais&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Mais item"><i class="fa fa-plus-square"></i></span>*}
{*                                                </td>*}
                                                <td  id="preco_total_produto_{$lista_desejo->CODLISTADESEJOS}"> {if $lista_desejo->TOTAL eq ""}0,00{else}{$lista_desejo->TOTAL}{/if}</td>
                                                <td><span onclick="javascript:del_row_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}')"><i class="fa fa-times"></i></span></td>
                                            </tr>

                                        {/foreach} 
                                        <tr>
                                            <td colspan="10" valign="center">
                                                <img src="{$web_files}/img/present.png" border="0" alt="Embalagem para presente" alt="Embalagem para presente"/> <strong>Deseja que embale para presente?</strong> <span style="cursor: pointer; color: #df5d65; font-style: italic;" onclick="embalar_presente()"/>Clique aqui</span> <span {if $embalar_presente eq "1" }class="yes"{else}class="yes hide"{/if}> &nbsp;<img src="{$web_files}/img/yes.png" alt="OK" title="OK" border="0"/></span>
                                            </td>
                                        </tr>
                                        {*<tr>
                                        <td colspan="10" valign="center">
                                        <strong>Programa de fidelidade:</strong> Com esta compra você vai ganhar R$ <span class="bonus">{$bonus}</span> de bônus para utilizar nas próximas compras. <a href="/{$language}/informacoes/programa-fidelidade" target="_blank" style="color: #df5d65; font-style: italic;">Saiba como funciona</a>
                                        </td>
                                        </tr>*}
                                        {*<tr>
                                        <td colspan="10" valign="center">
                                        <h4 style='font-size: 15px;margin-top: 8px;'>VANTAGENS AO FINALIZAR ESTA COMPRA:</h4>
                                        <div class='panel panel-toggle'>
                                        <strong>LOREM:</strong> ... <a onclick='$(this).next(".panel-body").toggleClass("hide");' style='cursor:pointer;'>Ver regras</a>
                                        <div class='panel-body hide'>hey</div>
                                        </div>
                                        </td>
                                        </tr>*}
                                    {/if}

                                <style>
                                    .panel-toggle{
                                        background: #EFEDED;
                                        border-bottom: solid 2px #D2D2D2 !important;
                                        padding: 12px;
                                    }
                                </style>

                                {if $nenhum_produto == false}
                                <table class="table" style="font-size: 11px;margin-top: 12px;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Calcular frete e prazo: </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='width: 55%;'>
                                                <input type="hidden" class="form-control" id="codproduto" name="codproduto" value="{$codproduto}"/>
                                                <input type="hidden" class="form-control" id="codcadastro" name="codcadastro" value="{$codcadastro}"/>
                                                <input type="hidden" class="form-control" id="total_peso" name="total_peso" value="{$total_peso}"/>
                                                <input type="hidden" class="form-control" id="cep_remetente" name="cep_remetente" value="{$cep_remetente}"/>
                                                <input type="text" class="form-control" id="cep_destinatario" name="cep_destinatario" maxlength="8" value="{$CEP}" onkeypress="return formataCEP(event, this);" placeholder="CEP" style="width: 95%;"/>

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

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div>
                    <ul class="list-unstyled">
                        <li class="previous pull-left"><a href="/{$language}/" class="btn btn-dark">&larr; Continuar comprando</a></li>
                            {if $nenhum_produto == false}
                            <li class="next pull-right hide"><a onclick="javascript:finalizar_compra()" class="btn btn-primary">Finalizar compra &rarr;</a></li>
                            {/if}
                    </ul>
                </div> 

                <div class="row">
                    <div class="col-lg-12" style="text-align: center;margin-bottom: 25px;">
                        <hr style="position: relative; top: 18px; border-top: 5px solid #eee;"/>
                        <img src="{$web_files}/img/Lock.png" alt="Checkout seguro"  title="Checkout seguro" border="0" style="width: 7%; position: relative; bottom: 30px; border: 8px solid #fff; border-radius: 13px;"/>
                        <h3 style="color: #df5d65;" id="checkout_seguro">CHECKOUT SEGURO</h3>
                        <div style="font-size: 22px;">TOTAL DE 4 PASSOS</div>
                    </div>
                </div>

                <div class="row steps step-1 hide">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>
                                <span class='title-tag'>1</span><strong>A COMPRA </strong> SERÁ REALIZADA POR
                            </h2>
                        </div>
                        <div id="step-1">

                        </div>
                    </div>
                </div>

                <div class="row steps step-2 hide">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>
                                <span class='title-tag'>2</span><strong>MEUS </strong> ENDEREÇOS
                            </h2>
                        </div>
                        <div id="step-2">

                        </div>
                    </div>
                </div>  

                <div class="row steps step-3 hide">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>
                                <span class='title-tag'>3</span><strong>FORMA </strong> DE ENVIO
                            </h2>
                        </div>
                        <div id="step-3">

                        </div>
                    </div>
                </div>  

                <div class="row steps step-4 hide">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>
                                <span class='title-tag'>4</span><strong>FORMA </strong> DE PAGAMENTO
                            </h2>
                        </div>
                        <div id="step-4">

                        </div>
                    </div>
                </div>
            </div>
            {if $nenhum_produto == false}
                <div id="checkout-panel-2" class="checkout-panel-2 checkout-panel">
                    <div id="total-box-tabela">
                        {*                <img src="{$web_files}/img/checkout-head.png">*}
                        <table width="100%">
                            <tbody>
                                <tr class="cart_total_price_product" style="font-weight: normal; display: none">
                                    <td colspan="6" style="width: 105px;">Produtos sem impostos :</td>
                                    <td class="sta-right-text" id="total_parcial">
                                        {if $sem_impostos eq ""}
                                            0,00
                                        {else}
                                            {$sem_impostos}    
                                        {/if}                                
                                    </td>
                                </tr>
                                <tr class="cart_total_price_product" style="font-weight: normal; display: none">
                                    <td colspan="6" style="width: 105px;">Impostos :</td>
                                    <td class="sta-right-text" id="total_impostos">
                                        {if $sobre_valor eq ""}
                                            0,00
                                        {else}
                                            {$sobre_valor}    
                                        {/if}                                
                                    </td>
                                </tr>
                                <tr class="cart_total_voucher" style="display: none;">
                                    <td colspan="6">
                                        Desconto :
                                    </td>
                                    <td class="sta-right-text price-discount" id="total_discount">
                                        R$0,00
                                    </td>
                                </tr> 

                                <tr class="cart_total_voucher" style="display: none;">
                                    <td colspan="6">
                                        Total gift-wrapping :
                                    </td>
                                    <td class="sta-right-text price-discount" id="total_wrapping">
                                        R$0,00
                                    </td>
                                </tr>
                                
                                <tr class="cart_total_delivery" style="">
                                    <td colspan="6" id="total_product-txt">
                                        Total de Produtos:
                                    </td>
                                    <td class="sta-right-text" id="total_geral">
                                        {if $total_geral eq ""}
                                            0,00
                                        {else}
                                            {$total_geral}    
                                        {/if}                                
                                    </td>
                                </tr>
                                
                                <tr class="cart_total_delivery" style="">
                                    <td colspan="6" id="total_product-txt">
                                        Quantidade:
                                    </td>
                                    <td class="sta-right-text" id="total_geral">
                                        {if $total_produtos eq ""}
                                            0 Item
                                        {else}
                                            {if $total_produtos == 1 }{$total_produtos} Item{else}{$total_produtos} Itens {/if}
                                        {/if}                                
                                    </td>
                                </tr>

                                <tr class="cart_total_delivery">
                                    <td colspan="6">Frete:</td>

                                    <td id="taxa_entrega" class="sta-right-text">
                                        A escolher
                                    </td>
                                </tr>

                                <tr class="prazo_entrega_tr hide">
                                    <td colspan="6">Prazo de Entrega:</td>

                                    <td id="prazo_entrega" class="sta-right-text">
                                        0,00
                                    </td>
                                </tr>

                                {*<tr>
                                <td colspan="7" style="border-top: 1px solid #eee;"> </td>
                                </tr>
                                <tr class="cart_total_price_product" style="font-weight: normal;">
                                <td colspan="6" style="width: 105px;">Peso total :</td>
                                <td class="sta-right-text" id="peso_total">
                                {if $total_peso eq ""}
                                0.000 kg.
                                {else}
                                {$total_peso} kg.
                                {/if}                                
                                </td>
                                </tr>
                                <tr>
                                <td colspan="7"  style="border-bottom: 1px solid #eee;"> </td>
                                </tr>*}
                                
                                <tr class="cart_total_price" style="">
                                    <td colspan="6" id="total_product-txt">
                                        Total:
                                    </td>
                                    <td class="sta-right-text" id="total_geral">
                                        {if $total_geral eq ""}
                                            0,00
                                        {else}
                                            {$total_geral}    
                                        {/if}                                
                                    </td>
                                </tr>
                                <tr class="cart_total_tax" style="display:none">
                                    <td colspan="6">
                                        Total:
                                    </td>
                                    <td class="price sta-right-text" id="total_tax">R$0,00</td>
                                </tr>
                                <tr class="cart_total_price" style="display:none">
                                    <td colspan="6">
                                        Total:
                                    </td>
                                    <td class="sta-right-text"> R$380,00 </td>

                            </tbody>
                        </table>
                    </div>
                    <div id="cart_voucher">
                        <form action="#" method="post" id="voucher" onsubmit="return false">
                            <fieldset>
                                <label for="discount_name"><b>CUPOM DE DESCONTO</b> </label>
                                <input type="text" id="discount_name" name="discount_name" value="" style="text-align: center;" class="form-control" style="margin-bottom: 12px" maxlength="6">
                                <p class="submit">
                                    <input type="hidden" name="ticket_desconto" id="ticket_desconto"/>
                                    <button type="button" name="submitAddDiscount" id="submitAddDiscount" class="btn btn-default" onclick="javascript:checar_desconto();">ADICIONAR CUPOM</button>
                                    {*                                    <input type="submit" name="submitAddDiscount" value="ADICIONAR CUPOM" class="btn btn-default" id="submitAddDiscount" onclick="javascript:checar_desconto();"></p> *}
                                <div class="cart-voucher-txt-alert" style="color: #db4851;"></div>
                                <div class="cart-voucher-txt">Caso você possua um cupom de desconto ou presente, adicione acima</div>
                            </fieldset>
                        </form> 
                    </div>
                    <div id="eseguro"> 
                        <h6>É UM SITE SEGURO?</h6>
                        <p>Sim, a Maria de Barro utiliza criptografia (SSL) e tem auditoria diária da empresa Site Blindado.</p>
                        <div style=" margin-top: 12px; ">
                            <div class="selo-top-cart-cartao">
                                <div id="armored_website" style="display: inline-block;">
                                    <param id="aw_preload" value="true" />
                                </div>
                                {*                                <script type="text/javascript" src="//selo.siteblindado.com/aw.js"></script>*}
                            </div>
                        </div> 
                    </div>
                </div>
            {/if}
        </div>

    </div>
</section>

{include file="footer.tpl"}
<script>
    $(function() {
        $('.tab-credit-cards a').click(function() {

        });
    });
    
    $(document).ready(function(){
        finalizar_compra();    
    });

</script>