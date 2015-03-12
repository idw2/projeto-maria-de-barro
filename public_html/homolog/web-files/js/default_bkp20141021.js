$(document).ready(function () {

    if (document.getElementById("selectPrductSort") != null) {
        $('#selectPrductSort').change(function () {
            monta_url_produtos();
        });
    }

    if (document.getElementById("selectPrductSort_2") != null) {
        $('#selectPrductSort_2').change(function () {
            monta_url_produtos();
        });
    }

    if (document.getElementById("qntdd_produtos") != null) {
        $('#qntdd_produtos').change(function () {
            monta_url_produtos();
        });
    }

    if (document.getElementById("trocar_senha") != null) {
        $("#trocar_senha").click(function () {
            if ($(".show_senha").hasClass("hide")) {
                $(".show_senha").removeClass("hide");
            } else {
                $(".show_senha").addClass("hide");
            }
        });
    }

    if (document.getElementById("cep") != null) {
        $('#cep').mask('99999-999');
        $('#cep').change(function () {
            var cep = jQuery(this).val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: '/web-files/server/cep.php',
                success: function (data) {
                    $(".Loader").addClass('hide');
                    $("#logradouro").val(data["Logradouro"]);
                    $("#bairro").val(data["Bairro"]);
                    $("#cidade").val(data["Cidade"]);
                    $("#estado").val(data["UF"]);
                }
            });

        });
    }

    if (document.getElementById("pesquisar_endereco") != null) {
        $('#pesquisar_endereco').click(function () {
            var cep = $("#cep").val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: '/web-files/server/cep.php',
                success: function (data) {
                    $(".Loader").addClass('hide');
                    $("#logradouro").val(data["Logradouro"]);
                    $("#bairro").val(data["Bairro"]);
                    $("#cidade").val(data["Cidade"]);
                    $("#estado").val(data["UF"]);
                }
            });

        });
    }


    if (document.getElementById("mais_enderecos") != null) {
        $("#mais_enderecos").click(function () {
            if ($("#formulario_enderecos").hasClass("hide")) {
                $("#formulario_enderecos").removeClass("hide");
                $("#mais_enderecos").html("- ENDERECO");
            } else {
                $("#formulario_enderecos").addClass("hide");
                $("#mais_enderecos").html("+ ENDERECO");
            }

        });
    }


    if (document.getElementById("table-1") != null) {
        $("#table-1").tableDnD({
            onDragStart: function (table, row) {
                $(".Loader").removeClass('hide');
//                console.log(table);
//                console.log(row);
                //$("#debugArea").html("Started dragging row "+row.id);
                //$(table).parent().find('.result').text("Started dragging row "+row.id);
            },
            onDragClass: "myDragClass active",
            onDrop: function () {
                var keys = null;
                $("#table-1").find("tr").each(function (i) {
                    if (i % 2 == 1) {
                        jQuery(this).addClass('myDragClass');
                    } else {
                        jQuery(this).removeClass('myDragClass');
                    }

                    if (jQuery(this).attr("id") != null) {
                        (i == 0) ? keys = jQuery(this).attr("id") + ";" : keys += jQuery(this).attr("id") + ";";
                    }
                });

                $.ajax({
                    type: 'post',
                    data: "keys=" + keys,
                    url: '/web-files/server/order_produtos.php',
                    success: function (data) {
                        $(".Loader").addClass('hide');
//                        console.log(data);
                    }
                });
            }
        });

        $("#table-1").find("tr").each(function (i) {
            if (i % 2 == 1) {
                jQuery(this).addClass('myDragClass');
            }
        });
    }

    if (document.getElementById("preco") != null) {
        $("#preco").keyup(function () {
            $(".view-preco").html($("#preco").val());
        });
    }

    if (document.getElementById("de") != null) {
        $("#de").keyup(function () {
            $(".view-preco-de").html($("#de").val());
        });
    }


    if (document.getElementById("nome") != null) {
        $("#nome").keyup(function () {
            $(".view-nome").html($("#nome").val());
        });
    }


    if (document.getElementById("linha_1") != null) {
        $("#linha_1").keyup(function () {
            $(".view-linha_1").html($("#linha_1").val());
        });
    }


    if (document.getElementById("linha_2") != null) {
        $("#linha_2").keyup(function () {
            $(".view-linha_2").html($("#linha_2").val());
        });
    }


    if (document.getElementById("linha_3") != null) {
        $("#linha_3").keyup(function () {
            $(".view-linha_3").html($("#linha_3").val());
        });
    }


    if ($('.fancybox').hasClass("fancybox")) {
        $('.fancybox').fancybox({
            "hideOnContentClick": true,
            afterClose: function () {
                window.location.reload();
            }
        });
    }


    if ($('.fancybox-crop').hasClass("fancybox-crop")) {
        $('.fancybox-crop').fancybox({
            "hideOnContentClick": true
        });
    }

    if (document.getElementById("m-btn") != null) {
        $("#m-btn").click(function (e) {
            e.preventDefault();
//            console.log("click");

        });
    }


    if (document.getElementById("url_amigavel") != null) {
        var url_amigavel = $("#url_amigavel").val();
        var settings = {
            url: "/web-files/server/upload.php?url_amigavel=" + url_amigavel,
            method: "POST",
            allowedTypes: "jpg,png,gif,doc,pdf,zip",
            fileName: "myfile",
            multiple: true,
            onSuccess: function (files, data, xhr)
            {
                $("#status").html("<font color='green'>Imagens enviadas com sucesso!</font>");

            },
            onError: function (files, status, errMsg)
            {
                $("#status").html("<font color='red'>Ocorreu um erro ao enviar as imagens!</font>");
            }
        };
    }

    if (document.getElementById("mulitplefileuploader") != null) {
        $("#mulitplefileuploader").uploadFile(settings);
    }

    if (document.getElementById("table-1") != null) {
        $("#table-1").tableDnD({
            onDragStart: function (table, row) {
                $(".Loader").removeClass('hide');
//                console.log(table);
//                console.log(row);
                //$("#debugArea").html("Started dragging row "+row.id);
                //$(table).parent().find('.result').text("Started dragging row "+row.id);
            },
            onDragClass: "myDragClass active",
            onDrop: function () {
                var keys = null;
                $("#table-1").find("tr").each(function (i) {
                    if (i % 2 == 1) {
                        jQuery(this).addClass('myDragClass');
                    } else {
                        jQuery(this).removeClass('myDragClass');
                    }

                    if (jQuery(this).attr("id") != null) {
                        (i == 0) ? keys = jQuery(this).attr("id") + ";" : keys += jQuery(this).attr("id") + ";";
                    }
                });

                $.ajax({
                    type: 'post',
                    data: "keys=" + keys,
                    url: '/web-files/server/order_fotos.php',
                    success: function (data) {
                        $(".Loader").addClass('hide');
                        console.log(data);
                    }
                });
            }
        });

        if (document.getElementById("table-1") != null) {
            $("#table-1").find("tr").each(function (i) {
                if (i % 2 == 1) {
                    jQuery(this).addClass('myDragClass');
                }
            });
        }

    }


    if (document.getElementById("btn_cep") != null) {
        $("#btn_cep").click(function () {
            get_soma_peso();
        });
    }

    if (document.getElementById("forma_envio") != null) {
        $("#forma_envio").change(function () {
            get_soma_peso();
        });
    }

    if ($('.myFormaEnvio').hasClass("myFormaEnvio")) {
        $(".myFormaEnvio").change(function () {
            get_soma_peso();
        });
    }

    if (document.getElementById("resume-somos") != null) {
        $.ajax({
            type: 'post',
            data: "keys=",
            url: '/web-files/server/get_resume_somos.php',
            success: function (data) {
                $("#resume-somos").html(data);
                console.log(data);
            }
        });
    }

    if (document.getElementById("accordion") != null) {
        $(function () {
            $("#accordion").accordion();
        });
    }

    if (document.getElementById("btn_atendimento") != null) {
        $("#btn_atendimento").click(function () {
            ($(".window_atendimento").hasClass("hide")) ? $(".window_atendimento").removeClass("hide") : $(".window_atendimento").addClass("hide");
            $(".load_atendimento").removeClass("hide");
            $(".text_atendimento").addClass("hide");

            $.ajax({
                type: 'post',
                data: "keys=",
                url: '/' + $("#language") + '/atendimento',
                success: function (data) {
                    $(".text_atendimento").removeClass("hide");
                    $(".text_atendimento").html(data);
                    $(".load_atendimento").addClass("hide");
                    console.log(data);
                }
            });

        });
    }

    if ($('.btn_close').hasClass("btn_close")) {
        $(".btn_close").click(function () {
            $(".body_atendimento").addClass("hide");
        });
    }

    if ($('.meus-atendimentos').hasClass("meus-atendimentos")) {
        setInterval(meusAtendimentos, 1000);
    }


});

