if (document.layers)
	window.captureEvents(Event.KEYDOWN | Event.KEYUP);

/**
 *  Coloca mascara no campo e após a digitação faz o auto-tab
 *  Usar o caracter '#' como coringa. 
 *  O campos maxLength não é obrigatório
 *  Ex se fosse para CPF: onkeypress="return mask(true, event, this, '###.###.###-##');" - Obs: Para CPF já existe função própria
 *  Para mascara dinâmica, inicie a márcara com '[' e depois a máscara que será dinâmica, finalizando com ']', depois pode continuar com a marcara normal
 *  Ex de utilização dinâmica, para separar de 2 em 2 caracteres com um '-' e finalizar com '.' e outro caracter: onkeypress="return mask(false, event, this, '[-##].#');"
 *  Para colocar somente um '-' no penúltimo caracter, como nos casos de dv: onkeypress="return mask(false, event, this, '[#].#', 10);"
 */
 
function mask(somenteNumeros, event, campo, mask, maxLength) {
	var keyCode;

	if (event.srcElement)
		keyCode = event.keyCode;
	else if (event.target)
		keyCode = event.which;

	var maskStack = new Array();

	var isDynMask = false;

	if (mask.indexOf('[') != -1)
		isDynMask = true;

	var length = mask.length;

	for ( var i = 0; i < length; i++)
		maskStack.push(mask.charAt(i));

	var value = campo.value;
	var i = value.length;

	if (keyCode == 0 || keyCode == 8)
		return true;

	if (somenteNumeros && (keyCode < 48 || keyCode > 57))
		return false;

	if (maxLength != undefined && value.length > maxLength) {
		return false;
	}

	if (!isDynMask && i < length) {

		if (maskStack.toString().indexOf(String.fromCharCode(keyCode)) != -1
				&& keyCode != 8) {
			return false;
		} else {
			if (keyCode != 8) {
				if (maskStack[i] != '#') {
					var old = campo.value;
					campo.value = old + maskStack[i];
				}
			}

			if (autoTab(campo, keyCode, length)) {
				if (!document.layers) {
					return true;
				} else if (keyCode != 8) {
					campo.value += String.fromCharCode(keyCode);
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}

	} else if (isDynMask) {

		var maskChars = "";
		for ( var j = 0; j < maskStack.length; j++)
			if (maskStack[j] != '#' && maskStack[j] != '['
					&& maskStack[j] != ']')
				maskChars += maskStack[j];

		var tempValue = "";
		for ( var j = 0; j < value.length; j++) {
			if (maskChars.indexOf(value.charAt(j)) == -1)
				tempValue += value.charAt(j);
		}

		value = tempValue + String.fromCharCode(keyCode);

		if (maskChars.indexOf(String.fromCharCode(keyCode)) != -1) {
			return false;
		} else {

			var staticMask = mask.substring(mask.indexOf(']') + 1);
			var dynMask = mask.substring(mask.indexOf('[') + 1, mask
					.indexOf(']'));

			var realMask = new Array;

			if (mask.indexOf('[') == 0) {

				var countStaticMask = staticMask.length - 1;
				var countDynMask = dynMask.length - 1;

				for ( var j = value.length - 1; j >= 0; j--) {
					if (countStaticMask >= 0) {
						realMask.push(staticMask.charAt(countStaticMask));
						countStaticMask--;
					}
					if (countStaticMask < 0) {
						if (countDynMask >= 0) {
							if (dynMask.charAt(countDynMask) != '#') {
								realMask.push(dynMask.charAt(countDynMask));
								countDynMask--;
							}
						}

						if (countDynMask == -1) {
							countDynMask = dynMask.length - 1;
						}

						realMask.push(dynMask.charAt(countDynMask));
						countDynMask--;
					}
				}
			}

			var result = "";

			var countValue = 0;
			while (realMask.length > 0) {
				var c = realMask.pop();
				if (c == '#') {
					result += value.charAt(countValue);
					countValue++;
				} else {
					result += c;
				}
			}

			campo.value = result;

			if (maxLength != undefined && value.length == maxLength) {
				var form = campo.form;
				for ( var i = 0; i < form.elements.length; i++) {
					if (form.elements[i] == campo) {
						campo.blur();
						if ((form.elements[i + 1] != null)
								&& (form.elements[i + 1].name != "METHOD"))
							form.elements[i + 1].focus();
						break;
					}
				}
			}
			return false;
		}
	} else {
		return false;
	}

}

function autoTab(campo, keyCode, length) {
	var i = campo.value.length;
	if (i == length - 1) {
		campo.value += String.fromCharCode(keyCode);
		var form = campo.form;
		for ( var i = 0; i < form.elements.length; i++) {
			if (form.elements[i] == campo) {
				campo.blur();
				if ((form.elements[i + 1] != null)
						&& (form.elements[i + 1].name != "METHOD"))
					form.elements[i + 1].focus();
				break;
			}
		}
		return false;
	} else {
		return true;
	}
}

/* Formata CPF depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataCPF(event, this);"
 */
function formataCPF(event, campo) {
	return mask(true, event, campo, '###.###.###-##');
}

/* Formata Telefone depois auto-tab 
 * exemplo de utilização: onkeypress="return formataTelefone(event, this);"
 */
function formataTelefone(event, campo) {
	return mask(true, event, campo, '(##)####-####');
}

/* Formata CNPJ depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataCNPJ(event, this);"
 */
function formataCNPJ(event, campo) {
	return mask(true, event, campo, '##.###.###/####-##');
}

/* Formata Data depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataData(event, this);"
 */
function formataData(event, campo) {
	return mask(true, event, campo, '##/##/####');
}

/* Formata Data e Hora depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataDataHora(event, this);"
 */
function formataDataHora(event, campo) {
	return mask(true, event, campo, '##/##/#### ##:##');
}

/* Formata Hora depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataHora(event, this);"
 */
function formataHora(event, campo) {
	return mask(true, event, campo, '##:##');
}

/* Formata numero com DV, depois do máx do tamanho contando com o DV faz auto-tab 
 * exemplo de utiulização: onkeypress="return formataNumDV(event, this, 6);"
 */
function formataNumDV(event, campo, maxTamanhoComDV) {
	return mask(true, event, campo, '[#]', maxTamanhoComDV);
}

/* Formata CEP depois auto-tab 
 * exemplo de utiulização: onkeypress="return formataCEP(event, this);"
 */
function formataCEP(event, campo) {
	return mask(true, event, campo, '#####-###');
}

/* Formata valor, depois do máx do tamanho contando com os caracters faz auto-tab 
 * USAR OBRIGATORIAMENTE o backspaceFormataValor() junto
 * exemplo de utiulização: onkeypress="formataValor(event, this, 12);" onkeydown="backspaceFormataValor(event, this)"
 */
function formataValor(event, campo, maxTamanhoComDV) {
	return reais(campo, event, maxTamanhoComDV);
}
/* USAR OBRIGATORIAMENTE JUNTO COM O formataValor */
function backspaceFormataValor(event, campo) {
	return backspace(campo, event);
}

/* Formata valor, depois do máx do tamanho contando com os caracters faz auto-tab 
 * USAR OBRIGATORIAMENTE o backspaceFormataValor() junto
 * exemplo de utiulização: onkeypress="formataValorNaoAceitaDecimal(event, this, 12);" onkeydown="backspaceFormataValorNaoAceitaDecimal(event, this)"
 */
function formataValorNaoAceitaDecimal(event, campo, maxTamanhoComDV) {
	return reaisNaoAceitaDecimal(campo, event, maxTamanhoComDV);
}
/* USAR OBRIGATORIAMENTE JUNTO COM O formataValorNaoAceitaDecimal */
function backspaceFormataValorNaoAceitaDecimal(event, campo) {
	return backspaceNaoAceitaDecimal(campo, event);
}

// JavaScript Document
/** Função para ajustar e retirar barras de rolagem do Iframe **/
function adjustFrame(frame) {
	var frmTemp;
	if (document.all) {
		var w = frame.document.body.scrollWidth;
		var h = frame.document.body.scrollHeight;

		if (frame.document.body.scrollWidth > frame.document.body.offsetWidth) {
			document.all[frame.name].height = h + 30;
		} else {
			document.all[frame.name].height = h;
		}
	} else if (document.getElementById) {

		var w = frame.document.width;
		var h = frame.document.height;

		if (frame.document.body.scrollWidth > frame.document.body.offsetWidth) {
			document.getElementById(frame.name).height = h + 30;
		} else {
			document.getElementById(frame.name).height = h;
		}
	}
	return false;
}

/** Função para completar a data durante a digitação **/
function completaData(objCampo) {
	vr = objCampo.value;

	if (objCampo.value.length == 8) {
		if (objCampo.value.length == 8 & vr.substr(6, 2) <= 30) {
			objCampo.value = vr.substr(0, 6) + "20" + vr.substr(6, 2);
		}
		if (objCampo.value.length == 8 & vr.substr(6, 2) >= 30) {
			objCampo.value = vr.substr(0, 6) + "19" + vr.substr(6, 2);
		}
	}
}

/** Função utilizada para completar o campos com zeros a esquerda **/
function completaCampo(objCampo, len) {
	var num = "";
	var campo = "";
	var retorno = "";
	campo = objCampo.value;
	if (campo.length < len && campo != "") {
		for (i = 0; i < (len - campo.length); i++) {
			num += "0";
		}
	}
	retorno = num + campo;
	objCampo.value = retorno.toUpperCase();
}

/* USADO INTERNAMENTE PELO formataValor */
function _formataValorPrototype(c) {
	var t = this;
	if (c == undefined)
		c = 2;
	var p, d = (t = t.split("."))[1].substr(0, c);
	for (p = (t = t[0]).length; (p -= 3) >= 1;) {
		t = t.substr(0, p) + "." + t.substr(p);
	}
	return t + "," + d + Array(c + 1 - d.length).join(0);
}

/* USADO INTERNAMENTE PELO formataValor */
String.prototype.formatValor = _formataValorPrototype
function _demask(valor, semZerosEsq) {
	var val2 = '';
	var strCheck = '0123456789';
	var len = valor.length;
	if (len == 0)
		return 0.00;

	if (semZerosEsq == true) {
		for ( var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ','))
				break;

		for (; i < len; i++) {
			if (strCheck.indexOf(valor.charAt(i)) != -1)
				val2 += valor.charAt(i);
		}

		if (val2.length == 0)
			return "0.00";
		if (val2.length == 1)
			return "0.0" + val2;
		if (val2.length == 2)
			return "0." + val2;

		var parte1 = val2.substring(0, val2.length - 2);
		var parte2 = val2.substring(val2.length - 2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;

	} else {
		val3 = "";
		for ( var k = 0; k < len; k++)
			if (strCheck.indexOf(valor.charAt(k)) != -1)
				val3 += valor.charAt(k);
		return val3;
	}
}

/* USADO INTERNAMENTE PELO formataValor */
function reais(obj, event, tam) {

	var strCheck = '0123456789';
	var whichCode;
	if (event.srcElement)
		whichCode = event.keyCode;
	else if (event.target)
		whichCode = event.which;

	if (whichCode == 8 && !document.all) {
		if (event.preventDefault) { //standart browsers   
			event.preventDefault();
		} else { // internet explorer   
			event.returnValue = false;
		}
		var valor = obj.value;
		var x = valor.substring(0, valor.length - 1);
		obj.value = _demask(x, true).formatValor();
		return false;
	}
	if (whichCode == 0)
		return true;
	if (whichCode == 9)
		return true; //tab   
	if (whichCode == 13)
		return true; //enter   
	if (whichCode == 16)
		return true; //shift
	if (whichCode == 17)
		return true; //control
	if (whichCode == 27)
		return true; //esc   
	if (whichCode == 34)
		return true; //end   
	if (whichCode == 35)
		return true;//end   
	if (whichCode == 36)
		return true; //home   

	if (event.preventDefault) {
		event.preventDefault()
	} else {
		event.returnValue = false
	}
	var key = String.fromCharCode(whichCode);
	if (strCheck.indexOf(key) == -1)
		return false;
	if (obj.value.length >= tam)
		return false;
	obj.value += key;

	var len = obj.value.length;
	var bodeaux = _demask(obj.value, true).formatValor();
	obj.value = bodeaux;

	/*  
	 Move o cursor para o final no opera. 
	 */
	if (obj.createTextRange) {
		var range = obj.createTextRange();
		range.collapse(false);
		range.select();
	} else if (obj.setSelectionRange) {
		obj.focus();
		var length = obj.value.length;
		obj.setSelectionRange(length, length);
	}

	return false;
}

/* USADO INTERNAMENTE PELO formataValor */
function backspace(obj, event) {
	var whichCode;
	if (event.srcElement)
		whichCode = event.keyCode;
	else if (event.target)
		whichCode = event.which;

	if (whichCode == 8 && document.all) {
		var valor = obj.value;
		var x = valor.substring(0, valor.length - 1);
		var y = _demask(x, true).formatValor();
		obj.value = "";
		obj.value += y;
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		return false;
	}
}

/* USADO INTERNAMENTE PELO formataValorNaoAceitaDecimal */
function reaisNaoAceitaDecimal(obj, event, tam) {

	var strCheck = '0123456789';
	var whichCode;
	if (event.srcElement)
		whichCode = event.keyCode;
	else if (event.target)
		whichCode = event.which;

	if (whichCode == 8 && !document.all) {
		if (event.preventDefault) { //standart browsers   
			event.preventDefault();
		} else { // internet explorer   
			event.returnValue = false;
		}

		var x;
		if (obj.value.length <= 4) {
			x = '0,00';
		} else {
			// retira o último caracter e os zeros do fim   
			x = obj.value.substring(0, obj.value.length - 4) + ',00';
		}
		obj.value = _demask(x, true).formatValor();
		return false;
	}
	if (whichCode == 0)
		return true;
	if (whichCode == 9)
		return true; //tab   
	if (whichCode == 13)
		return true; //enter   
	if (whichCode == 16)
		return true; //shift
	if (whichCode == 17)
		return true; //control
	if (whichCode == 27)
		return true; //esc   
	if (whichCode == 34)
		return true; //end   
	if (whichCode == 35)
		return true;//end   
	if (whichCode == 36)
		return true; //home   

	if (event.preventDefault) {
		event.preventDefault()
	} else {
		event.returnValue = false
	}
	var key = String.fromCharCode(whichCode);
	if (strCheck.indexOf(key) == -1)
		return false;
	if (obj.value.length >= tam)
		return false;

	if (obj.value.length < 1) {
		obj.value = key + ',00';
	} else {
		var valor = obj.value;
		// sem os zeros do fim   
		var x = valor.substring(0, valor.length - 3);
		obj.value = x + key + ',00';
	}

	var bodeaux = _demask(obj.value, true).formatValor();
	obj.value = bodeaux;

	/*  
	 Move o cursor para o final no opera. 
	 */
	if (obj.createTextRange) {
		var range = obj.createTextRange();
		range.collapse(false);
		range.select();
	} else if (obj.setSelectionRange) {
		obj.focus();
		var length = obj.value.length;
		obj.setSelectionRange(length, length);
	}

	return false;
}

/* USADO INTERNAMENTE PELO formataValorNaoAceitaDecimal */
function backspaceNaoAceitaDecimal(obj, event) {
	var whichCode;
	if (event.srcElement)
		whichCode = event.keyCode;
	else if (event.target)
		whichCode = event.which;

	if (whichCode == 8 && document.all) {
		var x;
		if (obj.value.length <= 4) {
			x = '0,00';
		} else {
			// retira o último caracter e os zeros do fim   
			x = obj.value.substring(0, obj.value.length - 4) + ',00';
		}
		var y = _demask(x, true).formatValor();
		obj.value = "";
		obj.value += y;
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		return false;
	}
}

function dataTableSelectOneRadio(radio) {
	var id = radio.name.substring(radio.name.lastIndexOf(':'));
	var el = radio.form.elements;
	for ( var i = 0; i < el.length; i++) {
		if (el[i].name.substring(el[i].name.lastIndexOf(':')) == id) {
			el[i].checked = false;
		}
	}
	radio.checked = true;
}

function closePanel() {
	if (document.getElementById('mpform:error') == null) {
		Richfaces.hideModalPanel('mp');
	}
	;
};

/*
 * Função responsável por selecionar todos checkbox ou desmarcar todos de um determinado form
 *
 * @author: Marco Nascimento
 * @date: 03/12/2008
 * @email: marcotulio.nascimento@gmail.com / knox872003@yahoo.com.br
 */
function checkAll(objCheckALL, idForm) {
	var elForm = document.getElementById(idForm);
	var qtdEl = elForm.elements.length;
	var el = elForm.elements;

	for (i = 0; qtdEl > i; i++) {
		if (el[i].type == 'checkbox' && !el[i].disabled) {
			el[i].checked = (objCheckALL.checked == true) ? true : false;
		}
	}
}
/*
$("[alt=phone]").live('keypress', function (event) {  
	  var target, phone, element;  
	  target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
	  phone = target.value.replace(/\D/g, '');  
	  element = $(target);  
	  element.unsetMask();  
	  if (phone.length > 5 && phone.substr(0,3) == "119") { //ele só vai colocar no formato de SP quando for ddd 11 e iniciar com 9.  
		  element.setMask("(99) 99999-9999");  
	  } else {  
		  element.setMask("(99) 9999-9999");  
	  }  
  })  
  
 */