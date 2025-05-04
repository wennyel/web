<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR');
    ob_start();
	session_start();
	require_once("settings.php");
    require("function_class.php");
    require_once("pdo.php");

    $db = Database::conexao();

	
?>