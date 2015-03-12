<div style="padding: 20px 10px 0 10px; font-size: 18px; line-height: 2;">
    <h3 style="color: #df5d65; text-align: center;">Atendimento Online</h3>
    <div style="overflow-x: auto; height: 365px;" class="chat_text">
        <span style="display: inline-block; line-height: 1.2; font-size: 16px;"><strong style="color: #df5d65;">Mensagem automática: </strong>{$mensagem}</span>
        <span style="display: inline-block; line-height: 1.2; font-size: 16px;"><strong class="timer_chat"></strong></span>
    </div>
    <span style="display: inline-block; height: 36px;">
        <div class="atendimento_loading hide"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="8%" style="opacity:1"/> digitando...</div>
    </span>
    <div class="input-group">
        <input type="hidden" name="codatendimento" id="codatendimento" value="{$codatendimento}"/>
        <input type="text" class="form-control" disabled/>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button" disabled>Enviar</button>
        </span>
    </div>
    
</div>