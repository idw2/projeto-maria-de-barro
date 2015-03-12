{include file="header.tpl"}

<section class="pag-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                {*<div class="section-title">
                <h2>
                <strong>Recem</strong> Chegados
                </h2>
                </div>*}
                {*<ul class="nav nav-tabs" role="tablist">
                <li {if $page eq "index" or $page eq "produtos_novos"} class="active" {else} class="" {/if}><a href="/{$language}/" style="">Produtos Novos</a></li>
                <li {if $page eq "mais_vendidos"} class="active" {else} class="" {/if}><a href="/{$language}/categoria/mais_vendidos/">Mais vendidos</a></li>                        
                <li {if $page eq "promocoes"} class="active" {else} class="" {/if}><a href="/{$language}/categoria/promocoes/">Promoções</a></li>                        
                </ul>*}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="page-controls">
                    <ul class="pagination">
                        <li {if $btn_anterior == ""}class="disabled"{/if} >{if $btn_anterior == ""}<span>« Anterior</span>{else}<a href="{$btn_anterior}">« Anterior</a>{/if}</li>
                            {foreach item=pgn from=$paginacao}
                                {if $total_produto != 0}
                                    {if $pagina == $pgn }
                                    <li class="active"><a href="#">{$pgn} <span class="sr-only">(atual)</span></a></li>
                                    {else}
                                        {if $search == ""}

                                        {if $categoria == "geral"}
                                            <li><a href="/{$language}/novos-produtos/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}">{$pgn}</a></li>
                                            {else}
                                            <li><a href="/{$language}/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}">{$pgn}</a></li>                                            
                                            {/if}         

                                    {else}

                                        {if $categoria == "geral"}
                                            <li><a href="/{$language}/novos-produtos/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}/search/{$search}">{$pgn}</a></li>
                                            {else}
                                            <li><a href="/{$language}/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}/search/{$search}">{$pgn}</a></li>                                            
                                            {/if}

                                    {/if}
                                {/if}                        
                            {/if}                         
                        {/foreach}

                        {*<li><span class="dots">...</span></li>
                        <li><a href="#">10</a></li>*}

                        <li class="{if $btn_proximo == ""}disabled{/if}"><a href="{if $btn_proximo == ""}#{else}{$btn_proximo}{/if}">Próxima »</a></li>
                    </ul>
                    <div class="form-inline page-controls-options">
                        <label>Mostrar por: <select name="selectPrductSort" id="selectPrductSort" class="form-control">
                                <option value="">--</option>
                                <option value="mais-novos" {if $sort == "mais_novos"}selected{/if}>Mais novos</option>
                                <option value="preco-crescente" {if $sort == "preco_crescente"}selected{/if}>Preço: Menor para o maior</option>
                                <option value="preco-decrescente" {if $sort == "preco_decrescente"}selected{/if}>Preço: Maior para o menor</option>
                                <option value="nome-crescente" {if $sort == "nome_crescente"}selected{/if}>Listar por nome: A para o Z</option>
                                <option value="nome-decrescente" {if $sort == "nome_decrescente"}selected{/if}>Listar por nome: Z para o A</option>
                                <option value="quantidade" {if $sort == "quantidade"}selected{/if}>Em estoque</option>
                            </select>
                        </label>
                        {if $categoria == "geral"}
                            {if $search == ""}
                                <input type="hidden" name="url" id="url" value="/{$language}/novos-produtos"/>
                            {else}
                                <input type="hidden" name="url" id="url" value="/{$language}/novos-produtos/search/{$search}"/>
                            {/if}    
                        {else}
                            <input type="hidden" name="url" id="url" value="/{$language}/{$categoria}"/>
                        {/if}
                        <input type="hidden" name="pagina" id="pagina" value="{if $pagina != ""}{$pagina}{/if}"/>
                        <input type="hidden" name="qntdd_produtos" id="qntdd_produtos" value="{if $qntdd != ""}{$qntdd}{/if}"/>
                    </div>
                </div>
                <div class="divisor-dashed"></div>
            </div>
        </div> 

        <div class="row">
            {foreach item=produto from=$arr}
                {if $produto->CODPRODUTO != ""}
                    <div class="col-thumb col-xs-6 col-sm-3">
                        <div class="thumbnail">
                            <div class="thumbnail-img">
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    {if $produto->IS_NOVO eq 1}
                                        <span class="thumbnail-tag">Novo</span>
                                    {/if}
                                    <img src="{$produto->CROP268}" alt="{$produto->NOME}" border="0" title="{$produto->NOME}" class="img-responsive" width="261" height="289"/>
                                </a>
                            </div>
                            <div class="thumbnail-infos">
                                <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                                {*                                    <div class="">diferença de R$ {$produto->DIFERENCA}</div>*}
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-subtitle">{$produto->NOME}</div>
                                </a>
                                <a href="/{$language}/{$produto->CATEGORIA}/{$produto->URL_AMIGAVEL}">
                                    <div class="thumbnail-title">{if $produto->IS_PROMOCAO eq 1}<span class="price-through">R$ {$produto->DE}</span>{/if} R$ {$produto->PRECO}</div>
                                </a>
                                <span class="ou"></span>
                                <div class="thumbnail-infos-highlight"><strong>6x</strong> de <strong>R$ {$produto->PRECO_6}</strong></div>
                                {*<div class="thumbnail-btn">
                                <a onclick="javascript:add_checkout_list('{$lista_desejos}{$produto->CODPRODUTO}', '/{$language}/produtos/checkout/', 'Loader_{$produto->CODPRODUTO}')" class="btn btn-light">Eu quero</a>
                                <span class="Loader_{$produto->CODPRODUTO} Load_paralelo hide">
                                <img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="25" height="25"/>
                                </span>
                                </div>*}
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="page-controls">
                    <ul class="pagination">
                        <li {if $btn_anterior == ""}class="disabled"{/if} >{if $btn_anterior == ""}<span>« Anterior</span>{else}<a href="{$btn_anterior}">« Anterior</a>{/if}</li>
                            {foreach item=pgn from=$paginacao}
                                {if $total_produto != 0}
                                    {if $pagina == $pgn }
                                    <li class="active"><a href="#">{$pgn} <span class="sr-only">(atual)</span></a></li>
                                    {else}
                                        {if $search == ""}

                                        {if $categoria == "geral"}
                                            <li><a href="/{$language}/novos-produtos/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}">{$pgn}</a></li>
                                            {else}
                                            <li><a href="/{$language}/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}">{$pgn}</a></li>                                            
                                            {/if}         

                                    {else}

                                        {if $categoria == "geral"}
                                            <li><a href="/{$language}/novos-produtos/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}/search/{$search}">{$pgn}</a></li>
                                            {else}
                                            <li><a href="/{$language}/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$pgn}/search/{$search}">{$pgn}</a></li>                                            
                                            {/if}

                                    {/if}                                    
                                {/if}                        
                            {/if}                         
                        {/foreach}

                        {*<li><span class="dots">...</span></li>
                        <li><a href="#">10</a></li>*}

                        <li class="{if $btn_proximo == ""}disabled{/if}"><a href="{if $btn_proximo == ""}#{else}{$btn_proximo}{/if}">Próxima »</a></li>
                    </ul>
                    <div class="form-inline page-controls-options">
                        <label>Mostrar por: <select name="selectPrductSort_2" id="selectPrductSort_2" class="form-control">
                                <option value="">--</option>
                                <option value="mais_novos" {if $sort == "mais_novos"}selected{/if}>Mais novos</option>
                                <option value="preco-crescente" {if $sort == "preco_crescente"}selected{/if}>Preço: Menor para o maior</option>
                                <option value="preco-decrescente" {if $sort == "preco_decrescente"}selected{/if}>Preço: Maior para o menor</option>
                                <option value="nome-crescente" {if $sort == "nome_crescente"}selected{/if}>Listar por nome: A para o Z</option>
                                <option value="nome-decrescente" {if $sort == "nome_decrescente"}selected{/if}>Listar por nome: Z para o A</option>
                                <option value="quantidade" {if $sort == "quantidade"}selected{/if}>Em estoque</option>
                            </select>
                        </label>


                        {if $categoria == "geral"}
                            {if $search == ""}
                                <input type="hidden" name="url" id="url" value="/{$language}/novos-produtos"/>
                            {else}
                                <input type="hidden" name="url" id="url" value="/{$language}/novos-produtos/search/{$search}"/>
                            {/if}    
                        {else}
                            <input type="hidden" name="url" id="url" value="/{$language}/{$categoria}"/>
                        {/if}



                        <input type="hidden" name="pagina" id="pagina" value="{if $pagina != ""}{$pagina}{/if}"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{include file="footer.tpl"}