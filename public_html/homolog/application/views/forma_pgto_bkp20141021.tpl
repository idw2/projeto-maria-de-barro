<div class="row">

    <div class="col-lg-12">

        {counter assign=i start=1 print=false} 
        {foreach item=endereco from=$endereco_list}
            {if $endereco->CODENDERECO != "" && $endereco->STATUS == "1"}
                {assign var="CODENDERECO" value="{$endereco->CODENDERECO}"}
            {/if}    
            {counter}    
        {/foreach}

        {*        <form class="" name="formListenderecos" id="formListenderecos">*}
        <ul class="nav nav-tabs nav-tabs-2" role="tablist"> 
            <li class="active"><a href="#tabs-1" role="tab" data-toggle="tab">Cartão de <strong>crédito</strong></a></li>
            <li><a href="#tabs-2" role="tab" data-toggle="tab">Boleto <strong>bancário</strong></a></li>
            <li><a href="#tabs-3" role="tab" data-toggle="tab"><img src="/web-files/img/assets/paypal-logo.png?v=2"></a></li>
        </ul>
        <div class="tab-content">

            <div id="tabs-1" class="tab-pane active">
                {*<form name="CieloForm" id="CieloForm" onsubmit="return false">
                <div class='row'>
                <div class="col-lg-12">
                <center>
                <img src="/web-files/img/cielo.jpg" alt="Cielo" title="Cielo" border="0" style='margin: 40px 0;'/>
                </center>
                </div>
                </div>
                <div class='row form-group'>
                <div class="col-sm-12">
                <h2 class='title-lg'>Valor total: <strong>R$00,00</strong></h2>
                </div>

                </div>
                <div class='row form-group'>
                <div class="col-sm-12 form-inline">
                <label for='formaPagamento'>Opções de parcelamento</label><br/>
                <select name="formaPagamento" class='form-control'>
                <option value="1" checked>Crédito à Vista</option>
                <option value="2">2x</option>
                <option value="3">3x</option>
                <option value="4">4x</option>
                <option value="5">5x</option>
                <option value="6">6x</option>
                <option value="7">7x</option>
                <option value="8">8x</option>
                <option value="9">9x</option>
                <option value="10">10x</option>
                <option value="11">11x</option>
                <option value="12">12x</option>
                </select>
                </div>
                </div>
                <div class='row form-group'>
                <div class="col-sm-6 required">
                <label for="cartao-numero">Cartão de crédito</label>
                <input type="text" id="cartao-numero" name="cartao-numero" placeholder="Número do cartão" class="form-control" >
                </div>
                <div class="col-sm-4 required">
                <label for="cartao-venc-mes" style='width: 100%;'>Data de vencimento</label>
                <select name="cartao-venc-mes" id="cartao-venc-mes" class='pull-left form-control' style='width: 48%; margin-right: 2%;'>
                <option value="-" checked>Mês</option>
                <option value="01" checked>01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>
                <select name="cartao-venc-ano" id="cartao-venc-ano" class='pull-left form-control' style='width: 50%;' >
                <option value="-" checked>Ano</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                </select>
                </div>
                <div class="col-sm-2 required">
                <label for="cartao-cvc">Código de segurança</label>
                <input type="text" name="cartao-cvc" id="cartao-cvc" maxlength="3" class='form-control' placeholder="CVC">
                </div>
                </div>
                <div class='row form-group'>
                <div class="col-sm-8 required">
                <label for="cartao-nome">Nome do titular (Como no cartão)</label>
                <input type="text" id="cartao-nome" name="cartao-nome" class="form-control" placeholder="Nome do titular do cartão" >
                </div>
                </div>
                <div class='row form-group'>
                <div class="col-sm-12">
                <label>
                <input type='checkbox' id='endereco-faturamento-eq' name='endereco-faturamento-eq' >
                O endereço de faturamento é igual ao nome e local de entrega
                </label>
                </div>
                </div>
                <div class='row form-group'>
                <div class="col-sm-12">
                <button id='confirm-payment' class='btn btn-primary' onclick="javascript:cielo('{$CLIENT_HIDDEN}', '{$CODCADASTRO}', '{$CODENDERECO}');">Efetuar pagamento</button>
                </div>
                </div>*}


                <center>
                    <img src="/web-files/img/cielo.jpg" alt="Cielo" title="Cielo" border="0"/>
                    <br/>
                    <br/>
                    <form name="CieloForm" id="CieloForm" onsubmit="return false">
                        <table border="1" class="table">
                            {*<tr>
                            <td>Total Compra</td>
                            <td>
                            <h2 class='title-lg'>R$ <span id="exibe_valor">0,00</span></h2>
                            </td>			
                            </tr>*}
                            <tr>
                                {*  <td>Forma de pagamento</td>*}
                                <td>

                                    <input type="radio" name="codigoBandeira" value="visa" checked/>visa
                                    <input type="radio" name="codigoBandeira" value="mastercard"/>mastercard 
                                    <input type="radio" name="codigoBandeira" value="diners"/>diners 
                                    <input type="radio" name="codigoBandeira" value="discover"/>discover  
                                    <input type="radio" name="codigoBandeira" value="elo"/>elo 
                                    <input type="radio" name="codigoBandeira" value="amex"/>amex 
                                    <input type="radio" name="codigoBandeira" value="jcb"/>jcb 
                                    <input type="radio" name="codigoBandeira" value="aura"/>aura  

                                    <br>
                                    <label>Opções de parcelamento</label><br/>
                                    <select name="formaPagamento" id="formaPagamento" class="form-control">
                                        <option value="A">Débito</option>
                                        <option value="1" checked>Crédito à Vista</option>
                                        <option value="2">2x</option>
                                        <option value="3">3x</option>
                                        <option value="4">4x</option>
                                        <option value="5">5x</option>
                                        <option value="6">6x</option>						
                                        <option value="7">7x</option>						
                                        <option value="8">8x</option>						
                                        <option value="9">9x</option>						
                                        <option value="10">10x</option>						
                                        <option value="11">11x</option>						
                                        <option value="12">12x</option>	
                                    </select>

                                    {*<select name="codigoBandeira" id="codigoBandeira">
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                    <option value="elo">Elo</option>
                                    </select>*}

                                    {*<br/>										
                                    <input type="radio" name="formaPagamento" value="A">Débito
                                    <br><input type="radio" name="formaPagamento" value="1" checked>Crédito à Vista
                                    <br><input type="radio" name="formaPagamento" value="2">2x
                                    <br><input type="radio" name="formaPagamento" value="3">3x
                                    <br><input type="radio" name="formaPagamento" value="4">4x
                                    <br><input type="radio" name="formaPagamento" value="5">5x
                                    <br><input type="radio" name="formaPagamento" value="6">6x						
                                    <br><input type="radio" name="formaPagamento" value="7">7x						
                                    <br><input type="radio" name="formaPagamento" value="8">8x						
                                    <br><input type="radio" name="formaPagamento" value="9">9x						
                                    <br><input type="radio" name="formaPagamento" value="10">10x						
                                    <br><input type="radio" name="formaPagamento" value="11">11x						
                                    <br><input type="radio" name="formaPagamento" value="12">12x	*}				
                                </td>
                            </tr>
                            {* <tr>
                            <td>Tentar Autenticar?</td>
                            <td>
                            <input type="radio" name="tentarAutenticar" value="sim"/>Sim
                            <input type="radio" name="tentarAutenticar" value="nao" checked="checked"/>Não
                            </td>
                            </tr>*}		
                            <tr>
                                {*  <td>Cartão</td>*}
                                <td>
                                    <table border="0" class="table">
                                        <tr>
                                            {*<td>{*Número* }</td>*}
                                            <td>
                                                <label for="cartao-numero">Cartão de crédito</label>
                                                <input type="text" name="cartaoNumero" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            {*<td>{*Validade (jun/2010 = 201006)* }</td>*}
                                            <td>
                                                {*                                                <input type="text" name="cartaoValidade" value="08/2015">*}

                                                <label for="cartao-venc-mes" style='width: 100%;'>Data de vencimento</label>
                                                <select name="cartao-venc-mes" id="cartao-venc-mes" class='pull-left form-control' style='width: 48%; margin-right: 2%;'>
                                                    <optgroup label="Mês">
                                                        <option value="01" checked>01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </optgroup>
                                                </select>
                                                <select name="cartao-venc-ano" id="cartao-venc-ano" class='pull-left form-control' style='width: 50%;' >
                                                    <optgroup label="Ano">
                                                        <option value="2014" checked>14</option>
                                                        <option value="2015">15</option>
                                                        <option value="2016">16</option>
                                                        <option value="2017">17</option>
                                                        <option value="2018">18</option>
                                                        <option value="2019">19</option>
                                                        <option value="2020">20</option>
                                                        <option value="2021">21</option>
                                                        <option value="2022">22</option>
                                                        <option value="2023">23</option>
                                                        <option value="2024">24</option>
                                                        <option value="2025">25</option>
                                                        <option value="2026">26</option>
                                                        <option value="2027">27</option>
                                                        <option value="2028">28</option>
                                                        <option value="2029">29</option>
                                                        <option value="2030">30</option>
                                                    </optgroup>
                                                </select>

                                            </td>
                                        </tr>
                                        <tr>
                                            {*<td>{*Cód. Segurança* }</td>*}
                                            <td>
                                                <label for="cartao-cvc">Código de segurança</label>
                                                <input type="text" name="cartaoCodigoSeguranca" value="" maxlength="4" class='form-control' placeholder="CVC"/>
                                                <input type='hidden' name='capturarAutomaticamente' value='true'/>
                                                <input type='hidden' name='tentarAutenticar' value='sim'/>
                                                <input type='hidden' name='indicadorAutorizacao' value='3'/>
                                                <input type='hidden' name='tipoParcelamento' value='2'/>
                                                <input type="hidden" name="produto" id="produto" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            {*<td> {*<label for="cartao-nome">Nome do titular (Como no cartão)</label>* } </td>*}
                                            <td>
                                                <label for="cartao-nome">Nome do titular (Como no cartão)</label>
                                                <input type="text" name="nomeTitulo" id="nomeTitulo" class="form-control" placeholder="Nome do titular do cartão" >
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            {*<tr>
                            <td colspan="2">

                            </td>
                            <td>Configuração</td>
                            <td>
                            <table>
                            <tr>
                            <td>
                            Parcelamento
                            </td>
                            <td>
                            <select name="tipoParcelamento">
                            <option value="2">Loja</option>
                            <option value="3">Administradora</option>
                            </select>
                            </td>
                            </tr>
                            <tr>
                            <td>Capturar Automaticamente?</td>
                            <td>
                            <select name="capturarAutomaticamente">
                            <option value="true">Sim</option>
                            <option value="false" selected="selected">Não</option>
                            </select>
                            </td>
                            </tr>
                            <tr>
                            <td>Autorização Automática</td>
                            <td>
                            <select name="indicadorAutorizacao">
                            <option value="3">Autorizar Direto</option>
                            <option value="2">Autorizar transação autenticada e não-autenticada</option>
                            <option value="0">Somente autenticar a transação</option>
                            <option value="1">Autorizar transação somente se autenticada</option>
                            </select>
                            </td>
                            </tr>							
                            </table>
                            </td>
                            </tr>*}										
                            <tr>
                                <td>

                                    <div class='panel panel-highlight'>
                                        <div class="panel-body">
                                            <p style="font-size: 2rem;line-height: 2.6rem;" class="return-cielo">Por favor, preencher todos os campos!<br></p>
                                            <button type="buttom" class="btn btn-primary btn-primary-maria" name="enviar" onclick="javascript:cielo('{$CLIENT_HIDDEN}', '{$CODCADASTRO}', '{$CODENDERECO}');">Pagar</button>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </table>
                    </form>
                </center>
                </form>
            </div>
            <div id="tabs-2" class="tab-pane">

                <div class='form-group'>
                    <h2 class='title-lg'>PAGAMENTO COM BOLETO BANCÁRIO</h2>

                    <br/>
                    <img src="/application/controllers/boletophp-master/imagens/logocaixa.jpg" style="height: 40px; width: 150px;" border="0" alt="Caixa Economica Federal" title="Caixa Economica Federal"/>
                    <br/>

                    <p>Ao clicar no botão abaixo "PAGAR COM BOLETO", você será direcionada(o) para fazer o pagamento.</p>
                </div>
                <div class='panel panel-highlight'>
                    <div class="panel-body">
                        <p style="font-size: 2rem;line-height: 2.6rem;">Pagável preferêncialmente nas Casas Lotérias ou na InternetBank até a data do vencimento.<br></p>
                        <button type="buttom" class="btn btn-primary" name="enviar" onclick="javascript:boleto('{$CLIENT_HIDDEN}', '{$CODCADASTRO}', '{$CODENDERECO}');">PAGAR COM BOLETO</button>
                    </div>
                </div>
                <div class='form-group'>
                    <h3 class='title-md'>Atenção para alguns detalhes:</h3>
                    <ul>
                        <li>Ao solicitar o pagamento com boleto a data de vencimento é gerado pelo banco emissor. Caso seja feriado ou final de semana, pague no primeiro dia útil após o vencimento</li>
                        <li>Esgotado o prazo de pagamento do boleto você deverá observar seus e-mails que contém explicações de como gerar a segunda via da compra</li>
                        <li>A identificação de pagamento do boleto não é imediata, leva de 1 a 3 nas agências da Caixa Econômica Federal ou nas Casas Lotéricas, em outros bancos pode ocorrer a compensação até 5 dias úteis após a realização do pagamento.</li>
                        <li>Após a identificação de pagamento em nosso sistema, o seu pedido será preparado e enviado para o endereço de entrega cadastrado</li>
                    </ul>
                </div>
            </div>
            <div id="tabs-3" class="tab-pane">
                <div class='form-group'>
                    <h3 class='title-lg'>PAGAMENTO COM PAYPAL</h3>
                    <p>Ao clicar no botão abaixo "PAGAR COM PAYPAL", você será direcionada(o) para fazer o pagamento.<br></p>
                </div>
                <div class='form-group'>
                    <button type="button" id='confirm-payment-paypal' class='btn btn-primary'>PAGAR COM PAYPAL</button>
                </div>
            </div>
        </div>
        {*        </form>*}


        {*<form class="" name="formListenderecos" id="formListenderecos">
        <div class="radio-block">
        <input type="radio" name='pgto' value='moip' class="radio-switch">
        <img src="/web-files/img/assets/pagamento-moip.png" alt="Moip">
        </div>
        <div class="radio-block active">
        <input type="radio" name='pgto' value='paypal' checked='true' class="radio-switch">
        <img src="/web-files/img/assets/pagamento-paypal.png" alt="Paypal">
        </div>
        </form>*}

    </div>

