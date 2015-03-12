function getMyFolderRoot() {
    return "/homolog";
}

$(document).ready(function() {

    if (document.getElementById("selectPrductSort") != null) {
        $('#selectPrductSort').change(function() {
            monta_url_produtos();
        });
    }

    if (document.getElementById("selectPrductSort_2") != null) {
        $('#selectPrductSort_2').change(function() {
            monta_url_produtos();
        });
    }

    if (document.getElementById("qntdd_produtos") != null) {
        $('#qntdd_produtos').change(function() {
            monta_url_produtos();
        });
    }

    if (document.getElementById("trocar_senha") != null) {
        $("#trocar_senha").click(function() {
            if ($(".show_senha").hasClass("hide")) {
                $(".show_senha").removeClass("hide");
            } else {
                $(".show_senha").addClass("hide");
            }
        });
    }

    if (document.getElementById("btn_avaliacao") != null) {
        $("#btn_avaliacao").click(function() {
            computa_avaliacao();
        });
        get_avaliacao();
        console.log("btn_avaliacao: 1");
    }

    if (document.getElementById("btn_avaliacao_timer") != null) {
        get_avaliacao();
        console.log("btn_avaliacao_timer: 2");
    }

    if (document.getElementById("cep") != null) {
        $('#cep').mask('99999-999');
        $('#cep').change(function() {
            var cep = jQuery(this).val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: getMyFolderRoot() + '/web-files/server/cep.php',
                success: function(data) {
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
        $('#pesquisar_endereco').click(function() {
            var cep = $("#cep").val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: getMyFolderRoot() + '/web-files/server/cep.php',
                success: function(data) {
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
        $("#mais_enderecos").click(function() {
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
            onDragStart: function(table, row) {
                $(".Loader").removeClass('hide');
//                console.log(table);
//                console.log(row);
                //$("#debugArea").html("Started dragging row "+row.id);
                //$(table).parent().find('.result').text("Started dragging row "+row.id);
            },
            onDragClass: "myDragClass active",
            onDrop: function() {
                var keys = null;
                $("#table-1").find("tr").each(function(i) {
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
                    url: getMyFolderRoot() + '/web-files/server/order_produtos.php',
                    success: function(data) {
                        $(".Loader").addClass('hide');
//                        console.log(data);
                    }
                });
            }
        });

        $("#table-1").find("tr").each(function(i) {
            if (i % 2 == 1) {
                jQuery(this).addClass('myDragClass');
            }
        });
    }

    if (document.getElementById("preco") != null) {
        $("#preco").keyup(function() {
            $(".view-preco").html($("#preco").val());
        });
    }

    if (document.getElementById("de") != null) {
        $("#de").keyup(function() {
            $(".view-preco-de").html($("#de").val());
        });
    }


    if (document.getElementById("nome") != null) {
        $("#nome").keyup(function() {
            $(".view-nome").html($("#nome").val());
        });
    }


    if (document.getElementById("linha_1") != null) {
        $("#linha_1").keyup(function() {
            $(".view-linha_1").html($("#linha_1").val());
        });
    }


    if (document.getElementById("linha_2") != null) {
        $("#linha_2").keyup(function() {
            $(".view-linha_2").html($("#linha_2").val());
        });
    }


    if (document.getElementById("linha_3") != null) {
        $("#linha_3").keyup(function() {
            $(".view-linha_3").html($("#linha_3").val());
        });
    }


    if ($('.fancybox').hasClass("fancybox")) {
        $('.fancybox').fancybox({
            "hideOnContentClick": true,
            afterClose: function() {
                window.location.reload();
            }
        });
    }

    if ($('.avise-me-ao-chegar-button').hasClass("avise-me-ao-chegar-button")) {
        $('.avise-me-ao-chegar-button').click(function() {
            avise_me_chegar();
        });
    }


    if ($('.fancybox-crop').hasClass("fancybox-crop")) {
        $('.fancybox-crop').fancybox({
            "hideOnContentClick": true
        });
    }

    if (document.getElementById("m-btn") != null) {
        $("#m-btn").click(function(e) {
            e.preventDefault();
//            console.log("click");

        });
    }

    if (document.getElementById("url_amigavel") != null) {
        var url_amigavel = $("#url_amigavel").val();
        var folder = getMyFolderRoot();
        var settings = {
            url: folder + "/web-files/server/upload.php?url_amigavel=" + url_amigavel,
            method: "POST",
            allowedTypes: "jpg,png,gif,doc,pdf,zip",
            fileName: "myfile",
            multiple: true,
            onSuccess: function(files, data, xhr)
            {
                $("#status").html("<font color='green'>Imagens enviadas com sucesso!</font>");

            },
            onError: function(files, status, errMsg)
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
            onDragStart: function(table, row) {
                $(".Loader").removeClass('hide');
//                console.log(table);
//                console.log(row);
                //$("#debugArea").html("Started dragging row "+row.id);
                //$(table).parent().find('.result').text("Started dragging row "+row.id);
            },
            onDragClass: "myDragClass active",
            onDrop: function() {
                var keys = null;
                $("#table-1").find("tr").each(function(i) {
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
                    url: getMyFolderRoot() + '/web-files/server/order_fotos.php',
                    success: function(data) {
                        $(".Loader").addClass('hide');
                        console.log(data);
                    }
                });
            }
        });

        if (document.getElementById("table-1") != null) {
            $("#table-1").find("tr").each(function(i) {
                if (i % 2 == 1) {
                    jQuery(this).addClass('myDragClass');
                }
            });
        }

    }


    if (document.getElementById("btn_cep") != null) {
        $("#btn_cep").click(function() {
            get_soma_peso();
        });
    }

    if (document.getElementById("btn_calc_cep_rapido") != null) {
        $("#btn_calc_cep_rapido").click(function() {
            get_soma_peso2();
        });
    }

    if (document.getElementById("forma_envio") != null) {
        $("#forma_envio").change(function() {
            get_soma_peso();
        });
    }

    if (document.getElementById("forma_envio_rapido") != null) {
        $("#forma_envio_rapido").change(function() {
            get_soma_peso2();
        });
    }

    if ($('.myFormaEnvio').hasClass("myFormaEnvio")) {
        $(".myFormaEnvio").change(function() {
            get_soma_peso();
        });
    }

    if (document.getElementById("resume-somos") != null) {
        $.ajax({
            type: 'post',
            data: "keys=",
            url: getMyFolderRoot() + '/web-files/server/get_resume_somos.php',
            success: function(data) {
                $("#resume-somos").html(data);
                console.log(data);
            }
        });
    }

    if (document.getElementById("accordion") != null) {
        $(function() {
            $("#accordion").accordion();
        });
    }

    if (document.getElementById("btn_atendimento") != null) {
        $("#btn_atendimento").click(function() {
            ($(".window_atendimento").hasClass("hide")) ? $(".window_atendimento").removeClass("hide") : $(".window_atendimento").addClass("hide");
            $(".load_atendimento").removeClass("hide");
            $(".text_atendimento").addClass("hide");

            $.ajax({
                type: 'post',
                data: "keys=",
                url: getMyFolderRoot() + '/' + $("#language") + '/atendimento',
                success: function(data) {
                    $(".text_atendimento").removeClass("hide");
                    $(".text_atendimento").html(data);
                    $(".load_atendimento").addClass("hide");
                    console.log(data);
                }
            });

        });
    }

    if ($('.btn_close').hasClass("btn_close")) {
        $(".btn_close").click(function() {
            $(".body_atendimento").addClass("hide");
        });
    }

    if ($('.meus-atendimentos').hasClass("meus-atendimentos")) {
        setInterval(meusAtendimentos, 1000);
    }

});


function speed_login() {
    $.fancybox(
            "<div class='row'>" +
            "<div class='col-lg-12'>" +
            "<div class='auth-form-wrapper'>" +
            "<h3 class='auth-form-title'>Realizar Login</h3>" +
            "<form name='form-autenticacao' id='form-autenticacao' class='' onsubmit='return false' method='post' >" +
            "<div class='alert alert-info' role=''>Informe seus dados de acesso</div>" +
            "<input type='hidden' name='actionType' class='actionType-criar-conta' value=''/>" +
            "<p><input type='text' class='form-control email-autenticacao' id='email' name='email' maxlength='70' value='' placeholder='E-mail'/></p>" +
            "<p><input type='password' class='form-control  senha-autenticacao' id='senha' name='senha' maxlength='70' value='' placeholder='Senha'/></p>" +
            "<p>" +
            "<button type='submit' class='btn btn-primary btn-primary-maria' name='enviar' onclick='javascript:autenticacao2();' style='margin-right: 5px;'>Entrar</button><br/><br/><a href='/pt/conta/esqueceu-senha/' target='blank'>Esqueceu sua senha?</a>" +
            "<br/><span class='load-autenticacao hide'><img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 8%;'/></span>" +
            "</p>" +
            "</form>" +
            "</div>" +
            "</div>" +
            "</div>",
            {'autoDimensions': false,
                'width': 'auto',
                'height': 'auto',
                'transitionIn': 'none',
                'transitionOut': 'none'}
    );
}

//
//function myTimerAvaliacao() {
//    var d = new Date();
//    var t = d.toLocaleTimeString();
//    
//    $.ajax({
//        type: 'post',
//        data: "search=" + search,
//        url: getMyFolderRoot() + "/pt/avaliacao/timer-avalicacao",
//        success: function(data) {
//            if(data != ""){
//                clearInterval(myTimerAvaliacao());
//                window.location.reload();
//            }           
//        }
//    });
//    
//    
//}

function computa_avaliacao() {

    var codproduto = $("#codproduto").val();
    var codcadastro = $("#codcadastro").val();
    var avaliacao = $("#avaliacao").val();
    $("#msg_erro_avaliacao").html(null);

    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&codcadastro=" + codcadastro + "&avaliacao=" + avaliacao,
        url: getMyFolderRoot() + "/pt/avaliacao/computar-avaliacao",
        success: function(data) {
            if (data == "PRODUTO_AVALIADO") {
                $("#msg_erro_avaliacao").html("Sua avaliação já foi computada!");
            } else {
                $("#msg_erro_avaliacao").html("Voto computado com sucesso!");
            }
        }
    });
}

function get_avaliacao() {

    var codproduto = $("#codproduto").val();
    var codcadastro = $("#codcadastro").val();
    var avaliacao = $("#avaliacao").val();
    $("#msg_erro_avaliacao").html(null);

    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&codcadastro=" + codcadastro + "&avaliacao=" + avaliacao,
        url: getMyFolderRoot() + "/pt/avaliacao/get-avaliacao",
        success: function(data) {
            console.log(data);
//            if(data == "PRODUTO_AVALIADO"){
//                $("#msg_erro_avaliacao").html("Sua avaliação já foi computada!");
//            } else {
//                $("#msg_erro_avaliacao").html("Voto computado com sucesso!");
//            }
        }
    });
}

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
    $("#formListenderecos").html("<h1 style='align: center;'><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 21px;'></h1>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: getMyFolderRoot() + '/web-files/server/status_endereco.php',
        success: function(data) {
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

function avise_me_chegar() {

    var email = $(".avise-me-ao-chegar").val();
    var referencia = $(".avise-me-ao-referencia").val();


    $.ajax({
        type: 'post',
        data: "EMAIL=" + email + "&REFERENCIA=" + referencia,
        url: getMyFolderRoot() + '/pt/informacoes/avise-me-chegar',
        success: function(data) {
            $(".avise-me-ao-chegar-error").html(data);
            $(".avise-me-ao-chegar").val(null);
        }
    });
}

function alter_endereco_entrega2(codendereco, codcadastro) {

    //prepend
    //append
    $("#formListenderecos").html("<h1 style='align: center;'><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 21px;'></h1>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: getMyFolderRoot() + '/web-files/server/status_endereco.php',
        success: function(data) {
            $("#formListenderecos").html(data);
            $(".Loader").addClass('hide');
            console.log(data);
        }
    });
}

function del_row_enderecos(codendereco, codcadastro) {

    $("#formListenderecos").html("<img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 9%;'>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: getMyFolderRoot() + '/web-files/server/delete_endereco.php',
        success: function(data) {
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

function del_row_enderecos2(codendereco, codcadastro) {

    $("#formListenderecos").html("<h1 style='align: center;'><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 21px;'></h1>");

    $.ajax({
        type: 'post',
        data: "CODENDERECO=" + codendereco + "&CODCADASTRO=" + codcadastro,
        url: getMyFolderRoot() + '/web-files/server/delete_endereco.php',
        success: function(data) {

            $(".Loader").addClass('hide');
            if (data == "reload") {
                $("#formListenderecos").html("<div class='alert alert-warning' role='alert'><strong>Atenção: </strong>Não existe endereços de entrega cadastrado</div>");
            } else {
                $("#formListenderecos").html(data);
            }
            console.log(data);
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
        url: getMyFolderRoot() + '/web-files/server/update_qntdd.php',
        success: function(data) {
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

function release_crop(key, imagem, codfoto, indice, dimensao, guid) {

    var dataX1 = $("#" + key + "_dataX1_" + indice).val();
    var dataY1 = $("#" + key + "_dataY1_" + indice).val();
    var dataX2 = $("#" + key + "_dataX2_" + indice).val();
    var dataY2 = $("#" + key + "_dataY2_" + indice).val();
    var dataWidth = $("#" + key + "_dataWidth_" + indice).val();
    var dataHeight = $("#" + key + "_dataHeight_" + indice).val();
    var link = '';
    if (dimensao == "retrato") {
        link = getMyFolderRoot() + '/web-files/server/crop.php';
    } else {
        link = getMyFolderRoot() + '/web-files/server/crop_paisagem.php';
    }

    $(".LoaderCrop").removeClass('hide');

    $.ajax({
        type: 'post',
        data: "indice=" + indice + "&x1=" + dataX1 + "&y1=" + dataY1 + "&x2=" + dataX2 + "&y2=" + dataY2 + "&w=" + dataWidth + "&h=" + dataHeight + "&codfoto=" + codfoto + "&imagem=" + imagem,
        url: link,
        success: function(data) {
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
        url: getMyFolderRoot() + '/web-files/server/plus_wishlist.php',
        success: function(data) {
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


function plus_wishlist2(url, codlistaprodutos) {

    $.ajax({
        type: 'post',
        data: url,
        url: getMyFolderRoot() + '/web-files/server/plus_wishlist2.php',
        success: function(data) {
            $("#shopping-cart").html("<span class='label label-primary'>" + data + "</span>Meu Carrinho");

            if (url.indexOf("mais") != -1) {
                $("#input_" + codlistaprodutos).val((parseInt($("#input_" + codlistaprodutos).val()) + 1));
            } else {
                if ((parseInt($("#input_" + codlistaprodutos).val()) - 1) == 0) {
                    $("#input_" + codlistaprodutos).val(1);
                } else {
                    $("#input_" + codlistaprodutos).val((parseInt($("#input_" + codlistaprodutos).val()) - 1));
                }
            }
        }
    });
}

function plus_wishlist_checkout(url, codlistaprodutos) {

    /*
     * VARIAVEL QUE CARREGA AS 3 REQUISICOES AJAX
     */
    var html1 = null;
    var html2 = null;
    var html3 = null;
    var html4 = null;

    /*
     * CARREGA O PRELOAD AO LADO DO "SEUS PRODUTOS"
     */
    $(".img-load-seus-produtos").removeClass("hide");

    /*
     * PRIMEIRA REQUISICAO AJAX FAZ INTEGRACAO AO BANCO DE DADOS E ATUALIZA A LISTA COM A QUANTIDADE
     * DE PEDIDOS FEITOS NO PELO CLIENTE
     */
    $.ajax({
        type: 'post',
        data: url,
        url: getMyFolderRoot() + '/web-files/server/plus_wishlist2.php',
        success: function(data) {
            /*
             * ARMAZENA O PRIMEIRO HTML
             */
            html1 = "<span class='label label-primary'>" + data + "</span>Meu Carrinho";
            /*
             * SEGUNDA REQUISICAO AJAX BUSCA O HTML DA NOVA LISTA
             */
            $.ajax({
                type: 'post',
                data: url,
                url: getMyFolderRoot() + '/pt/produtos/checkout-update/',
                success: function(data) {
                    /*
                     * ARMAZENA O SEGUNDO HTML
                     */
                    html2 = data;
                    /*
                     * TERCEIRA REQUISICAO AJAX BUSCA O HTML DO CUPOM DE DESCONTOS
                     */
                    $.ajax({
                        type: 'post',
                        data: url,
                        url: getMyFolderRoot() + '/pt/produtos/checkout-cupom-desconto/',
                        success: function(data) {
                            /*
                             * ARMAZENA O TERCEIRO HTML
                             */
                            html3 = data;

                            /*
                             * REQUISICAO AJAX PARA ALTERAR HTML DO TOP
                             */
                            $.ajax({
                                type: 'post',
                                data: '',
                                url: getMyFolderRoot() + '/pt/index/top',
                                success: function(data) {
                                    /*
                                     * ARMAZENA O QUARTO HTML
                                     */
                                    html4 = data;
                                    /*
                                     * ATUALIZA PELO O REQUEST DOS 3 AJAX DE UMA SO VEZ
                                     */
                                    $("#shopping-cart").html(html1);
                                    $('.tbody-update').html(html2);
                                    $('.checkout-panel-2').html(html3);
                                    $("#stt_logado_print").html(html4);
                                    /*
                                     * ESCONDE O PRELOAD AO LADO DO "SEUS PRODUTOS"
                                     */
                                    $(".img-load-seus-produtos").addClass("hide");
                                    /*
                                     * CHAMA FUNCAO QUE ATUALIZA TODA A ESTRUTURA ABAIXO DO CADEADO DO CHECKOUT
                                     */
                                    finalizar_compra();

                                }
                            });

                        }
                    });
                }
            });
        }
    });

}


function calcula_bonus() {
    $.ajax({
        type: 'post',
        data: '',
        url: getMyFolderRoot() + '/pt/produtos/calcula-bonus',
        success: function(data) {
            $(".bonus").html(data);
        }
    });
}


function cielo(client_hidden, codcadastro, codendereco, language) {

    var total_geral = $("#total_geral").html();
    var produto = total_geral.replace(/\,|\./, "");

    var url = 'CLIENT_HIDDEN=' + client_hidden +
            '&CODCADASTRO=' + codcadastro +
            '&CODENDERECO=' + codendereco +
            '&CODIGOBANDEIRA=' + $("#CieloForm").find("input[type=radio]:checked").val() +
            '&FORMAPAGAMENTO=' + $("#formaPagamento").val() +
            '&CARTAOCODIGOSEGURANCA=' + $("#cartaoCodigoSeguranca").val() +
            '&CARTAONUMERO=' + $("#cartaoNumero").val() +
            '&CAPTURARAUTOMATICAMENTE=' + $("#capturarAutomaticamente").val() +
            '&TENTARAUTENTICAR=' + $("#tentarAutenticar").val() +
            '&INDICADORAUTORIZACAO=' + $("#indicadorAutorizacao").val() +
            '&TIPOPARCELAMENTO=' + $("#tipoParcelamento").val() +
            '&PRODUTO=' + produto +
            '&NOMETITULO=' + $("#nomeTitulo").val() +
            '&CARTAOVALIDADE=' + $("#cartaoValidade").val();

    $.ajax({
        type: 'post',
        data: url,
        url: getMyFolderRoot() + '/pt/produtos/cielo',
        success: function(data) {
            $(".return-cielo").html(data);
            if (data == "TRANSACAO_AUTORIZADA") {
                $("#alert_cielo").removeClass("alert-info");
                $("#alert_cielo").removeClass("alert-danger");
                $("#alert_cielo").removeClass("alert-success");
                $("#alert_cielo").html("<strong>* Transação autorizada</strong>!")
                finalizar_pedido(client_hidden, codcadastro, codendereco, language, 'cielo');
            } else {
                $("#alert_cielo").removeClass("alert-info");
                $("#alert_cielo").addClass("alert-danger");

                $("#cartaoNumero").val("");
                $("#cartaoValidade").val("");
                $("#cartaoCodigoSeguranca").val("");
                $("#nomeTitulo").val("");
                document.getElementById("formaPagamento").selectedIndex = 0;
                //$("#alert_cielo").html("<strong>ATENÇÃO: </strong>* Verifique os dados informados!");
                $("#alert_cielo").html(data);
            }
            console.log(data);
        }
    });
}

function boleto(client_hidden, codcadastro, codendereco, language) {

    finalizar_pedido(client_hidden, codcadastro, codendereco, language, 'boleto');
}

function paypal(client_hidden, codcadastro, codendereco, language) {

    finalizar_pedido(client_hidden, codcadastro, codendereco, language, 'paypal');
}

function del_row_wishlist(url) {
    $.ajax({
        type: 'post',
        data: url,
        url: getMyFolderRoot() + '/web-files/server/del_row_wishlist.php',
        success: function(data) {
            console.log(data);
            window.location.reload();
        }
    });
}

/*
 * FUNCAO QUE REALIZA O CALCULO DE SOMA DO FRETE 
 * CAPTURANDO INFORMACOES NO WEBSERVICE DOS CORREIOS OU TOTAL EXPRESS
 */

function get_soma_peso() {

    /*
     * REMOVE A CLASSE HIDE PARA EXIBIR O PRELOAD
     */
    $(".Loader").removeClass('hide');
    /*
     * CARREGA O CEP DA LOJA MARIA DE BARRO
     */
    var cep_remetente = $("#cep_remetente").val();
    /*
     * CARREGA O CEP DO DESTINATARIO
     */
    var cep_destinatario = $("#cep_destinatario_2").val();
    /*
     * CARREGA O PESO TOTAL DA COMPRA
     */
    var total_peso = $("#total_peso").val();
    /*
     * CARREGA A FORMA DE ENVIO SELECIONADA
     */
    var forma_envio = $("#forma_envio").val();
    /*
     * REMOVE O IFEM DOS CEP'S CASO EXISTA
     */
    var cr = cep_remetente.replace("-", "");
    var cd = cep_destinatario.replace("-", "");
    /*
     * CARREGA O VALOR TOTAL DA COMPRA JUNTAMENTE COM PS IMPOSTOS
     */
    var total_parcial = $("#total_parcial").html();
    var total_impostos = $("#total_impostos").html();

    /*
     * CHECA SE O CEP DO CLIENTE E UM CEP VALIDO
     */
    if (cd.length == 8) {
        /*
         * MONTA OS DADOS QUE SERAO PASSADOS VIA POST PELO AJAX
         */
        var url = "cep_remetente=" + cr
                + "&cep_destinatario=" + cd
                + "&total_peso=" + total_peso
                + "&forma_envio=" + forma_envio
                + "&total_geral=" + total_parcial.trim()
                + "&total_impostos=" + total_impostos.trim();
        /*
         * REALIZA A CHAMADA AJAX
         */
        $.ajax({
            type: 'post',
            data: url,
            url: getMyFolderRoot() + '/web-files/server/get_valor_frete.php',
            success: function(data) {

                /*
                 * RETIRA O PRELOAD 
                 */
                $(".Loader").addClass('hide');

                /*
                 * CASO TENHA ESCOLHIDO ALGUMA FORMA DE ENVIO TANTO CORREIOS QUANTO TRANSPORTADORA
                 */
                if (forma_envio == "total_express"
                        || forma_envio == "41106"
                        || forma_envio == "40010"
                        || forma_envio == "40215"
                        || forma_envio == "40290")
                {
                    /*
                     * EXIBE O PRAZO DE ENTREGA
                     */
                    $(".prazo_entrega_tr").removeClass("hide");
                    /*
                     * MONTA STRING BASEADO EM REGRA DE NEGOCIO DA LOJA
                     */
                    var pz = data["prazo_entrega"];
                    if (!isNaN(pz)) {
                        var pzd = parseInt(pz);
                        var str = "";
                        if (pzd == 0) {
                            str = "de 2 a 3 dias uteis";
                        } else {
                            str = "de " + pzd + " a " + (pzd + 4) + " dias uteis";
                        }
                    } else {
                        str = "";
                    }
                    /*
                     * EXIBE O PRAZO DE ENTREGA ESTIMADO PELOS WEBSERVICE OU PELA LOJA
                     */
                    $("#prazo_entrega").html(str);

                } else {

                    /*
                     * CASO TENHA ESCOLHIDO BUSCAR NA LOJA ESCONDE O PRAZO DE ENTREGA
                     */
                    $(".prazo_entrega_tr").addClass("hide");

                    /*
                     * REMOVE ALGUM HTML EXISTENTE DO PRAZO DE ENTREGA
                     */
                    $("#prazo_entrega").html(null);
                }
                /*
                 * ATUALIZA A SOMATORIA NO QUADRO DE DESCONTOS
                 */
                $("#total_geral").html(data["soma"]);
                $("#taxa_entrega").html(data["frete"]);
                $("#msg_erro").html(data["msg_erro"]);
                $("#total_impostos").html(data["total_impostos"]);

                /*
                 * MANTEM A EXIBICAO DO PASSO TRES
                 */
                if (data["frete"] != "Gratis") {
                    $(".step-3").removeClass("hide");
                }

                forma_pgto();
            }
        });
    } else {
        $(".Loader").addClass('hide');
    }

}

function get_soma_peso2() {

    $("#prazo").html(null);
    $("#frete").html(null);
    $("#msg_erro").html(null);
    $("#table-frete").css("display", "none");
    $(".LoaderImg").removeClass('hide');

    var cep_remetente = $("#cep_remetente").val();
    var cep_destinatario = $("#cep_destinatario").val();
    var total_peso = $("#total_peso").val();
    var forma_envio = $("#forma_envio_rapido").val();

    var cr = cep_remetente.replace("-", "");
    var cd = cep_destinatario.replace("-", "");


    var total_parcial = $("#total_parcial").val();
    if (total_parcial == "") {
        var total_parcial = $("#total_parcial").html();
    }

    var total_impostos = $("#total_impostos").val();
    if (total_impostos == "") {
        var total_impostos = $("#total_impostos").html();
    }

    if (cd.length == 8) {

        var url = "cep_remetente=" + cr
                + "&cep_destinatario=" + cd
                + "&total_peso=" + total_peso
                + "&forma_envio=" + forma_envio
                + "&total_geral=" + total_parcial.trim()
                + "&total_impostos=" + total_impostos.trim();

        $.ajax({
            type: 'post',
            data: url,
            url: getMyFolderRoot() + '/web-files/server/get_valor_frete.php',
            success: function(data) {

                console.log(data + " forma pgto 2");

                var pz = data["prazo_entrega"];
                if (!isNaN(pz)) {
                    var pzd = parseInt(pz);
                    var str = "";
                    if (pzd == 0) {
                        str = "de 2 a 3 dias uteis";
                    } else {
                        //(pzd == 1) ? str = (pzd + 3) + " dias utel" : str = pzd + " dias";
                        str = "de " + pzd + " a " + (pzd + 4) + " dias uteis";
                    }
                } else {
                    str = "";
                }

                var prazo_entrega = str;
                var frete = data["frete"];
                var msg_erro = data["msg_erro"];

                if (msg_erro == "") {

                    var fe = null;
                    switch (forma_envio) {
                        case 'total_express':
                            fe = "Total Express - Transportadora";
                            break;
                        case '41106':
                            fe = "Correios - PAC";
                            break;
                        case '40010':
                            fe = "Correios - SEDEX";
                            break;
                        case '40215':
                            fe = "Correios - SEDEX 10";
                            break;
                        case '40290':
                            fe = "Correios - SEDEX hoje";
                            break;
                        case '81019':
                            fe = "e-SEDEX";
                            break;
                    }

                    $("#table-frete").css("display", "block");
                    $("#prazo").html(prazo_entrega);
                    $("#frete").html("R$ " + frete);
                    $("#entrega").html(fe);

                } else {

                    $("#table-frete").css("display", "none");
                    $("#msg_erro").html(msg_erro)
                }

                $(".LoaderImg").addClass('hide');
                console.log(data);
            }
        });
    } else {
        $(".LoaderImg").addClass('hide');
    }

}

function forma_pgto() {

    $(".step-4").removeClass("hide");
    $("#step-4").html("<div style='text-align: center'><br/><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 21px'/><br/><br/></div>");

    if ($("#taxa_entrega").html() == "0,00") {
        $(".step-4").addClass("hide");
    } else {
        $.ajax({
            type: 'post',
            data: '',
            url: getMyFolderRoot() + '/pt/produtos/forma-pgto',
            success: function(data) {
                console.log(data);
                $("#step-4").html(data);
                var total_geral = $("#total_geral").html();
                $("#exibe_valor").html(total_geral);

                var tg1 = total_geral.replace(/\,|\./, "");
                $("input[type=hidden]").each(function(i) {
                    if ($(this).attr("name") == "produto")
                        $(this).val(tg1);
                });

                Plugins.init();
                //            $('#cartao-numero').validateCreditCard(function (e) {
                //                return $("#cartao-numero").removeClass(), null == e.card_type ? void $(".vertical.maestro").slideUp({duration: 200}).animate({opacity: 0}, {queue: !1, duration: 200}) : ($("#cartao-numero").addClass(e.card_type.name), "maestro" === e.card_type.name ? $(".vertical.maestro").slideDown({duration: 200}).animate({opacity: 1}, {queue: !1}) : $(".vertical.maestro").slideUp({duration: 200}).animate({opacity: 0}, {queue: !1, duration: 200}), e.length_valid && e.luhn_valid ? $("#cartao-numero").addClass("valid") : $("#cartao-numero").removeClass("valid"))
                //            }, {accept: ["visa", "visa_electron", "mastercard", "maestro", "discover"]});

            }
        });
    }



}



function add_checkout_list(params, url, loading) {
    $("." + loading).removeClass('hide');
    var qntdd = parseInt($("#quantidade").val());
    var quantidade = "&QUANTIDADE=" + qntdd;
    var valores = params + quantidade;

    alert(window.href);

    $.ajax({
        type: 'post',
        data: valores,
        url: getMyFolderRoot() + '/web-files/server/add_lista_desejos.php',
        success: function(data) {
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


    //alert(pgto);
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

        //console.log(f_envio);
        var total_geral = $("#total_geral").html();
        var total_parcial = $("#total_parcial").html();
        var bonus = $(".bonus").html();
        var impostos = $("#total_impostos").html();
        var ticket_desconto = $("#ticket_desconto").val();

//        alert(ticket_desconto);

        $.ajax({
            type: 'post',
            data: "LANGUAGE=" + language + "&FORMA_PGTO=" + form_pgto + "&CLIENT_HIDDEN=" + client_hidden + "&CODCADASTRO=" + codcadastro + "&CODENDERECO=" + codendereco + "&FORMA_ENVIO=" + f_envio + "&TAXA_ENTREGA=" + taxa_entrega.html() + "&TOTAL_GERAL=" + total_geral + "&TOTAL_PARCIAL=" + total_parcial + "&BONUS=" + bonus + "&IMPOSTOS=" + impostos + "&TICKET_DESCONTO=" + ticket_desconto,
            url: getMyFolderRoot() + '/web-files/server/add_pedido.php',
            success: function(data) {

                // =====================================
                // ANALYTICS
                // =====================================

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-56768389-1']);
                _gaq.push(['_trackPageview']);
                _gaq.push(['_set', 'currencyCode', 'BRL']);
                _gaq.push(['_addTrans',
                    '', // transaction ID - required
                    '', // affiliation or store name
                    '', // total - required
                    '', // tax
                    '', // shipping
                    '', // city
                    '', // state or province
                    ''             // country
                ]);

                _gaq.push(['_addItem',
                    '', // transaction ID - required
                    '', // SKU/code - required
                    '', // product name
                    '', // category or variation
                    '', // unit price - required
                    ''               // quantity - required
                ]);
                _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers

                (function() {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();

                // =====================================
                // /ANALYTICS
                // =====================================

                console.log(data);
                //$("#list-drop-desejos").html(data);
                $(".LoaderFinale").addClass("hide");
                if (form_pgto == "paypal") {
                    window.location = getMyFolderRoot() + '/' + language + '/produtos/pgto-paypal/pedido/' + data;
                } else {

                    window.location = getMyFolderRoot() + '/' + language + '/produtos/confirmacao/pedido/' + data;
                }

            }
        });

    }

}

/*
 * ESTE METODO REALIZA A CHECAGEM DE DESCONTOS E CUPONS 
 * @rogerio pontes {rogerio@designlab.com.br}
 */

function checar_desconto() {

    var discount_name = $("#discount_name").val();
    $("#ticket_desconto").val("");

    if (discount_name.length != 6) {
        $(".cart-voucher-txt-alert").html("<strong>* Número de cupom inválido!</strong>");
    } else {
        $.ajax({
            type: 'post',
            data: 'CUPOM=' + discount_name,
            url: getMyFolderRoot() + '/pt/produtos/checar-desconto',
            success: function(data) {
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
        url: getMyFolderRoot() + '/web-files/server/add_lista_desejos.php',
        success: function(data) {
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
        url: getMyFolderRoot() + '/web-files/server/add_lista_desejos.php',
        success: function(data) {
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
    (selectPrductSort == "") ? parte_1 = "/sort/mais-novos" : parte_1 = "/sort/" + selectPrductSort;

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
        url: getMyFolderRoot() + '/pt/produtos/embalar-presente',
        success: function(data) {
            if (parseInt(data)) {
                $(".yes").removeClass("hide");
            } else {
                $(".yes").addClass("hide");
            }
        }
    });
}

/*
 * ESTE METODO MOVIMENTA O SCROLL PARA O TOP POR MEIO DO ID ANCORA
 */
function scrollToAnchor(aid) {
    var aTag = $("#" + aid);
    var navbar = $('.navbar-fixed-top').height(),
            to = aTag.offset().top - navbar - 80;
    $('html,body').animate({scrollTop: to}, 'slow');
}


/*
 * ESTE METODO CONTROLA O PROCESSO DE FINALIZACAO
 * DA COMPRA DO CARRINHO
 */
function finalizar_compra() {

    /*
     * REMOVE A CLASS HIDE CSS DEIXANDO VISIVEL O PASSO 1
     * ABAIXO DO INICIA O PRELOAD
     */
    $(".step-1").removeClass("hide");
    $("#step-1").html("<div style='text-align: center'><br/><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 22px'/><br/><br/></div>");

    /*
     * NESTA PRIMEIRA INTERACAO AJX VERIFICA SE ESTA LOGADO
     * ABAIXO DO INICIA O PRELOAD
     */
    $.ajax({
        type: 'post',
        data: '',
        url: getMyFolderRoot() + '/pt/produtos/autenticacao/',
        success: function(data) {

            /*
             * NESTA PRIMEIRA INTERACAO AJAX VERIFICA SE ESTA LOGADO OU NAO
             * EXIBE O HTML COM O CADASTRO SE NAO ESTIVER LOGADO OU UM BLOCO DE BOAS VINDAS
             */
            $("#step-1").html(data);

            /*
             * SE NAO ESTVER LOGADO ELE O SISTEMA PARA NO PASSO 1
             */
            if ($("#EXISTE_USER_LOGADO").val() == "SIM") {

                /*
                 * CASO SIM EXIBE O HEAD NO PASSO 1
                 */
                $(".step-2").removeClass("hide");
                $("#step-2").html("<div style='text-align: center'><br/><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 22px'/><br/><br/></div>");

                /*
                 * REQUISICAO DO PASSO 2 VERIFICANDO SE EXISTE ENDERECOS CADASTRADOS
                 */
                $.ajax({
                    type: 'post',
                    data: '',
                    url: getMyFolderRoot() + '/pt/produtos/endereco/',
                    success: function(data) {

                        $(".load-autenticacao").addClass("hide");
                        /*
                         * CASO SIM EXIBE O HEAD NO PASSO 2
                         */
                        $(".step-2").removeClass("hide");
                        $("#step-2").html(data);

                        /*
                         * APOS CARREGAR O HTML CONSULTA O WEBSERVICE DO CORREIO PARA 
                         * POPULAR O ENDERECO PELO CEP
                         */
                        get_action_cep();

                        /*
                         * EXISTINDO O ENDERECO DE ENTREGA 
                         */
                        if ($("#EXISTE_ENDERECO_ENTREGA").val() == "SIM") {
                            /*
                             * PEGA A FORMA DE ENVIO
                             */
                            forma_envio();
                        }
                    }
                });
            }
        }
    });

}

function criar_conta() {

    $(".load-criar-conta").removeClass("hide");

    $.ajax({
        type: 'post',
        data: 'email=' + $(".email-criar-conta").val() + "&actionType=criar_conta",
        url: getMyFolderRoot() + '/pt/produtos/autenticacao',
        success: function(data) {

            if (data['url'] == "undefined" || data['url'] == undefined) {
                $(".load-criar-conta").addClass("hide");
                $("#step-1").html(data);
            } else {
                window.location.href = data['url'];
            }

        }
    });
}


/*
 * ESTE METODO VERIFICA SE O USUARIO ESTA ALTENTICADO
 * PARA COMPRAS
 */
function autenticacao() {

    /*
     * EXIBE O PRELOAD PARA O USUARIO FINAL
     */
    $(".load-autenticacao").removeClass("hide");

    /*
     * REALIZA A REQUISICAO AJAX
     */
    $.ajax({
        type: 'post',
        data: 'email=' + $(".email-autenticacao").val() + "&actionType=login&senha=" + $(".senha-autenticacao").val(),
        url: getMyFolderRoot() + '/pt/produtos/autenticacao',
        success: function(data) {

            /*
             * CASO CASO PELO REQUEST RETORNE "/produtos/endereco/" O USUARIO 
             * ESTA DEVIDAMENTE ALTENTICADO
             */
            if (data == "/produtos/endereco/") {
                /*
                 * REALIZA A SEGUNDA REQUISICAO AJAX
                 * VERIFICAR SE EXITE ENDERECO DE ENTREGA
                 */
                $.ajax({
                    type: 'post',
                    data: '',
                    url: getMyFolderRoot() + '/pt/produtos/endereco/',
                    success: function(data) {
                        /*
                         * ADICIONA A CLASSE HIDE PRA OCULPAR O PRELOAD
                         */
                        $(".load-autenticacao").addClass("hide");
                        /*
                         * REMOVE A CLASSE HIDE EXIBINDO O PASSO 2
                         */
                        $(".step-2").removeClass("hide");
                        /*
                         * ATUALIZA O HTML COM O FORMULARIO DE ENDERECO
                         */
                        $("#step-2").html(data);
                        /*
                         * CONSULTA O CEP PELO WEBSERVICE PARA POPULAR O FORMULARIO COM O ENDERCO PRE INFORMADO
                         */
                        get_action_cep();
                        /*
                         * CASO ENDERECO EXISTA ABRE O TERCEIRO PASSO
                         */
                        if ($("#EXISTE_ENDERECO_ENTREGA").val() == "SIM") {
                            /*
                             * CHAMA FUNCAO QUE GERENCIA O PASSO 3 REFERENTE A FORMA DE ENVIO
                             */
                            forma_envio();
                        }
                    }
                });

                /*
                 * REQUISICAO AJAX PARA EXIBIR HTML DO PASSO 1
                 */
                $.ajax({
                    type: 'post',
                    data: '',
                    url: getMyFolderRoot() + '/pt/produtos/autenticacao',
                    success: function(data) {
                        $(".load-autenticacao").addClass("hide");
                        $("#step-1").html(data);
                    }
                });

                /*
                 * REQUISICAO AJAX PARA ALTERAR HTML DO TOP
                 */
                $.ajax({
                    type: 'post',
                    data: '',
                    url: getMyFolderRoot() + '/pt/index/top',
                    success: function(data) {
                        $("#stt_logado_print").html(data);
                    }
                });

            } else {
                /*
                 * CASO NAO ESTEJA DEVIDAMENTE ALTENTICADO ADICIONA A CLASSE HIDE PARA OCULTAR PRELOAD 
                 */
                $(".load-autenticacao").addClass("hide");
                /*
                 * ADICIONA O FORMULARIO COM ALERTAS DE AUTENTICACAO INVALIDA
                 */
                $("#step-1").html(data);
            }

        }
    });

}

function autenticacao2() {

    $(".load-autenticacao").removeClass("hide");
    $.ajax({
        type: 'post',
        data: 'email=' + $(".email-autenticacao").val() + "&actionType=login&senha=" + $(".senha-autenticacao").val(),
        url: getMyFolderRoot() + '/pt/produtos/autenticacao',
        success: function(data) {

            if (data == "/produtos/endereco/") {
                //window.location.reload();

                $("a[title=Close]").click();

                var str = "<label>Avaliação</label>" +
                        "<select id='avaliacao' class='form-control'>" +
                        "<option value='NAO_GOSTEI'>Não gostei deste produto!</option>" +
                        "<option value='RAZOAVEL'>Este produto é razoavelmente bom!</option>" +
                        "<option value='BOM'>Este produto é bom!</option>" +
                        "<option value='EXCELENTE'>Excelente produto!</option>" +
                        "</select>" +
                        "<div style='height: 40px; display: inline-block'>" +
                        "<span id='msg_erro_avaliacao' style='color: #df5d65; font-weight: bold; line-height: 4;'></span>" +
                        "<span class='LoaderAvaliacao hide'>" +
                        "<img src='/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='width: 25px;'/>" +
                        "</span>" +
                        "</div>" +
                        "<br>" +
                        "<button type='button' id='btn_avaliacao' class='btn btn-primary btn-lg btn-primary-maria' role='button'>Avaliar</button>";

                $("#minhaAvaliacao").html(str);

                $.ajax({
                    type: 'post',
                    data: '',
                    url: getMyFolderRoot() + '/pt/index/top',
                    success: function(data) {
                        $("#stt_logado_print").html(data);
                    }
                });


            }

        }
    });

}

/*
 * ESTE METODO POPULA O FORMULARIO DE ENDERECO 
 * VINDO AS INFORMACOES DO WEB SERVICE DOS CORREIOS
 */
function get_action_cep() {

    if (document.getElementById("cep") != null) {
        $('#cep').mask('99999-999');
        $('#cep').change(function() {
            var cep = jQuery(this).val();
            $(".Loader-Endereco").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: getMyFolderRoot() + '/web-files/server/cep.php',
                success: function(data) {
                    $(".Loader-Endereco").addClass('hide');
                    $("#logradouro").val(data["Logradouro"]);
                    $("#bairro").val(data["Bairro"]);
                    $("#cidade").val(data["Cidade"]);
                    $("#estado").val(data["UF"]);
                }
            });

        });
    }

    if (document.getElementById("pesquisar_endereco") != null) {
        $('#pesquisar_endereco').click(function() {
            var cep = $("#cep").val();
            $(".Loader").removeClass('hide');
            $.ajax({
                type: 'post',
                data: "cep=" + cep,
                url: getMyFolderRoot() + '/web-files/server/cep.php',
                success: function(data) {
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
        $("#mais_enderecos").click(function() {
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
        url: getMyFolderRoot() + '/pt/produtos/endereco/',
        success: function(data) {
            $("#step-2").html(data);
            get_action_cep();
            forma_envio();
        }
    });
}

function cadastrar_endereco_conta() {

    var url = "estado=" + $("#estado").val() +
            "&cep=" + $("#cep").val() +
            "&logradouro=" + $("#logradouro").val() +
            "&numero=" + $("#numero").val() +
            "&complemento=" + $("#complemento").val() +
            "&bairro=" + $("#bairro").val() +
            "&cidade=" + $("#cidade").val();

    $("#step-2").html('<h1 style="text-align: center; line-height: 10;"><img src="/web-files/img/Loader.GIF" alt="Carregando..." title="Carregando..." border="0" style="width: 25px"/></h1>');

    $.ajax({
        type: 'post',
        data: url,
        url: getMyFolderRoot() + '/pt/produtos/endereco-conta/',
        success: function(data) {
            $("#step-2").html(data);
            
            $('#cep').mask('99999-999');
            $('#cep').change(function() {
                var cep = jQuery(this).val();
                $(".Loader").removeClass('hide');
                $.ajax({
                    type: 'post',
                    data: "cep=" + cep,
                    url: getMyFolderRoot() + '/web-files/server/cep.php',
                    success: function(data) {
                        $(".Loader").addClass('hide');
                        $("#logradouro").val(data["Logradouro"]);
                        $("#bairro").val(data["Bairro"]);
                        $("#cidade").val(data["Cidade"]);
                        $("#estado").val(data["UF"]);
                    }
                });

            });
        }
    });
}


function cadastrar_endereco2() {

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
        url: getMyFolderRoot() + '/pt/produtos/endereco/',
        success: function(data) {
            window.location.reload();
            //$("#step-2").html(data);
            //get_action_cep();
            //forma_envio();
        }
    });
}

/*
 * METODO QUE VERIFICA A FORMA ESCOLHIDA DE ENVIAR O PRODUTO
 */
function forma_envio() {
    /*
     * ATUALIZA O BOTAO PARA FINALIZAR COMPRA
     */
    $(".next").html('<a onclick="javascript:scrollToAnchor(\'step-4\')" class="btn btn-primary">Finalizar compra →</a>');

    /*
     * EXIBE O HEAD DO PASSO 3
     */
    $(".step-3").removeClass("hide");
    /*
     * OCULTA BOTAO ANTIGO REFERENTE A FINALIZACAO DA COMPRA QUE VEM PELO AJAX
     */
    $(".meu-endereco-entrega").addClass("hide");
    /*
     * CARREGA PRELOAD DO PASSO 3
     */
    $("#step-3").html("<div style='text-align: center'><br/><img src='" + getMyFolderRoot() + "/web-files/img/Loader.GIF' alt='Carregando...' title='Carregando...' border='0' style='opacity:1; width: 21px'/><br/><br/></div>");
    /*
     * REALIZA A REQUISICAO PARA FINALIZACAO DO PASSO 3
     */
    $.ajax({
        type: 'post',
        data: '',
        url: getMyFolderRoot() + '/pt/produtos/pagamento/',
        success: function(data) {
            /*
             * EXIBE HTML DA FORMA DE ENVIO
             */
            $("#step-3").html(data);
            /*
             * COLOCA EVENTO NO BOTAO PARA CALCULAR ENVIO ALTOMATICAMENTE
             */
            if ($('.myFormaEnvio').hasClass("myFormaEnvio")) {
                $(".myFormaEnvio").change(function() {
                    get_soma_peso();
                });
            }
            /*
             * CARREGA METODO PARA CALCULAR DE IMEDIATO A FORMA DE ENVIO
             * POR PADRAO VIA PAC CORREIOS
             */
            get_soma_peso();
        }
    });
}

var checkout_panel_offset = $('#checkout-panel-2').offset().top - 50;

$(window).scroll(function() {
    var position = $('body').scrollTop();
    if (position > checkout_panel_offset) {
        $('#checkout-panel-2').addClass('active');
    } else {
        $('#checkout-panel-2').removeClass("active");
    }
});
$(function() {
    Plugins.init();
});


//alert(myConstantFolder());

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
        url: getMyFolderRoot() + '/' + $("#language") + '/atendimento/valida-dados',
        success: function(data) {
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
        url: getMyFolderRoot() + '/' + $("#language") + '/atendimento/get-atendente',
        success: function(data) {
//            console.log(data);
        }
    });
}

function meusAtendimentos() {
    $.ajax({
        type: 'post',
        data: 'codatendente=' + $("#codatendente").val(),
        url: getMyFolderRoot() + '/pt/atendimento/get-usuarios-fila',
        success: function(data) {
//            console.log(data);
            $(".meus-atendimentos").html(data);

        }
    });
}

function update_precode(nome, valor) {
    var v = nome.replace("PRECODE_", "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + v + '&valor=' + valor.replace(/\,|\./, ""),
        url: getMyFolderRoot() + '/pt/produtos/update-precode',
        success: function(data) {
            console.log(data);
        }
    });
}

function update_precopara(nome, valor) {
    var v = nome.replace("PRECOPARA_", "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + v + '&valor=' + valor.replace(/\,|\./, ""),
        url: getMyFolderRoot() + '/pt/produtos/update-precopara',
        success: function(data) {
            console.log(data);
        }
    });

}

function update_precocompra(nome, valor, qntdd) {
    var v = nome.replace("PRECOCOMPRA_", "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + v + '&valor=' + valor + '&qntdd=' + qntdd,
        url: getMyFolderRoot() + '/pt/produtos/update-precodecompra',
        success: function(data) {
            $("#" + nome).val(data);
            console.log(data);
        }
    });

}

function update_precounitario(nome, valor) {
    var v = nome.replace("PRECOUNITARIO_", "");
    var vl = valor.replace(/\,|\./, "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + v + '&valor=' + vl,
        url: getMyFolderRoot() + '/pt/produtos/update-precounitario',
        success: function(data) {
            var cod = v.replace("#", "");
            var id = "#quantidade_" + cod;
            var qntdd = $(id).val();
            update_precocompra("PRECOCOMPRA_" + cod, vl, qntdd);
            console.log(data);
        }
    });
}

function update_peso(nome, valor) {
    var v = nome.replace("PESO_", "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + v + '&valor=' + valor,
        url: getMyFolderRoot() + '/pt/produtos/update-peso',
        success: function(data) {
            console.log(data);
        }
    });
}

function update_qntdd_estoque(codproduto, qntdd) {
    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&quantidade=" + qntdd,
        url: getMyFolderRoot() + '/pt/produtos/update-qntdd-estoque',
        success: function(data) {
            var valor = $("#PRECOUNITARIO_" + codproduto).val();
            var cod = codproduto.replace("#", "");
            update_precounitario("#PRECOUNITARIO_" + cod, valor);
            console.log(data);
        }
    });

}

function newsletter_footer() {

    var email = $("#email_newsletter").val();

    $.ajax({
        type: 'post',
        data: "email=" + email,
        url: getMyFolderRoot() + '/pt/informacoes/newsletter-footer',
        success: function(data) {
            $("#erro_newsletter").html(data);
        }
    });


}


function pStatusUpdate(codproduto, url) {
    var linkar = getMyFolderRoot() + "/" + url;
    $(".status-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');

    $.ajax({
        type: 'post',
        data: null,
        url: linkar,
        success: function(data) {
            if ($(".status-return-" + codproduto).hasClass('desative')) {
                $(".status-return-" + codproduto).removeClass('desative');
            } else {
                $(".status-return-" + codproduto).addClass('desative');
            }
            $(".status-" + codproduto).html(null);
        }
    });

}

function pDestaqueUpdate(codproduto, url) {
    var linkar = getMyFolderRoot() + "/" + url;
    $(".destaque-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');

    $.ajax({
        type: 'post',
        data: null,
        url: linkar,
        success: function(data) {
            if ($(".destaque-return-" + codproduto).hasClass('desative')) {
                $(".destaque-return-" + codproduto).removeClass('desative');
            } else {
                $(".destaque-return-" + codproduto).addClass('desative');
            }
            $(".destaque-" + codproduto).html(null);
        }
    });

}

function pClassificarNovoUpdate(codproduto, url) {
    var linkar = getMyFolderRoot() + "/" + url;
    $(".classificar-novo-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');

    $.ajax({
        type: 'post',
        data: null,
        url: linkar,
        success: function(data) {
            if ($(".classificar-novo-return-" + codproduto).hasClass('desative')) {
                $(".classificar-novo-return-" + codproduto).removeClass('desative');
            } else {
                $(".classificar-novo-return-" + codproduto).addClass('desative');
            }
            $(".classificar-novo-" + codproduto).html(null);
        }
    });

}

function pClassificarPromocaoUpdate(codproduto, url) {
    var linkar = getMyFolderRoot() + "/" + url;
    $(".classificar-promocao-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');

    $.ajax({
        type: 'post',
        data: null,
        url: linkar,
        success: function(data) {
            if ($(".classificar-promocao-return-" + codproduto).hasClass('desative')) {
                $(".classificar-promocao-return-" + codproduto).removeClass('desative');
            } else {
                $(".classificar-promocao-return-" + codproduto).addClass('desative');
            }
            $(".classificar-promocao-" + codproduto).html(null);
        }
    });

}

function pClassificarMaisVendidosUpdate(codproduto, url) {
    var linkar = getMyFolderRoot() + "/" + url;
    $(".classificar-mais-vendidos-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');

    $.ajax({
        type: 'post',
        data: null,
        url: linkar,
        success: function(data) {
            if ($(".classificar-mais-vendidos-return-" + codproduto).hasClass('desative')) {
                $(".classificar-mais-vendidos-return-" + codproduto).removeClass('desative');
            } else {
                $(".classificar-mais-vendidos-return-" + codproduto).addClass('desative');
            }
            $(".classificar-mais-vendidos-" + codproduto).html(null);
        }
    });

}

function pTextAreaUpdate(codproduto, url) {

    var form = "pFromSubmit_" + codproduto;

    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto,
        url: getMyFolderRoot() + '/pt/produtos/editar-get-dados',
        success: function(data) {

            $.fancybox(data, {
                'autoDimensions': false,
                'width': 550,
                'height': 'auto',
                'transitionIn': 'none',
                'transitionOut': 'none'});

            tinyMCE.init({
                // General options

                mode: "textareas",
                theme: "advanced",
                plugins: "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                // Theme options

                theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect",
                theme_advanced_buttons2: "",
                theme_advanced_buttons3: "",
                theme_advanced_buttons4: "",
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "center",
                theme_advanced_statusbar_location: "bottom",
                theme_advanced_resizing: true,
                // Skin options

                skin: "o2k7",
                skin_variant: "silver",
                // Example content CSS (should be your site CSS)

                content_css: "css/example.css",
                // Drop lists for link/image/media/template dialogs

                template_external_list_url: "js/template_list.js",
                external_link_list_url: "js/link_list.js",
                external_image_list_url: "js/image_list.js",
                media_external_list_url: "js/media_list.js",
                // Replace values for the template plugin

                template_replace_values: {
                    username: "Some User",
                    staffid: "991234"

                }

            });
        }
    });



}

function pTextAreaUpdateSubmit(form, codproduto, url) {

    var fd = new FormData();

    $('#' + form).find("textarea").each(function(i) {
        fd.append(jQuery(this).attr("name"), tinyMCE.editors[i].getContent());
    });

    $.ajax({
        type: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        url: getMyFolderRoot() + url,
        success: function(res) {
            $("a[title=Close]").click();
        }
    });
}

function pDeleteUpdate(codproduto, url) {
    if (confirm('ATENÇÃO: Esta ação não poderá ser desfeita!\n Deseja continuar?')) {
        var linkar = getMyFolderRoot() + "/" + url;
        $(".delete-" + codproduto).html('<img src="' + getMyFolderRoot() + '/web-files/img/Loader.GIF" style="width: 36px; position: relative; top: 4px;" alt="Carregando..." title="Carregando..." border="0"/>');
        $.ajax({
            type: 'post',
            data: null,
            url: linkar,
            success: function(data) {
                $(".delete-return-" + codproduto).remove();
            }
        });
    } else {
        return false;
    }
}

function pGetImagesShow(codproduto, referencia) {

    var images = "<ul class='list-inline'>";

    var count = 0;

    $(".delete-return-" + codproduto + ".yes").each(function(i) {
        images += "<li>" + jQuery(this).find("td").html() + "</li>";
        count++;
    });

    if (count != 0) {
        images += "</ul>";
        var seletor = $(".delete-return-" + codproduto + ".no").find("td:eq(0)").find("span:eq(1)");
        var pixel = (count * 110);
        seletor.css("width", pixel + "px");
        if (seletor.css("display") == "block") {
            seletor.css("display", "none");
        } else {
            seletor.css("display", "block");
        }

        seletor.html(images);
    }
}

function pNameUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&nome=" + valor,
        url: getMyFolderRoot() + "/pt/produtos/update-nome",
        success: function(data) {
            $("#" + id).removeClass("Loader");
        }
    });
}

function pPrecodeUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto + '&valor=' + valor.replace(/\,|\./, ""),
        url: getMyFolderRoot() + '/pt/produtos/update-precode',
        success: function(data) {
            $("#" + id).removeClass("Loader");
        }
    });
}

function pPrecoparaUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto + '&valor=' + valor.replace(/\,|\./, ""),
        url: getMyFolderRoot() + '/pt/produtos/update-precopara',
        success: function(data) {
            $("#" + id).removeClass("Loader");
        }
    });

}

function pReferenciaUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto + '&valor=' + valor.replace(/\,|\./, ""),
        url: getMyFolderRoot() + '/pt/produtos/update-referencia',
        success: function(data) {
            $("#" + id).removeClass("Loader");
        }
    });

}

function eQuantidadeEstoqueUpdate(id, codproduto) {

    $("#" + id).addClass("Loader");
    var qntdd = $("#" + id).val();

    $.ajax({
        type: 'post',
        data: "codproduto=" + codproduto + "&quantidade=" + qntdd,
        url: getMyFolderRoot() + '/pt/produtos/update-qntdd-estoque',
        success: function(data) {
            var valor = $("#pName_" + codproduto).val();
            var vl = valor.replace(/\,|\./, "");
            $.ajax({
                type: 'post',
                data: 'codproduto=' + codproduto + '&valor=' + vl,
                url: getMyFolderRoot() + '/pt/produtos/update-precounitario',
                success: function(data) {
                    update_precocompra("PRECOCOMPRA_" + codproduto, vl, qntdd);
                    $("#" + id).removeClass("Loader");
                    console.log(data);
                }
            });
        }
    });
}

function ePrecoUnitarioEstoqueUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    var vl = valor.replace(/\,|\./, "");
    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto + '&valor=' + vl,
        url: getMyFolderRoot() + '/pt/produtos/update-precounitario',
        success: function(data) {
            var qntdd = $("#qName_" + codproduto).val();
            update_precocompra("PRECOCOMPRA_" + codproduto, vl, qntdd);
            $("#" + id).removeClass("Loader");
            console.log(data);
        }
    });
}

function ePesoUpdate(id, codproduto) {
    $("#" + id).addClass("Loader");
    var valor = $("#" + id).val();
    $.ajax({
        type: 'post',
        data: 'codproduto=' + codproduto + '&valor=' + valor,
        url: getMyFolderRoot() + '/pt/produtos/update-peso',
        success: function(data) {
            $("#" + id).removeClass("Loader");
            console.log(data);
        }
    });
}

function sugestao(search) {
    if (search == "") {
        $(".sugestao").empty();
    } else {
        $.ajax({
            type: 'post',
            data: "search=" + search,
            url: getMyFolderRoot() + "/pt/produtos/sugestao",
            success: function(data) {
                $(".sugestao").html(data);
            }
        });
    }
}

/*
 * ESTA FUNCAO SIMULA O CLIQUE UM BOTAO EM ALGUMA JANELA
 * ESTA SENDO UTILIZADA NO IFRAME DO CUPOM DE DESCONTOS 
 */

function close_ifreme(idorclass){
    $(idorclass).click();
}


