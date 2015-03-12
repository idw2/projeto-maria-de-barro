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

            <h2><span class="label label-default">Lista de Produtos em Estoque Baixo</span></h2>
            <br/>

            <div class="panel-default hide">
                <h3> <span class="Loader "><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span> &nbsp;Aguarde, verificando estoque... &nbsp;{*<span class="contador" style="color: #df5d65">0</span>*}</h3>
            </div>

            <div class="panel-default showEstoque">


                <div class="container" style="width: 100%;">        
                    {if $falta_produtos_estoque == TRUE }  
                        <div class="row">        
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
    </div>
</div>

{include file="admin/footer.tpl"}

{*<script>
$(document).ready(function(){
    
$(".table#table-1").find("input").each(function(i){
 
if($(this).hasClass("unitary")){
$(".contador").html(x);  
var valor = $(this).val();
var name = $(this).attr("name");
update_precounitario(name, valor);

}       
});

$(".showEstoque").remove("hide");
});
</script>*}