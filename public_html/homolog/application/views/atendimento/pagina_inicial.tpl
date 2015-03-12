<div style="padding: 15%; font-size: 18px; line-height: 2;">
<h3 style="color: #df5d65">Entre com seus dados!</h3>
<input type="text" class="form-control" name="nome" id="nome" value="{$nome}" placeholder="Seu nome" style="margin-bottom: 9px;"/>
<input type="text" class="form-control" name="email" id="email" value="{$email}"  placeholder="Seu e-mail"/>
<input type="checkbox" name="enviar_email" id="enviar_email" {if $enviar_email eq 1} checked="true" {/if}/> Desejo que me envie esta conversa por e-mail assim que terminar.<br/>
<button type="button"  class="btn btn-primary" onclick="javascript:init_chat();" >Enviar</button>
<span class="atendimento_loading hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="20%" style="opacity:1"/></span>
<br/>
<strong class="atendimento_msg_erro">{$erro}</strong>
</div>