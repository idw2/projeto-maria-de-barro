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
            <!-- {include file="admin/search.tpl"} -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/produtos/cadastrar" method="post">


                <div class="row">
                    <div class="col-md-6 text-left">
                        <h2><span class="label label-default">Cadastro de Produtos</span></h2>
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
                            <div class="auto-img"><img src="{$web_files}/img/img_default.png" alt="" border="0" title="" class="img-responsive"/></div>
                            <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                            <div class="auto-price text-center" style="text-decoration: line-through"> R$ <span class="view-preco-de">0,00</span></div>
                            <div class="auto-price text-center"> R$ <span class="view-preco">0,00</span></div>
                            <div class="auto-title text-center view-nome">ANEL ZIRCONIA DUPLO</div>
                            <div class="text-center">
                                <a onclick="return false;" class="btn btn-default navbar-btn eu-quero">Eu quero</a> 
                            </div>
                        </div>

                        <h4 class="panel-heading x-label">Produto</h4>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="de" name="de" value='{$de}' placeholder="De" onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)"/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="preco" name="preco" value='{$preco}' placeholder="Para" onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)"/>
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="preco" name="quantidade" value='{$quantidade}' placeholder="Quantidade" onkeypress="return formataNumDV(event, this, 6);" />
                        </div>	
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="nome" name="nome" value='{$nome}' maxlength="40" placeholder="Nome"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="referencia" name="referencia" value='{$referencia}' maxlength="20" placeholder="Referência"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-lg" style="margin-bottom: 1%;">
                            <input type="text" class="form-control" id="peso" name="peso" maxlength="8" value='{$peso}' placeholder="Peso" onkeydown="javascript: return mascaraPeso(this, event, 5, 3);"/>
                        </div>


                        <br/>
                        <h4 class="panel-heading x-label">Categoria</h4>
                        <div class="input-group input-group-lg">
                            <select name="categoria" class="form-control">
                                <option value="aneis" {if $categoria == "aneis"}selected{/if}>Anéis</option>
                                <option value="brincos" {if $categoria == "brincos"}selected{/if}>Brinco</option>
                                <option value="colares" {if $categoria == "colares"}selected{/if}>Colares</option>
                                <option value="pulseiras" {if $categoria == "pulseiras"}selected{/if}>Pulseiras</option>
                                <option value="conjuntos" {if $categoria == "conjuntos"}selected{/if}>Conjuntos</option>
                            </select>
                        </div>                   

                        <br/> <br/>
                    </div>

                    <div class="col-md-5" style="padding-left: 0;">

                        <h4 class="panel-heading x-label">Descrição Rápida</h4>
                        <p><textarea class="form-control" rows="10" style="min-width: 100%" id="descricao" name="descricao">{$descricao}</textarea></p>
                        <br/> <br/>
                        <h4 class="panel-heading x-label">Mais Informações</h4>
                        <p><textarea class="form-control" rows="10" style="min-width: 100%" id="especificacoes" name="especificacoes">{$especificacoes}</textarea></p>
                        <br/> <br/>
                        <div class="input-group input-group-lg">
                            <button type="submit" class="btn btn-primary btn-lg btn-primary-maria" role="button">Enviar</button>
                        </div>

                    </div>
                    <div class="col-md-4" style="padding-left: 0;"></div>

                </div>

        </div>


        </form>
    </div>
</div>
</div>
{include file="admin/tinymce_2.tpl"}
{include file="admin/footer.tpl"}