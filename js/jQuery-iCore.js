// JavaScript Document

$j(document).ready(function() {

	new Ajax.Updater('logar', 'template/request/user-painel.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#logar');
	
	


	var url			=	$j(location).attr('href');

	if(url.indexOf("#!")!=-1){

		var splitUrl	=	url.split('#!');

		var pagina		=	splitUrl[1].split('.');

		new Ajax.Updater('container', 'template/request/'+pagina[0]+'.php', {method: 'get', asynchronous:true, evalScripts:true});

		mover('#container');

	}else{

		new Ajax.Updater('container', 'template/request/Home.php', {method: 'get', asynchronous:true, evalScripts:true});

	}


	window.setTimeout(

		function(){

			$j(".mask").fadeOut("slow");

		}

	, 4000);

});


function userLogado(){

	window.setTimeout(

		function(){

			//new Ajax.Updater('container', 'template/request/home.php', {method: 'get', asynchronous:true, evalScripts:true});

			new Ajax.Updater('logar', 'template/request/user-painel.php', {method: 'get', asynchronous:true, evalScripts:true});

		}

	, 4000);

}






function recuperarSenha(){

	var url			=	$j(location).attr('href');

	if(url.indexOf("#!")!=-1){

		var splitUrl	=	url.split('#!');

		var pagina		=	splitUrl[1].split('.');

		var codigo		=	pagina[1].split('/');

		document.getElementById('codigo').value	=	codigo[0];

		document.getElementById('email').value	=	codigo[1];

		alert(codigo[0]);

	}

}
function limparForm(form){

	$a(form + " input[type='text'], " + form + " input[type='password'], " + form + " textarea").each(function(){

		this.value	=	"";

	});

}
function carregando(elemento){

	if(!elemento){

		var elemento = '#container';

	}

	$j(elemento).html('<div align="center"><br /><div class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div><br /></div>');

}

function SomenteNumero(e){

	var tecla=(window.event)?event.keyCode:e.which;

	if((tecla>47 && tecla<58)) return true;

	else{

	if (tecla==8 || tecla==0) return true;

		else return false;

	}

}

function getTempo(tempo){

	if(parseInt(tempo) >= 60){

		var hra = Math.floor(parseInt(tempo) / 60);

		var min = Math.floor(parseInt(tempo) % 60);

		var dia = "";

	if(hra >= 24){

		dia = Math.floor(parseInt(hra) / 24);

		hra = Math.floor(parseInt(hra) % 24);

	}

		min = (min > 0) ? min+" Min" : "";

		hra = (hra > 0) ? hra+" Hrs " : "";

		dia = (dia > 0) ? dia+" Dias " : "";

		tempo = dia + hra + min;

	}else{

		tempo = tempo + " min";

	}

	$j(".tempodejogo").html(tempo);

}

function megaSena(id){

	var opcao	=	$j("#" + id).is(":checked");

	var count = $j('input[name="megasena[]"]:checked').length;



	if(opcao){

		$j(".opcao"+id).removeClass("ativo");

		$j('#'+id).attr('checked', false);

	}else{

		if(count>=10){

			alert("Só é permitido máximo de 10 numeros!");

		}else{

			$j(".opcao"+id).addClass("ativo");

			$j('#'+id).attr('checked', true);

		}

	}

	var selecionados = $j('input[name="megasena[]"]:checked').length;

	var calcValor = selecionados * 150000;

	$j(".selecionadosMega").html(selecionados);

	$j(".valorMega").html(number_format(calcValor));

}

function expandirNot(id){

	$j(".artigos .conteudo").hide(10);

	$j("#"+id).slideToggle('slow').siblings("#"+id+":visible").slideToggle('fast');

	$j("#"+id).next().siblings("#"+id).next("#"+id+":visible").prev();



}

function mover(elemento){

	if(!elemento){

		var elemento = '#container';

	}

	$j('html, body').animate({

		scrollTop: $j(elemento).offset().top

	}, 1000);

}



function loadRank(elemento){

	carregando('.rank');

	new Ajax.Updater('rank', 'template/request/ranking.php?type='+elemento, {method: 'get', asynchronous:true, evalScripts:true});

}


function limparForm(form){

	$j(form + " input[type='text'], " + form + " input[type='password'], " + form + " textarea").each(function(){

		this.value	=	"";

	});

}

function ResetFormValues() {
 
        $(":text").each(function () {
            $(this).val("");
        });
 
        $(":radio").each(function () {
            $(this).prop({ checked: false })
        });
 
        $("select").each(function () {
            $(this).val("");
        });
    }


function number_format(number, decimals, dec_point, thousands_sep) {

  number = (number + '')

    .replace(/[^0-9+\-Ee.]/g, '');

  var n = !isFinite(+number) ? 0 : +number,

    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),

    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,

    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,

    s = '',

    toFixedFix = function(n, prec) {

      var k = Math.pow(10, prec);

      return '' + (Math.round(n * k) / k)

        .toFixed(prec);

    };

  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))

    .split('.');

  if (s[0].length > 3) {

    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);

  }

  if ((s[1] || '')

    .length < prec) {

    s[1] = s[1] || '';

    s[1] += new Array(prec - s[1].length + 1)

      .join('0');

  }

  return s.join(dec);

}

<!-- Disable   

function disableselect(e){   

	return false;

}   

function reEnable(){   

	return true;

}

//if IE4+   

document.onselectstart=new Function ("return false")   

document.oncontextmenu=new Function ("return false")   

//if NS6   

if(window.sidebar){   

	

	document.onclick=reEnable;

}

function verificaBotao(oEvent){

	var oEvent = oEvent ? oEvent : window.event;

	var tecla = (oEvent.keyCode) ? oEvent.keyCode : oEvent.which;

	if(tecla == 17 || tecla == 44|| tecla == 106){

		return false;

	}

}

//Bloqueador de Selecao - iceBreaker http://www.icebreaker.com.br/

function bloquear(e){return false}

function desbloquear(){return true}

document.onselectstart=new Function ("return false")

function gerarAgorar() {

                var albaretotsr = "123456789";

                // ledmsaldw aleatorias
                var ledmsaldw = [];
                for (var i = 0; i < 3; ++i)
                    ledmsaldw[i] = albaretotsr.charAt(Math.floor(Math.random() * 25));

                // numero aleatorios
                var numeros = [];
                for (var i = 0; i < 4; ++i) {
                    var sortekeyr = Math.floor(Math.random() * 9);

                    if (sortekeyr == 0)
                        sortekeyr = 1; // 1 - 9

                    numeros[i] = sortekeyr; 
                }

                var newpasswr = ledmsaldw.join('') + numeros.join('');

                document.getElementById('txtnewpasswr').value = newpasswr;
            }

