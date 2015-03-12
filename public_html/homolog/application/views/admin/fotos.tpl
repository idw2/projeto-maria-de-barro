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
            <!--
            {include file="admin/search.tpl"}
            -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"  style="text-align: left;">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h2><span class="label label-default">Lista de Imagens</span></h2>
                </div>
                <br/>
                <div class="col-md-6 text-right">
                    <a href="/{$language}/produtos/produtos_lista" class="btn btn-default navbar-btn"><i class="fa fa-reply">&nbsp</i> Voltar</a>
                </div>
                
            </div>
            <br/>

            <div class="container" style="text-align: left; margin-left: 0; padding-left: 0;">

                <div class="col-md-3 text-left">
                    <h4 class="panel-heading x-label">Preview</h4>
                    <div class="thumbnail env-produto" style="margin: 0;"> 
                        {if $foto_destaque eq ""}
                            <div class="auto-img"><img src="{$web_files}/img/img_default.png" alt="" border="0" title="" class="img-responsive"/></div>
                        {else}
                            <div class="auto-img"><img src="{$foto_destaque}" alt="" border="0" title="" class="img-responsive"/></div>
                        {/if}                        
                        <div class="row sp1"><div class="col-sm-12 sp2"></div></div>
                        <div class="auto-price text-center"> R$ <span class="view-preco">{$produto->PRECO}</span></div>
                        <div class="auto-title text-center view-nome">{$produto->NOME}</div>
                        <div class="text-center">
                            <a onclick="return false;" class="btn btn-default navbar-btn eu-quero">Eu quero</a> 
                        </div>
                    </div>
                    
                </div>    
                <div class="col-md-9 text-left">
                    
                    
                </div>    
                

            </div>
            <br/>

            <a id="m-btn" href='#single_2' class="btn btn-default navbar-btn fancybox"><i class="fa fa-photo"></i> Enviar fotos</a>
            <span class="Loader hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0"/></span>
            <div id="single_2" style="display: none; width: 530px; height: 500px;">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="mulitplefileuploader">Upload</div>
                        <input type="hidden" id="url_amigavel" value="{$url_amigavel}"/>
                    </div>
                    <div class="panel-body">
                        <div id="status"></div>
                    </div>
                    
                </div>
                <div>
                    <p><button type="buttom" class="btn btn-primary btn-primary-maria" onclick="javascript:$('a[title=Close]').click();">FECHAR</button></p>
                </div>    


            </div>

            <div class="panel-default">

                <table class='table' id="table-1" cellspacing="0" cellpadding="2">
                    
                    <thead>
                        <th>#</th>
                        <th>Informações</th>
                        <th>Ações</th>
                        
                    </thead>
                    
                    
                    {counter assign=i start=1 print=false} 
                    {foreach name=outer item=foto from=$fotos}

                        {foreach key=key item=item from=$foto}
                            {if $key == "CODFOTO"} {$CODFOTO = $item}{/if}
                            {if $key == "DTA"} {$DTA = $item}{/if}
                            {if $key == "ORIGINAL"} {$ORIGINAL = $item}{/if}
                            {if $key == "NOME"} {$NOME = $item}{/if}
                            {if $key == "TIPO"} {$TIPO = $item}{/if}
                            {if $key == "FORMATO"} {$FORMATO = $item}{/if}
                            {if $key == "DESTAQUE"} {$DESTAQUE = $item}
                                {if $item == "0"}
                                    {$star = "desative"}
                                {else}
                                    {$star = ""}
                                {/if} 
                            {/if}    
                            {if $key == "STATUS"} {$STATUS = $item}
                                {if $item == "0"}
                                    {$eye = "desative"}
                                    {$stt = "1"}
                                {else}
                                    {$eye = ""}
                                    {$stt = "0"}
                                {/if} 
                            {/if}  
                            {if $key == "ORDEM"} {$ORDEM = $item}{/if}
                        {/foreach}

                        {assign var="url_del" value="/{$language}/produtos/delete_foto/url/{$url_amigavel}/codfoto/{$CODFOTO}"}

                        <tr id="{$CODFOTO}" style="border-radius: 0;">
                            <td>    
                                <img src="{$ORIGINAL}" alt="{$NOME}" data-toggle="tooltip" title="{$NOME}" border="0" style="width: 150px;"/>
                            </td>    
                            <td>

                                <!--<span style="display: inline-block; margin-right: 10px; margin-left: 10px; cursor: move; float: left;">
                                <img src="{$web_files}/img/move.png" alt="Drag" data-toggle="Drag" title="Drag" border="0" style="width: 55px;"/>
                            </span>-->


                                <span style="display: inline-block;">
                                    <strong>Nome: </strong>{$NOME}<br/>
                                    <strong>Tipo: </strong> {$TIPO}<br/>
                                    <strong>Formato: </strong>.{$FORMATO}<br/>
                                    <strong>Abrir imagem em uma nova janela: </strong><a href="{$ORIGINAL}" target="_blank" class="fa fa-camera"></a><br/>
                                </span>
                            </td>    
                            
                            <td>
                                <span style="display: inline-block; margin-right: 10px">
                                    
                                    <a href="/{$language}/produtos/foto_destaque/url/{$url_amigavel}/codfoto/{$CODFOTO}"><span class="ico-default-star {$star}" data-toggle="tooltip" title="Destaque"><i class="fa fa-star"></i></span></a>
                                    <a href="/{$language}/produtos/foto_status/status/{$stt}/url/{$url_amigavel}/codfoto/{$CODFOTO}"><span class="ico-default-eye {$eye}" data-toggle="tooltip" title="Status"><i class="fa fa-eye"></i></span></a>
                                    <a href="#crop_{$i}" class="fancybox-crop" data-id="{$i}" onclick="javascript:getCrop('crop_{$i}');"><span class="ico-default-edit" data-toggle="tooltip" title="Crop"><i class="fa fa-crop"></i></span></a>
                                    <div id="crop_{$i}" style="display: none !important; display: inline-block;">
                                        <form method='post' id='FormSendImage_{$i}' onsubmit='return false' enctype='multipart/form-data'>   

                                            <input type="hidden" id="crop_{$i}_dataX1_1"/>
                                            <input type="hidden" id="crop_{$i}_dataY1_1"/>
                                            <input type="hidden" id="crop_{$i}_dataX2_1"/>
                                            <input type="hidden" id="crop_{$i}_dataY2_1"/>
                                            <input type="hidden" id="crop_{$i}_dataWidth_1" />
                                            <input type="hidden" id="crop_{$i}_dataHeight_1"/>

                                            <input type="hidden" id="crop_{$i}_dataX1_2"/>
                                            <input type="hidden" id="crop_{$i}_dataY1_2"/>
                                            <input type="hidden" id="crop_{$i}_dataX2_2"/>
                                            <input type="hidden" id="crop_{$i}_dataY2_2"/>
                                            <input type="hidden" id="crop_{$i}_dataWidth_2" />
                                            <input type="hidden" id="crop_{$i}_dataHeight_2"/>

                                            <input type="hidden" id="crop_{$i}_dataX1_3"/>
                                            <input type="hidden" id="crop_{$i}_dataY1_3"/>
                                            <input type="hidden" id="crop_{$i}_dataX2_3"/>
                                            <input type="hidden" id="crop_{$i}_dataY2_3"/>
                                            <input type="hidden" id="crop_{$i}_dataWidth_3" />
                                            <input type="hidden" id="crop_{$i}_dataHeight_3"/>


                                            <div class="panel panel-default show_crop_{$i}_1">
                                                <div class="panel-body pn1_crop_{$i}">
                                                    <img class='crop_{$i}_preview_1' src='{$ORIGINAL}' alt='Preview' title='Preview' border='0'/>
                                                </div>
                                                <br/>
                                                <div class="panel-footer" style="text-align: right;">
                                                    <div class="row">
                                                        <div class="col-md-6" style="text-align: left;"> <strong>Foto: </strong> Retrato. <br/> <br/> 
                                                            <div class="myload_crop_{$i}"></div>
                                                        </div>
                                                        <div class="col-md-6" style="text-align: right;">
                                                            <span class="LoaderCrop hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 7%;"/></span>
                                                            <a id="m-btn" onclick="release_crop('crop_{$i}', 'crop_{$i}_preview_1', '{$CODFOTO}', 1, 'retrato', 'crop_{$i}')" class="btn btn-default navbar-btn"><i class="fa fa-crop"></i> Crop</a>
                                                            
                                                            {*<ul class="pager">
                                                                <li class="next"><a href="#"  id="crop_{$i}_click" onclick="choose_crop('crop_{$i}')">Próximo &rarr;</a></li>
                                                            </ul>*}
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   


                                            <div class="panel panel-default show_crop_{$i}_2 hidex">  
                                                <div class="panel-body pn2_crop_{$i}">
                                                    <img class='crop_{$i}_preview_2' src='{$ORIGINAL}' alt='Preview' title='Preview' border='0'/>
                                                </div>
                                                <br/>
                                                <div class="panel-footer" style="text-align: right;">
                                                    <div class="row">
                                                        <div class="col-md-6" style="text-align: left;"> <strong>Foto: </strong> Paisagem.  <br/> <br/> 
                                                            <div class="myload_crop_{$i}"></div>
                                                        </div>
                                                        <div class="col-md-6" style="text-align: right;">
                                                            <span class="LoaderCrop hide"><img src="{$web_files}/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 7%;"/></span>
                                                            <a id="m-btn" onclick="release_crop('crop_{$i}', 'crop_{$i}_preview_2', '{$CODFOTO}', 2, 'paisagem', 'crop_{$i}')" class="btn btn-default navbar-btn"><i class="fa fa-crop"></i> Crop</a>
                                                            
                                                            {*<ul class="pager">
                                                                <li class="next"><a href="#"  onclick="choose_crop('crop_{$i}')">Próximo &rarr;</a></li>
                                                            </ul>
                                                            *}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>                                    

                                    </div>                 
                                    <a onclick="delete_foto('{$url_del}')"><span class="ico-default-trash" data-toggle="tooltip" title="Excluir"><i class="fa fa-trash-o"></i></span></a>
                                </span>    
                            </td>    
                        </tr>


                        {counter}
                    {/foreach}
                </table>

                <pre id="serialize_output" style="display: none;">Item 1,Item 3,Item 2,Item 5,Item 4,Item 6</pre>
            </div>

        </div>
    </div>