function formataReais(valorReal) {

    size = parseInt(valorReal.length);
    result = null;
    if (size >= 9) {
        //9.999.999,99                                                                         
        if (size == 9) {
            p1 = valorReal.substr(-2);
            p2 = valorReal.substr(-5, 3);
            p3 = valorReal.substr(-8, 3);
            p4 = valorReal.substr(-9, 1);
            result = p4 + "." + p3 + "." + p2 + "," + p1;
        } else if (size == 10) {
            p1 = valorReal.substr(-2);
            p2 = valorReal.substr(-5, 3);
            p3 = valorReal.substr(-8, 3);
            p4 = valorReal.substr(-10, 2);
            result = p4 + "." + p3 + "." + p2 + "," + p1;
        } else if (size == 11) {
            p1 = valorReal.substr(-2);
            p2 = valorReal.substr(-5, 3);
            p3 = valorReal.substr(-8, 3);
            p4 = valorReal.substr(-11, 3);
            result = p4 + "." + p3 + "." + p2 + "," + p1;
        }
        return result;
    } else if (size == 8) {
        //999.999,99                                                                           
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-5, 3);
        p3 = valorReal.substr(-8, 3);
        result = p3 + "." + p2 + "," + p1;
        return result;
    } else if (size == 7) {
        //99.999,99                                                                            
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-5, 3);
        p3 = valorReal.substr(-7, 2);
        result = p3 + "." + p2 + "," + p1;
        return result;
    } else if (size == 6) {
        //9.999,99                                                                             
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-5, 3);
        p3 = valorReal.substr(-6, 1);
        result = p3 + "." + p2 + "," + p1;
        return result;
    } else if (size == 5) {
        //999,99                                                                               
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-5, 3);
        result = p2 + "," + p1;
        return result;
    } else if (size == 4) {
        //99,99                                                                                
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-4, 2);
        result = p2 + "," + p1;
        return result;
    } else if (size == 3) {
        //9,99                                                                                 
        p1 = valorReal.substr(-2);
        p2 = valorReal.substr(-3, 1);
        $result = p2 + "," + p1;
        return result;
    } else if (size == 2) {
        //0,99                                                                                 
        p1 = valorReal.substr(-2);
        result = "0," + p1;
        return result;
    }

    return false;

}

