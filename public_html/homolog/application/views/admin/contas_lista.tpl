{include file="admin/header.tpl"}

{*
 {foreach item=compras from=$compras_all}  
     
     update compras set nome=(select p.nome from produtos as p where p.codproduto='{$compras->CODPRODUTO}') where codcompra='{$compras->CODCOMPRA}';<br/>
     
 {/foreach}  
 *}

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

            <h2><span class="label label-default">Lista de Clientes</span></h2>
            <br/>
{*            <a href="/{$language}/conta/pdf-aniversariantes" target="_blank" class="btn btn-default navbar-btn"><i class="fa fa-file-pdf-o"></i> Aniversariantes do Mês</a>*}
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>

            <div class="panel-default">
       
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nascimento</th>
                        <th>Sexo</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Ações</th>
                    </thead>
                    
                    {counter assign=i start=1 print=false} 
                    {foreach item=conta from=$contas}  
                       {if $conta->CODCADASTRO != ""}
                            <tr {if $i % 2 == 0 }class="myDragClass"{/if}>
                                <td>{$conta->DTA}</td>
                                <td>{$conta->NOME}</td>
                                <td>{$conta->EMAIL}</td>
                                <td>{$conta->NASCIMENTO}</td>
                                <td>{$conta->SEXO}</td>
                                <td>({$conta->DDD}){$conta->TELEFONE} {if $conta->RAMAL != ""}<br/>Ramal: {$conta->RAMAL}{/if}</td>
                                <td>{$conta->CPF}</td>
                                {if $conta->STATUS == "0"}
                                    {$eye = "desative"}
                                    {$stt = "1"}
                                {else}
                                    {$eye = ""}
                                    {$stt = "0"}
                                {/if}  
                                <td>
                                    <a href="/{$language}/conta/status/{$stt}/{$conta->CODCADASTRO}"><span class="ico-default-eye {$eye}" data-toggle="tooltip" title="Status"><i class="fa fa-eye"></i></span></a>
                                    <a href="/{$language}/conta/editar/{$conta->CODCADASTRO}"><span class="ico-default-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-edit"></i></span></a>
                                </td>
                            </tr>     
                        {/if}                      
                        {counter}
                    {/foreach}  

                    
                </table>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}