{include file="admin/header.tpl"}

<div class="sidebar">
    {include file="admin/navbar.tpl"}
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                {include file="admin/logo.tpl"}
            </div>
          {*  {include file="admin/search.tpl"}*}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6 text-left">
                    <h2><span class="label label-default">Visualizar Pedido</span></h2>
                </div>
                <br/>
                <div class="col-md-6 text-right">
                    <a href="/{$language}/pedidos/pedidos_lista" class="btn btn-default navbar-btn"><i class="fa fa-reply">&nbsp</i> Voltar</a>
                </div>
            </div>
                
        </div>
    </div>

    <h3>1. Dados do comprador</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 
                <table class="table" style="font-size: 14px">
                    {foreach item=pessoa from=$cadastro}  
                    <tr>
                        <td>Nome:</td>
                        <td>{$pessoa->NOME}</td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td>{$pessoa->EMAIL}</td>
                    </tr>
                    <tr>
                        <td>Data de nascimento:</td>
                        <td>{$pessoa->NASCIMENTO}</td>
                    </tr>
                    <tr>
                        <td>Sexo:</td>
                        <td>{$pessoa->SEXO}</td>
                    </tr>
                    <tr>
                        <td>Telefone:</td>
                        <td>({$pessoa->DDD}) {$pessoa->TELEFONE}{if $pessoa->RAMAL != ""}, Ramal: {$pessoa->RAMAL}{/if}</td>
                    </tr>
                    {/foreach}
                </table>
            </div>
        </div>
    </div>
    
     <h3>2. Endereço de Entrega</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 
                <table class="table" style="font-size: 14px">
                    {foreach item=endereco from=$endereco_entrega}  
                    <tr>
                        
                        <td>CEP:</td>
                        <td>{$endereco->CEP}</td> 
                        
                    </tr>    
                    <tr> <td>Endereço:</td><td>{$endereco->LOGRADOURO}, nº {$endereco->NUMERO} {if $endereco->COMPLEMENTO != ""}- {$endereco->COMPLEMENTO}{/if}</td> </tr>
                    <tr> <td>Bairro:</td><td>{$endereco->BAIRRO}</td> </tr>
                    <tr> <td>Cidade/UF:</td><td>{$endereco->CIDADE}/{$endereco->UF}</td> </tr>
                    {/foreach}
                </table>
            </div>
        </div>
    </div>            
    
    <h3>3. Produtos escolhidos</h3>
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
                            {foreach item=lista_desejo from=$compras}  

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

    <h3>4. Dados da Transação</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 

                
                    <table class="table">    
                        <tr>
                            <td>Código da transação:</td>
                            <td>{$pedido->CODPEDIDO}</td>
                        </tr>
                        <tr>
                            <td>Código do cliente:</td>
                            <td>{$pedido->CODCADASTRO}</td>
                        </tr>
                        <tr>
                            <td>Número do Pedido:</td>
                            <td>{$pedido->N_PEDIDO}</td>
                        </tr>
                        <tr>
                            <td>Data e hora da transação:</td>
                            <td>{$pedido->DTA}</td>
                        </tr>
                        <tr>
                            <td>Forma de envio:</td>
                            <td>{$pedido->FORMA_ENVIO}</td>
                        </tr>
                        <tr>
                            <td>Forma de pagamento:</td>
                            <td>{$pedido->FORMA_PGTO}</td>
                        </tr>
                        {if $pedido->FORMA_PGTO == "boleto"}
                        <tr>
                            <td>Nosso Número:</td>
                            <td>{$pedido->NOSSO_NUMERO}</td>
                        </tr>    
                        {/if}
                        
                        {if $pedido->TAXA_ENTREGA != "" || $pedido->FORMA_ENVIO != "Retirada na Loja"} 
                            <tr>
                                <td>Total da compra sem impostos:</td>
                                <td>{$pedido->TOTAL_PARCIAL}</td>
                            </tr>
                        {/if}
                        <tr>
                            <td>Imposto:</td>
                            <td>{$pedido->IMPOSTOS}</td>
                        </tr>
                        {if $pedido->DESCONTO != 0 }
                        <tr>
                            <td>Desconto:</td>
                            <td>-{$pedido->DESCONTO}</td>
                        </tr>    
                        {/if}
                        <tr>
                            <td>Taxa de entrega:</td>
                            <td>
                                {if $pedido->TAXA_ENTREGA == "" && $pedido->FORMA_ENVIO == "Retirada na Loja"} 
                                    -- 
                                {else} 
                                    {if $pedido->TAXA_ENTREGA == ""} 
                                        Grátis 
                                    {else} 
                                        {$pedido->TAXA_ENTREGA} 
                                    {/if} 
                                {/if}
                           </td>
                        </tr>
                        <tr>
                            <td>Total à pagar:</td>
                            <td>{$pedido->TOTAL_GERAL}</td>
                        </tr>
                    </table>   
                

            </div>
        </div>           
    </div>
                        
    <h3>5. Status do produto</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"> 
                <table class="table"> 
                    <thead>
                        <tr>
                            <th>Situação</th>
                            <th>Data</th>
                            <th>Anotações</th>
                        </tr>
                    </thead>

                    <tbody>
                        {foreach item=anotacao from=$anotacoes}  

                            <tr>
                                <td>{$anotacao->STATUS}</td>
                                <td>{$anotacao->DTA}</td>
                                <td>{$anotacao->APONTAMENTO}</td>

                            </tr>

                        {/foreach} 
                    </tbody>
                </table> 
            </div>           
        </div>           
    </div>
    {if $pedido->STATUS == "0"}
    <h3>6. Rastreamento</h3>
    
    <form method="post">
        <select name="situacao" class="form-control">
            <option value="Postado">Postado</option>
            <option value="Devolvido">Devolvido</option>
            <option value="Concluido">Concluído</option>
            <option value="Outros">Outros</option>
        </select>
        <br/>
        <textarea name="observacoes" rows="10" style="width: 100%" ></textarea>
        <br/>
        <div class="input-group input-group-lg">
            <button type="submit" class="btn btn-primary btn-lg btn-primary-maria" role="button">Enviar</button>
        </div>
    </form>
    
    {/if}
  
</div>                          
{include file="admin/tinymce_2.tpl"}
{include file="admin/footer.tpl"}