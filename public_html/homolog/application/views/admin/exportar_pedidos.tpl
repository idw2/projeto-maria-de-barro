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
            {*{include file="admin/search.tpl"}*}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <h2><span class="label label-default">Exportar Pedidos </span></h2>
            <br/>
            
            <br/>
            <a href="/{$language}/pedidos/exportar-endereco" class="btn btn-default navbar-btn"><i class="fa fa-exchange"></i> Exportar endereço</a>
            <div class="panel-default">
       
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th style="width: 15%">Data Exportação</th>
                        <th>Tipo</th>
                        <th style="width: 20%">Link</th>
                        <th style="width: 15%" align='center'><center>Planilha</center></th>
                        <th style="width: 15%" align='center'><center>Bloco de Textos<BR/>(MAC e LINUX)</center></th>
                        <th style="width: 15%" align='center'><center>Bloco de Textos (WINDOWS)</center></th>
                    </thead>
                   {counter assign=i start=0 print=false} 
                   {foreach item=arq_xls from=$arquivo_xls_resultado} 
                      {if $arq_xls->CODXLS != ""}
                        <tbody>
                             <tr {if $i % 2 == 1}class="myDragClass"{/if}>
                                 <td>{$arq_xls->DTA}</td>
                                 <td>{$arq_xls->TIPO}</td>
                                 <td>
{*                                     <textarea class="form-control">{$arq_xls->LINK}</textarea>*}
                                     {$arq_xls->LINK}
                                 </td>
                                 <td align='center'>
                                     <a href="{$arq_xls->LINK}" target="_blank" download="Planilha Endereços de Entrega.xls"><i class="fa fa-download"></i></a>
                                 </td>
                                 <td align='center'>
                                     <a href="{$arq_xls->LINK2}" target="_blank" download="Endereços de Entrega.txt"><i class="fa fa-download"></i></a>
                                 </td>
                                 <td align='center'>
                                     <a href="{$arq_xls->LINK3}" target="_blank" download="Endereços de Entrega.txt"><i class="fa fa-download"></i></a>
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