</div>

<div>
    {*<div style="text-align: center;"> 
    <span id="msg_erro_Finale"></span>
    <span class="LoaderFinale hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/></span></div>
    <ul class="pager">
    {*<li class="previous"><a href="/{$language}/">&larr; Continuar comprando</a></li>* }
    <li class="next"><a style="cursor: pointer;" onclick="javascript:finalizar_pedido('{$CLIENT_HIDDEN}', '{$CODCADASTRO}', '{$CODENDERECO}', '{$language}');">Finalizar compra &rarr;</a></li>
    </ul>*}
</div> 



{* 
 
<div id="opc_payment_methods" class="opc-main-block">
                




<ul class="sta-tabs sta-nav sta-nav-tabs" id="sta-tab-payment-options">
    
        
    
<li class="active"><a href="#tab-cartao" class="no-anchor-scroll" onclick="return false"><i class="fa fa-credit-card"></i> Cartão de <strong>crédito</strong></a></li>
<li><a href="#tab-debit-card" class="no-anchor-scroll" onclick="return false"><i class="fa fa-credit-card"></i>Cartão de <strong>débito</strong></a></li>
<li class=""><a href="#tab-bankline" class="no-anchor-scroll" onclick="return false"><b>Débito bancário</b></a></li>
<li><a href="#tab-boleto" class="no-anchor-scroll" onclick="return false"><i class="fa fa-barcode"></i> Boleto<span class="sm-hide" style="vertical-align: inherit"> bancário</span></a></li>
<li><a href="#tab-paypal" class="no-anchor-scroll" onclick="return false"><img src="//www.amomuito.com/img/one-page-checkout/paypal.gif?1" alt=""></a></li>
</ul>
<div class="sta-tab-content" id="sta-tab-payment-options-body">
    
        
    
<div class="sta-tab-pane active" id="tab-cartao" data-tab-url="/modules/stamoip/payment_execution.php?tipo=creditCard"><p class="sta-pg-title2"><strong>Opções de parcelamento sem juros:</strong></p>

<div class="sta-cartao-parcelas clearfix">
<div class="sta-cartao-parcela" style="width: 134px;">
<label>
<input type="radio" name="sta-cartao-parcela" value="1" checked="checked" onchange="staOpcCartaoParcelaRadioChange(this);">
<span class="sta-pg-title2">À vista R$180,00</span>
</label>
</div>
<div class="sta-cartao-parcela" style="width: 134px;">
<label>
<input type="radio" name="sta-cartao-parcela" value="2" onchange="staOpcCartaoParcelaRadioChange(this);">
<span class="sta-pg-title2">2X de R$90,00</span>
</label>
</div>
<div class="sta-cartao-parcela" style="width: 134px;">
<label>
<input type="radio" name="sta-cartao-parcela" value="3" onchange="staOpcCartaoParcelaRadioChange(this);">
<span class="sta-pg-title2">3X de R$60,00</span>
</label>
</div>
<div class="sta-cartao-parcela sta-parcela-active" style="width: 134px;">
<label>
<input type="radio" name="sta-cartao-parcela" value="4" onchange="staOpcCartaoParcelaRadioChange(this);">
<span class="sta-pg-title2">4X de R$45,00</span>
</label>
</div>

<script type="text/javascript">
staAjustarLarguraDosThumbDeParcelas();
</script>
</div>


<div class="sta-form " id="stamoip-cardform">
<input type="hidden" value="" name="cartao-cofre" id="cartao-cofre">
<div class="sta-form-row">
<div class="required sta-control-group bandrs" style="width: 90%">
<label class="control-label">Selecione o cartão</label>
<div class="controls">
<div class="sta-card-icons">
<div class="visa" onclick="staSelectCardBrandName('Visa')" title="Visa"></div>
<div class="mastercard" onclick="staSelectCardBrandName('Mastercard')" title="Mastercard"></div>
<div class="amex" onclick="staSelectCardBrandName('Amex')" title="American Express"></div>
<div class="diners diners_club_carte_blanche diners_club_international" onclick="staSelectCardBrandName('Diners')" title="Diners"></div>

<div class="hipercard" onclick="staSelectCardBrandName('Hipercard')" title="Hipercard"></div>
</div>
<input type="hidden" value="" id="cartao-brand-name" name="cartao-brand-name">
<div id="sta-what-i-picked" style="margin-top: 8px;color: #FFFFFF;background: #F15151;padding: 7px 19px;border-radius: 3px; display:none">Você precisa marcar a bandeira do cartão, se é VISA, MASTERCARD...</div>
</div>
</div>
</div>
<div class="sta-form-row">
<div class="required text sta-control-group cartao-numero-wp">
<label for="cartao-numero">Número do cartão de crédito</label>
<div class="sta-hint-wrapper">
<input type="text" name="cartao-numero" id="cartao-numero" maxlength="24" placeholder="Use apenas números" class="unknown">
<script type="text/javascript">
if ($('#cartao-numero').payment) $('#cartao-numero').payment('formatCardNumber');

var cartaoNumeroEmitiuAlerta = false;
var cartaoNumeroPiscando = false;
$('#cartao-numero').bind('keyup', function(e) {
var cartaoNumero = $('#cartao-numero');
var value = (cartaoNumero.val() || '');
if (value.match(/[^\d ]/)) {
if (!cartaoNumeroEmitiuAlerta) {
cartaoNumeroEmitiuAlerta = true;
alert("Digite apenas números.\nNão use pontos, hifens ou qualquer outro caractere além de números.")
}
if (!cartaoNumeroPiscando) {
cartaoNumeroPiscando = true;
cartaoNumero.addClass('sta-red-border');
cartaoNumero.fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100, function() {
cartaoNumero.removeClass('sta-red-border');
cartaoNumeroPiscando = false;
});
}
} else {
cartaoNumeroEmitiuAlerta = false;
}
});
$('#cartao-numero').bind('keypress', function(e) {
var cartaoNumero = $('#cartao-numero');
var value = (cartaoNumero.val() || '');
if (value.match(/[^\d ]/)) {
stopEvent(e);
}
});