function txtBoxFormat(objeto, sMask, evtKeyPress) {
    var i, nCount, sValue, fldLen, mskLen, bolMask, sCod, nTecla;


    if (document.all) { // Internet Explorer
        nTecla = evtKeyPress.keyCode;
    } else if (document.layers) { // Nestcape
        nTecla = evtKeyPress.which;
    } else {
        nTecla = evtKeyPress.which;
        if (nTecla == 8) {
            return true;
        }
    }

    sValue = objeto.value;

    // Limpa todos os caracteres de formatação que
    // já estiverem no campo.
    sValue = sValue.toString().replace("-", "");
    sValue = sValue.toString().replace("-", "");
    sValue = sValue.toString().replace(".", "");
    sValue = sValue.toString().replace(".", "");
    sValue = sValue.toString().replace("/", "");
    sValue = sValue.toString().replace("/", "");
    sValue = sValue.toString().replace(":", "");
    sValue = sValue.toString().replace(":", "");
    sValue = sValue.toString().replace("(", "");
    sValue = sValue.toString().replace("(", "");
    sValue = sValue.toString().replace(")", "");
    sValue = sValue.toString().replace(")", "");
    sValue = sValue.toString().replace(" ", "");
    sValue = sValue.toString().replace(" ", "");
    fldLen = sValue.length;
    mskLen = sMask.length;

    i = 0;
    nCount = 0;
    sCod = "";
    mskLen = fldLen;

    while (i <= mskLen) {
        bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
        bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

        if (bolMask) {
            sCod += sMask.charAt(i);
            mskLen++;
        }
        else {
            sCod += sValue.charAt(nCount);
            nCount++;
        }

        i++;
    }

    objeto.value = sCod;

    if (nTecla != 8) { // backspace
        if (sMask.charAt(i - 1) == "9") { // apenas números...
            return ((nTecla > 47) && (nTecla < 58));
        }
        else { // qualquer caracter...
            return true;
        }
    }
    else {
        return true;
    }
}

function makenum(nro) {

    var valid = "0123456789";
    var numerook = "";
    var temp;
    for (var i = 0; i < nro.length; i++)
    {
        temp = nro.substr(i, 1);
        if (valid.indexOf(temp) != -1)
            numerook = numerook + temp;
    }
    return(numerook);
}

function mascaraPeso(objeto, e, tammax, decimais) {

    // var tecla  = (window.event) ? e.which : e.keyCode;
    var tecla = e.keyCode ? e.keyCode : e.which;
    var tamObj = objeto.value.length;

    if ((tecla == 8) && (tamObj == tammax))
        tamObj = tamObj - 1;

    vr = makenum(objeto.value);
    tam = vr.length;

    if (((tecla == 8) || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) && (parseInt(tamObj) + 1 <= parseInt(tammax)))
    {
        if ((tam < tammax) && (tecla != 8))
            tam = vr.length + 1;
        if ((tecla == 8) && (tam > 1))
            tam = tam - 1;
        if ((tam >= (decimais)))
            objeto.value = vr.substr(0, (tam - decimais)) + "." + vr.substr((tam - decimais), tam);
    }
    else if ((tecla != 8) && (tecla != 9) && (tecla != 13) && (tecla != 18) && (tecla != 35) && (tecla != 36) && (tecla != 37) && (tecla != 39))
    {
        return false;
    }
}

