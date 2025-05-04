<?php
require("../../../web_conexao/init.php");
ini_set('default_charset', 'UTF-8');
Deslogado();
checkout_token();
  
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
echo $e;	
}
 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
			
			
	

?>
<style>
	.fitem2 {
    font: 11px/17px Arial, sans-serif;
}
* {
    outline: 0;
    -moz-outline: 0 none;
}
</style>



<div class="content-title title-carousel c-title">
		<span class="title">Envie seu suporte</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

        <b style="color:#D2B48C;">Notas</b>:<br>
        &nbsp;&nbsp;&nbsp;Agora seu atendimento ficou muito mais prático, envie ticket com um assunto desejado e aguarde ser respondido.
		<br><br>
		<b style="color:#D2B48C;">Regras de uso</b>:
		<ul style="font-size:13px;">
			 <li>- Caso o seu ticket foi resolvido, envie uma resposta final e marque a opção "SIM" para fechar o Ticket.</li>
			 <li>- Evite enviar vários tickets do mesmo assunto.</li>
			 <li>- Nunca envie ticket com assuntos repetido.</li>
			 <li>- Envie um ticket somente se não houver outro Pendente.</li>
		</ul>
		
      <br>
		 <div class="flabel" style="text-align: center; "><input style="color:#7a9390;" name="sbmtAddPnt" class="fsubmit" type="button" value="GERENCIAR MEUS TICKETS" onclick="#"></div>
		<div class="nbody nbody_N">

  <div class="nbar nbar_N" onclick=" ">
    <div style="padding: 5px; 0px;">

      <div class="ndate" style="float: left;"></div>
      <div class="clear"></div>

  </div>

  </div>

  </div>

     </div>

   </div>



<form name="EnvTicket" id="EnvTicket">
	
	<?php
			$number1 = rand(10,22);
			$number2 = rand(31,50);
            $number3 = rand(51,80);
            $number4 = rand(81,99);
            $cod_ticket = soNumero(anti_injection($number1.$number2.$number3.$number4));
			?>
	 <input name="ticket_id" type="hidden" maxlength="15" value="<?=$cod_ticket?>" class="ffield">
    <div class="news-info"><span>Código do ticket </span> - <?=$cod_ticket?>.</div>
	
	<div class="news-info" style="margin-bottom:5px;"><span>Nome </span> -  <?=$result_conta->Nome?>.</div>
    <input name="nome" type="hidden" value="<?=$result_conta->Nome?>" maxlength="15" class="ffield">
	
	
	
	
	<div class="flabel" style="margin-bottom:7px;">
      <div class="fitem" style=""><label for="rusername">Assunto</label></div>
      <div class="finput" style="">
        <select name="assunto" id="input_camp_ticket" onchange="novoInput()">
		<option value="0">Selecione seu assunto</option>
			<option value="1">Reportar Bug</option>
			<option value="2">Doações</option>
			<option value="3">Denúncia</option>
			<option value="4">Elógios</option>
			<option value="5">Outros</option>
		  </select>
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" id="new_camp_input" style="display:none;">
      <div class="fitem" style=""><label for="rusername">Código de transação</label></div>
      <div class="finput" style="">
        <input type="text" name="transacao">
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Descrição do ticket</label></div>
      <div class="finput" style="">
		  
		  <textarea name="descricao" style="height:60px; width: 93%;" value="" maxlength="400" class="ffield"></textarea>
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" style="">
		  <div style="padding-left:180px;margin-bottom:10px;">
   <div style="margin: 5px 10px;border-radius: 5px 5px 5px 5px; background: none repeat scroll 0% 0% rgba(70, 70, 70, 0.5); border: 1px solid rgba(70, 70, 70, 0.5); overflow: hidden; width: 200px;">
     
   
	   
	   <a onclick="
    document.getElementById('captcha').src='template/request/captcha.php?'+Math.random();
    document.getElementById('register').focus();"
    id="change-image" style="cursor:pointer;">
	   <img style="position:absolute; z-index:999; width:25px; height:25px; margin-left:170px; margin-top:3.5px; border-left:1px solid #bcbcbc; border-bottom:1px solid #bcbcbc; border-bottom-left-radius:40%;" src="images/atualizar.png">
	   </a>
	   
	   <a onclick="
    document.getElementById('captcha').src='template/request/captcha.php?'+Math.random();
    document.getElementById('register').focus();"
    id="change-image" style="cursor:pointer;">
	   <img src="template/request/captcha.php" style="border-radius: 3px 3px 0px 0px; width: 97%; margin-left: 3px; margin-top: 3px;" id="captcha" /><br/>
	   </a>


