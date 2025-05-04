<?php 
require('../../web_conexao/init.php');
if(htmlentities(anti_injection(!array_key_exists("token", $_GET)))){
	
	echo "fatal error!";
	exit();
	
}
if(htmlentities(anti_injection(antiSQL($_GET['token'])))!="bjtSockeLendary22qsS"){
	
	echo "fatal error!";
	exit();
}


try{
$stmtC = $db->prepare("SELECT * FROM ACCOUNT.dbo.cabal_charge_auth where ServiceKind=25 AND cashVIP=1 ");
$stmtC->execute(); 
$userCash = $stmtC->fetchAll();
}catch(PDOException  $er ){ echo "Error: ".$er; exit();}
 $new_date				=	date('Y-m-d H:i:s.B', strtotime('+1 day'));
foreach($userCash as $row){
    
	$pegaResult = $db->query("select * from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$row['UserNum']."'")->fetchObject();
	$date_atual 	=	strtotime(date('Y-m-d H:i'));
	$vencidoEm	    =	strtotime($pegaResult->DataVIP);
	if($vencidoEm > $date_atual){
		echo 'Ainda não é hora de entregar ticket para usernum => '.$pegaResult->UserNum.'<br>';
		
	}else{
  try{
	  $qnt_de_ticket = 1;//
	  $myticket = $db->prepare("UPDATE MWeb.dbo.cabal_m_tickets_usuarios set Tickets=Tickets+:ticket, DataVIP=:bdata where UserNum=:user");
	  $myticket->bindParam(':ticket', $qnt_de_ticket, PDO::PARAM_INT);
	  $myticket->bindParam(':user', $row['UserNum'], PDO::PARAM_INT);
	  $myticket->bindParam(':bdata', $new_date, PDO::PARAM_STR);
	  $myticket->execute();	
  }catch(PDOException $error) { echo $error; }
	}
			 
}

  
?>