function alter_endereco_entrega(codendereco, codcadastro) {

    //prepend
    //append
    $("#formListenderecos").html("<img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 9%;'>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: '/web-files/server/status_endereco.php',
        success: function (data) {
            $("#formListenderecos").html(data)
            console.log(data);

            if ($("#step-3").html() == "") {
                return false;
            } else {
                forma_envio();
            }
        }
    });
}

function del_row_enderecos(codendereco, codcadastro) {

    $("#formListenderecos").html("<img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 9%;'>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: '/web-files/server/delete_endereco.php',
        success: function (data) {
            if (data == 'reload') {
                $(".meu-endereco-entrega").addClass("hide");
                $("#formListenderecos").html("");
                $("#step-3").html("");
                $(".step-3").addClass("hide");
                $(".step-4").addClass("hide");
                //console.log(data);
                //window.location.reload();
            } else {
                $("#formListenderecos").html(data);
                forma_envio();
                console.log(data);
            }
        }
    });
}

function delete_produto(url) {
    if (confirm('ATENÇÃO: Esta ação não poderá ser desfeita!\n Deseja continuar?')) {
        window.location = url;
        return true;
    } else {
        return false;
    }
}

function update_qntdd(codproduto, qntdd) {
    $(".Loader").removeClass('hide');
    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&quantidade=" + qntdd,
        url: '/web-files/server/update_qntdd.php',
        success: function (data) {
            $(".Loader").addClass('hide');
            console.log(data);
        }
    });

}

function delete_produto(url) {

    if (confirm('ATENÇÃO: Esta ação não poderá ser desfeita!\n Deseja continuar?')) {
        window.location = "/" + url;
        return true;
    } else {
        return false;
    }
}

function delete_foto(url) {
    if (confirm('ATENÇÃO: Esta ação não poderá ser desfeita!\n Deseja continuar?')) {
        window.location = url;
        return true;
    } else {
        return false;
    }
}

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
        done: function (data) {
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
        done: function (data) {
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

function release_crop(key, imagem, codfoto, indice, dimensao, guid) {

    var dataX1 = $("#" + key + "_dataX1_" + indice).val();
    var dataY1 = $("#" + key + "_dataY1_" + indice).val();
    var dataX2 = $("#" + key + "_dataX2_" + indice).val();
    var dataY2 = $("#" + key + "_dataY2_" + indice).val();
    var dataWidth = $("#" + key + "_dataWidth_" + indice).val();
    var dataHeight = $("#" + key + "_dataHeight_" + indice).val();
    var link = '';
    if (dimensao == "retrato") {
        link = '/web-files/server/crop.php';
    } else {
        link = '/web-files/server/crop_paisagem.php';
    }

    $(".LoaderCrop").removeClass('hide');

    $.ajax({
        type: 'post',
        data: "indice=" + indice + "&x1=" + dataX1 + "&y1=" + dataY1 + "&x2=" + dataX2 + "&y2=" + dataY2 + "&w=" + dataWidth + "&h=" + dataHeight + "&codfoto=" + codfoto + "&imagem=" + imagem,
        url: link,
        success: function (data) {
            $(".LoaderCrop").addClass('hide');
            if (dimensao == "retrato") {
                choose_crop(guid);
            } else {
                $("a[title=Close]").click();
                window.location.reload();
            }
        }
    });
}


function choose_crop(id) {

    if ($(".show_" + id + "_2").hasClass("hidex")) {
        $(".show_" + id + "_1").addClass('hidex');
        $(".show_" + id + "_2").removeClass('hidex');
    } else {
        $(".show_" + id + "_1").removeClass('hidex');
        $(".show_" + id + "_2").addClass('hidex');
    }
}


function plus_wishlist(url, codlistaprodutos) {

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
                    $("#peso_total").html(data['peso_total']);
                    $("#total_parcial").html(data['total_parcial']);
                    $("#total_impostos").html(data['imposto']);

                    $("#preco_total_produto_" + codlistaprodutos).html(data['total']);
                    $("#peso_total_produto_" + codlistaprodutos).html(data['PESO_TOTAL']);
                    $("#input_" + codlistaprodutos).val(data['QUANTIDADE']);
                    $("#peso_total").html(data['peso_total']);
                    $("#item_carrinho").html(data['itens']);
                    $("#total_peso").val(data['peso_total']);
                    calcula_bonus();

                    var valor = $("#step-3").html();
                    var teste = valor.trim();

                    if (teste == "") {
                        return;
                    } else {
                        forma_envio();
                    }

                }
                console.log(data);
            }
        }
    });
}

