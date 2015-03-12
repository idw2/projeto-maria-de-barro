
{if $nenhum_produto == true}
    <tr>
        <th colspan="10">Nenhum produto na sua Lista de Desejos!</th>
    </tr>
{else}    
    {foreach item=lista_desejo from=$ld}  
        <tr>
            <td><a href="/{$language}/descricao/categoria/{$lista_desejo->CATEG}/{$lista_desejo->URL_AMIGAVEL}"><img src="{$lista_desejo->FOTO}" alt="{$lista_desejo->NOME}" title="{$lista_desejo->NOME}" border="0"/></a><br/></td>
            <td style="text-transform: uppercase;">
                {$lista_desejo->NOME}
                {if $lista_desejo->ALERT != ""}
                    <br/><span style="color: #df5d65; font-size: 10px; font-weight: bold;">{$lista_desejo->ALERT}</span>
                {/if}
            </td>
            <td>{$lista_desejo->REFERENCIA}</td>
            <td>{$lista_desejo->PRECO}</td>
            <td id="n_input">
                <table>
                    <tr>
                        <td><span style="cursor: pointer;" class="minus" onclick="javascript:plus_wishlist_checkout('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=menos&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Menos item"><i class="fa fa-minus-square"></i></span>&nbsp;</td>
                        <td><input type="text" name="quantidade" id="input_{$lista_desejo->CODLISTADESEJOS}"  style="width: 44px; text-align: center;" value="{$lista_desejo->QUANTIDADE}" readonly="readonly"/></td>
                        <td>&nbsp;<span style="cursor: pointer;" class="plus" onclick="javascript:plus_wishlist_checkout('{$url_checkout}{$lista_desejo->CODPRODUTO}&COMANDO=mais&CODLISTADESEJOS={$lista_desejo->CODLISTADESEJOS}&imposto={$imposto}', '{$lista_desejo->CODLISTADESEJOS}');" title="Mais item"><i class="fa fa-plus-square"></i></span></td>
                    </tr>
                </table>                
            </td>
            <td  id="preco_total_produto_{$lista_desejo->CODLISTADESEJOS}"> {if $lista_desejo->TOTAL eq ""}0,00{else}{$lista_desejo->TOTAL}{/if}</td>
            <td><span onclick="javascript:del_row_wishlist('{$url_checkout}{$lista_desejo->CODPRODUTO}')"><i class="fa fa-times"></i></span></td>
        </tr>
    {/foreach} 
    <tr>
        <td colspan="10" valign="center">
            <img src="{$web_files}/img/present.png" border="0" alt="Embalagem para presente" alt="Embalagem para presente"/> <strong>Deseja que embale para presente?</strong> <span style="cursor: pointer; color: #df5d65; font-style: italic;" onclick="embalar_presente()"/>Clique aqui</span> <span {if $embalar_presente eq "1" }class="yes"{else}class="yes hide"{/if}> &nbsp;<img src="{$web_files}/img/yes.png" alt="OK" title="OK" border="0"/></span>
            <style>
                .panel-toggle{
                    background: #EFEDED;
                    border-bottom: solid 2px #D2D2D2 !important;
                    padding: 12px;
                }
            </style>
        </td>
    </tr>
{/if}

