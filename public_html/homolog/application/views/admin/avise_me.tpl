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
{*            {include file="admin/search.tpl"}*}
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

            <h2><span class="label label-default">Avise-me quando chegar</span></h2>
            <br/>
            {*
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
            </div>
            *}
            {* <br/>
            <a href="/{$language}/produtos/cadastrar" class="btn btn-default navbar-btn"><i class="fa fa-plus-square"></i> Cadastro de Produtos</a>
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>
            *}
            <div class="panel-default hide">
                <h3> <span class="Loader "><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span> &nbsp;Aguarde, verificando estoque... &nbsp;{*<span class="contador" style="color: #df5d65">0</span>*}</h3>
            </div>

            <div class="panel-default showEstoque">

                <table class="table">
                    <thead>                
                    <th>Nome/E-mail</th>
                    <th></th>
                    </thead>

                    {if $ERRO_NAO_EXISTE_SOLICITACAO == "ERRO_NAO_EXISTE_SOLICITACAO"}
                        <tr>
                            <td colspan="3">Não existem solicitações!</td>
                        </tr>
                    {/if}

                    {counter assign=i start=0 print=false} 
                    {foreach item=ame from=$avise_me}  

                        <tr {if i % 2 == 1} class="{$myDragClass}"{/if}>
                            <td>{if $ame->NOME eq "" } {$ame->EMAIL} {else}{$ame->NOME}<br/>{$ame->EMAIL}{/if}</td>
                            <td>
                                <div class="row">        
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Tabela de Solicitações </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome</th>
                                                    <th>Referência</th>
                                                    <th>Preço</th>
                                                    <th>Categoria</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
{*                                            {$ame->ITENS|@var_dump}*}
                                            {foreach item=it from=$ame->ITENS}
                                                <tbody>
                                                    <tr>
                                                        <td><a href="/pt/produtos/editar/{$it->URL_AMIGAVEL}" target="_blank"><img src="{$it->CROP80}" border="0" title="{$it->NOME}" alt="{$it->NOME}"></a></td>
                                                        <td style="width: 50%">{$it->NOME}</td>
                                                        <td style="width: 10%">{$it->REFERENCIA}</td>
                                                        <td style="width: 10%">{$it->PRECO}</td>
                                                        <td style="width: 10%">{$it->CATEGORIA}</td>
                                                        <td style="width: 5%"><a title="Enviar aviso para o cliente?" href="/pt/produtos/enviar-aviso/{$it->CODAVISEME}/{$ame->EMAIL_B64}"><i class="glyphicon glyphicon-upload"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            {/foreach}

                                        </table>
                                    </div>        
                                </div> 
                            </td>
                        </tr>

                        {counter}    
                    {/foreach}

                </table>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}
