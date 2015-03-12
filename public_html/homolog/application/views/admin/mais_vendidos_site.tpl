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
            {include file="admin/search.tpl"}
        </div>
    </div>

        
    <div class="row">
        <div class="col-md-12">

            <h2><span class="label label-default">Lista de Produtos mais Vendidos Site</span></h2>
            <br/>

            <br/>
            <a href="/{$language}/produtos/mais-vendidos-site-xls" class="btn btn-default navbar-btn" target="_blank"><i class="fa fa-exchange"></i> Exportar</a>    
    
            <div class="panel-default showEstoque">

                <table class='table'>
                    <thead>
                    <th>#</th>
                    <th style="width: 10%;">Quantidade Vendida</th>
                    <th>Referência</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th style="width: 10%;">Peso/Kg.</th>
                    <th style="width: 10%;">Preço<br/>Final do Produto<br/>por Unidade</th>
                    <th style="width: 10%;">Preço<br/>Unitário de Compra<br/>do Produto</th>
                    <th style="width: 10%;">Total da Compra</th>
                        {*                    <th style="width: 10%;">De</th>*}
                        {*                    <th style="width: 10%;">Para</th>*}
                        {*                    <th>Ações</th>*}
                    </thead>

                    {if $ERRO_NAO_EXISTE_PRODUTOS == "ERRO_NAO_EXISTE_PRODUTOS"}
                        <tr>
                            <td colspan="7">Não existem produtos desta categoria cadastrados!</td>
                        </tr>
                    {/if}

                    {counter assign=i start=0 print=false} 
                    {foreach item=produto from=$meus_produtos}  
                        {if $produto->DESTAQUE == "0"}
                            {$star = "desative"}
                            {$dtq = "1"}
                        {else}
                            {$star = ""}
                            {$dtq = "0"}
                        {/if}    
                        {if $produto->STATUS == "0"}
                            {$eye = "desative"}
                            {$stt = "1"}
                        {else}
                            {$eye = ""}
                            {$stt = "0"}
                        {/if}      
                        {if $produto->IS_NOVO == "0"}
                            {$heart = "desative"}
                            {$nv = "1"}
                        {else}
                            {$heart = ""}
                            {$nv = "0"}
                        {/if} 
                        {if $produto->IS_PROMOCAO == "0"}
                            {$dolar = "desative"}
                            {$pmc = "1"}
                        {else}
                            {$dolar = ""}
                            {$pmc = "0"}
                        {/if}
                        {if $produto->MAIS_VENDIDO == "0"}
                            {$trophy = "desative"}
                            {$tph = "1"}
                        {else}
                            {$trophy = ""}
                            {$tph = "0"}
                        {/if}
                        {if $produto->CODPRODUTO != "" && $teste != $produto->REFERENCIA}   
                            {assign var="teste" value=$produto->REFERENCIA}
                            <tr class="delete-return-{$produto->CODPRODUTO} no">
                                <td>
                                    <span style="cursor: pointer; position: relative; display: block; width: 80px;" onclick="javascript:pGetImagesShow('{$produto->CODPRODUTO}', '{$produto->REFERENCIA}')">
                                        {if $produto->CROP80 != ""}
                                            <img src="{$produto->CROP80}" border="0" alt="{$produto->NOME}" title="{$produto->NOME}">
                                        {else}
                                            <img src="/web-files/img/no-image.png" style="width: 80px;" border="0" alt="{$produto->NOME}" title="{$produto->NOME}">
                                        {/if}
                                        <span style="display: none;min-width: 80px;position: absolute;left: 100%;bottom: 0px;cursor: default;width: 300px;zoom: 115%;background: rgb(255, 255, 255);border: 1px solid #ccc;border-radius: 20px; padding: 10px 0px 0px 15px; z-index: 1000;">teste</span>
                                    </span>
                                </td>
                                <td>{$produto->MAIS_VENDIDOS}</td>
                                <td>{$produto->REFERENCIA}</td>
                                <td>{$produto->NOME}</td>
                                <td>{$produto->CATEGORIA}</td>
                                <td>{$produto->PESO}</td>
                                <td>{$produto->PRECO}</td>
                                <td>{$produto->PRECO_UNITARIO}</td>
                                <td>{$produto->PRECO_COMPRA}</td>
                            </tr>
                         {else}    

                            {assign var="teste" value=$produto->REFERENCIA}
                            <tr class="delete-return-{$produto->CODPRODUTO} yes hide">
                                <td colspan="8">{if $produto->CROP80 != ""}<img src="{$produto->CROP80}" border="0" alt="{$produto->NOME}" title="{$produto->NOME}">{else}<img src="/web-files/img/no-image.png" style="width: 80px;" border="0" alt="{$produto->NOME}" title="{$produto->NOME}">{/if}</td>
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