function calcula_bonus() {
    $.ajax({
        type: 'post',
        data: '',
        url: '/pt/produtos/calcula-bonus',
        success: function (data) {
            $(".bonus").html(data);
        }
    });
}


function cielo(client_hidden, codcadastro, codendereco) {

    var url = 'CLIENT_HIDDEN=' + client_hidden +
            '&CODCADASTRO=' + codcadastro +
            '&CODENDERECO=' + codendereco +
            '&CODIGOBANDEIRA=' + $("#CieloForm").find("input[type=radio]:checked").val() +
            '&FORMAPAGAMENTO=' + $("#formaPagamento").val() +
            '&CARTAOVALIDADE=' + $("#cartao-venc-mes").val() + "/" + $("#cartao-venc-ano").val();
    
    //alert( $("#CieloForm").find("input[type=radio]:checked").val());
    
    $("#CieloForm").find("input").each(function () {
        var str = $(this).attr("name");
        if (str != "" && str != "codigoBandeira" ) {
            var res = str.toUpperCase();
            url += "&" + res + "=" + $(this).val();
        }
    });
    
//    alert(url);
//    return;
    
    //alert( $("#CieloForm").find("input[type=radio]:checked").val());

    $.ajax({
        type: 'post',
        data: url,
        url: '/pt/produtos/cielo',
        success: function (data) {
            alert(data);
            $(".return-cielo").html(data);
            if (data == "TRANSACAO_AUTORIZADA") {
                finalizar_pedido(client_hidden, codcadastro, codendereco, 'pt', 'cielo');
            }
            console.log(data);
            //$(".bonus").html(data);
        }
    });
}

function boleto(client_hidden, codcadastro, codendereco) {

    finalizar_pedido(client_hidden, codcadastro, codendereco, 'pt', 'boleto');
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
            data: "cep_remetente=" + cr + "&cep_destinatario=" + cd + "&total_peso=" + total_peso + "&forma_envio=" + forma_envio + "&total_geral=" + $("#total_parcial").html() + "&total_impostos=" + $("#total_impostos").html(),
            url: '/web-files/server/get_valor_frete.php',
            success: function (data) {
                $(".Loader").addClass('hide');
                // alert(data); return;
                $("#total_geral").html(data["soma"]);
                $("#taxa_entrega").html(data["frete"]);
                $("#msg_erro").html(data["msg_erro"]);
                $("#total_impostos").html(data["total_impostos"]);
                //alert(data["frete"]);

                if (data["frete"] == "Gratis") {
                    $(".step-3").addClass("hide");
                } else {
                    $(".step-3").removeClass("hide");
                }
                ;
                forma_pgto();
                console.log(data);
                //window.location.reload();

            }
        });
    } else {
        $(".Loader").addClass('hide');
    }

}

function forma_pgto() {

    $(".step-4").removeClass("hide");
    $("#step-4").html("<div style='text-align: center'><br/><img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 6%'/><br/><br/></div>");

    $.ajax({
        type: 'post',
        data: '',
        url: '/pt/produtos/forma-pgto',
        success: function (data) {
            console.log(data);
            $("#step-4").html(data);
            var total_geral = $("#total_geral").html();
            $("#exibe_valor").html(total_geral);
            
            var tg1 = total_geral.replace(/\,|\./, "");
            $("input[type=hidden]").each(function(i){
                if($(this).attr("name") == "produto")
                    $(this).val(tg1);
            });
            
            Plugins.init();
//            $('#cartao-numero').validateCreditCard(function (e) {
//                return $("#cartao-numero").removeClass(), null == e.card_type ? void $(".vertical.maestro").slideUp({duration: 200}).animate({opacity: 0}, {queue: !1, duration: 200}) : ($("#cartao-numero").addClass(e.card_type.name), "maestro" === e.card_type.name ? $(".vertical.maestro").slideDown({duration: 200}).animate({opacity: 1}, {queue: !1}) : $(".vertical.maestro").slideUp({duration: 200}).animate({opacity: 0}, {queue: !1, duration: 200}), e.length_valid && e.luhn_valid ? $("#cartao-numero").addClass("valid") : $("#cartao-numero").removeClass("valid"))
//            }, {accept: ["visa", "visa_electron", "mastercard", "maestro", "discover"]});

        }
    });
}

function add_checkout_list(params, url, loading) {
    $("." + loading).removeClass('hide');
    var qntdd = parseInt($("#quantidade").val());
    var quantidade = "&QUANTIDADE=" + qntdd;
    var valores = params + quantidade;

    $.ajax({
        type: 'post',
        data: valores,
        url: '/web-files/server/add_lista_desejos.php',
        success: function (data) {
            //alert(data);
            //$("#list-drop-desejos").html(data);
            $("." + loading).addClass('hide');
            window.location = url;

            //window.location.reload();
            //$("a[title=Close]").click();
            //$(".myload_crop_" + indice).html("<strong style='color: #395aa4'>" + data + "</strong>");
        }
    });
}

