<?php get_head(); ?>

<div class="loader" style="display: none;"></div>

<section class="pag-section pag-section-neutral">
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>
                <form id="form" action="./form/send-payment.php" method="post" class="ajax-form" novalidate>
                    <div class="form-group">
                        <label for="user_email">Email do cliente</label>
                        <input type="email" name="user_email" placeholder="cliente@provedor.com.br" class="input" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Valor do pagamento</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="tel" name="produto" placeholder="00,00" class="input mask_money" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">                        
                        <label for="cartao_nome">Bandeiras</label>
                        <select name="codigoBandeira" class="input">
                            <option value="visa" selected>Visa</option>
                            <option value="mastercard">Master</option>
                            <option value="amex">American Express</option>
                            <option value="diners">Diners Club‎</option>
                            <option value="elo">Elo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cartao_numero">Cartão de crédito</label>
                        <input type="tel" name="cartaoNumero" placeholder="Número do cartão" class="input" required>
                    </div>
                    <div class="form-group">
                        <div style="width: 50%; float: left;">
                            <label for="cartao_numero">Data de vencimento</label>
                            <input type="tel" name="cartao_dta_mes" class="input" placeholder="MM" maxlength="2" style="width:45px;padding: 6px 6px;text-align: center;" required> 
                            <span style="margin: 0 6px;display: inline-block;">/</span>
                            <input type="tel" name="cartao_dta_ano" class="input input-col-2" maxlength="4" placeholder="AAAA" style="width:60px;padding: 6px 6px;text-align: center;" required>
                        </div>
                        <div style="width: 45%;margin-left: 5%; float: left;">
                            <label for="cartao_numero">Código de segurança</label>
                            <input type="tel" name="cartaoCodigoSeguranca" class="input" placeholder="CVC" maxlength="4" style="width:70px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cartao_nome">Nome no cartão</label>
                        <input type="text" name="nomeTitulo" placeholder="Como consta no cartão" class="input" required>
                    </div>
                    <div class="form-group">
                        <label for="cartao_nome">Opções de parcelamento</label>
                        <select name="formaPagamento" class="input">
                            <option value="1" selected>Crédito a vista</option>
                            <option value="2">2x</option>
                            <option value="3">3x</option>
                            <option value="4">4x</option>
                            <option value="5">5x</option>
                            <option value="6">6x</option>
                        </select>
                    </div>
                    <hr>
                    <center>
                        <div id="armored_website" style="display: inline-block;">
                            <param id="aw_preload" value="true" />
                        </div>
                        <script type="text/javascript" src="//selo.siteblindado.com/aw.js"></script>
                    </center>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Pagar</button>
                        <input type="hidden" name="capturarAutomaticamente" id="capturarAutomaticamente" value="true">
                        <input type="hidden" name="tentarAutenticar" id="tentarAutenticar" value="sim">
                        <input type="hidden" name="indicadorAutorizacao" id="indicadorAutorizacao" value="3">
                        <input type="hidden" name="tipoParcelamento" id="tipoParcelamento" value="2">  
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/template" id="tpt-form-response-success">
    <div class="panel panel-success">
    <div class="panel-heading">
    Pagamento efetuado com succeso!
    </div>
    <div class="panel-body">
    <!--O recibo do pagamento foi enviado para o email informado.-->
    </div>
    </div>
    <div class="form-group">
    <a href="./" class="btn btn-primary btn-block">Realizar novo pagamento</a>
    </div>
</script>

<script type="text/template" id="tpt-form-response-error">
    <div class="panel panel-danger">
    <div class="panel-heading">
    Erro ao efetuar o pagamento!
    </div>
    <div class="panel-body">
    Verifique os dados fornecidos e tente novamente.
    </div>
    </div>
    <div class="form-group">
    <a href="./" class="btn btn-default btn-block">Realizar novo pagamento</a>
    </div>
</script>

<script type="text/template" id="tpt-form-response-error_conexao">
    <div class="panel panel-danger">
    <div class="panel-heading">
    Erro ao efetuar o pagamento!
    </div>
    <div class="panel-body">
    Falha na conexão, tente mais tarde.
    </div>
    </div>
    <div class="form-group">
    <a href="./" class="btn btn-default btn-block">Realizar novo pagamento</a>
    </div>
</script>

<?php get_footer(); ?>