{counter assign=i start=1 print=false} 
{foreach item=chat from=$atendimentos_aberto}  
    {if $chat->CODATENDIMENTO != ""}    
        <tr {if $i % 2 == 1}class="myDragClass"{/if}>
            <td>{$i}</td>
            <td>{$chat->DTA}</td>
            <td>{$chat->NOME}</td>
            <td>{$chat->EMAIL}</td>
            {*<td>
               {if $chat->ON_LINE == "0"}
                    {$eye = "desative"}
                    {$stt = "1"}
                {else}
                    {$eye = ""}
                    {$stt = "0"}
                {/if}
                <a href="/{$language}/atendimento/on-line/{$stt}/{$chat->EMAIL}"><span class="ico-default-eye {$eye}" data-toggle="tooltip" {if $chat->ON_LINE == "0"} title="Off-Line" {else}  title="On-Line" {/if}><i class="fa fa-eye"></i></span></a> 
            </td>*}
            <td>
                <a href="/{$language}/atendimento/chat/{$chat->CODATENDIMENTO}"  class="btn btn-primary">Atender</a>
            </td>
        </tr>    
    {/if}
{counter}    
{/foreach} 
             