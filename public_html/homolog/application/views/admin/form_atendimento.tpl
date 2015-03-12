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

            <h2><span class="label label-default">Atendimento online</span></h2>
            <br/>
            <div class="panel-default">
                <div style="padding: 20px 10px 0 10px; font-size: 18px; line-height: 2;">
                    <div style="overflow-x: auto; height: 365px;" class="chat_text">
                        {counter assign=i start=1 print=false} 
                        {foreach item=mensagem from=$mensagens} 
                            <div style="display: inline-block; line-height: 1.2; font-size: 16px;"><strong style="color: #df5d65;">Mensagem automática: </strong>{$mensagem->MENSAGEM}</div>
                        {counter}  
                        {/foreach}
                    </div>
                    <span style="display: inline-block; height: 36px;">
                        <div class="atendimento_loading hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" width="8%" style="opacity:1"/> digitando...</div>
                    </span>
                    <div class="input-group">
                        <input type="hidden" name="codatendimento" id="codatendimento" value="{$codatendimento}"/>
                        <input type="text" class="form-control"/>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Enviar</button>
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}