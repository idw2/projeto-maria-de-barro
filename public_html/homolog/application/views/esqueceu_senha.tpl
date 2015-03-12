{include file="header.tpl"}

<div class="container" style="padding-top: 50px">
    <div class="col-md-6">
    <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/conta/esqueceu-senha" method="post">

        {if $erro eq ""}

            <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

        {else}

            {if $sucesso eq "FALSE"}
                <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
            {else}
                <div class="alert alert-success" role="alert">{$erro}</div>	
            {/if}

        {/if}

        <h3 style="margin: 16px 0 12px">Recuperar senha</h3>
        <br/>

        <p><input type="text" class="form-control" style="min-width: 60%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail" /></p>
        <br/>

        <p>
            <button type="submit" class="btn btn-primary" name="enviar">ENVIAR</button>
            <span class="input-group"><a href="/{$language}/conta/login-cadastro/">» Acessar conta?</a></span>  
        </p>

    </form>
</div>
</div>


{include file="footer.tpl"}