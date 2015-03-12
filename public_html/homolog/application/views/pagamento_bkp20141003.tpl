{include file="header.tpl"}

<div class="container">
    <br/>   
    <div class="row">

        {include file="navbar2.tpl"}

    </div>
    {*<div class="row" id="accordion">*}

    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>
                    <strong>1.</strong> Confira a sua lista de compras
                </h2>
            </div>
        </div>
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
                                {*<th>#</th>*}
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
                                    <td id="n_input" align="center">{$lista_desejo->QUANTIDADE}</td>
                                    <td  id="preco_total_produto_{$lista_desejo->CODLISTADESEJOS}"> {if $lista_desejo->TOTAL eq ""}0,00{else}{$lista_desejo->TOTAL}{/if}</td>
                                    {*                                    <td><span class="plus" onclick="javascript:del_row_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}')"><i class="glyphicon glyphicon-trash">&nbsp;</i></span></td>*}
                                </tr>

                            {/foreach} 
                        {/if}

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>
                    <strong>2.</strong> Confira o seu endereço de entrega
                </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 

                {counter assign=i start=1 print=false} 
                {foreach item=endereco from=$endereco_list}  
                    {if $endereco->CODENDERECO != "" && $endereco->STATUS == "1"}

                        <table class="table" style="font-size: 14px">
                            {assign var="CEP" value="{$endereco->CEP}"}
                            {assign var="CODENDERECO" value="{$endereco->CODENDERECO}"}
                            <tr> <td>CEP:</td><td>{$endereco->CEP}</td></tr>    
                            <tr> <td>Endereço:</td><td>{$endereco->LOGRADOURO}, nº {$endereco->NUMERO} {if $endereco->COMPLEMENTO != ""}- {$endereco->COMPLEMENTO}{/if}</td> </tr>
                            <tr> <td>Bairro:</td><td>{$endereco->BAIRRO}</td> </tr>
                            <tr> <td>Cidade/UF:</td><td>{$endereco->CIDADE}/{$endereco->UF}</td> </tr>
                        </table>
                    {/if}    
                    {counter}    
                {/foreach}

            </div>
        </div>
        <div>
            <ul class="pager">
                <li class="previous"><a href="/{$language}/produtos/endereco">&larr; Alterar endereço de entrega</a></li>
            </ul>
        </div>            
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>
                    <strong>3.</strong> Confira a forma de envio de sua encomenda
                </h2>
            </div>
        </div>
    </div>
    <p>(*) Atenção: Alguns serviços de entrega de encomenda poderão não estar disponíveis em algumas localidades </p>
    <div class="row">
        <div class="col-lg-8">    
            {if $nenhum_produto == false}   
                <div class="panel panel-default">    
                    <table class="table" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>Estimar custo de envio da encomenda.</th>
                            </tr>
                            <tr>
                                <th>Peso Total: <span id="peso_total">{$total_peso}</span>Kg. </th>  
                            </tr>
                        </thead>
                        </body>

                        <tr>
                            <td>
                                <input type="hidden" class="form-control" id="total_peso" name="total_peso" value="{$total_peso}"/>
                                <input type="hidden" class="form-control" id="cep_remetente" name="cep_remetente" value="{$cep_remetente}"/>
                                <input type="text" class="form-control" id="cep_destinatario" name="cep_destinatario" maxlength="8" value="{$CEP}" onkeypress="return formataCEP(event, this);" placeholder="Insira seu CEP" style="width: 50%" readonly="readonly"/>
                                <br>
                                <label>Tipo de encomenda</label>
                                <select id="forma_envio" class="form-control myFormaEnvio" style="width: 50%">
                                    <option value="">---</option>
                                    <option value="41106">PAC</option>
                                    <option value="40010">SEDEX</option>
                                    <option value="40215">SEDEX 10</option>
                                    <option value="40290">SEDEX hoje</option>
                                    {*<option value="81019">e-SEDEX</option>*}
                                </select>
                                <span class="Loader hide" style="float: left;"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/></span>
                                <br/>
                                <span id="msg_erro"></span>
                                <br/>
                                {*<button type="button" id="btn_cep" class="btn btn-primary btn-lg btn-primary-maria" role="button">Entrar</button>*}


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
                                <td>Total de Produtos</td>
                                <td>R$&nbsp;                                 
                                    <span id="total_parcial">
                                        {if $total_geral eq ""}
                                            0,00
                                        {else}
                                            {$total_geral}    
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
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>
                    <strong>4.</strong> Forma de pagamento
                </h2>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12">
            <form class="" name="formListenderecos" id="formListenderecos">
                <div class="radio-block">
                    <input type="radio" name='pgto' value='moip' class="radio-switch">
                    <img src="/web-files/img/assets/pagamento-moip.png" alt="Moip">
                </div>
                <div class="radio-block active">
                    <input type="radio" name='pgto' value='paypal' checked='true' class="radio-switch">
                    <img src="/web-files/img/assets/pagamento-paypal.png" alt="Paypal">
                </div>
            </form>
        </div>

    </div>

    {*</div>*}
    <div>
        <div style="text-align: center;"> 
            <span id="msg_erro_Finale"></span>
            <span class="LoaderFinale hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/></span></div>
        <ul class="pager">
            <li class="previous"><a href="/{$language}/">&larr; Continuar comprando</a></li>
            <li class="next"><a style="cursor: pointer;" onclick="javascript:finalizar_pedido('{$CLIENT_HIDDEN}', '{$CODCADASTRO}', '{$CODENDERECO}', '{$language}');">Finalizar compra &rarr;</a></li>
        </ul>
    </div> 
</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}