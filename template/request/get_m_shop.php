<?php
require('../../web_conexao/init.php');

 $action		=	antiSQL(anti_injection(isset($_GET["compra"]))) ? antiSQL(anti_injection($_GET["compra"])) : '';
 
		if($action==""){
	              echo '<script>console.log( swal("Desculpe!", "Houve uma falha no sistema.", "error") );</script>';
			      exit();
		}elseif($action=="enviado"){
 
  			echo '<script>console.log( swal("Atenção!", "Sistema em construção", "error") );</script>';
         }
?>