</script>
</div>
</div>
<p class="required text" style="box-sizing: border-box;width: 170px">
<label for="cartao-venc-mes">Vencimento</label>
<select name="cartao-venc-mes" id="cartao-venc-mes">
<option value="none">Mês</option>
<option value="1">01</option>
<option value="2">02</option>
<option value="3">03</option>
<option value="4">04</option>
<option value="5">05</option>
<option value="6">06</option>
<option value="7">07</option>
<option value="8">08</option>
<option value="9">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
<select name="cartao-venc-ano" id="cartao-venc-ano">
<option value="none">Ano</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
<option value="2026">2026</option>
<option value="2027">2027</option>
<option value="2028">2028</option>
<option value="2029">2029</option>
<option value="2030">2030</option>
<option value="2031">2031</option>
</select>
</p>

<div class="required text sta-control-group" style="box-sizing: border-box;width: 230px">
<label style="margin-bottom: 0">CVC (código de segurança)</label>
<div class="sta-hint-wrapper">
<input type="text" name="cartao-cvc" id="cartao-cvc" maxlength="3">
<div class="sta-hint sta-hint-right cartao-cvc-hint">
<i class="sta-back-card"></i> <a href="#" tabindex="-1" class="no-anchor-scroll" onclick="staShowCvcHelp(this);return false">Saiba mais</a>
</div>
</div>
</div>
</div>
<div class="sta-form-row">
<p class="required text">
<label for="cartao-titular-nome">Nome (idêntico ao do cartão)</label>
<input type="text" name="cartao-titular-nome" id="cartao-titular-nome" maxlength="100">
</p>
<p class="required text titular-details sta-hide">
<label for="cartao-nasc-dia">Data de nascimento do títular do cartão</label>
<select name="cartao-nasc-dia" id="cartao-nasc-dia">
<option value="none">Dia</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30" selected="selected">30</option>
<option value="31">31</option>
</select>
<select name="cartao-nasc-mes" id="cartao-nasc-mes">
<option value="none">Mês</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10" selected="selected">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
<select name="cartao-nasc-ano" id="cartao-nasc-ano">
<option value="none">Ano</option>
<option value="1914">1914</option>
<option value="1915">1915</option>
<option value="1916">1916</option>
<option value="1917">1917</option>
<option value="1918">1918</option>
<option value="1919">1919</option>
<option value="1920">1920</option>
<option value="1921">1921</option>
<option value="1922">1922</option>
<option value="1923">1923</option>
<option value="1924">1924</option>
<option value="1925">1925</option>
<option value="1926">1926</option>
<option value="1927">1927</option>
<option value="1928">1928</option>
<option value="1929">1929</option>
<option value="1930">1930</option>
<option value="1931">1931</option>
<option value="1932">1932</option>
<option value="1933">1933</option>
<option value="1934">1934</option>
<option value="1935">1935</option>
<option value="1936">1936</option>
<option value="1937">1937</option>
<option value="1938">1938</option>
<option value="1939">1939</option>
<option value="1940">1940</option>
<option value="1941">1941</option>
<option value="1942">1942</option>
<option value="1943">1943</option>
<option value="1944">1944</option>
<option value="1945">1945</option>
<option value="1946">1946</option>
<option value="1947">1947</option>
<option value="1948">1948</option>
<option value="1949">1949</option>
<option value="1950">1950</option>
<option value="1951">1951</option>
<option value="1952">1952</option>
<option value="1953">1953</option>
<option value="1954">1954</option>
<option value="1955">1955</option>
<option value="1956">1956</option>
<option value="1957">1957</option>
<option value="1958">1958</option>
<option value="1959">1959</option>
<option value="1960">1960</option>
<option value="1961">1961</option>
<option value="1962">1962</option>
<option value="1963">1963</option>
<option value="1964">1964</option>
<option value="1965">1965</option>
<option value="1966">1966</option>
<option value="1967">1967</option>
<option value="1968">1968</option>
<option value="1969">1969</option>
<option value="1970">1970</option>
<option value="1971">1971</option>
<option value="1972">1972</option>
<option value="1973">1973</option>
<option value="1974">1974</option>
<option value="1975">1975</option>
<option value="1976">1976</option>
<option value="1977" selected="selected">1977</option>
<option value="1978">1978</option>
<option value="1979">1979</option>
<option value="1980">1980</option>
<option value="1981">1981</option>
<option value="1982">1982</option>
<option value="1983">1983</option>
<option value="1984">1984</option>
<option value="1985">1985</option>
<option value="1986">1986</option>
<option value="1987">1987</option>
<option value="1988">1988</option>
<option value="1989">1989</option>
<option value="1990">1990</option>
<option value="1991">1991</option>
<option value="1992">1992</option>
<option value="1993">1993</option>
<option value="1994">1994</option>
<option value="1995">1995</option>
<option value="1996">1996</option>
<option value="1997">1997</option>
<option value="1998">1998</option>
<option value="1999">1999</option>
<option value="2000">2000</option>
<option value="2001">2001</option>
<option value="2002">2002</option>
<option value="2003">2003</option>
<option value="2004">2004</option>
<option value="2005">2005</option>
<option value="2006">2006</option>
<option value="2007">2007</option>
<option value="2008">2008</option>
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
</select>
</p>
<p class="required text titular-details sta-hide">
<label for="cartao-titular-fone">Telefone do titular do cartão</label>
<input type="text" name="cartao-titular-fone" id="cartao-titular-fone" maxlength="25" value="6139678750">
</p>
<p class="required text titular-details sta-hide">
<label for="cartao-titular-cpf">CPF do titular do cartão</label>
<input type="text" name="cartao-titular-cpf" id="cartao-titular-cpf" maxlength="14" value="829.297.501-20">
</p>

