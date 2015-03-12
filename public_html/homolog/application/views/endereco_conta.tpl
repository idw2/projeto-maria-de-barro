<div class="col-sm-6 col-sm-push-6">
    {if $sem_endereco == 0}
        <div class='alert alert-warning' role='alert'><strong>Atenção: </strong>Não existe endereços de entrega cadastrado</div>
    {/if}
    <form class="navbar-form navbar-left" name="formListenderecos" id="formListenderecos" style="width: 100%">    
        {counter assign=i start=1 print=false} 
        {foreach item=endereco from=$endereco_list}  
            {if $endereco->CODENDERECO != ""}
                {if $endereco->STATUS == "1"}
                    <h4 colspan='2'>{$i}. Endereço de entrega</h4>
                {else}
                    <h4 colspan='2'>{$i}. Endereço adicional</h4>
                {/if}
                <div class="">
                    <div class="panel-body">
                        <table class="table" style="font-size: 14px">
                            <tr>
                                <td rowspan='4'><input type='radio' value='{$endereco->STATUS}' name='prioridade' onclick="javascript:alter_endereco_entrega2('{$endereco->CODENDERECO}', '{$codcadastro}')" id='{$endereco->CODENDERECO}' {if $endereco->STATUS == "1"}checked="true"{/if}/></td>
                                <td>CEP:</td>
                                <td>{$endereco->CEP}</td> 
                                <td rowspan='4'><span class="plus" onclick="javascript:del_row_enderecos2('{$endereco->CODENDERECO}', '{$codcadastro}')"><i class="fa fa-times"></i></span></td>
                            </tr>    
                            <tr> <td>Endereço:</td><td>{$endereco->LOGRADOURO}, nº {$endereco->NUMERO} {if $endereco->COMPLEMENTO != ""}- {$endereco->COMPLEMENTO} {/if}</td> </tr>
                            <tr> <td>Bairro:</td><td>{$endereco->BAIRRO}</td> </tr>
                            <tr> <td>Cidade/UF:</td><td>{$endereco->CIDADE}/{$endereco->UF}</td> </tr>
                        </table>
                    </div>
                </div>
            {/if}    
            {counter}    
        {/foreach}
    </form>
</div> 

<div class="col-sm-6 col-sm-pull-6">
    <div class="panel panel-primary" >
        <div class="panel-body" style="border: solid 0 #e9e9e9;">
            {if $msg_erro != ""}
                <div class="alert alert-info" role="alert">{$msg_erro}</div>
            {/if}
            <form class="form" id="formulario_enderecos" method="post" onsubmit="return false">

                {if $erro eq ""}

                {else}
                    <div class="alert alert-danger" role="alert"  style="font-size: 15px;"><strong>Atenção: </strong>{$erro}</div>
                {/if}

                <div class="form-group">
                    <label for="cep" class="required">CEP</label>
                    <div class="form-inline">
                        <input type="text" class="form-control" id="cep" name="cep" maxlength="9" value="{$cep}" placeholder="CEP" style="margin-right: 15px;"/>
                        <span class="input-group" style="cursor: pointer; font-size: 15px;" id="pesquisar_endereco"><a>» Pesquisar</a></span>  
                        <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px"/></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cep" class="required">Endereço</label>
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
                    <label for="cep" class="required">Completemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="100" value="{$complemento}" placeholder="Complemento"/>
                </div>
                <div class="form-group">
                    <label for="cep" class="required">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50" value="{$bairro}" placeholder="Bairro"/>
                </div>
                <div class="form-group">
                    <label for="cep" class="required">Cidade / Estado</label>
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
                    <button type="submit" class="btn btn-default" name="enviar" onclick="javascript:cadastrar_endereco_conta();">Cadastrar endereço</button>
                    <span class="Loader-endereco hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px;"/></span>
                </div>
            </form>
        </div>
    </div>
</div>