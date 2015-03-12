<div class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
        <a href="#" class="brand-circle"><img src="{$web_files}/img/brand-circle.png"></a>
        <ul class="nav navbar-nav">
            {if $nome_logon == ""}
                <li><a href="/{$language}/conta/login-cadastro/" id="nav-login">Login e Cadastro</a></li>
                {else}
                <li><strong style="display: inline-block; line-height: 50px; color: #df5d65;">{$saudacao} {$nome_logon}!</strong></li>
                <li><a href="/{$language}/conta/" id="nav-login" style="display: inline-block;"> Minha conta</a></li>
                {/if}

            {*<li><a onclick="open_atendimento()" style="cursor: pointer;">Atendimento Online</a></li>*}
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/{$language}/informacoes/newsletter">Newsletter</a></li>
                {if $nome_logon != ""}
                <li><a href="/{$language}/conta/wishlist">Wishlist</a></li>
                {/if}
            <li>
                <a id="shopping-cart" href="/{$language}/produtos/checkout/" class="btn-with-icon fa fa-shopping-cart">
                    {if $total_produtos eq "" }

                    {else}
                        <span class="label label-primary">{$total_produtos}</span>
                    {/if}
                    Meu Carrinho
                </a>
            </li>
            {if $nome_logon != ""}
                <li><a href="/{$language}/conta/sair" id="nav-login" style="display: inline-block;">Sair</a></li>    
                {/if}
                {* CARRINHO COM DROPDOWN *}

            {*<li class="dropdown">
            <a href="/{$language}/produtos/checkout/" class="dropdown-toggle btn-with-icon fa fa-shopping-cart" data-toggle="dropdown">
            {if $total_produtos eq "" }
            {else}
            <span class="label label-primary">{$total_produtos}</span>
            {/if}
            Meu Carrinho
            </a>
            <ul class="dropdown-menu" role="menu">
            <li><a href="#">-</a></li>
            <li class="divider"></li>
            <li class="dropdown-footer">
            <a class="btn btn-primary btn-block" href="#">Checkout</a>
            </li>
            </ul>
            </li>*}
            {*<li><a href="#">Checkout</a></li>*}

        </ul>
    </div>
</div>
<div class="container header-brand">
    <div class="row">
        <div class="col-sm-6 col-brand">
            <a href="/{$language}/" class="brand"><img src="{$web_files}/img/logo.png" alt="Maria de Barro" border="0" title="" class="img-responsive"/></a>
        </div>
        <div class="col-sm-6 text-right col-chart">
            <p>
                <a href="tel:+5521995765038"><span class="icon-whatsapp"></span> 21 99576.5038</a><br/>
                <a href="tel:+552132835265"><span class="fa fa-phone" style="margin-right: 12px"></span> 21 3283.5265</a>
            </p>
        </div>
    </div>
</div>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <a href="#" class="hamburger">
                    <span class="sr-only">Menu</span>
                    <span class="bar"></span>
                </a>
            </div>
            {include file="navbar.tpl"}
        </div>
    </div>
</nav>