</div>

<div class="sta-form-row titular-details  titular-details-resumo">
<div style="background: #F9F9F9;  padding: 5px 9px; font-size: 11px; line-height: 1.4em;   border-top: 1px solid #DDD;  border-bottom: 1px solid #DDD;  font-family: Arial;    margin-bottom: 15px;box-sizing: border-box;">
<b>Dados do titular do cartão</b> - <button class="sta-btn sta-btn-link" style="text-transform: none;font-weight: normal;font-size: 11px;padding: 0 0 2px" onclick="$('.titular-details').toggleClass('sta-hide');">Corrigir estes dados</button> <br>
<b>CPF:</b> 829.297.501-20 - <b>Nascimento:</b> 30/10/1977 - <b>Telefone:</b> 6139678750 <br>
</div>
</div>
<div class="sta-form-row">
<div class="sta-control-group cartao-guardar-numero-wp">
<div class="cartao-guardar-numero">
<label for="cartao-guardar-numero">
<input type="checkbox" name="cartao-guardar-numero" id="cartao-guardar-numero" checked="">
Salvar informações básicas do cartão, para facilitar a próxima compra. 
</label>
<a hre="#" class="tooltip" tooltip="O número do código de segurança (CVC) não é gravado e sempre será pedido durante o processo de compra, sem ele você não consegue finalizar a compra.
As informações do cartão são criptografadas.">Dúvida?</a>
</div>
</div>
</div>
</div>

