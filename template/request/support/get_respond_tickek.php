<?php

require("../../../web_conexao/init.php");
Deslogado();
checkout_token();

try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
    echo $e;	
}

$numeric		=	antiSQL(anti_injection(isset($_GET['id_ticket']))) ? antiSQL(anti_injection($_GET['id_ticket'])) : '';
$status		    =	antiSQL(anti_injection(isset($_POST['status']))) ? antiSQL(anti_injection($_POST['status'])) : '';
if($numeric==""){
echo '<div class="ferrorbig">Nota: Houve um error na válidação de registros, favor entre em contato com o administrador.</div>';	
	exit();
}

 if(isset($numeric)){
    
	    $descricao = htmlentities(antiSQL(anti_injection($_POST['textResp'])));
	    $ticket_status = soNumero(antiSQL(anti_injection($status)));
	 
	 $check = $db->query("select count(*) from MWeb.dbo.cabal_ticket_suportes where ID_ticket = '".$numeric."'")->fetchColumn();
	 $result_suportes = $db->query("select * from MWeb.dbo.cabal_ticket_suportes where ID_ticket = '".$numeric."'")->fetchObject();
	 if(!is_numeric($numeric)){
		   echo '<div class="ferrorbig"><font color="red">ALERTA:</font> Houve uma tentativa de injection, sua conta foi registrada e será analisada pela administração!</div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif(strlen($numeric)>8){
		   echo '<div class="ferrorbig"><font color="red">ALERTA:</font> Houve uma tentativa de injection, sua conta foi registrada e será analisada pela administração!</div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif($check==0){
		   echo '<div class="ferrorbig"><font color="red">AVISO:</font> Não identificamos o ticket que você deseja responder, verifique como o administrador para tentar solucionar o problema que está ocorrendo no sistema.</div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif(!$descricao){
		   echo '<div class="ferrorbig"><font color="red">ALERTA:</font> O Campo não pode fica em branco, digite uma resposta para o atendimento acima.</div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif($result_suportes->Status==0){
		 
		 echo '<div class="ferrorbig"><font color="#B22222">Informação:</font> <font style="font-size:11px; font-weight:normal !important;">Esté ticket ainda está pendente por isso não é possivel responder o mesmo.</font></div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif($result_suportes->Status>=2){
		 
		 echo '<div class="ferrorbig"><font color="#B22222">Informação:</font> <font style="font-size:11px; font-weight:normal !important;">Esté ticket de suporte foi fechado e por esse motivo não é possivel enviar respostas, favor abra um novo ticket para discute um novo assunto.</font></div>';
		 exit();
		 $db=null;
		 unset($db);
	 }elseif(empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
					    echo '<div class="msg-box msg-warning"><div><div><div><div><div><div class="msg-content">
<span class="title">OPS!</span> os caracteres digitados no Re-Captch está inválido.</div>
</div></div></div></div></div></div>';   
				    }else{
			
			$myDate = date("d-m-Y H:i:s.B");
			$tipo = "usuario";
		 
		 try{
       $stmte = $db->prepare("INSERT INTO MWeb.dbo.cabal_ticket_suportes_conversas (msg,Data,Nome_usuario,id_conversas,Tipo) VALUES (:msg,getdate(),:usuario,:ticket,:tipo)");
	   $stmte->bindParam(":msg", $descricao , PDO::PARAM_INT);			
       $stmte->bindParam(":usuario", $result_conta->ID, PDO::PARAM_STR);
	   $stmte->bindParam(":ticket", $numeric , PDO::PARAM_INT);
	   $stmte->bindParam(":tipo", $tipo , PDO::PARAM_STR);
	  
       $executa = $stmte->execute();
       
			 
	   //Mudar Status//
			$result_table = $db->query("select Status from MWeb.dbo.cabal_ticket_suportes where ID_ticket='".$numeric."'")->fetchObject();
			 
			 if($ticket_status==0 AND $result_table->Status==0){
			      $db->query("UPDATE MWeb.dbo.cabal_ticket_suportes set Status=0 where ID_ticket='".$numeric."'");
			 }elseif($ticket_status>=1){
				   $db->query("UPDATE MWeb.dbo.cabal_ticket_suportes set Status=2 where ID_ticket='".$numeric."'");
			 }
			 
       if($executa){
		   if($ticket_status>=2){
			   echo '<div class="ferrorbig">Obrigado: foi uma honra pode está lhe ajudando no atendimento, caso tenha mais dúvidas basta voltar e abrir um novo ticket, tenha um bom jogo :)</div>';
			   unset($stmte);
			   $stmte = null;
		   }else{
               echo '<div class="ferrorbig">Nota: sua resposta foi entregue, em breve retornaremos o contato!</div>';
		   }
      unset($stmte);
		   $stmte = null;
	   }
       else{
           echo '<div class="ferrorbig">[ERROR] houve um problema em nosso banco de dados, favor entre em contato com o administrador.</div>';
       }
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
		 

 
 
 }
 }
?>