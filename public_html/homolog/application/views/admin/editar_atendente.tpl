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
            <!-- {include file="admin/search.tpl"} -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/admin/editar/{$email}" method="post">


                <div class="row">
                    <div class="col-md-6 text-left">
                        <h2><span class="label label-default">Editar Atendente</span></h2>
                    </div>
                    <br/>
                    <div class="col-md-6 text-right">
                        <a href="/{$language}/admin/atendentes_lista" class="btn btn-default navbar-btn"><i class="fa fa-reply">&nbsp</i> Voltar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-left">
                        {if $erro eq ""}

                            <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

                        {else}

                            {if $sucesso eq "FALSE"}
                                <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                            {else}
                                <div class="alert alert-success" role="alert">{$erro}</div>	
                            {/if}

                        {/if}

                    </div>
                    <div class="col-md-6 text-right"></div>
                </div>


                <div class="row">

                    <div class="col-md-12 text-left">

                        <p><input type="text" class="form-control" id="nome" name="nome" maxlength="40" value="{$nome}" placeholder="Nome completo"/></p>
                        <h4>E-mail: {$email}</h4>
                        
                        <input type="checkbox" name="trocar_senha" id="trocar_senha"/> Trocar senha?
                        <p class="show_senha hide"><input type="password" class="form-control" id="senha" name="senha" maxlength="70" value="" placeholder="Senha"/></p>
                        
                        <h4>Sexo</h4>
                        <p>
                            <select name="sexo" class="form-control">
                                <option value="M" {if $sexo == "M"}selected{/if}>Masculino</option>
                                <option value="F" {if $sexo == "F"}selected{/if}>Feminino</option>
                            </select>
                        </p>
                        <h4>
                            {if $status eq 0}
                                <input type="checkbox" name="status"/> Ativo
                            {else}
                                <input type="checkbox" name="status" checked="true"/> Ativo
                            {/if}    
                        </h4>
                        <p><button type="submit" class="btn btn-primary" name="enviar">ENVIAR</button></p>

                    </div>

                </div>

        </div>


        </form>
    </div>
</div>
</div>
{include file="admin/tinymce_2.tpl"}
{include file="admin/footer.tpl"}