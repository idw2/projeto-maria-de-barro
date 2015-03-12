{include file="header.tpl"}

<div class="container" style="padding-top: 50px">
    <div class="col-md-6">
    <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/conta/trocar-senha/codigo/{$codcadastro}" method="post">

        {if $erro eq ""}

            <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

        {else}

            {if $sucesso eq "FALSE"}
                <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
            {else}
                <div class="alert alert-success" role="alert">{$erro}</div>	
            {/if}

        {/if}

        <h3 style="margin: 16px 0 12px">Trocar senha</h3>
        <br/>				
        <p>
        <div class="input-group">
            <input type="password" class="form-control" id="senha" name="senha" value="{$senha}" autofocus="1" placeholder="Nova senha"/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></span>
        </div>		
        </p>
        <p>
        <div class="input-group">
            <input type="password" class="form-control" id="repetir_senha" name="repetir_senha" value="{$repetir_senha}" autofocus="1" placeholder="Repetir senha"/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></span>
        </div>		
        </p>
        <p>
        <div class="input-group">
            <input type="text" class="form-control" id="novo_lembrete" name="novo_lembrete" value="{$novo_lembrete}" autofocus="1" placeholder="Novo lembrete"/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
        </div>
        </p>
        <p>
            <button type="submit" class="btn btn-primary" name="enviar">ALTERAR</button>
            <span class="input-group"><a href="/{$language}/conta/login-cadastro/">» Acessar conta?</a></span>  
        </p>

    </form>
</div>            
<div class="col-md-6">

    <div class="jumbotron">
        <div class="container">

            <!-- h1 e p que já tínhamos -->
            <h2>Parabéns!</h2>
            <br/>
            <p>Você solicitou a alteração de sua senha.<br/>
            <p>É obrigatório informar uma dica como lembrete para o cadastro da nova senha.<br/>

        </div>
    </div>
</div> 
</div>


{include file="footer.tpl"}