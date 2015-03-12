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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/admin/alterar_senha" method="post">
                <h2><span class="label label-default">Alterar senha</span></h2>
                <br/>
                {if $erro eq ""}

                    <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

                {else}

                    {if $sucesso eq "FALSE"}
                        <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                    {else}
                        <div class="alert alert-success" role="alert">{$erro}</div>	
                    {/if}

                {/if}

                <br/>
                <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                    <input type="password" class="form-control" id="senha_atual" name="senha_atual" placeholder="Senha atual"/>
                    <span class="input-group-addon"><i class="fa fa-pencil">&nbsp</i></span>
                </div>	
                <br/>
                <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                    <input type="password" class="form-control" id="senha_nova" name="senha_nova" placeholder="Nova senha"/>
                    <span class="input-group-addon"><i class="fa fa-pencil">&nbsp</i></span>
                </div>	
                <br/>
                <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                    <input type="password" class="form-control" id="senha_repetir" name="senha_repetir" placeholder="Repetir senha"/>
                    <span class="input-group-addon"><i class="fa fa-pencil">&nbsp</i></span>
                </div>	
                <br/>
                <div class="input-group input-group-lg">
                    <button type="submit" class="btn btn-primary btn-lg btn-primary-maria" role="button">Entrar</button>
                </div>

            </form>

        </div>
    </div>
</div>
{include file="admin/tinymce_1.tpl"}
{include file="admin/footer.tpl"}