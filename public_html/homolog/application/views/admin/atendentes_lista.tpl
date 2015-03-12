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

            <h2><span class="label label-default">Lista de Atendentes</span></h2>
            <br/>
            <a href="/{$language}/admin/cadastrar_atendente" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-user"></i> Cadastrar Atendente</a>
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>

            <div class="panel-default">
       
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Data cadastro</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Sexo</th>
                        <th>Situação</th>
                    </thead>
                    
                   {if $ERRO_NAO_EXITE_ATENDENTE == "ERRO_NAO_EXITE_ATENDENTE"}
                       <tr>
                          <td colspan="5">Não existe atendentes cadastrados!</td>
                       </tr>
                    {/if}
                    
                    {counter assign=i start=0 print=false} 
                    {foreach item=atendente from=$atendentes}  
                        {if $atendente->CODCONTA != ""}
                        <tbody>
                            <tr {if $i % 2 == 1}class="myDragClass"{/if}>
                                <td>{$atendente->DTA}</td>
                                <td>{$atendente->NOME}</td>
                                <td>{$atendente->EMAIL}</td>
                                <td>{$atendente->SEXO}</td>
                                <td>
                                    {if $atendente->STATUS == "0"}
                                        {$eye = "desative"}
                                        {$stt = "1"}
                                    {else}
                                        {$eye = ""}
                                        {$stt = "0"}
                                    {/if}
                                    <a href="/{$language}/admin/status/{$stt}/{$atendente->EMAIL}"><span class="ico-default-eye {$eye}" data-toggle="tooltip" title="Status"><i class="fa fa-eye"></i></span></a>
                                    <a href="/{$language}/admin/editar/{$atendente->EMAIL}"><span class="ico-default-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-edit"></i></span></a>                             
                                    <a onclick="delete_produto('{$language}/admin/delete/{$atendente->EMAIL}')"><span class="ico-default-trash" data-toggle="tooltip" title="Excluir"><i class="fa fa-trash-o"></i></span></a>
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