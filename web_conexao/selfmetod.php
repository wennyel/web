<?php
	$phpself = $_SERVER['PHP_SELF'];

	if(!empty($_SERVER['QUERY_STRING'])) {
	 $IncEvil = $phpself .= "?" . $_SERVER['QUERY_STRING'];
	}


	if(eregi("http|cmd|www|ftp|.dat|.txt|.gif|wget|from|select|-1|-2|-3|-4|-5|-6|-7|-8|-9|update|insert|delete|where|drop table|show tables|#|\*|--|\\\\", $IncEvil)) {
	 echo "<div class=\"boxerror\">Tentar Burlar o sistema e crime, seus dados foram salvo. Voce sera redirecionado para a pagina principal.</div>";
	 echo "<meta http-equiv=\"refresh\" content=\"3; URL=index.php\">";
	 exit;
	} 
?>