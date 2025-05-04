<?php

require("../../../web_conexao/init.php");
Deslogado();
AdminCP();
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
.Notas {
		color: #FFE92D;
        text-shadow: 0px 0px 10px #FDFB69;	
	font-weight:bold;
	}
.cashcupom{display:none;}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Adicionar moeda</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Fique atento sempre no tipo de moeda que você vai enviar.</li>
</ul>
<form name="addmoeda" id="addmoeda">

   <div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Nome do jogador</label></div>
      <div class="finput" style="">
        <input name="jogador" type="text" maxlength="21" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Valor</label></div>
      <div class="finput" style="">
        <input name="moeda" type="text" maxlength="10" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Tipo de moeda</label></div>
      <div class="finput" style="">
        <select id="options" onchange="optionCheckSelect()" name="tipo" style="margin-bottom:3px;">
                   <option value="tpoint">TPoint</option>
			       <option value="cash">Cash</option>
			       <option value="cashcupom">Card Cash (Bronze)</option>
			       <option value="ticket">Ticket</option>
        </select>
		 
          </div>
      <div class="clear"></div>
    </div>

	
	<div class="flabel" id="myinputs" style="visibility:hidden">
      <div class="fitem" style=""><label for="rusername">Quantidade</label></div>
      <div class="finput" style="">
        <select name="quantity" class="ffield" style="margin-bottom:3px;">
			<option value="1">1 Unidade</option>
			<option value="2">2 Unidade</option>
			<option value="3">3 Unidade</option>
			<option value="4">4 Unidade</option>
			<option value="5">5 Unidade</option>
			<option value="6">6 Unidade</option>
			<option value="7">7 Unidade</option>
			<option value="8">8 Unidade</option>
			<option value="9">9 Unidade</option>
			<option value="10">10 Unidade</option>
			<option value="11">11 Unidade</option>
			<option value="12">12 Unidade</option>
			<option value="13">13 Unidade</option>
			<option value="14">14 Unidade</option>
			<option value="15">15 Unidade</option>
		  </select>
          </div>
      <div class="clear"></div>
    </div>
	

   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Adicionar" onclick="new Ajax.Updater('errors', 'template/request/p/get_moeda_insert.php?action=addc', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addmoeda)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='addc')
		{ 
			
			$jogador = htmlentities(antiSQL(anti_injection($_POST['jogador'])));
			
			$moeda = soNumero(antiSQL(anti_injection($_POST['moeda'])));
			
			$tipo = antiSQL(anti_injection($_POST['tipo']));
			
			$quantity = soNumero(antiSQL(anti_injection($_POST['quantity'])));
			
			$countCard = $quantity;
			
			$jogador_count = $db->query("select count(*) from Server01.dbo.cabal_character_table where Name='".$jogador."'")->fetchColumn();
			
			
			$permitir = array('tpoint','cash','ticket','cashcupom');
			if(!$jogador || !$moeda || !$tipo){
		       echo '<script type="text/javascript">document.addmoeda.reset();</script>';
			   echo '<script>console.log( swal("Informamos!", "é necessário preencher todos os campos.", "info") );</script>';
				exit();
			}elseif($jogador_count==0){
				echo '<script type="text/javascript">document.addmoeda.reset();</script>';
	echo '<script>console.log( swal("Informamos!", "O nome do jogador não existe ou deve está escrito incorretamente.", "info") );</script>';
				exit();
			}elseif(!is_numeric($moeda)){
				echo '<script type="text/javascript">document.addmoeda.reset();</script>';
	            echo '<script>console.log( swal("Informamos!", "o campo moeda não é um valor numerico.", "info") );</script>';
				exit();
			}elseif(!in_array($tipo, $permitir)){
				echo '<script type="text/javascript">document.addmoeda.reset();</script>';
	            echo '<script>console.log( swal("TENTATIVA DE INJECTION!", "você tentou roubar informações de nosso servidor, suas informações foram registradas e seram analisadas pela administração.", "warning") );</script>';
				exit();
			}else{
			
				
				try{
				    $Character = $db->query("select * from server01.dbo.cabal_character_table where Name='".$jogador."'")->fetchObject();
					$usernum = $db->query("select * from ACCOUNT.dbo.cabal_auth_table where '".$Character->CharacterIdx."'/8=UserNum")->fetchObject();
					$table_ticket_user = $db->query("select count(*) from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$usernum->UserNum."'")->fetchColumn();
					$CashAccount_count = $db->query("select count(*) from CabalCash.dbo.CashAccount where UserNum='".$usernum->UserNum."'")->fetchColumn();
					if($table_ticket_user==0){
			 //caso não exista registro na tabela de tickets a query vai criar um registro//
			 $db->query("INSERT INTO MWeb.dbo.cabal_m_tickets_usuarios (UserNum,Tickets,Tickets_gastos) VALUES ('".$usernum->UserNum."',0,0) ");
						
					}
					if($CashAccount_count==0){
						//caso não exista registro na tabela de tickets a query vai criar um registro//
			 $db->query("INSERT INTO CabalCash.dbo.CashAccount (ID,UserNum,Cash,CashBonus) VALUES ('".$usernum->ID."','".$usernum->UserNum."',0,0) ");
					}
					
					switch($tipo){
							
						case 'tpoint' : 
							$db->query("UPDATE Netcafebilling.dbo.Point set TPoint = TPoint + '".$moeda."' where UserNum='".$usernum->UserNum."'");               
						$point = $db->query("select * from Netcafebilling.dbo.Point where UserNum='".$usernum->UserNum."'")->fetchObject();
							
					echo '<script>console.log( swal("TPoint Enviado", "Você adicionou '.number_format($moeda).' TPoint na conta '.$usernum->ID.'.", "success") );</script>';
							break;
							
						case 'cash' :
							$db->query("UPDATE CabalCash.dbo.CashAccount set Cash = Cash + '".$moeda."' where UserNum='".$usernum->UserNum."'");
							echo '<script>console.log( swal("Cash Enviado", "Você adicionou '.number_format($moeda).' Cash na conta '.$usernum->ID.'.", "success") );</script>';
							break;
							
							case 'cashcupom' :
							if(!$quantity){
							echo '<script>console.log( swal("Falha", "desculpe, mais o campo quantidade é inválido #1.", "warning") );</script>';	
							}elseif(!is_numeric($quantity)){
							echo '<script>console.log( swal("Falha", "desculpe, mais o campo quantidade é inválido #2.", "warning") );</script>';
							}elseif($quantity < 1 || $quantity > 15){
							echo '<script>console.log( swal("Falha", "desculpe, mais o campo quantidade é inválido #3.", "warning") );</script>';
							}else{
								while($quantity > 0){
							$db->query("USE [CabalCash]exec up_AddMyCashItemByItem '".$usernum->UserNum."',0,0,'2366','".$moeda."','0'");
							    $quantity--;
								}
								echo '<script>console.log( swal("Cash Enviado", "você enviou x'.$countCard.' card cash no valor de '.number_format($moeda).' cash para o usuário '.$usernum->ID.'.", "success") );</script>';
								
							}
							break;
							
						case 'ticket' :
							$db->query("UPDATE MWeb.dbo.cabal_m_tickets_usuarios set Tickets = Tickets + '".$moeda."' where UserNum='".$usernum->UserNum."'");
							echo '<script>console.log( swal("Ticket Enviado", "Você adicionou '.number_format($moeda).' Ticket na conta '.$usernum->ID.'.", "success") );</script>';
							break;
					}
					
					
				}catch(PDOException $e){
					echo '<script>console.log( swal("Atenção!", "Houve um error na execução de dados.", "error") );</script>';
					echo $e;
				}
				
			
           
			echo '<script type="text/javascript">document.AdicionarVideo.reset();</script>';
			echo '<script>console.log( swal("Informamos!", "Seu video foi adicionado com sucesso.", "success") );</script>';
				exit();
				
			}
		}elseif($action!="" AND $action!="addc"){
			
			
			header("Location: ./");
			
		}






?>
