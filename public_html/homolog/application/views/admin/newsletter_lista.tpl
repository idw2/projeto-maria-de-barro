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
            
            <h2><span class="label label-default">Lista de Newsletter</span></h2>
            <br/>

            <div class="panel-default">
       
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Data cadastro</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Sexo</th>
                        <th>Situação</th>
                    </thead>
                    
                    {if $ERRO_NAO_NEWSLETTER == "ERRO_NAO_NEWSLETTER"}
                       <tr>
                          <td colspan="5">Não existe newsletter cadastrada!</td>
                       </tr>
                    {/if}
                    
                    {counter assign=i start=0 print=false} 
                    {foreach item=newsletter from=$newsletters}  
                        {if $newsletter->CODNEWSLETTER != ""}
                        <tbody>
                            <tr {if $i % 2 == 1}class="myDragClass"{/if}>
                                <td>{$newsletter->DTA}</td>
                                <td>{$newsletter->NOME}</td>
                                <td>{$newsletter->EMAIL}</td>
                                <td>{$newsletter->SEXO}</td>
                                <td>
                                    {if $newsletter->STATUS == "0"}
                                        {$eye = "desative"}
                                        {$stt = "1"}
                                    {else}
                                        {$eye = ""}
                                        {$stt = "0"}
                                    {/if}
                                    <a href="/{$language}/informacoes/newsletter_status/{$stt}/{$newsletter->EMAIL}"><span class="ico-default-eye {$eye}" data-toggle="tooltip" title="Status"><i class="fa fa-eye"></i></span></a>
                                </td>
                            </tr>
                        </tbody>
                        {/if}
                    {counter}    
                    {/foreach}
                    
                </table>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}