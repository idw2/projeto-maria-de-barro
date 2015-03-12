{include file="header.tpl"}

<div class="container">
    <br/>   
    <div class="row">

        {include file="navbar2.tpl"}

    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="section-title">
                <h2>
                    <a href="#">
                        <strong>Cadastro</strong> de endereços
                    </a>
                </h2>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    {if $msg_erro != ""}
                        <div class="alert alert-info" role="alert">{$msg_erro}</div>
                    {/if}
                    <form class="form" method="post" action="/{$language}/produtos/endereco/">

                        {if $erro eq ""}
                            <div class="alert alert-success" role="alert"><strong>Atenção: </strong>Preencher todos os campos!</div>
                        {else}
                            <div class="alert alert-danger" role="alert"><strong>Atenção: </strong>{$erro}</div>
                        {/if}
                        <br/>

                        <h3>{$nome}</h3>

                        <div class="form-group form-inline">
                            <input type="text" class="form-control" id="cep" name="cep" maxlength="9" value="{$cep}" placeholder="CEP" style="margin-right: 15px;"/>
                            <span class="input-group" style="cursor: pointer;" id="pesquisar_endereco"><a>» Pesquisar</a></span>  
                            <span class="Loader hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px"/></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-sm-8">
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="140" value="{$logradouro}" placeholder="Endereço"/>
                                </div>
                                <div class="col col-sm-4">
                                    <input type="text" class="form-control" id="numero" name="numero" maxlength="5" value="{$numero}" placeholder="Nº" onkeypress="return formataNumDV(event, this, 6);"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="12" value="{$complemento}" placeholder="Complemento"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50" value="{$bairro}" placeholder="Bairro"/>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-sm-8">
                                    <input type="text" class="form-control" id="cidade" name="cidade" maxlength="80" value="{$cidade}" placeholder="Cidade"/>
                                </div>
                                <div class="col col-sm-4">
                                    <input type="text" class="form-control" id="estado" name="estado" maxlength="2" value="{$estado}" placeholder="UF"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-default" href="/{$language}/produtos/minha_conta/">VOLTAR</a>
                            <button type="submit" class="btn btn-default" name="enviar">ENVIAR</button>
                            <span class="Loader2 hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="navbar-form navbar-left" name="formListenderecos" id="formListenderecos" style="width: 100%">    
                {counter assign=i start=1 print=false} 
                {foreach item=endereco from=$endereco_list}  
                    {if $endereco->CODENDERECO != ""}
                        {if $endereco->STATUS == "1"}
                            <h4 colspan='2'>{$i}. Endereço de entrega</h4>
                        {else}
                            <h4 colspan='2'>{$i}. Endereço adicional</h4>
                        {/if}
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table" style="font-size: 14px">
                                    <tr>
                                        <td rowspan='4'><input type='radio' value='{$endereco->STATUS}' name='prioridade' onclick="javascript:alter_endereco_entrega('{$endereco->CODENDERECO}', '{$codcadastro}')" id='{$endereco->CODENDERECO}' {if $endereco->STATUS == "1"}checked="true"{/if}/></td>
                                        <td>CEP:</td>
                                        <td>{$endereco->CEP}</td> 
                                        <td rowspan='4'><span class="plus" onclick="javascript:del_row_enderecos('{$endereco->CODENDERECO}', '{$codcadastro}')"><i class="fa fa-times"></i></span></td>
                                    </tr>    
                                    <tr> <td>Endereço:</td><td>{$endereco->LOGRADOURO}, nº {$endereco->NUMERO} {if $endereco->COMPLEMENTO != ""}- {$endereco->COMPLEMENTO}{/if}</td> </tr>
                                    <tr> <td>Bairro:</td><td>{$endereco->BAIRRO}</td> </tr>
                                    <tr> <td>Cidade/UF:</td><td>{$endereco->CIDADE}/{$endereco->UF}</td> </tr>
                                </table>
                            </div>
                        </div>
                    {/if}    
                    {counter}    
                {/foreach}
            </form>
            {if $sem_endereco >= 1}
                <button type="submit" class="btn btn-primary" name="enviar" id='mais_enderecos'>+ ENDERECO</button>  
            {/if}

        </div>

    </div>
    <div>
        <ul class="pager">
            <li class="previous"><a href="/{$language}/produtos/checkout/">&larr; Continuar comprando</a></li>
                {if $sem_endereco}
                <li class="next"><a href="/{$language}/produtos/pagamento">Finalizar compra &rarr;</a></li>
                {/if}
        </ul>
    </div> 
</div>
<div style="clear: both;"></div>
<style>
    .endereco{
        cursor: pointer;
    }
</style>

{include file="footer.tpl"}