<style>
	.boxError {color:#A51B31; font-size:11px; padding: 5px 0 5px 0;}
	.boxSuccess {color:rgb(0, 181, 5); font-size:11px; padding: 5px 0 5px 0;}
	.boxInfor {color:rgba(17, 169, 162, 0.89); font-size:11px; padding: 5px 0 5px 0;}
</style>
<?php
	require("../../web_conexao/init.php");
	
	if(!aiRemove(antiSQL(anti_injection(array_key_exists("sair", $_GET))))){ // if 0002

	   if(antiSQL(aiRemove(anti_injection(array_key_exists("username", $_POST)))) AND aiRemove(antiSQL(anti_injection(array_key_exists("password", $_POST))))){ //if 0008
		
	$username	    =	aiRemove(antiSQL(anti_injection($_POST["username"]))); 
	$password	    =	aiRemove(antiSQL(anti_injection($_POST["password"])));
		
		
		if(aiRemove(antiSQL(anti_injection(array_key_exists("username", $_POST)))) AND aiRemove(antiSQL(anti_injection(array_key_exists("password", $_POST))))){ //if 0001
			
			
			if(!empty($username) AND !empty($password)){ //if - 0004
			
			
			if(!preg_match('/^[a-z\d_]{3,28}$/i', $username)){
				echo '<script>console.log( swal("Information!", "Invalid login.", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d]{4,15}$/i', $password)){
				echo '<script>console.log( swal("Information!", "Invalid format login.", "info") );</script>';
			}else{ //else - 0006
				
		// Home Try	
			
				$Query_E = $db->query("SELECT count(*) FROM Account.dbo.cabal_auth_table WHERE ID='".$username."' AND PWDCOMPARE('".$password."', Password) = 1 ")->fetchColumn();
			
				
				
				if($Query_E>=1){
					
					
					$_SESSION["my_login"]	  =	aiRemove($username);
            
		            $_SESSION["my_password"]  =	aiRemove($password); 
					$number1 = rand(10,30);
                                           $number2 = rand(31,50);
                                           $number3 = rand(51,80);
                                           $number4 = rand(81,99);
                                           $txtChave = anti_injection($number1.$number2.$number3.$number4);
					
					$countC = $db->query("select Chave from account.dbo.cabal_auth_table where ID='".$username."'")->fetchObject();
					if($countC->Chave==NULL OR $countC->Chave==""){	
					$db->query("UPDATE ACCOUNT.dbo.cabal_auth_table set Chave='".$txtChave."' where ID='".$username."'");
					}
					$obj_acc = $db->query("select * from ACCOUNT.dbo.cabal_auth_table where ID='".$username."'")->fetchObject();
 
					$count_ticket_register = $db->query("select count(*) from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$obj_acc->UserNum."'")->fetchColumn();
					
					$checkCash = $db->query("SELECT count(*) FROM CabalCash.dbo.CashAccount where ID='".$username."' AND UserNum='".$obj_acc->UserNum."'")->fetchColumn();
					if($checkCash==0){
					   	$db->query("INSERT INTO CabalCash.dbo.CashAccount (ID,UserNum,Cash) VALUES ('".$username."','".$obj_acc->UserNum."','0') ");
					}
					if($count_ticket_register==0){
						//if there is no record in the ticket table the query will create a record//
			 $db->query("INSERT INTO MWeb.dbo.cabal_m_tickets_usuarios (UserNum,Tickets,Tickets_gastos) VALUES ('".$obj_acc->UserNum."',0,0) ");
					}
					echo '<script>console.log( swal("Conectado!", "estamos processando seus dados..", "success") );</script>';
					?>

<script>
	
	$j(document).ready(function() {
						userLogado();
					});
               
	
</script>

<?
					
					
					
					
				}else{
					
					echo '<script>console.log( swal("Desculpe!","Informações de login incorretas.", "info") );</script>';
				}
				
				
			} //end - else 0006
			
			
			
			
			} //end -  if 0004
			else{ //else - 0005
			 echo '<script>console.log( swal("Informamos", "Login Inválido.", "info") );</script>';
			} // end - else 0005
			
			
			
		} // end - if 0001
	
	
		
		
	   } //end if -- 0008
	   else{
		   
		   echo '<script>console.log( swal("Informamos", "You need to fill in both fields.", "info") );</script>';
	   }
		   
		
	} //end - if 0002
	
	else{ // else - 0003
		session_destroy();
		echo '<script>console.log( swal("Encerrando login", "Aguarde, estamos limpando seu acesso.", "info") );</script>';
		
	
		
		
		
		
		
?>

<script>
	
	$j(document).ready(function() {
						userLogado();
					});
               
	
</script>

<? } ?>
