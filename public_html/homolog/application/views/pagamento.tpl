{counter assign=i start=1 print=false} 
{foreach item=endereco from=$endereco_list}  
    {if $endereco->CODENDERECO != "" && $endereco->STATUS == "1"}
        {assign var="CEP" value="{$endereco->CEP}"}
        {assign var="CODENDERECO" value="{$endereco->CODENDERECO}"}
    {/if}    
    {counter}    
{/foreach}


<p style="text-align: center">
    <img src="{$web_files}/img/transportadoras.jpg" alt="Métodos de Envio" title="Métodos de Envio" border="0" style="width: 268px;"/><br>
    (*) Método de envio preferêncial Total Express Transportadora<br>
    (*) Atenção: Alguns serviços de entrega de encomenda poderão não estar disponíveis em algumas localidades 
</p>
<div class="row">
{*    <div class="col-lg-8">    *}
    <div class="col-lg-12">    
        {if $nenhum_produto == false}   
            <div class="">    
                <table class="table" style="font-size: 14px">
                    <thead>
                        <tr>
                            <th>Estimar custo de envio da encomenda.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="hidden" class="form-control" id="total_peso" name="total_peso" value="{$total_peso}"/>
                            <input type="hidden" class="form-control" id="cep_destinatario_2" name="cep_destinatario_2" value="{$cep_remetente}"/>
                            <input type="text" class="form-control" id="cep_destinatario" name="cep_destinatario" maxlength="8" value="{$CEP}" onkeypress="return formataCEP(event, this);" placeholder="Insira seu CEP" style="width: 50%" readonly="readonly"/>
                            <br>
                            <label>Tipo de encomenda</label>
                            <select id="forma_envio" class="form-control myFormaEnvio" style="width: 50%">
                                <option value="total_express">Total Express - Transportadora</option>
                                <option value="41106" selected>Correios - PAC</option>
                                <option value="40010">Correios - SEDEX</option>
                                <option value="40215">Correios - SEDEX 10</option>
                                <option value="40290">Correios - SEDEX hoje</option>
                                <option value="Retirada na Loja">Retirada na Loja</option>
                                {*<option value="81019">e-SEDEX</option>*}
                            </select><span class="Loader hide" style="text-align: center; width: 100%; display: inline-block; padding-top: 17px;"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 21px;"/></span>
                            <span id="msg_erro"></span>
                            {*<button type="button" id="btn_cep" class="btn btn-primary btn-lg btn-primary-maria" role="button">Entrar</button>*}


                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        {/if}
    </div>
</div>
<div style="clear: both;"></div>