<div class="sta-control-group">
<button onclick="staConfirmPayment(this, 'moipCreditCard')" class="sta-btn sta-btn-large sta-btn-success">Efetuar pagamento</button>
</div></div>
<div class="sta-tab-pane" id="tab-debit-card" data-tab-url="/modules/cielo/meios.php?ajax"></div>
<div class="sta-tab-pane " id="tab-bankline" data-tab-url="/modules/stamoip/payment_execution.php?tipo=bankline"></div>
<div class="sta-tab-pane" id="tab-boleto" data-tab-url="/modules/boletobancario/payment.php?staopc"></div>
<div class="sta-tab-pane" id="tab-paypal" data-tab-url="/modules/paypal/payment/submit.php?ajax"></div>
</div>
<script type="text/javascript">
staLoadPaymentTabContent($('#sta-tab-payment-options > li.active a').attr('href'));
</script>


<div class="sta-pagamento-hide">
    
<div id="HOOK_TOP_PAYMENT">	</div>

<h4>Por favor, escolha a forma de pagamento para o seu pedido:&nbsp;<span class="price">R$180,00</span></h4><br>
<div id="opc_payment_methods-content">
<div id="HOOK_PAYMENT"><p class="payment_module">
<a href="https://www.amomuito.com/modules/boletobancario/payment.php" title="Pagamento no Boleto Bancário">
<img src="/modules/boletobancario/imagens/boleto.gif" alt="Pagamento no Boleto Bancário">
Pagamento com Boleto Bancário
</a>
</p>
<p class="payment_module" height="">
<a href="https://www.amomuito.com/modules/paypal/payment/submit.php" title="Pay with PayPal">
<img src="/modules/paypal/paypal.gif" alt="Pay with PayPal" style="float:left;">
<br>
Pay with your PayPal account (Não é possível parcelar) 
<br style="clear:both">
</a>
</p><p class="payment_module" style="text-align:center;">
<a href="https://www.amomuito.com/modules/cielo/meios.php" title="Pagar com Cartoes de Credito Cielo">
<img src="https://www.amomuito.com/modules/cielo/pagar.png" alt="Pagar com Cartoes de Credito Cielo"></a>
</p>
</div>
</div>

