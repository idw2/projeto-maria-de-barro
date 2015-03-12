{include file="header.tpl"}

<div class="container">
    <br/>   
 <div class="row">
        <div class="col-md-6">

            <div class="jumbotron">
                <div class="container">

                    <!-- h1 e p que já tínhamos -->
                    <h2>Ainda está com problemas?</h2>
                    <br/>
                    <p><strong>E-mail:</strong><br/>
                        <span style='font-size: 20'>maria@mariadebarro.com.br</span>
                    </p><br/>
                    <br/>
                    <p><strong>Obs:</strong><br/>O prazo de respostas para as solicitações é de até 24h.</p><br/>

                </div>
            </div>
        </div> 

        <div class="col-md-6">
            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/informacoes/contato" method="post">

                {if $erro eq ""}

                    <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

                {else}

                    {if $sucesso eq "FALSE"}
                        <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                    {else}
                        <div class="alert alert-success" role="alert">{$erro}</div>	
                    {/if}

                {/if}
                
                <div class="section-title">
                    <h2>
                         <strong>Fale</strong> conosco
                    </h2>
                </div>

                <br/>
                <p><input type="text" class="form-control" style="min-width: 100%" id="nome" name="nome" maxlength="40" value="{$nome}" placeholder="Nome completo"/></p>
                <p><input type="text" class="form-control" style="max-width: 47%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail"/></p>
                <p><input type="text" class="form-control" style="min-width: 100%" id="assunto" name="assunto" maxlength="70" value="{$assunto}" placeholder="Assunto"/></p>
                <p><textarea class="form-control" rows="5" style="min-width: 100%" id="mensagem" name="mensagem">{$mensagem}</textarea></p>
                <p><button type="submit" class="btn btn-primary btn-primary-maria" name="enviar">ENVIAR</button></p>

            </form>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}