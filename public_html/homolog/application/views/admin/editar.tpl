{include file="admin/header.tpl"}

<div class="sidebar">
    {include file="admin/navbar.tpl"}
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                {include file="admin/logo.tpl"}
            </div>
            {include file="admin/search.tpl"}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/produtos/editar/{$url_amigavel}" method="post">

                <div class="row">
                    <div class="col-md-6 text-left">
                        <h2><span class="label label-default">Editar Produto</span></h2>
                    </div>
                    <br/>
                    <div class="col-md-6 text-right">
                        <a href="/{$language}/produtos/produtos_lista" class="btn btn-default navbar-btn"><i class="fa fa-reply">&nbsp</i> Voltar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-left">
                        {if $erro eq ""}

                            <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>

                        {else}

                            {if $sucesso eq FALSE}
                                <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                            {else}
                                <div class="alert alert-success" role="alert">{$erro}</div>	
                            {/if}

                        {/if}

                    </div>
                    <div class="col-md-6 text-right"></div>
                </div>

                <div class="row">

                    <div class="col-md-3 text-left">

                        <h4 class="panel-heading x-label">Preview</h4>
                        <div class="thumbnail env-produto" style="margin: 0;"> 
                            {if $foto_destaque eq ""}
                                <div class="auto-img"><img src="{$web_files}/img/img_default.png" alt="" border="0" title="" class="img-responsive"/></div>
                                {else}
                                <div class="auto-img"><img src="{$foto_destaque}" alt="" border="0" title="" class="img-responsive"/></div>
                                {/if}  
                            <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                            <div class="auto-price text-center"> R$ <span class="view-preco">{$produto->PRECO}</span></div>
                            <div class="auto-title text-center view-nome">{$produto->NOME}</div>
                            <div class="text-center">
                                <a onclick="return false;" class="btn btn-default navbar-btn eu-quero">Eu quero</a> 
                            </div>
                        </div>

                        <h4 class="panel-heading x-label">Produtos</h4>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="de" name="de" placeholder="De" value="{$produto->DE}"  onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)" {if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}readonly="readonly"{/if}/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="preco" name="preco" placeholder="Para" value="{$produto->PRECO}" onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)" {if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}readonly="readonly"{/if}/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="preco" name="quantidade" placeholder="Quantidade" value="{$produto->QUANTIDADE}" onkeypress="return formataNumDV(event, this, 6);" {if $email_restricao == "fabiano@mariadebarro.com.br" || $email_restricao == "thais@mariadebarro.com.br"}readonly="readonly"{/if}/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="40" value="{$produto->NOME}" placeholder="Nome"/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="referencia" name="referencia" maxlength="20" value="{$produto->REFERENCIA}" placeholder="Referência"/>
{*                            <label>Referência: {$produto->REFERENCIA}</label>*}
                        </div>
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="peso" name="peso" maxlength="8" value="{$produto->PESO}" placeholder="Peso" onkeydown="javascript: return mascaraPeso(this, event, 5, 3);"/>
                        </div>

                        <br/>
                        <h4 class="panel-heading x-label">Categoria</h4>
                        <div class="input-group input-group-lg">

                            {if $produto->CATEGORIA eq "aneis"}
                                {$active_1 = "selected"}
                            {elseif $produto->CATEGORIA == "brincos"}    
                                {$active_2 = "selected"}
                            {elseif $produto->CATEGORIA == "colares"}    
                                {$active_3 = "selected"}
                            {elseif $produto->CATEGORIA == "pulseiras"}    
                                {$active_4 = "selected"}
                            {else}
                                {$active_5 = "selected"} 
                            {/if}    

                            <select name="categoria" class="form-control">

                                <option value="aneis" {$active_1}>Anéis</option>
                                <option value="brincos" {$active_2}>Brinco</option>
                                <option value="colares" {$active_3}>Colares</option>
                                <option value="pulseiras" {$active_4}>Pulseiras</option>
                                <option value="conjuntos" {$active_5}>Conjuntos</option>

                            </select>
                        </div>

                    </div>

                    <div class="col-md-5" style="padding-left: 0;">

                        <h4 class="panel-heading x-label">Descrição Rápida</h4>
                        <p><textarea class="form-control" rows="10" style="min-width: 100%" id="descricao" name="descricao">{$produto->DESCRICAO}</textarea></p>
                        <br/> <br/>
                        <h4 class="panel-heading x-label">Mais Informações</h4>
                        <p><textarea class="form-control" rows="10" style="min-width: 100%" id="especificacoes" name="especificacoes">{$produto->ESPECIFICACOES}</textarea></p>
                        <br/> <br/>

                        <div class="input-group input-group-lg">
                            <button type="submit" class="btn btn-primary btn-lg btn-primary-maria" role="button">Enviar</button>
                        </div>

                    </div> 
                    <div class="col-md-4" style="padding-left: 0;"></div>

                </div>


            </form>
        </div>
    </div>
</div>
{include file="admin/tinymce_2.tpl"}
{include file="admin/footer.tpl"}