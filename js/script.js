var navegador = navigator.userAgent.toLowerCase(); //Cria e atribui � vari�vel global 'navegador' (em caracteres min�sculos) o nome e a vers�o do navegador

//Cria uma vari�vel global chamada 'xmlhttp'
var xmlhttp; 



//Fun��o que inicia o objeto XMLHttpRequest

function objetoXML() {

	if (navegador.indexOf('msie') != -1) { //Internet Explorer

		var controle = (navegador.indexOf('msie 5') != -1) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP'; //Operador tern�rio que adiciona o objeto padr�o do seu navegador (caso for o IE) � vari�vel 'controle'

		try {

			xmlhttp = new ActiveXObject(controle); //Inicia o objeto no IE

		} catch (e) { }

	} else { //Firefox, Safari, Mozilla

		xmlhttp = new XMLHttpRequest(); //Inicia o objeto no Firefox, Safari, Mozilla

	}

}

//Fun��o que envia o formul�rio

function enviarForm(url, campos, destino) {

	//Atribui � vari�vel 'elemento' o elemento que ir� receber a p�gina postada
	var elemento = document.getElementById(destino); 

	//Executa a fun��o objetoXML()
	objetoXML(); 

	//Se o objeto de 'xmlhttp' n�o estiver true
	if (!xmlhttp) {

		//Insere no 'elemento' o texto atribu�do
		elemento.innerHTML = 'Imposs�vel iniciar o objeto XMLHttpRequest.'; 

		return;

	} else { 

		//Insere no 'elemento' o texto atribu�do
elemento.innerHTML = '<div style="padding-top:10px;padding-bottom:10px; font-weight:bold;">Carregando....</div>'; 

	}

	xmlhttp.onreadystatechange = function () {

		//Se a requisi��o estiver completada
		if (xmlhttp.readyState == 4 || xmlhttp.readyState == 0) { 

			//Se o status da requisi��o estiver OK
			if (xmlhttp.status == 200) {

				//Insere no 'elemento' a p�gina postada
				elemento.innerHTML = xmlhttp.responseText; 

			} else { 

				//Insere no 'elemento' o texto atribu�do
				elemento.innerHMTL = 'P�gina n�o encontrada!'; 

			}

		}

	}

	//Abre a p�gina que receber� os campos do formul�rio
	xmlhttp.open('POST', url+'?'+campos, true);

	//Envia o formul�rio com dados da vari�vel 'campos' (passado por par�metro)
	xmlhttp.send(campos); 

}