</div>

{include file="admin/footer.tpl"}

<script>
    function getCrop(id) {

    var $image1 = $("." + id + "_preview_1"),
            $dataX1_1 = $("#" + id + "_dataX1_1"),
            $dataY1_1 = $("#" + id + "_dataY1_1"),
            $dataX2_1 = $("#" + id + "_dataX2_1"),
            $dataY2_1 = $("#" + id + "_dataY2_1"),
            $dataHeight_1 = $("#" + id + "_dataHeight_1"),
            $dataWidth_1 = $("#" + id + "_dataWidth_1");

    $image1.cropper({
        aspectRatio: 0.9,
        done: function(data) {
            console.log(data.x1 + ":" + data.y1 + ":" + data.x2 + ":" + data.y2 + ":" + data.height + ":" + data.width);
            $dataX1_1.val(data.x1);
            $dataY1_1.val(data.y1);
            $dataX2_1.val(data.x2);
            $dataY2_1.val(data.y2);
            $dataHeight_1.val(data.height);
            $dataWidth_1.val(data.width);
        }
    });

    var $image2 = $("." + id + "_preview_2"),
            $dataX1_2 = $("#" + id + "_dataX1_2"),
            $dataY1_2 = $("#" + id + "_dataY1_2"),
            $dataX2_2 = $("#" + id + "_dataX2_2"),
            $dataY2_2 = $("#" + id + "_dataY2_2"),
            $dataHeight_2 = $("#" + id + "_dataHeight_2"),
            $dataWidth_2 = $("#" + id + "_dataWidth_2");

    $image2.cropper({
        aspectRatio: 1.8,
        done: function(data) {
            console.log(data.x1 + ":" + data.y1 + ":" + data.x2 + ":" + data.y2 + ":" + data.height + ":" + data.width);
            $dataX1_2.val(data.x1);
            $dataY1_2.val(data.y1);
            $dataX2_2.val(data.x2);
            $dataY2_2.val(data.y2);
            $dataHeight_2.val(data.height);
            $dataWidth_2.val(data.width);
        }
    });

}
</script>