{include file="header.tpl"}

<div class="container">
    {include file="navbar2.tpl"}
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">  
       
                <table class='table table-pedidos' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Nº do Pedido</th>
                        <th>Data</th>
                        <th>Pagamento</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </thead>
                    
                    {counter assign=i start=1 print=false} 
                    {foreach item=pedido from=$pedidos}  
                        {if $pedido->CODPEDIDO != ""}
                            <tr {if $i % 2 == 0 }class="myDragClass"{/if}>
                                <td><a href="/{$language}/conta/view/codpedido/{$pedido->CODPEDIDO}">{$pedido->N_PEDIDO}</a></td>
                                <td>{$pedido->DTA}</td>
                                <td>
                                {if $pedido->STATUS == "0"}
                                        
                                        {if $pedido->FORMA_PGTO == "paypal"}
                                            <a href="/{$language}/produtos/pgto-paypal/pedido/{$pedido->CODPEDIDO}">PayPal</a>
                                        {else if $pedido->FORMA_PGTO == "cielo"}
                                            <a href="#">Cielo</a>                                            
                                        {else} 
                                            <a href="{$web_files}/produtos/boleto/pedido/{$pedido->CODPEDIDO}" target="_blank">Boleto</a>
                                        {/if} 
                                        
                                {else}
                                     Pagamento efetuado
                                {/if}
                                </td>
                                <td>R$ {$pedido->TOTAL_GERAL}</td>
                                <td>
                                    
                                    <a href="/{$language}/conta/view/codpedido/{$pedido->CODPEDIDO}">Ver detalhes</a>
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

{include file="footer.tpl"}