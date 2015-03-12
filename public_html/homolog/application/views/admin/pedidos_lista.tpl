{include file="admin/header.tpl"}

{*
 {foreach item=compras from=$compras_all}  
     
     update compras set nome=(select p.nome from produtos as p where p.codproduto='{$compras->CODPRODUTO}') where codcompra='{$compras->CODCOMPRA}';<br/>
     
 {/foreach}  
 *}

<div class="sidebar">
    {include file="admin/navbar.tpl"}
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                {include file="admin/logo.tpl"}
            </div>
            {include file="admin/search.tpl"}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <h2><span class="label label-default">Lista de Produtos</span></h2>
            <br/>
            {*<a href="/{$language}/produtos/cadastrar" class="btn btn-default navbar-btn"><i class="fa fa-plus-square"></i> Cadastro de Produtos</a>*}
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>

            <div class="panel-default">
       
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Data</th>
                        <th>Nº do Pedido</th>
                        <th>Nome</th>
                        <th>Forma de Pagamento</th>
                        <th>Forma de Envio</th>
                        <th>Total Parcial</th>
                        <th>Imposto</th>
                        <th>Taxa de Entrega</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </thead>
                    
                    {counter assign=i start=1 print=false} 
                    {foreach item=pedido from=$pedidos}  
                        {if $pedido->CODPEDIDO != ""}
                            <tr {if $i % 2 == 0 }class="myDragClass"{/if}>
                                <td>{$pedido->DTA}</td>
                                <td>{$pedido->N_PEDIDO}</td>
                                <td>{$pedido->NOME}</td>
                                <td>{$pedido->FORMA_PGTO}</td>
                                <td>{$pedido->FORMA_ENVIO}</td>
                                <td>R$ {$pedido->TOTAL_PARCIAL}</td>
                                <td>R$ {$pedido->IMPOSTOS}</td>
                                <td>{if $pedido->TAXA_ENTREGA != ""}R$ {$pedido->TAXA_ENTREGA}{/if}</td>
                                <td>R$ {$pedido->TOTAL_GERAL}</td>
                                {if $pedido->STATUS == "0"}
                                     {$star = "desative"}
                                    {$dtq = "1"}
                                {else}
                                    {$star = ""}
                                    {$dtq = "0"}
                                {/if}   
                                <td>
                                    <a href="/{$language}/pedidos/status/{$pedido->STATUS}/{$pedido->CODPEDIDO}"><span class="ico-default-star {$star}" data-toggle="tooltip" title="Pago?"><i class="fa fa-thumbs-o-up"></i></span></a>
                                    <a href="/{$language}/pedidos/view/codpedido/{$pedido->CODPEDIDO}"><span class="ico-default-photo" data-toggle="tooltip" title="Visualizar Pedido"><i class="fa fa-th-list"></i></span></a>
                                    {if $pedido->STATUS == "0"}
                                        <a onclick="delete_produto('{$language}/pedidos/delete/codpedido/{$pedido->CODPEDIDO}')"><span class="ico-default-trash" data-toggle="tooltip" title="Excluir"><i class="fa fa-trash-o"></i></span></a>
                                    {/if}
                                </td>
                            </tr>     
                        {/if}                         
                        {counter}
                    {/foreach}  

                    
                </table>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}