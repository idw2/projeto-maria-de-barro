{include file="header.tpl"}

<div class="container">
    <br/>   
    <div class="row">
        <div class="col-md-6">

            <div class="jumbotron">
                <div class="container">

                    <h2>Inscreva-se?</h2>
                    <br/>
                    <p>E receba periódicamente notícias do nosso site!</p><br/>

                </div>
            </div>
        </div> 

        <div class="col-md-6">
            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/informacoes/newsletter" method="post">

                {if $erro eq ""}

                    <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

                {else}
                    {if $sucesso eq "FALSE"}
                        <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                    {else}
                        <div class="alert alert-success" role="alert">{$erro}</div>	
                    {/if}
                {/if}

                <h3 style="margin: 16px 0 12px">Newsletter</h3>
                <br/>
                <p><input type="text" class="form-control" style="min-width: 100%" id="nome" name="nome" maxlength="40" value="{$nome}" placeholder="Nome completo"/></p>
                <p><input type="text" class="form-control" style="max-width: 47%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail"/></p>
                <h4>Sexo</h4>
                <p>
                    <select name="sexo" class="form-control">
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </p>
                <h4>
                    {if $termos eq ""}
                        <input type="checkbox" name="termos"/> Sim, ceito receber as notícias deste site por e-mail.
                    {else}
                        <input type="checkbox" name="termos" checked="true"/> Sim, aceito receber as notícias deste site por e-mail.    
                    {/if}    
                </h4>
                <p><button type="submit" class="btn btn-primary" name="enviar">ENVIAR</button></p>

            </form>
        </div>
                
    </div>
</div>
<div style="clear: both;"></div>


{include file="footer.tpl"}