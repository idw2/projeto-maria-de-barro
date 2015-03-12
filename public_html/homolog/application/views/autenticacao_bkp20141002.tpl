{include file="header.tpl"}

<div class="container">
    <br/>   
    <div class="row">

        {include file="navbar2.tpl"}

    </div>
    {if $controle}   
        <div class="row">       
            <div class="col-sm-6 col-sm-offset-3">    
                <div class="section-title">
                    <h2>
                        <a href="#">
                            <strong>Autenticação</strong>
                        </a>
                    </h2>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <form class="navbar-form navbar-left" style="width: 100%" onsubmit="return false" method="post">
                            {if $msg_erro != ""}
                                <div class="alert alert-info" role="alert">{$msg_erro}</div>
                            {/if}
                            <input type="hidden" name="actionType" value="criar_conta"/>
                            <h3>{$saudacao} {$nome}!</h3>
                            <p>Veja como é fácil adquirir nossos produtos e serviços.</p>
                            <p><input type="text" class="form-control" style="min-width: 40%" id="email" name="email" maxlength="70" value="{$email}" placeholder="E-mail" readonly="readonly"/></p>
                            <p><a class="btn btn-default" href="/{$language}/produtos/sair/">Sair e acessar com outra conta!</a></p>
                            <p><a class="btn btn-default" href="/{$language}/produtos/minha_conta/">Minha conta!</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    {else}   


        <div class="row">       
            <div class="col-lg-6">    
                <div class="panel panel-default">    
                    <table class="table" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>Criar uma conta</th>
                            </tr>
                        </thead>
                        </body>

                        <tr>
                            <td>
                                <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/produtos/autenticacao/" method="post">
                                    {if $msg_erro != ""}
                                        <div class="alert alert-info" role="alert">{$msg_erro}</div>
                                    {/if}
                                    <input type="hidden" name="actionType" value="criar_conta"/>
                                    <label>Por favor, entre com seu endereço de e-mail para criar uma conta!</label>
                                    <p><input type="text" class="form-control" style="max-width: 47%" id="email" name="email" maxlength="70" value="{$email_conta}" placeholder="E-mail"/></p>
                                    <p><button type="submit" class="btn btn-primary btn-primary-maria" name="enviar">Criar conta</button></p>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">    
                <div class="panel panel-default">    
                    <table class="table" style="font-size: 14px">
                        <thead>
                            <tr>
                                <th>Já está registrado?</th>
                            </tr>
                        </thead>
                        </body>

                        <tr>
                            <td>
                                <form class="navbar-form navbar-left" style="width: 100%" action="/{$language}/produtos/autenticacao/" method="post">
                                    {if $msg_erro_login != ""}
                                        <div class="alert alert-info" role="alert">{$msg_erro_login}</div>
                                    {/if}
                                    <input type="hidden" name="actionType" value="login"/>
                                    <p><input type="text" class="form-control" style="max-width: 47%" id="email" name="email" maxlength="70" value="{$email_login}" placeholder="E-mail"/></p>
                                    <p><input type="password" class="form-control" style="max-width: 47%" id="senha" name="senha" maxlength="70" value="" placeholder="Senha"/></p>
                                    <p><button type="submit" class="btn btn-primary btn-primary-maria" name="enviar">Autenticação</button></p>
                                    <a href="/{$language}/produtos/esqueceu_senha/">Esqueceu sua senha?</a>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    {/if}                           
    <div>
        <ul class="pager">
            <li class="previous"><a href="/{$language}/produtos/checkout/">&larr; Continuar comprando</a></li>
                {if $controle} 
                <li class="next"><a href="/{$language}/produtos/pagamento/">Avançar &rarr;</a></li>
                {/if}
        </ul>
    </div> 
