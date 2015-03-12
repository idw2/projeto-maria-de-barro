{include file="admin/header.tpl"}

<div class="container">
    <div class="row box-login">

        <div class="col-sm-4"> </div>
        <div class="col-sm-4">

            {if $erro eq ""}

                <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

            {else}

                {if $sucesso eq "FALSE"}
                    <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                {else}
                    <div class="alert alert-success" role="alert">{$erro}</div>	
                {/if}

            {/if}

            <img class="area-restrita img-responsive center-block" src="{$web_files}/img/logo.png" alt="" border="0" title="" /><br/>
            <form class="form-horizontal" role="form" method="post" action="/{$language}/admin/login">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="{$email}"/>
                    <span class="input-group-addon"><i class="fa fa-reply-all">&nbsp</i></span>
                </div>
                <br/>
                <div class="input-group input-group-lg">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha"/>
                    <span class="input-group-addon"><i class="fa fa-pencil">&nbsp</i></span>
                </div>	
                <br/>
                <div class="input-group input-group-lg">
                    <button type="submit" class="btn btn-primary btn-lg btn-primary-maria" role="button">Entrar</button>
                </div>						
            </form>
        </div>
        <div class="col-sm-4">  </div>

    </div>
</div>

{include file="admin/footer.tpl"}