<div id="total-box-tabela">
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
            <tr class="cart_total_voucher hide">
                <td colspan="6">
                    Desconto :
                </td>
                <td class="sta-right-text price-discount" id="total_discount">
                    R$0,00
                </td>
            </tr> 

            <tr class="cart_total_voucher hide">
                <td colspan="6">
                    Total gift-wrapping :
                </td>
                <td class="sta-right-text price-discount" id="total_wrapping">
                    R$0,00
                </td>
            </tr>

            <tr class="cart_total_delivery_tp">
                <td colspan="6" id="total_product-txt">
                    Total de Produtos:
                </td>
                <td class="sta-right-text">
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
                <td class="sta-right-text">
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
            </p>   
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
        </div>
    </div> 
</div>