<p class="cart_navigation"><a href="https://www.amomuito.com/pagamento?step=2" title="Anterior" class="button">« Voltar</a></p>
</div>
    
</div>
    
<style>
#order-opc div.opc-main-block {
position: relative;
margin-left: 59px;
}
.sta-opc-passos {
width: 79%;
clear: both;
position: relative;
color: #333;
font-size: 17px;
font-family: Lato,Arial;
line-height: 21px;
margin: 0 0 10px;
}
#page {
margin: 0 auto 2px;
width: 1024px;
text-align: left;
}
.sta-nav-tabs.sta-nav {
margin-bottom: 26px;
margin-left: 0;
list-style: none;
}
ul.sta-nav-tabs {
padding: 0;
margin: 0 0 10px 25px;
}
.sta-nav-tabs {
border-bottom: 1px solid #B4B4B4;
}
.sta-nav-tabs:before, .sta-nav-tabs:after {
display: table;
line-height: 0;
content: "";
}
.sta-nav-tabs:after {
clear: both;
}

.sta-opc-passos {
width: 79%;
clear: both;
position: relative;
color: #333;
font-size: 17px;
font-family: Lato,Arial;
line-height: 21px;
margin: 0 0 10px;
}

#page {
margin: 0 auto 2px;
width: 1024px;
text-align: left;
}

.sta-opc-passos {
width: 79%;
clear: both;
position: relative;
color: #333;
font-size: 17px;
font-family: Lato,Arial;
line-height: 21px;
margin: 0 0 10px;
}
.sta-opc-passos .sta-opc-step #sta-lista-de-pagamentos #pagamento-opc #sta-tab-payment-options.sta-tabs li a, .sta-opc-passos .sta-opc-step #sta-lista-de-pagamentos #pagamento-opc #sta-tab-payment-options.sta-tabs li a:hover {
color: #333;
}

.sta-opc-passos .sta-opc-step #sta-lista-de-pagamentos #pagamento-opc #sta-tab-payment-options.sta-tabs li a, .sta-opc-passos .sta-opc-step #sta-lista-de-pagamentos #pagamento-opc #sta-tab-payment-options.sta-tabs li a:hover {
color: #333;
}

.sta-opc-passos .sta-opc-step #sta-lista-de-pagamentos #pagamento-opc #sta-tab-payment-options li a {
line-height: 30px;
color: #eee;
}


</style>*}