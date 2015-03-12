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

            <h2><span class="label label-default">Meus atendimentos</span></h2>
            <br/>
            <div class="panel-default">
                <input type="hidden" name="codatendente" id="codatendente" value="{$dados['CODCONTA']}"/>
                <input type="hidden" name="language" id="language" value="{$language}"/>
                <table class='table' id="table-1-2" cellspacing="0" cellpadding="2">
                    <thead>
                        <th>Fila</th>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>E-mail</th>
{*                        <th>Status</th>*}
                        <th>Ações</th>
                    </thead>
                    <tbody class='meus-atendimentos'></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}