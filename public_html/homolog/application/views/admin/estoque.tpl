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

    {if $falta_produtos_estoque == TRUE }    
        {*
        <table>
        {foreach item=referencia_nome_produto from=$referencia_nome_produtos}   
        <tr>
        <td>{$referencia_nome_produto->REFERENCIA}</td>
        <td>{$referencia_nome_produto->NOME}</td>
        </tr>
        {/foreach}
        </table>*}    

        {*<script>
        jQuery(document).ready(function() {
        $.fancybox(
        "<h2><span>ATENÇÃO:</span> Existem {$num_produtos_que_faltam} produto(s) com estoque baixo!</h2>" +
        "<div class='panel panel-default'>" +
        "<div class='panel-heading'>Os seguintes produtos relacionados abaixo estão com 1 ou nenhuma unidade!</div>"+
        "<table class='table'>" +
        "<thead>" +
        "<tr>" +
        "<th>Referência</th>" +
        "<th>Produto</th>" +
        "<th>Quantidade</th>" +
        "</tr>" +
        "</thead>" +
        "<tbody>" +
        {foreach item=referencia_nome_produto from=$referencia_nome_produtos}   
        "<tr>" +
        "<td>{$referencia_nome_produto->REFERENCIA}</td>" +
        "<td>{$referencia_nome_produto->NOME}</td>" +
        "<td>{$referencia_nome_produto->QUANTIDADE}</td>" +
        "</tr>" +
        {/foreach}
        "</body>" +
        "</table>" +
        "</div>",
        {
        'autoDimensions': false,
        'width': 350,
        'height': 'auto',
        'transitionIn': 'none',
        'transitionOut': 'none'
        }
        );
        });
        </script>*}

    {/if} 

    <div class="row">
        <div class="col-md-12">

            <h2><span class="label label-default">Lista de Produtos em Estoque</span></h2>
            <br/>

            <div class="row">
                <div class="col-md-6">

                    <div class="container" style="width: 100%;"> 
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">Busca por Categorias</div>
                                <form method="post" id="formCategoria" style="margin: 3%;">
                                    <input type="radio" name="categoria" value="todos" {if $categoria == "todos"} checked="true" {/if} onclick="javascript:start_form_categoria();"/> Todos<br/>
                                    <input type="radio" name="categoria" value="aneis" {if $categoria == "aneis"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Anéis<br/>
                                    <input type="radio" name="categoria" value="brincos" {if $categoria == "brincos"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Brinco<br/>
                                    <input type="radio" name="categoria" value="colares" {if $categoria == "colares"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Colares<br/>
                                    <input type="radio" name="categoria" value="pulseiras" {if $categoria == "pulseiras"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Pulseiras<br/>
                                    <input type="radio" name="categoria" value="conjuntos" {if $categoria == "conjuntos"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Conjuntos<br/>
                                    <input type="hidden" name="actionType" value="pesquisa_categoria">
                                </form>
                            </div> 
                        </div> 
                    </div> 

                    {*<div class="container" style="width: 100%;"> 
                    <div class="row">
                    <div class='panel panel-default'>
                    <div class="panel-heading">Total de Produtos</div>
                    <table class='table'>
                    <thead>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    </thead>
                    <tr>
                    <td>Anéis</td><td>{$qtdd_aneis}</td>
                    </tr>
                    <tr>
                    <td>Brincos</td><td>{$qtdd_brincos}</td>
                    </tr>
                    <tr>
                    <td>Colares</td><td>{$qtdd_colares}</td>
                    </tr>
                    <tr>
                    <td>Pulseiras</td><td>{$qtdd_pulseiras}</td>
                    </tr>
                    <tr>
                    <td>Conjuntos</td><td>{$qtdd_conjuntos}</td>
                    </tr>
                    <tr>
                    <td><strong>Total geral</strong></td><td>{$total_produtos}</td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    </div>  *}              

                </div>
                <div class="col-md-6">

                    <div class="container" style="width: 100%;"> 
                        <div class="row">
                            <div class='panel panel-default'>
                                <div class="panel-heading">Total de Produtos</div>
                                <table class='table'>
                                    <thead>
                                    <th>Categoria</th>
                                    <th>Quantidade</th>
                                    </thead>
                                    <tr>
                                        <td>Anéis</td><td>{$qtdd_aneis}</td>
                                    </tr>
                                    <tr>
                                        <td>Brincos</td><td>{$qtdd_brincos}</td>
                                    </tr>
                                    <tr>
                                        <td>Colares</td><td>{$qtdd_colares}</td>
                                    </tr>
                                    <tr>
                                        <td>Pulseiras</td><td>{$qtdd_pulseiras}</td>
                                    </tr>
                                    <tr>
                                        <td>Conjuntos</td><td>{$qtdd_conjuntos}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total geral</strong></td><td>{$total_produtos}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {*<div class="container" style="width: 100%;">        
                    {if $falta_produtos_estoque == TRUE }  
                    <div class="row" style="overflow-x:auto; height: 570px;">        
                    <div class="panel panel-default">
                    <div class="panel-heading"><span>ATENÇÃO:</span> Existem {$num_produtos_que_faltam} produto(s) com estoque baixo!</div>
                    <table class="table">
                    <thead>
                    <tr>
                    <th>Referência</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach item=referencia_nome_produto from=$referencia_nome_produtos}   
                    <tr>
                    <td>{$referencia_nome_produto->REFERENCIA}</td>
                    <td>{$referencia_nome_produto->NOME}</td>
                    <td>{$referencia_nome_produto->QUANTIDADE}</td>
                    </tr>
                    {/foreach}
                    </tbody>
                    </table>
                    </div>        
                    </div> 
                    {/if}
                    </div>*}
                </div>
            </div>

            {*<div class="row">
            <div class="col-md-6">

            <div class="container" style="width: 100%;"> 
            <div class="row">
            <div class="panel panel-default">
            <div class="panel-heading">Busca por Categorias</div>
            <form method="post" id="formCategoria" style="margin: 3%;">
            <input type="radio" name="categoria" value="todos" {if $categoria == "todos"} checked="true" {/if} onclick="javascript:start_form_categoria();"/> Todos<br/>
            <input type="radio" name="categoria" value="aneis" {if $categoria == "aneis"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Anéis<br/>
            <input type="radio" name="categoria" value="brincos" {if $categoria == "brincos"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Brinco<br/>
            <input type="radio" name="categoria" value="colares" {if $categoria == "colares"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Colares<br/>
            <input type="radio" name="categoria" value="pulseiras" {if $categoria == "pulseiras"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Pulseiras<br/>
            <input type="radio" name="categoria" value="conjuntos" {if $categoria == "conjuntos"} checked="true" {/if}  onclick="javascript:start_form_categoria();"/> Conjuntos<br/>
            <input type="hidden" name="actionType" value="pesquisa_categoria">
            </form>
            </div> 
            </div> 
            </div> 

            <div class="container" style="width: 100%;"> 
            <div class="row">
            <div class='panel panel-default'>
            <div class="panel-heading">Total de Produtos</div>
            <table class='table'>
            <thead>
            <th>Categoria</th>
            <th>Quantidade</th>
            </thead>
            <tr>
            <td>Anéis</td><td>{$qtdd_aneis}</td>
            </tr>
            <tr>
            <td>Brincos</td><td>{$qtdd_brincos}</td>
            </tr>
            <tr>
            <td>Colares</td><td>{$qtdd_colares}</td>
            </tr>
            <tr>
            <td>Pulseiras</td><td>{$qtdd_pulseiras}</td>
            </tr>
            <tr>
            <td>Conjuntos</td><td>{$qtdd_conjuntos}</td>
            </tr>
            <tr>
            <td><strong>Total geral</strong></td><td>{$total_produtos}</td>
            </tr>
            </table>
            </div>
            </div>
            </div>                

            </div>
            <div class="col-md-6">
            <div class="container" style="width: 100%;">        
            {if $falta_produtos_estoque == TRUE }  
            <div class="row" style="overflow-x:auto; height: 570px;">        
            <div class="panel panel-default">
            <div class="panel-heading"><span>ATENÇÃO:</span> Existem {$num_produtos_que_faltam} produto(s) com estoque baixo!</div>
            <table class="table">
            <thead>
            <tr>
            <th>Referência</th>
            <th>Produto</th>
            <th>Quantidade</th>
            </tr>
            </thead>
            <tbody>
            {foreach item=referencia_nome_produto from=$referencia_nome_produtos}   
            <tr>
            <td>{$referencia_nome_produto->REFERENCIA}</td>
            <td>{$referencia_nome_produto->NOME}</td>
            <td>{$referencia_nome_produto->QUANTIDADE}</td>
            </tr>
            {/foreach}
            </tbody>
            </table>
            </div>        
            </div> 
            {/if}
            </div>
            </div>
            </div>*}

            <br/>
            <a href="/{$language}/produtos/exportar-estoque-xls" class="btn btn-default navbar-btn" target="_blank"><i class="fa fa-exchange"></i> Exportar estoque</a>
            
            {* <br/>
            <a href="/{$language}/produtos/cadastrar" class="btn btn-default navbar-btn"><i class="fa fa-plus-square"></i> Cadastro de Produtos</a>
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>
            *}
            
            <div class="panel-default hide">
                <h3> <span class="Loader "><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span> &nbsp;Aguarde, verificando estoque... &nbsp;{*<span class="contador" style="color: #df5d65">0</span>*}</h3>
            </div>

            <div class="panel-default showEstoque">

                <style>
                    .pNameImput{
                        width: 400px;
                        padding-right: 6px;
                        padding-left: 6px;
                    }

                    .pNameImput.Loader{
                        background: url(/web-files/img/Loader_small.gif) no-repeat;
                        background-position: center right 6px;
                    }
                </style> 

                <style>
                    .pNameImput{
                        width: 400px;
                        padding-right: 6px;
                        padding-left: 6px;
                    }

                    .pNameImput.Loader{
                        background: url(/web-files/img/Loader_small.gif) no-repeat;
                        background-position: center right 6px;
                    }
                </style> 
                
                {*                <table class='table' id="table-1" cellspacing="0" cellpadding="2">*}
                <table class='table'>
                    <thead>
                    <th>#</th>
                    <th>Referência</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th style="width: 10%;">Peso/Kg.</th>
                    <th style="width: 10%;">Quantidade</th>
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
                                <td>{$produto->REFERENCIA}</td>
                                <td>{$produto->NOME}</td>
                                <td>{$produto->CATEGORIA}</td>
                                <td>
{*                                    <input type="text" class="form-control" name="PESO_{$produto->CODPRODUTO}" value="{$produto->PESO}" placeholder="Peso/Kg"  onkeypress="update_peso(this.name, this.value);" onkeydown="javascript: return mascaraPeso(this, event, 5, 3);"/>*}
                                    <div class="input-group">
                                        <input type="text" class="form-control pNameImput" id="psName_{$produto->CODPRODUTO}" value="{$produto->PESO}" onkeydown="javascript: return mascaraPeso(this, event, 5, 3);" style="width: 120px;"/>
                                        <span class="input-group-btn">
                                            <span class="btn btn-default" type="button" onclick="javascript:ePesoUpdate('psName_{$produto->CODPRODUTO}', '{$produto->CODPRODUTO}')"><i class="glyphicon glyphicon-refresh"></i></span>
                                        </span>
                                    </div>
                                </td>
                                <td>
{*                                    <input type="text" class="form-control" name="{$produto->CODPRODUTO}" id="quantidade_{$produto->CODPRODUTO}" onkeyup="javascript:update_qntdd_estoque(this.name, this.value)" onkeypress="return formataNumDV(event, this, 6);" value="{$produto->QUANTIDADE}"/>*}
                                    <div class="input-group">
                                        <input type="text" class="form-control pNameImput" id="qName_{$produto->CODPRODUTO}" value="{$produto->QUANTIDADE}" onkeyup="javascript:update_qntdd_estoque(this.name, this.value)" onkeypress="return formataNumDV(event, this, 6);" style="width: 120px;"/>
                                        <span class="input-group-btn">
                                            <span class="btn btn-default" type="button" onclick="javascript:eQuantidadeEstoqueUpdate('qName_{$produto->CODPRODUTO}', '{$produto->CODPRODUTO}')"><i class="glyphicon glyphicon-refresh"></i></span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{$produto->PRECO}" readonly="readonly"/>
                                </td>
                                <td>
{*                                  <input type="text" class="form-control unitary" name="PRECOUNITARIO_{$produto->CODPRODUTO}" id="PRECOUNITARIO_{$produto->CODPRODUTO}" onkeyup="javascript:update_precounitario(this.name, this.value)"  onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)" value="{$produto->PRECO_UNITARIO}" {if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}readonly="readonly"{/if}/>*}
                                    <div class="input-group">
                                        <input type="text" class="form-control pNameImput" id="pName_{$produto->CODPRODUTO}" value="{$produto->PRECO_UNITARIO}" onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)" style="width: 120px;"/>
                                        <span class="input-group-btn">
                                            <span class="btn btn-default" type="button" onclick="javascript:ePrecoUnitarioEstoqueUpdate('pName_{$produto->CODPRODUTO}', '{$produto->CODPRODUTO}')"><i class="glyphicon glyphicon-refresh"></i></span>
                                        </span>
                                    </div>
                                
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="PRECOCOMPRA_{$produto->CODPRODUTO}" id="PRECOCOMPRA_{$produto->CODPRODUTO}" {*onkeyup="javascript:update_precocompra(this.name, this.value)"*}  onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)" value="{$produto->PRECO_COMPRA}" readonly="readonly"/>
                                </td>
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
