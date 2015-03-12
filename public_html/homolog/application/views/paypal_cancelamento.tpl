{include file="header.tpl"}

<div class="container">
    <br/>   
    {*<div class="row">

        {include file="navbar2.tpl"}

    </div>*}
    {*<div class="row" id="accordion">*}

    <div class='section-title'>
        <h2><strong>Pedido</strong> cancelado!</h2>
    </div>
    <h3 style="font-weight: 300;margin-top: 25px">{$saudacao} {$NOME},<br><br> seu pagamento foi cancelado pelo PayPal.<br> 
        Verifique os dados informados e tente novamente.<br/>
    Acompanhe seu pedido na página <a href='/{$language}/conta/meus-pedidos'>Meus pedidos</a>.</h3>

</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}