function finalizar_pedido(client_hidden, codcadastro, codendereco, language, pgto) {

    // alert(pgto);
    //return;

    $("#msg_erro_Finale").html("");
    $(".LoaderFinale").removeClass("hide");

    var taxa_entrega = $("#taxa_entrega");
    var f_envio = "";

    if (taxa_entrega.html() == "0,00" || taxa_entrega.html() == "" || taxa_entrega.html() == null) {
        $("#msg_erro_Finale").html("Forma de envio não definida!");
        $(".LoaderFinale").addClass("hide");
    } else {

        f_envio = $("select#forma_envio").val();
        var form_pgto = "";

//        $("input[type=radio]").each(function(i) {
//            if ($(this).attr("name") == "pgto" && $(this).is(":checked")) {
//                form_pgto = $(this).val();
//            }
//        });

        var form_pgto = pgto;

        console.log(f_envio);
        var total_geral = $("#total_geral").html();
        var total_parcial = $("#total_parcial").html();
        var bonus = $(".bonus").html();
        var impostos = $("#total_impostos").html();
        var ticket_desconto = $("#ticket_desconto").val();

//        alert(ticket_desconto);

        $.ajax({
            type: 'post',
            data: "LANGUAGE=" + language + "&FORMA_PGTO=" + form_pgto + "&CLIENT_HIDDEN=" + client_hidden + "&CODCADASTRO=" + codcadastro + "&CODENDERECO=" + codendereco + "&FORMA_ENVIO=" + f_envio + "&TAXA_ENTREGA=" + taxa_entrega.html() + "&TOTAL_GERAL=" + total_geral.trim() + "&TOTAL_PARCIAL=" + total_parcial.trim() + "&BONUS=" + bonus.trim() + "&IMPOSTOS=" + impostos.trim() + "&TICKET_DESCONTO=" + ticket_desconto.trim(),
            url: '/web-files/server/add_pedido.php',
            success: function (data) {
//                alert(data)
//                return;
                console.log(data['CODPEDIDO']);
                //$("#list-drop-desejos").html(data);
                $(".LoaderFinale").addClass("hide");
                window.location = '/' + language + '/produtos/confirmacao/pedido/' + data['CODPEDIDO'];
            }
        });

    }

}

function checar_desconto() {

    var discount_name = $("#discount_name").val();
    $("#ticket_desconto").val("");

    if (discount_name.length != 6) {
        $(".cart-voucher-txt-alert").html("<strong>* Número de cupom inválido!</strong>");
    } else {
        $.ajax({
            type: 'post',
            data: 'CUPOM=' + discount_name,
            url: '/pt/produtos/checar-desconto',
            success: function (data) {
                if (data["success"] == "") {
                    $(".cart-voucher-txt-alert").html(data["erro_msg"]);
                    $("#ticket_desconto").val("");
                } else {
                    $(".cart-voucher-txt-alert").html(data["success"]);
                    $("#ticket_desconto").val(discount_name);
                }

//                console.log(data['CODPEDIDO']);
//                //$("#list-drop-desejos").html(data);
//                $(".LoaderFinale").addClass("hide");
//                window.location = '/' + language + '/produtos/confirmacao/pedido/' + data['CODPEDIDO'];
            }
        });
    }
}

function start_form_categoria() {
    $("#formCategoria").submit();
}

function add_checkout(params, url) {
    $(".Loader").removeClass('hide');
    var qntdd = parseInt($("#quantidade").val());
    var quantidade = "&QUANTIDADE=" + qntdd;
    var valores = params + quantidade;

    $.ajax({
        type: 'post',
        data: valores,
        url: '/web-files/server/add_lista_desejos.php',
        success: function (data) {
            //alert(data);
            //$("#list-drop-desejos").html(data);
            $(".Loader").addClass('hide');
            window.location = url;

            //window.location.reload();
            //$("a[title=Close]").click();
            //$(".myload_crop_" + indice).html("<strong style='color: #395aa4'>" + data + "</strong>");
        }
    });
}

function add_lista_desejos(params) {
    $(".Loader").removeClass('hide');
    var qntdd = parseInt($("#quantidade").val());
    var quantidade = "&QUANTIDADE=" + qntdd;
    var valores = params + quantidade;

    $.ajax({
        type: 'post',
        data: valores,
        url: '/web-files/server/add_lista_desejos.php',
        success: function (data) {
            //alert(data);
            $("#list-drop-desejos").html(data);
            $(".Loader").addClass('hide');

            var carrinho = $("#item_carrinho").html();
            var limpa_1 = carrinho.replace("Itens", "");
            var limpa_2 = limpa_1.replace("Item", "");
            var limpa_3 = limpa_2.replace("(Vazio)", "");
            var str = limpa_3.trim();

            if (str == "") {
                if (qntdd == 1) {
                    var resultado = qntdd + " Item";
                    $("#item_carrinho").html(resultado);
                } else {
                    var resultado = qntdd + " Itens";
                    $("#item_carrinho").html(resultado);
                }
            } else {

                var valor = parseInt(str) + qntdd;
                var resultado = valor + " Itens";
                $("#item_carrinho").html(resultado);
            }

            //window.location.reload();
            //$("a[title=Close]").click();
            //$(".myload_crop_" + indice).html("<strong style='color: #395aa4'>" + data + "</strong>");
        }
    });
}

