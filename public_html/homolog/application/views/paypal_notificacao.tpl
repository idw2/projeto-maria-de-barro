{include file="header.tpl"}

<div class="container">
    <br/>   
    {*<div class="row">

        {include file="navbar2.tpl"}

    </div>*}
    {*<div class="row" id="accordion">*}

    <div class='section-title'>
        <h2><strong>Pedido</strong> não confirmado!</h2>
    </div>
    <h3 style="font-weight: 300;margin-top: 25px">{$saudacao} {$NOME},<br><br> houve um erro ao efetuar o pagamento.<br/>
        Verifique os dados informados e tente novamento.<br>
         Acompanhe seu pedido na página <a href='/{$language}/conta/meus-pedidos'>Meus pedidos</a>.</h3>

</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}