</div>
<div style="clear: both;"></div>
<script>


    window.onload = teste;

    function teste() {
        $(document).ready(function () {
            $("#btn_cep").click(function () {
                get_soma_peso();
            });
        });
    }

    function get_soma_peso() {

        $(".Loader").removeClass('hide');

        var cep_remetente = $("#cep_remetente").val();
        var cep_destinatario = $("#cep_destinatario").val();
        var total_peso = $("#total_peso").val();
        var forma_envio = $("#forma_envio").val();

        var cr = cep_remetente.replace("-", "");
        var cd = cep_destinatario.replace("-", "");

        if (cd.length == 8) {
            $.ajax({
                type: 'post',
                data: "cep_remetente=" + cr + "&cep_destinatario=" + cd + "&total_peso=" + total_peso + "&forma_envio=" + forma_envio + "&total_geral=" + $("#total_parcial").html(),
                url: '/web-files/server/get_valor_frete.php',
                success: function (data) {
                    $(".Loader").addClass('hide');
                    // alert(data); return;
                    $("#total_geral").html(data["soma"]);
                    $("#taxa_entrega").html(data["frete"]);
                    $("#msg_erro").html(data["msg_erro"]);
                    console.log(data);
                    //window.location.reload();

                }
            });
        } else {
            $(".Loader").addClass('hide');
        }

    }

    function del_row_wishlist(url) {
        $.ajax({
            type: 'post',
            data: url,
            url: '/web-files/server/del_row_wishlist.php',
            success: function (data) {
                console.log(data);
                window.location.reload();
            }
        });
    }


    function plus_wishlist(url, codlistaprodutos) {

        //alert(url);

        //alert(comando);
        //return;

        $.ajax({
            type: 'post',
            data: url,
            url: '/web-files/server/plus_wishlist.php',
            success: function (data) {
                if (data == "reload") {
                    window.location.reload();
                } else {
                    if (data["reload"] == "vazio") {
                        window.location.reload();
                    } else {
                        data['peso']; //=> 4.800    
                        data['total']; //=> 864,00    
                        data['peso_total']; //=> 7.2    
                        data['total_geral']; //=> 1.296,00    
                        data['itens']; //=> 24 Itens    
                        data['CODPRODUTO']; //=> BA1059BB37702C988645CE1DA29D996D    
                        data['NOME']; //=> ANEL DOURADO CRUZ - BRANCA    
                        data['PESO']; //=> 0.300    
                        data['CATEG']; //=> aneis    
                        data['PESO_TOTAL']; //=> 4.800    
                        data['CATEGORIA']; //=> Anéis    
                        data['PRECO']; //=> 54,00    
                        data['REFERENCIA']; //=> A-00014    
                        data['CODLISTADESEJOS']; //=> A3B3BCDC19E1DD088199667523D257AB    
                        data['TOTAL']; //=> 864,00    
                        data['QUANTIDADE']; //=> 16    
                        data['PRECO_UNITARIO']; //=> 5400)

                        $("#total_geral").html(data['total_geral']);
                        $("#total_parcial").html(data['total_geral']);
                        $("#preco_total_produto_" + codlistaprodutos).html(data['total']);
                        $("#peso_total_produto_" + codlistaprodutos).html(data['PESO_TOTAL']);
                        $("#input_" + codlistaprodutos).val(data['QUANTIDADE']);
                        $("#peso_total").html(data['peso_total']);
                        $("#item_carrinho").html(data['itens']);
                        $("#total_peso").val(data['peso_total']);
                        get_soma_peso();

                    }




    {*
    data[peso] => 3.300    
    data[total] => 594,00    
    data[peso_total] => 5.7    
    data[total_getal] => 1.026,00    
    data[itens] => 19 Itens    [0] => stdClass Object        (            [CODPRODUTO] => BA1059BB37702C988645CE1DA29D996D            [NOME] => ANEL DOURADO CRUZ - BRANCA            [PESO] => 0.300            [CATEG] => aneis            [PESO_TOTAL] => 13.200            [FOTO] => /web-files/upload/thumbs/3D260BF9A14A044EA9D30CC06ECC0CEC/0167EF82A8D074FDC85770EF1D39E2EE.jpg            [CATEGORIA] => Anéis            [PRECO] => 54,00            [REFERENCIA] => A-00014            [CODLISTADESEJOS] => C5468436D70CF906F700F5B996379EBE            [TOTAL] => 2.376,00            [QUANTIDADE] => 44            [PRECO_UNITARIO] => 5400        )    [1] => stdClass Object        (            [CODPRODUTO] => F6E952B25FA3577D9730B5B2FA13E120            [NOME] => ANEL LARGO CRAVEJADO DE ZIRCôNIA             [PESO] => 0.300            [CATEG] => aneis            [PESO_TOTAL] => 2.400            [FOTO] => /web-files/upload/thumbs/677EBCC875C45B6D0AF70F2B32D10659/318129E8E7EB09EDCEA24B2316F0F25E.jpg            [CATEGORIA] => Anéis            [PRECO] => 54,00            [REFERENCIA] => A-00013            [CODLISTADESEJOS] => E33E8903065AF30A4D42C1F18CB55775            [TOTAL] => 432,00            [QUANTIDADE] => 8            [PRECO_UNITARIO] => 5400        ))
    *}
                    console.log(data);
                }
            }
        });

    {*var input = $(obj).parent().parent().find('input');

    var multiplo = parseInt(input.val());
    if (comando == "mais") {
    valor = (preco_unitario * (multiplo + 1));
    input.val(multiplo + 1);
    //$(obj).parents().eq(5).find("td").eq(8).html(formataReais(valor.toString()));

    var total_geral = $("#total_geral").html();
    var tgl = total_geral.replace(",", "");
    var tg = tgl.replace(".", "");

    var geral = (parseInt(tg) + preco_unitario);
    //$("#total_geral").html(formataReais(geral.toString()));

    } else {
    valor = (preco_unitario * (multiplo - 1));
    if (multiplo > 0) {
    input.val(multiplo - 1);
    }
    if (valor > 0) {
    //$(obj).parents().eq(5).find("td").eq(8).html(formataReais(valor.toString()));

    } else {
    //$(obj).parents().eq(5).find("td").eq(8).html("0,00");
    }
    var total_geral = $("#total_geral").html();
    var tgl = total_geral.replace(",", "");
    var tg = tgl.replace(".", "");

    var geral = (parseInt(tg) - preco_unitario);
    //$("#total_geral").html(formataReais(geral.toString()));
    }*}
    {* 
    $.ajax({
    type: 'post',
    data: url + "&comando=" + comando,
    url: '/web-files/server/plus_wishlist.php',
    success: function(data) {
    if (data == "reload") {
    window.location.reload();
    } else {
    alert(data);
    data["peso"]
    data["total"];
    data["peso_total"];    
    data["total_getal"];  
    data["itens"];  
                    
    $("#total_geral").html(data["total_getal"]);
    $(obj).parents().eq(5).find("td").eq(6).html(data['peso']);
    $("#peso_total").html(data['peso_total']);
    $(obj).parents().eq(5).find("td").eq(8).html(data["total"]);
    $("#item_carrinho").html(data["itens"]);
                    
    $(obj).parents().eq(5).find("td").eq(6).html(data['peso'])
    $("#peso_total").html(data['peso_total']);
                    
    var carrinho = $("#item_carrinho").html();
    var qntdd = 0;
    $("#n_input").find("input").each(function(i){
    var n = parseInt(jQuery(this).val());
    qntdd = (qntdd+n);
    });
                    
    var limpa_1 = carrinho.replace("Itens", "");
    var limpa_2 = limpa_1.replace("Item", "");
    var limpa_3 = limpa_2.replace("(Vazio)", "");
    var str = limpa_3.trim();
                   
    var valor = qntdd; 
    var resultado = valor + " Itens";
    $("#item_carrinho").html(resultado);
                    
    console.log(data);
    }
    }
    });*}


    }

</script>

{include file="footer.tpl"}