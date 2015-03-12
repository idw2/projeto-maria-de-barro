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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <h2><span class="label label-default">Editar Clientes</span></h2>
            <br/>

            <form class="navbar-form navbar-left" method="post">

                {if $success == 1 }
                    <div class="alert alert-info" role="alert"><strong>Parabéns: </strong>Seus dados foram atualizados com sucesso!</div>
                {else}
                    {if $erro eq ""}
                        <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>
                    {else}
                        <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                    {/if}
                {/if}


                <br/>
                <h4>Dados pessoais</h4>
                <p><input type="text" class="form-control" style="min-width: 100%" id="nome" name="nome" maxlength="40" value="{$nome}" placeholder="Nome completo"/></p>
                <p>
                    <label>{$email}</label>
                    <input type="hidden" class="form-control" style="min-width: 47%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail" readonly/>
                </p>
                <h4>Data de nascimento</h4>
                <p>{$aniversario}</p>
                
                {if $sexo == "M"}
                    {assign var="checked1" value="selected"}
                {else}    
                    {assign var="checked2" value="selected"}
                {/if}    
                
                <h4>Sexo</h4>
                <p> 
                    <select name="sexo" class="form-control">
                        <option value="M" {$checked1}>Masculino</option>
                        <option value="F" {$checked2}>Feminino</option>
                    </select>
                </p>
                <p>
                <h4>Telefone ou celular</h4>
                <input type="text" class="form-control" style="max-width: 15%" id="ddd" name="ddd" maxlength="4" value="{$ddd}" placeholder="DDD" onkeypress="return formataNumDV(event, this, 2);"/>
                <input type="text" class="form-control" style="max-width: 30%" id="tel" name="tel" maxlength="10" value="{$tel}" placeholder="Telefone" onkeypress="return formataNumDV(event, this, 9);"/>
                <input type="text" class="form-control" style="max-width: 30%" id="ramal" name="ramal" maxlength="8" value="{$ramal}" placeholder="Ramal" onkeypress="return formataNumDV(event, this, 4);"/>
                </p>
                <h4 style="position: relative">CPF 
                    <span class="CPF-Ask hide">O cadastro do CPF é obrigatório para o envio da Nota Fiscal</span>
                    <i class="fa fa-question-circle" style="cursor: pointer" onmouseover="showAsk()" onmouseout="hideAsk()"></i>

                </h4>
                <style>
                    .CPF-Ask{
                        border: 1px solid #ccc;
                        display: inline-block;
                        padding: 20px;
                        border-radius: 34px;
                        color: #fff;
                        background: #df5d65;
                        position: absolute;
                        top: -21px;
                        left: 66px;
                        z-index: 10000;
                    }
                    .fa.fa-question-circle{
                        color: #df5d65;
                    }
                </style>
                <script>
                    function showAsk() {
                        $(".CPF-Ask").removeClass("hide");
                    }
                    function hideAsk() {
                        $(".CPF-Ask").addClass("hide");
                    }
                </script>
                <p> 
                    {*<label>{$cpf}</label>*}
                    <input type="text" class="form-control" style="min-width: 47%" id="cpf" name="cpf" maxlength="70" value="{if $cpf != '..-'}{$cpf}{/if}" placeholder="CPF"/>
                </p>
                
                <h4><input type="checkbox" name="updatePassword" id="updatePassword" {if $updatePassword eq "on" } checked="true" {/if} /> Desejo atualizar a minha senha.</h4>
                <div class="updatePassword {if $updatePassword != "on" } hide {/if}">
                    <h4>Sua senha</h4>
                    <p><input type="password" class="form-control" style="max-width: 47%" id="passwd" name="passwd" maxlength="50" value="" placeholder="Senha"/></p>
                    <p><input type="password" class="form-control" style="max-width: 47%" id="passwd2" name="passwd2" maxlength="50" value=""  placeholder="Repetir senha"/></p>
                    <h4>Lembrete de segurança</h4>
                    <p><input type="text" class="form-control" style="min-width: 100%" id="lembrete" name="lembrete" maxlength="30" value="{$lembrete}" placeholder="Lembrete de senha"/></p>
                </div>
                <p><button type="submit" class="btn btn-primary" name="enviar">ENVIAR</button></p>
            </form>

        </div>
    </div>
</div>
<script>

window.onload = teste;
function teste(){
$(document).ready(function(){
$("#updatePassword").click(function(){
if( $("#updatePassword").is(':checked') ){
    $(".updatePassword").removeClass("hide");
} else {
    $(".updatePassword").addClass("hide");
} 
});
});
}

    
</script>

{include file="admin/footer.tpl"}