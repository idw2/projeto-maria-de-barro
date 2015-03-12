{if $controle}   

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-justified navbar-checkout" role="tablist" style="font-size: 14px">
                <li {if $page eq "meus-pedidos"}class="active"{/if}><a href="/{$language}/conta/meus-pedidos/">Meus Pedidos</a></li>
                <li {if $page eq "meus-enderecos"}class="active"{/if}><a href="/{$language}/conta/endereco/">Meus Endereços</a></li>
                <li {if $page eq "meus-dados"}class="active"{/if}><a href="/{$language}/conta/meus-dados/">Meus Dados</a></li>
                <li {if $page eq "wishlist"}class="active"{/if}><a href='/{$language}/conta/wishlist'>Wishlist</a></li>
                    {*        <li {if $page eq "confirmacao"}class="active"{/if}><a href='/{$language}/produtos/checkout/'>Checkout</a></li>*}
            </ul>
            {*<ul class="nav nav-tabs nav-justified navbar-checkout" role="tablist" style="font-size: 14px">
            <li {if $page eq "resumo"}class="active"{/if}><a href="/{$language}/produtos/checkout/">Resumo</a></li>
            <li {if $page eq "login"}class="active"{/if}><a href="/{$language}/produtos/autenticacao/">Login</a></li>
            <li {if $page eq "endereco"}class="active"{/if}><a href="/{$language}/produtos/endereco/">Endereço</a></li>
            <li {if $page eq "pagamento"}class="active"{/if}><a href='/{$language}/produtos/pagamento'>Pagamento</a></li>
            <li {if $page eq "confirmacao"}class="active"{/if}><a href='/{$language}/produtos/confirmacao'>Confirmação</a></li>
            </ul>*}
        </div>
    </div>

{/if}