function plus(valor) {
    var qntdd = parseInt($("#quantidade").val());
    if (valor == "mais") {
        qntdd = (qntdd + 1);
        $("#quantidade").val(qntdd);
        return false;
    } else {
        if ($("#quantidade").val() == 1) {
            return false;
        } else {
            qntdd = (qntdd - 1);
            $("#quantidade").val(qntdd);
            return false;
        }
    }
}

function monta_url_produtos() {
    var parte_1 = "";
    var parte_2 = "";
    var parte_3 = "";

    var selectPrductSort = $('#selectPrductSort').val();
    (selectPrductSort == "") ? parte_1 = "/sort/mais_novos" : parte_1 = "/sort/" + selectPrductSort;

    var qntdd_produtos = $('#qntdd_produtos').val();
    (qntdd_produtos == "") ? parte_2 = "/qntdd/4" : parte_2 = "/qntdd/" + qntdd_produtos;

    var pagina = $('#pagina').val();
    (pagina == "") ? parte_3 = "/pagina/1" : parte_3 = "/pagina/" + pagina;

    var link = $("#url").val() + parte_1 + parte_2 + parte_3;

    window.location = link;
}

function embalar_presente() {

    $.ajax({
        type: 'post',
        data: '',
        url: '/pt/produtos/embalar-presente',
        success: function (data) {
            if (parseInt(data)) {
                $(".yes").removeClass("hide");
            } else {
                $(".yes").addClass("hide");
            }
        }
    });
}

function finalizar_compra() {

    if ($(".step-1").hasClass("hide")) {

        $(".step-1").removeClass("hide");
        $("#step-1").html("<div style='text-align: center'><br/><img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 6%'/><br/><br/></div>");

        $.ajax({
            type: 'post',
            data: '',
            url: '/pt/produtos/autenticacao',
            success: function (data) {

                $(".next").addClass("hide");
                $("#step-1").html(data);

                if ($("#EXISTE_USER_LOGADO").val() == "SIM") {

                    $(".step-2").removeClass("hide");
                    $("#step-2").html("<div style='text-align: center'><br/><img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 6%'/><br/><br/></div>");

                    $.ajax({
                        type: 'post',
                        data: '',
                        url: '/pt/produtos/endereco/',
                        success: function (data) {
                            $(".load-autenticacao").addClass("hide");
                            $(".step-2").removeClass("hide");
                            $("#step-2").html(data);
                            get_action_cep();
                            if ($("#EXISTE_ENDERECO_ENTREGA").val() == "SIM") {
                                forma_envio();
                            }
                        }
                    });
                }
            }
        });
    }

}

function criar_conta() {

    $(".load-criar-conta").removeClass("hide");

    $.ajax({
        type: 'post',
        data: 'email=' + $(".email-criar-conta").val() + "&actionType=criar_conta",
        url: '/pt/produtos/autenticacao',
        success: function (data) {
            $(".load-criar-conta").addClass("hide");
            $("#step-1").html(data);
        }
    });
}

function autenticacao() {

    $(".load-autenticacao").removeClass("hide");

    $.ajax({
        type: 'post',
        data: 'email=' + $(".email-autenticacao").val() + "&actionType=login&senha=" + $(".senha-autenticacao").val(),
        url: '/pt/produtos/autenticacao',
        success: function (data) {
            //data['msg_erro_login'];
            //alert(data); return false;

            if (data == "/produtos/endereco/") {
                $.ajax({
                    type: 'post',
                    data: '',
                    url: '/pt/produtos/endereco/',
                    success: function (data) {
                        $(".load-autenticacao").addClass("hide");
                        $(".step-2").removeClass("hide");
                        $("#step-2").html(data);
                        get_action_cep();
                        if ($("#EXISTE_ENDERECO_ENTREGA").val() == "SIM") {
                            forma_envio();
                        }
                    }
                });

                $.ajax({
                    type: 'post',
                    data: '',
                    url: '/pt/produtos/autenticacao',
                    success: function (data) {
                        $(".load-autenticacao").addClass("hide");
                        $("#step-1").html(data);
                    }
                });

            } else {
                $(".load-autenticacao").addClass("hide");
                $("#step-1").html(data);
            }

        }
    });

}



