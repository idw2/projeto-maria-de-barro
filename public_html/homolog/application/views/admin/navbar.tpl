<nav class="navbar navbar-default" role="navigation">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse" style="padding-bottom: 3%; background: #e25f66">
        <div class="panel-heading"><h4>Painel Administrativo</h4></div>
        <ul class="nav nav-stacked" style="font-size: 14px;">
            <li {if $page eq "welcome"} class="active" {else} class="" {/if}><a href="/{$language}/admin/welcome">Home</a></li>
            
            {if $papel == "ADMINISTRADOR"}
               
                <div class="panel-heading"><h4>Produtos</h4></div>
                <li {if $page eq "produtos_lista"} class="active" {else} class="" {/if}><a href="/{$language}/produtos/produtos-lista">Lista</a></li> 
                {if $email_restricao == "thais@mariadebarro.com.br"}
                {else}
                <li {if $page eq "estoque"} class="active" {else} class="" {/if}><a href="/{$language}/produtos/estoque">Estoque</a></li> 
                <li {if $page eq "estoque-baixo"} class="active" {else} class="" {/if} {if $num_de_qntdd_produtos != 0}style="background: #fff;"{/if}><a href="/{$language}/produtos/estoque-baixo" style="position: relative; {if $num_de_qntdd_produtos != 0}color: #333{/if}">Estoque Baixo {if $num_de_qntdd_produtos != 0} <span style='background: #5F8DE2; display: inline-block; padding: 3px 10px; position: absolute; color: #fff; font-weight: bold; font-size: 19px; bottom: 3px; right: 7px;'>{$num_de_qntdd_produtos}</span> {/if}</a></li> 
                {/if}
                <li {if $page eq "avise-me"} class="active" {else} class="" {/if} {if $existe_avise_me != 0}style="background: #fff;"{/if}><a href="/{$language}/produtos/avise-me" style="position: relative; {if $existe_avise_me != 0}color: #333{/if}">Avise-me quando chegar {if $existe_avise_me != 0} <span style='background: #5F8DE2; display: inline-block; padding: 3px 10px; position: absolute; color: #fff; font-weight: bold; font-size: 19px; bottom: 15px; right: 7px;'>{$existe_avise_me}</span> {/if}</a></li>  
                <li {if $page eq "mais-vendidos-site"} class="active" {else} class="" {/if}><a href="/{$language}/produtos/mais-vendidos-site">Mais Vendidos</a></li> 
                <div class="panel-heading"><h4>Contas</h4></div>
                <li {if $page eq "conta-lista"} class="active" {else} class="" {/if}><a href="/{$language}/conta/lista">Clientes</a></li>
                <li {if $page eq "aniversariantes-lista"} class="active" {else} class="" {/if} {if $existe_aniversariantes != 0}style="background: #fff;"{/if}><a href="/{$language}/conta/aniversariantes" style="position: relative; {if $existe_aniversariantes != 0}color: #333{/if}">Aniversariantes {if $existe_aniversariantes != 0} <span style='background: #5F8DE2; display: inline-block; padding: 3px 10px; position: absolute; color: #fff; font-weight: bold; font-size: 19px; bottom: 4px; right: 7px;'>{$existe_aniversariantes}</span> {/if}</a></li>
                
                {*{if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}
                {else}*}
                <div class="panel-heading"><h4>Pagamentos</h4></div>
                <li {if $page eq "pedidos_lista"} class="active" {else} class="" {/if}><a href="/{$language}/pedidos/pedidos-lista">Lista</a></li>
                <li {if $page eq "exportar"} class="active" {else} class="" {/if}><a href="/{$language}/pedidos/exportar">Exportar</a></li>
               {* {/if}*}
                <div class="panel-heading"><h4>Newsletter</h4></div>
                <li {if $page eq "newsletter_lista"} class="active" {else} class="" {/if}><a href="/{$language}/informacoes/newsletter-lista">Lista</a></li>
                {*<div class="panel-heading"><h4>Atendentes</h4></div>
                <li {if $page eq "atendentes_lista"} class="active" {else} class="" {/if}><a href="/{$language}/admin/atendentes-lista">Lista</a></li>*}
                {if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}
                {else}
                <div class="panel-heading"><h4>Nota Fiscal</h4></div>
                <li {if $page eq "nota-fiscal"} class="active" {else} class="" {/if} {if $existe_novos_produtos_cadastrados != 0}style="background: #fff;"{/if}><a href="/{$language}/nota-fiscal/exportar" style="position: relative; {if $existe_novos_produtos_cadastrados != 0}color: #333{/if}">Exportar {if $existe_novos_produtos_cadastrados != 0} <span style='background: #5F8DE2; display: inline-block; padding: 3px 10px; position: absolute; color: #fff; font-weight: bold; font-size: 19px; bottom: 4px; right: 7px;'>{$existe_novos_produtos_cadastrados}</span> {/if}</a></li>
                {/if}
                <div class="panel-heading"><h4>Páginas</h4></div>
                <li {if $page eq "quem_somos"} class="active" {else} class="" {/if}><a href="/{$language}/html/quem_somos">Quem somos</a></li>
                <li {if $page eq "promocoes"} class="active" {else} class="" {/if}><a href="/{$language}/html/promocoes">Promoções</a></li>
                <li {if $page eq "programa_vantagens"} class="active" {else} class="" {/if}><a href="/{$language}/html/programa-vantagens">Programa de Vantagens</a></li>              
                <li {if $page eq "programa_fidelidade"} class="active" {else} class="" {/if}><a href="/{$language}/html/programa-fidelidade">Programa de Fidelidade</a></li>              
                <li {if $page eq "politica_privacidade"} class="active" {else} class="" {/if}><a href="/{$language}/html/politica-privacidade">Política de Privacidade</a></li>              
                <li {if $page eq "termos_servicos"} class="active" {else} class="" {/if}><a href="/{$language}/html/termos-servicos">Termos de serviço</a></li>              
                <li {if $page eq "forma_pagamento"} class="active" {else} class="" {/if}><a href="/{$language}/html/forma-pagamento">Forma de Pagamento</a></li>              
                <li {if $page eq "entrega_devolucao"} class="active" {else} class="" {/if}><a href="/{$language}/html/entrega-devolucao">Entrega e Devolução</a></li>              
                <li {if $page eq "procon_rj"} class="active" {else} class="" {/if}><a href="/{$language}/html/procon-rj">PROCON-RJ</a></li>              
                <li {if $page eq "perguntas_frequentes"} class="active" {else} class="" {/if}><a href="/{$language}/html/perguntas-frequentes">Perguntas Frequentes</a></li>              
                <li {if $page eq "cuidados_produtos"} class="active" {else} class="" {/if}><a href="/{$language}/html/cuidados-produtos">Cuidado com os Produtos</a></li>              
            
            {else}
                
                <div class="panel-heading"><h4>Status</h4></div>
                <li {if $page eq "meu_status"} class="active" {else} class="" {/if}><a href="/{$language}/atendimento/meu-status">Meu status</a></li> 
                <div class="panel-heading"><h4>Atendimento</h4></div>
                <li {if $page eq "meus_atendimentos"} class="active" {else} class="" {/if}><a href="/{$language}/atendimento/meus-atendimentos">Meus atendimentos</a></li> 
            
            {/if}
            
            <div class="panel-heading"><h4>Serviços</h4></div>
            <li {if $page eq "alterar_senha"} class="active" {else} class="" {/if}><a href="/{$language}/admin/alterar-senha">Alterar senha</a></li>              
            <li {if $page eq "logout"} class="active" {else} class="" {/if}><a href="/{$language}/admin/logout">Sair</a></li>              
            
        </ul>     
    </div><!-- /.navbar-collapse -->
</nav>