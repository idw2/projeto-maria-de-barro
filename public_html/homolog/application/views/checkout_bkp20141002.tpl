{include file="header.tpl"}

<div class="container">
    <br/>   
    <div class="row">

        {include file="navbar2.tpl"}

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 
                <table class="table" style="font-size: 14px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome do Produto</th>
                            <th>Categoria</th>
                            <th>Referência</th>
                            <th>Preço Unitário</th>
                            <th>Peso Unitário</th>
                            <th>Peso Total</th>
                            <th style="width: 11%;">Quantidade</th>
                            <th style="width: 8%;">Total</th>
                            <th>#</th>
                        </tr>
                    </thead>

                    <tbody>

                        {if $nenhum_produto == true}
                            <tr>
                                <th colspan="8">Nenhum produto na sua Lista de Desejos!</th>
                            </tr>
                        {else}    
                            {foreach item=lista_desejo from=$ld}  

                                <tr>
                                    <td><a href="/{$language}/descricao/categoria/{$lista_desejo->CATEG}/{$lista_desejo->URL_AMIGAVEL}"><img src="{$lista_desejo->FOTO}" alt="{$lista_desejo->NOME}" title="{$lista_desejo->NOME}" border="0"/></a><br/></td>
                                    <td style="text-transform: uppercase;">{$lista_desejo->NOME}</td>
                                    <td>{$lista_desejo->CATEGORIA}</td>
                                    <td>{$lista_desejo->REFERENCIA}</td>
                                    <td>{$lista_desejo->PRECO}</td>
                                    <td>{$lista_desejo->PESO}</td>
                                    <td id="peso_total_produto_{$lista_desejo->CODLISTADESEJOS}">{$lista_desejo->PESO_TOTAL}</td>
                                    <td id="n_input">
                                        <span class="minus" onclick="javascript:plus_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=menos&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}', '{$lista_desejo->CODLISTADESEJOS}');" title="Menos item"><i class="fa fa-minus-square"></i></span>
                                        <input type="text" name="quantidade" {*id="quantidade"*} id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/>
                                        <span class="plus" onclick="javascript:plus_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=mais&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}', '{$lista_desejo->CODLISTADESEJOS}');" title="Mais item"><i class="fa fa-plus-square"></i></span>
                                    </td>
                                    <td  id="preco_total_produto_{$lista_desejo->CODLISTADESEJOS}"> {if $lista_desejo->TOTAL eq ""}0,00{else}{$lista_desejo->TOTAL}{/if}</td>
                                    <td><span onclick="javascript:del_row_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}')"><i class="fa fa-times"></i></span></td>
                                </tr>

                            {/foreach} 
                        {/if}

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-8">    
            {if $nenhum_produto == false}   
                <div class="panel panel-default">    
                    <table class="table" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>Estimar custo de envio da encomenda.</th>
                            </tr>
                            <tr>
                                <th>Peso Total:&nbsp;<span id="peso_total">{$total_peso}</span>Kg. </th>  
                            </tr>
                        </thead>
                        </body>

                        <tr>
                            <td>
                                <input type="hidden" class="form-control" id="total_peso" name="total_peso" value="{$total_peso}"/>
                                <input type="hidden" class="form-control" id="cep_remetente" name="cep_remetente" value="{$cep_remetente}"/>
                                <input type="text" class="form-control" id="cep_destinatario" name="cep_destinatario" maxlength="8" value="" onkeypress="return formataCEP(event, this);" placeholder="Insira seu CEP" style="width: 50%"/>
                                <label>Tipo de encomenda</label>
                                <select id="forma_envio" class="form-control" style="width: 50%">
                                    <option value=""></option>
                                    <option value="41106">PAC</option>
                                    <option value="40010">SEDEX</option>
                                    <option value="40215">SEDEX 10</option>
                                    <option value="40290">SEDEX hoje</option>
                                    {*<option value="81019">e-SEDEX</option>*}
                                </select>
                                <br/>
                                <span id="msg_erro"></span><br/>
                                {*<button type="button" id="btn_cep" class="btn btn-primary btn-lg btn-primary-maria" role="button">Entrar</button>*}

                                <span class="Loader hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 7%;"/></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            {/if}
        </div>
        <div class="col-lg-4">        
            {if $nenhum_produto == false}            
                <div class="panel panel-default">    
                    <table class="table" style="font-size: 14px">
                        <tbody>
                            <tr>
                                <td>Total sem Impostos</td>
                                <td>R$&nbsp;                                 
                                    <span id="total_parcial">
                                    {if $sem_impostos eq ""}
                                        0,00
                                    {else}
                                        {$sem_impostos}    
                                    {/if}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Imposto</td>
                                <td>R$&nbsp;                                 
                                    <span id="total_impostos">
                                    {if $sobre_valor eq ""}
                                        0,00
                                    {else}
                                        {$sobre_valor}    
                                    {/if}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Taxa de Entrega</td>
                                <td>R$&nbsp;
                                    <span id="taxa_entrega">0,00</span></td>
                            </tr>
                            <tr>
                                <td style="width: 42%;"></td>
                                <td>
                                    <div class="panel panel-default">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th>TOTAL</th>
                                                </tr>    
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="auto-price text-left" style="padding: 11px 0 0 0;">R$&nbsp;
                                                            <span id="total_geral">
                                                                {if $total_geral eq ""}
                                                                    0,00
                                                                {else}
                                                                    {$total_geral}    
                                                                {/if}                                                            
                                                            </span>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>   
                    </table>   
                </div>

            {/if}                                     
        </div>

    </div>
    <div>
        <ul class="pager">
            <li class="previous"><a href="/{$language}/">&larr; Continuar comprando</a></li>
            <li class="next"><a href="/{$language}/produtos/pagamento">Finalizar compra &rarr;</a></li>
        </ul>
    </div> 
</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}