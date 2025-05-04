<?php 
require('../../web_conexao/init.php');
if(htmlentities(anti_injection(!array_key_exists("token", $_GET)))){
	
	echo "fatal error!";
	exit();
	
}
if(htmlentities(anti_injection(antiSQL($_GET['token'])))!="bjtSocketiCore"){
	
	echo "fatal error!";
	exit();
}


try{
$stmtC = $db->prepare("SELECT * FROM server01.dbo.cabal_LordOfWar_table where premio=0");
$stmtC->execute(); 
$userCash = $stmtC->fetchAll();
}catch(PDOException  $er ){ echo "Error: ".$er; exit();}

foreach($userCash as $row){

 switch($row['Nation']){
  
	 case 1 :
		 try{
	 // Seleciona a Usernum referente a idx do personagem//
	 $getNum = $db->query("select * from account.dbo.cabal_auth_table where '".$row['CharacterIdx']."'/8=UserNum")->fetchObject();
	 $getItem = $db->query("select * from server01.dbo.NCK_LORDOFWAR_REWARD where Nation='1' ")->fetchObject(); 
	 $getWar = $db->query("select * from server01.dbo.cabal_LordOfWar_table where CharacterIdx='".$row['CharacterIdx']."' AND Nation=1")->fetchObject(); 
		 }catch(PDOException $e) { echo $e; }
       
	
			 if(date("w")==0){ 

		    if($getWar->premio==0){

		 try{
	Database::conexao()->query("exec MWeb.dbo.cabal_envMoeda_portadores '".$getNum->UserNum."','".$getItem->ticket."','".$getItem->tpoint."','".$getItem->cash."','".$row['CharacterIdx']."'");
			 
	Database::conexao()->query("exec server01.dbo.cabal_sp_mail_send_GM '".$row['CharacterIdx']."','Recompensa de Portador','".$getItem->RewardText."','".$getItem->RewardItem."','".$getItem->RewardItemOpt."','".$getItem->RewardItemDur."','".$getItem->RewardAlz."'");
	 }catch(PDOException  $er ){ echo "Error: ".$er; }
			
				try{
$sql = "INSERT INTO MWeb.dbo.cabal_sedex_premio_war (UserNum,Personagem,ItemIdx,ItemOpt,ItemDur,Cash,Tpoint,ticket,Nation) VALUES (:usernum,:personagem,:idx,:option,:duracao,:cash,:tpoint,:ticket,'1')";
$sth = Database::conexao()->prepare($sql);
$sth->bindParam(':usernum', $getNum->UserNum, PDO::PARAM_INT);
$sth->bindParam(':personagem', $row['CharacterIdx'], PDO::PARAM_INT);
$sth->bindParam(':idx', $getItem->RewardItem, PDO::PARAM_INT);
$sth->bindParam(':option', $getItem->RewardItemOpt, PDO::PARAM_INT);
$sth->bindParam(':duracao', $getItem->RewardItemDur, PDO::PARAM_INT);
$sth->bindParam(':cash', $getItem->cash, PDO::PARAM_INT);
$sth->bindParam(':tpoint', $getItem->tpoint, PDO::PARAM_INT);
$sth->bindParam(':ticket', $getItem->ticket, PDO::PARAM_INT);
$sth->execute();	
}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
		 }else{
echo "nao pode receber o premio.";
	}
		 }else{
		 
			 echo "Ainda não é data de enviar prêmio!<br>";
			 exit();
			 unset($getNum);
			 unset($getItem);
			 unset($getWar);
			 
		 }
	
			 
		 
		 
		 
     
		
	 break;
	 
	 
	 
	 
		 case 2 : 
		 
		  try{
	 // Seleciona a Usernum referente a idx do personagem//
	 $getNum = $db->query("select * from account.dbo.cabal_auth_table where '".$row['CharacterIdx']."'/8=UserNum")->fetchObject();
	 $getItem = $db->query("select * from server01.dbo.NCK_LORDOFWAR_REWARD where Nation='2' ")->fetchObject(); 
	 $getWar = $db->query("select * from server01.dbo.cabal_LordOfWar_table where CharacterIdx='".$row['CharacterIdx']."' AND Nation=2")->fetchObject(); 
		 }catch(PDOException $e) { echo $e; }
       
		 if(date("w")==0){
			 

		    if($getWar->premio==0){

		 try{
	Database::conexao()->query("exec MWeb.dbo.cabal_envMoeda_portadores '".$getNum->UserNum."','".$getItem->ticket."','".$getItem->tpoint."','".$getItem->cash."','".$row['CharacterIdx']."'");
			 
	Database::conexao()->query("exec server01.dbo.cabal_sp_mail_send_GM '".$row['CharacterIdx']."','Recompensa de Portador','".$getItem->RewardText."','".$getItem->RewardItem."','".$getItem->RewardItemOpt."','".$getItem->RewardItemDur."'");
	 }catch(PDOException  $er ){ echo "Error: ".$er; }
			
				try{
$sql = "INSERT INTO MWeb.dbo.cabal_sedex_premio_war (UserNum,Personagem,ItemIdx,ItemOpt,ItemDur,Cash,Tpoint,ticket,Nation) VALUES (:usernum,:personagem,:idx,:option,:duracao,:cash,:tpoint,:ticket,'2')";
$sth = Database::conexao()->prepare($sql);
$sth->bindParam(':usernum', $getNum->UserNum, PDO::PARAM_INT);
$sth->bindParam(':personagem', $row['CharacterIdx'], PDO::PARAM_INT);
$sth->bindParam(':idx', $getItem->RewardItem, PDO::PARAM_INT);
$sth->bindParam(':option', $getItem->RewardItemOpt, PDO::PARAM_INT);
$sth->bindParam(':duracao', $getItem->RewardItemDur, PDO::PARAM_INT);
$sth->bindParam(':cash', $getItem->cash, PDO::PARAM_INT);
$sth->bindParam(':tpoint', $getItem->tpoint, PDO::PARAM_INT);
$sth->bindParam(':ticket', $getItem->ticket, PDO::PARAM_INT);
$sth->execute();	
}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
		 }else{
echo "nao pode receber o premio.";
}
		 }else{
		 
			 echo "Ainda não é data de enviar prêmio!<br>";
			 exit();
			 unset($getNum);
			 unset($getItem);
			 unset($getWar);
			 
		 }
		 
		 break;
 }
	
}

  
?>