function get_action_cep() {

    if (document.getElementById("cep") != null) {
        $('#cep').mask('99999-999');
        $('#cep').change(function () {
            var cep = jQuery(this).val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: '/web-files/server/cep.php',
                success: function (data) {
                    $(".Loader").addClass('hide');
                    $("#logradouro").val(data["Logradouro"]);
                    $("#bairro").val(data["Bairro"]);
                    $("#cidade").val(data["Cidade"]);
                    $("#estado").val(data["UF"]);
                }
            });

        });
    }

    if (document.getElementById("pesquisar_endereco") != null) {
        $('#pesquisar_endereco').click(function () {
            var cep = $("#cep").val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: '/web-files/server/cep.php',
                success: function (data) {
                    $(".Loader").addClass('hide');
                    $("#logradouro").val(data["Logradouro"]);
                    $("#bairro").val(data["Bairro"]);
                    $("#cidade").val(data["Cidade"]);
                    $("#estado").val(data["UF"]);
                }
            });

        });
    }

    if (document.getElementById("mais_enderecos") != null) {
        $("#mais_enderecos").click(function () {
            if ($("#formulario_enderecos").hasClass("hide")) {
                $("#formulario_enderecos").removeClass("hide");
                $("#mais_enderecos").html("- ENDEREÇO");
            } else {
                $("#formulario_enderecos").addClass("hide");
                $("#mais_enderecos").html("+ ENDEREÇO");
            }

        });
    }
}

function cadastrar_endereco() {

    $(".Loader-endereco").removeClass("hide");

    var url = "estado=" + $("#estado").val() +
            "&cep=" + $("#cep").val() +
            "&logradouro=" + $("#logradouro").val() +
            "&numero=" + $("#numero").val() +
            "&complemento=" + $("#complemento").val() +
            "&bairro=" + $("#bairro").val() +
            "&cidade=" + $("#cidade").val();

    $.ajax({
        type: 'post',
        data: url,
        url: '/pt/produtos/endereco/',
        success: function (data) {
            $("#step-2").html(data);
            get_action_cep();
            forma_envio();
        }
    });
}

function forma_envio() {

    $(".step-3").removeClass("hide");
    $(".meu-endereco-entrega").addClass("hide");
    $("#step-3").html("<div style='text-align: center'><br/><img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 6%'/><br/><br/></div>");

    $.ajax({
        type: 'post',
        data: '',
        url: '/pt/produtos/pagamento/',
        success: function (data) {
            $("#step-3").html(data);
            if ($('.myFormaEnvio').hasClass("myFormaEnvio")) {
                $(".myFormaEnvio").change(function () {
                    get_soma_peso();
                });
            }
            get_soma_peso();
        }
    });
}

var checkout_panel_offset = $('#checkout-panel-2').offset().top - 50;

$(window).scroll(function () {
    var position = $('body').scrollTop();
    if (position > checkout_panel_offset) {
        $('#checkout-panel-2').addClass('active');
    } else {
        $('#checkout-panel-2').removeClass("active");
    }
});
$(function () {
    Plugins.init();
});

///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
/*deste codigo em diante o atendimento online*/

function open_atendimento() {
    alert("não está pronto!");
}

function init_chat() {
    $(".atendimento_loading").removeClass("hide");
    ($("#enviar_email").is(":checked")) ? box = "on" : box = "off";

    $.ajax({
        type: 'post',
        data: 'nome=' + $("#nome").val() + '&email=' + $("#email").val() + "&enviar_email=" + box,
        url: '/' + $("#language") + '/atendimento/valida-dados',
        success: function (data) {
            $(".atendimento_loading").addClass("hide");
            $(".text_atendimento").html(data);
            setInterval(myTimer, 1000);
            setInterval(getAtendente, 1000);
//            console.log(data);
        }
    });
}

function myTimer() {

    var d = new Date();
    var t = d.toLocaleTimeString();
    $(".timer_chat").html(t);
    //console.log(t + " teste");
    //$(".chat_text").append("<div style='display: inline-block; line-height: 1.2; font-size: 16px;'>" + t + "</div>");
}

function getAtendente() {

    $.ajax({
        type: 'post',
        data: 'codatendimento=' + $("#codatendimento").val(),
        url: '/' + $("#language") + '/atendimento/get-atendente',
        success: function (data) {
//            console.log(data);
        }
    });
}

function meusAtendimentos() {
    $.ajax({
        type: 'post',
        data: 'codatendente=' + $("#codatendente").val(),
        url: '/pt/atendimento/get-usuarios-fila',
        success: function (data) {
//            console.log(data);
            $(".meus-atendimentos").html(data);

        }
    });
}

//function myStopFunction() {
//    clearInterval(myVar);
//}