<!-- CHANGE TEXT LINK -->



<input type="text" style="border: medium none; border-radius: 5px 5px 5px 5px; width: 200px; padding: 3px 5px;" name="captcha" id="captcha" autocomplete="off" /><br/>
	   
	   
	   
	
  </div>
</div>
		  
        
      <div class="clear"></div>
    </div>


   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ENVIAR" onclick="document.getElementById('captcha').src='template/request/captcha.php?'+Math.random(); new Ajax.Updater('errors', 'template/request/support/get_insert_ticket.php?action=enviar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.EnvTicket)}); carregando('#errors'); ReCaptchA();"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='enviar'){ 
			
			
			$ticket_id = soNumero(antiSQL(anti_injection($_POST['ticket_id'])));
			$Nome      = antiSQL(anti_injection($_POST['nome']));
			$Assunto   = soNumero(antiSQL(anti_injection($_POST['assunto'])));
			$descricao = htmlentities(antiSQL(anti_injection($_POST['descricao'])));
			
			$myDate = date("d-m-Y H:i:s.B");
			
			$validTicket = $db-query("select count(*) from MWeb.dbo.cabal_ticket_suportes where ID_ticket = '".$ticket_id."'")->fetchColumn();
			
			if(!$ticket_id || !$Nome || !$Assunto || !$descricao) {
				echo '<script>console.log( swal("Desculpe!", "verifique os campos acima, todos devem está preenchidos!", "info") );</script>';	
			}elseif($validTicket>=1){
				echo '<script>console.log( swal("Desculpe!", "Houve um error, tente atualizar a página de ticket.", "info") );</script>';		
			}elseif(!preg_match('/^[A-Za-z]+$/', $Nome)){
				echo '<script>console.log( swal("Desculpe!", "Houve um erro inesperado, favor report o erro para o administrador. Código [t02].", "info") );</script>';		
			}elseif(!is_numeric($ticket_id)){
				echo '<script>console.log( swal("Desculpe!", "Houve um erro inesperado, favor report o erro para o administrador. Código [t02].", "info") );</script>';
			}elseif(!is_numeric($ticket_id)){
				echo '<script>console.log( swal("Desculpe!", "Houve um erro inesperado, favor report o erro para o administrador. Código [t02].", "info") );</script>';
			}elseif(strlen($descricao) < 30 || strlen($descricao) > 400){
				echo '<script>console.log( swal("Desculpe!", "O Campo de descrição requer no minimo 30 caracteres e no máximo 200.", "info") );</script>';
			}elseif(empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
				echo '<script>console.log( swal("Desculpe!", "parece que você não digitou o re-captch corretamente.", "info") );</script>';
					   
				    }else{
			
			
			
			try{
       $stmte = $db->prepare("INSERT INTO MWeb.dbo.cabal_ticket_suportes (UserNum,ID_ticket,Assunto,Msg,Data) VALUES (:usernum,:ticketID, :Assunto, :Msg, getdate())");
	   $stmte->bindParam(":usernum", $result_conta->UserNum , PDO::PARAM_INT);			
       $stmte->bindParam(":ticketID", $ticket_id , PDO::PARAM_INT);
       $stmte->bindParam(":Assunto", $Assunto , PDO::PARAM_INT);
	   $stmte->bindParam(":Msg", $descricao , PDO::PARAM_STR);
	  
       $executa = $stmte->execute();
 
       if($executa){
				echo '<script>console.log( swal("Obrigado!", "seu ticket foi enviado com sucesso, em breve entraremos em contato!.", "success") );</script>';
					 
      unset($stmte);
		   $stmte = null;
	   }
       else{
				echo '<script>console.log( swal("Desculpe!", "[ERROR] houve um problema em nosso banco de dados, favor entre em contato com o administrador.", "info") );</script>';
				        }
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
			
			
			}	
			
			
			}

?>
