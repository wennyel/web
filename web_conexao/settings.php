<?php

	define('HTTP', 'https://');
	define('URL', 'www.domain.top');
	define('URLWebShop', 'webshop.domain.top');
    define('url_token', 'domain.com.br'); // exemplo: www.cabaliCore.com.br //
	define('NAME', 'Cabal Name');
	define('TITLE', 'Cabal Online - Name - Cabal Pirata - Cabal 2');
	define('DESCRIPTION', 'Cabal - Cabal Online - Cabal Pirata - Cabal 2 - iCore - a batalha que você sempre imaginou - O lugar onde nascem as lendas. conheça os personagens do Cabal');
	define('KEYWORDS', 'Cabal, Cabal Online, Cabal Pirata, Cabal 2, Cabal2, Pirata, Online, Cabal Cadastro, Cabal Download, cabal br, cabal online brasil, cabal online download, cabal pirata download, cabalpirata, cabalonline, cabal private, icore');

    //Login para acesso ao painel de administrador//
    $AdminCP = array('wennyel');

   //Ativar e desativar sistemas de web//
    $nation_web = 1; // value 1 = ativado / value 0 = desativado
 
	define('EMAIL', 'domain@gmail.com');
	define('RECAPTCHA_PUBLIC_KEY', '6LezgSIUAAAAAApMij8PvFkVbg6qNVCycvqhHZ1x');
	define('RECAPTCHA_PRIVATE_KEY', '6LezgSIUAAAAAEcyzRQ3rs_SIPDqruYWhm5rRtgU');

    $caixaPostalServidorEmail = 'smtp.domain.com.br'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
    $caixaPostalServidorUser  =  'contato@domain.com.br'; // Usuário do servidor SMTP (endereço de email)
    $caixaPostalServidorSenha = 'Gcek32?2'; //Senha do servidor SMTP (senha do email usado)
    $caixaPostalEmailFrom = 'contato@domain.com.br';

	define('DB_HOST', 'localhost');
	define('DB_NAME', 'account');
	define('DB_USER', 'sa');
	define('DB_PASS', 'neneca');
	define('DB_DRIVER', 'sqlsrv');

	define('DB_ACC', 'Account');
    define('DB_CSH', 'CabalCash');
    define('DB_SRV01', 'Server01');
    define('DB_NETC', 'NetcafeBilling');
    define('DB_EVENT', 'EventData');
    define('DB_SITE', 'MWeb');
?>