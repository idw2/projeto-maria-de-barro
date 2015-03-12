{include file="header.tpl"}

<div class="container">
    <br/>   
    {*<div class="row">

    {include file="navbar2.tpl"}

    </div>*}
    {*<div class="row" id="accordion">*}

    <div class='section-title'>
        <h2><strong>Pedido</strong> confirmado!</h2>
    </div>
    <h3 style="font-weight: 300;margin-top: 25px">Obrigado {$dados['NOME']} por adquirir nossos produtos!</h3>

    <h4 style="font-weight: 300;">
        {if $forma_pgto == "cielo"} Pagamento confirmado com sucesso!
        {/if}

    </h4>

    <a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1582765" target="_blank"><img src="https://mariadebarro.com.br/web-files/img/assets/banner_ebit.gif"></a><br><br>


    <div class="row">
        <div class="col-lg-12">

            {*<table class="table">   
            <tr>
            <td>Código da transação:</td>
            <td>{$pedido->CODPEDIDO}</td>
            {assign var="CODPEDIDO" value="{$pedido->CODPEDIDO}"}
            </tr>
            <tr>
            <td>Código do cliente:</td>
            <td>{$pedido->CODCADASTRO}</td>
            </tr>
            <tr>
            <td>Número do Pedido:</td>
            <td>{$pedido->N_PEDIDO}</td>
            </tr>
            <tr>
            <td>Data e hora da transação:</td>
            <td>{$pedido->DTA}</td>
            </tr>
            <tr>
            <td>{if $pedido->FRETE_GRATIS == "1"} Frete {else} Forma de envio: {/if}</td>
            <td>{if $pedido->FRETE_GRATIS == "1"} Gratis {else} {$pedido->FORMA_ENVIO} {/if}</td>
            </tr>
            <tr>
            <td>Embalagem:</td>
            <td>{if $pedido->EMBALAR_PRESENTE == "1"} Para presente {else} Comum {/if}</td>
            </tr>
            <tr>
            <td>Forma de pagamento:</td>
            <td>{$pedido->FORMA_PGTO}</td>
            </tr>
            <tr>
            <td>Cupom de Desconto:</td>
            <td>{if $pedido->CUPOM == ""} Não informado {else} {$pedido->CUPOM}{/if}</td>
            </tr>
            <tr>
            <td>Total compra:</td>
            <td>{$pedido->TOTAL_COMPRA}</td>
            </tr>
            <tr style="display: none;">
            <td>Total sem impostos:</td>
            <td>{$pedido->TOTAL_PARCIAL}</td>
            </tr>
            <tr  style="display: none;">
            <td>Impostos</td>
            <td>{$pedido->IMPOSTOS}</td>
            </tr>
            {if $pedido->FRETE_GRATIS == "0"}
            <tr>
            <td>Taxa de entrega:</td>
            <td>{$pedido->TAXA_ENTREGA}</td>
            </tr>
            {/if}
            <tr>
            <td>Desconto:</td>
            <td>{if $pedido->DESCONTO == "0"} 0,00 {else} -{$pedido->DESCONTO}{/if}</td>
            </tr>
            <tr>
            <td>{if $forma_pgto == "cielo"} Valor pago: {else} Total à pagar:  {/if}</td>
            <td>{$pedido->TOTAL_GERAL}</td>
            </tr>
            </table>*}
            {if $forma_pgto == "paypal"}                 
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <!--Tipo do botão-->
                    <input type="hidden" name="cmd" value="_xclick" />

                    <!--Vendedor e URL de retorno, cancelamento e notificação-->
                    <input type="hidden" name="business" value="{$email_paypal}" />
                    <input type="hidden" name="return" value="{$url_retorno}" />
                    <input type="hidden" name="cancel" value="{$url_cancelamento}" />
                    <input type="hidden" name="notify_url" value="{$url_notificacao}" />

                    <!--Internacionalização e localização da página de pagamento-->
                    <input type="hidden" name="charset" value="utf-8" />
                    <input type="hidden" name="lc" value="BR" />
                    <input type="hidden" name="country_code" value="BR" />
                    <input type="hidden" name="currency_code" value="BRL" />

                    <input type="hidden" name="image_url" value="http://{$site}web-files/img/logo.png">

                    <!--Informações sobre o produto e seu valor-->
                    <input type="hidden" name="amount" value="{$pedido->TOTAL_PAYPAL}" />
                    <input type="hidden" name="item_name" value="Maria de Barro {$pedido->N_PEDIDO}" />
                    <input type="hidden" name="quantity" value="1" />

                    <!--Botão para submissão do formulário-->
                    <input type="image" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_buynowCC_LG.gif" border="0" />
                </form>  
            {/if}
            {if $forma_pgto == "moip"}         
                <form action="https://www.moip.com.br/PagamentoMoIP.do" method="post" target="_blank">
                    <input type="hidden" name="id_carteira" value="{$email_moip}">
                    <input type="hidden" name="valor" value="{$pedido->TOTAL_MOIP}">
                    <input type="hidden" name="nome" value="Maria de Barro {$pedido->N_PEDIDO}">   
                    <input type='image' name='submit' src='https://desenvolvedor.moip.com.br/sandbox/imgs/buttons/bt_pagar_c02_e04.png' alt='Pagar via Moip' border='0' />
                </form>
            {/if}
            {if $forma_pgto == "boleto"}         
                <a href="{$web_files}/produtos/boleto/pedido/{$CODPEDIDO}" target="_blank" class='btn btn-default' style='padding: 6px 8px;height: auto;line-height: auto;'>
                    <img src="{$web_files}/img/assets/band_boleto.png" alt="Boleto Bancário" title="Boleto Bancário"  border="0" style='margin-right: 5px;'/> Visualizar Boleto
                </a>
            {/if}
        </div>
    </div>



</div>
<div style="clear: both;"></div>

{include file="footer.tpl"}