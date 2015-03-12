{if $controle}   
    <div class="row">       
        <div class="col-lg-12">    
            <form class="form" onsubmit="return false" method="post">
                {if $msg_erro != ""}
                    <div class="alert alert-info" role="alert" style="font-size: 15px;">{$msg_erro}</div>
                {/if}
                <input type="hidden" name="actionType" value="criar_conta"/>
                <h3>{$saudacao} {$nome}!</h3>
                <p>Veja como é fácil adquirir nossos produtos e serviços.</p>
                {*                        <p><input type="text" class="form-control" style="min-width: 40%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail" readonly="readonly"/></p>*}
                <p>
                    
                    <span class="btn btn-default hide" onclick="window.location = '/{$language}/produtos/sair/'">Sair e acessar com outra conta!
                        <input type="hidden" id="EXISTE_USER_LOGADO" value="SIM">
                    </span>
                    {*                        <p><a class="btn btn-default" href="/{$language}/produtos/minha_conta/">Minha conta!</a></p>*}
                </p>
            </form>
        </div>
    </div>

{else} 

    <div class="row">       

        <div class="col-sm-6">
            <div class="auth-form-wrapper">
                <h3 class="auth-form-title">Já é cadastrado?</h3>
                <form name="form-autenticacao" id="form-autenticacao" class="" onsubmit="return false" method="post" >
                    {if $msg_erro_login != ""}
                        <div class="alert alert-info" role="alert">{$msg_erro_login}</div>
                    {/if}
                    <input type="hidden" name="actionType" class="actionType-criar-conta" value="login"/>
                    <p><input type="text" class="form-control email-autenticacao" id="email" name="email" maxlength="70" value="{$email_login}" placeholder="E-mail"/></p>
                    <p><input type="password" class="form-control  senha-autenticacao" id="senha" name="senha" maxlength="70" value="" placeholder="Senha"/></p>
                    <p>
                        <button type="submit" class="btn btn-primary btn-primary-maria" name="enviar" onclick="javascript:autenticacao();" style="margin-right: 5px;">Entrar</button> <a href="/{$language}/produtos/esqueceu_senha/">Esqueceu sua senha?</a>
                        <span class="load-autenticacao hide"><img src='{$web_files}/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 4%'/></span>
                    </p>
                </form>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="auth-form-wrapper">
                <h3 class="auth-form-title">Cadastre-se aqui.</h3>
                <div class="criar-conta">
                    <form name="form-criar-conta" id="form-criar-conta" onsubmit="return false" method="post">
                        {if $msg_erro != ""}
                            <div class="alert alert-info" role="alert">{$msg_erro}</div>
                        {/if}
                        <label>Por favor, entre com seu endereço de e-mail para criar uma conta!</label>
                        <input type="hidden" name="actionType" class="actionType-criar-conta" value="criar_conta"/>
                        <p><input type="email" class="form-control email-criar-conta" name="email" maxlength="70" value="{$email_conta}" placeholder="E-mail"/></p>
                        <p>
                            <button type="buttom" class="btn btn-primary btn-primary-maria"  onclick="javascript:criar_conta();" name="enviar">Criar conta</button>
                            <span class="load-criar-conta hide"><img src='{$web_files}/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 4%'/></span>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
{/if}                           
