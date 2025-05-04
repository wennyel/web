<?php

require("../../../web_conexao/init.php");

#################################
#### CUSTO PRA DELETAR CHAR #####
$custDel = "2000"; // 2k de cash
#################################

Deslogado();
$personagem = htmlspecialchars(aiRemove(anti_injection(aiRemove(@$_GET['Idx']))));
try{
$retC = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:iD");
$retC->bindParam(':iD', $_SESSION['my_login'], PDO::PARAM_STR);
$retC->execute(); 
$result_conta = $retC->fetchObject();
}catch(PDOException  $er ){
echo "Error: ".$er;
}

try{
$stmtCount = $db->prepare("SELECT count(*) FROM server01.dbo.cabal_character_table where CharacterIdx/8=:UserNum");
$stmtCount->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
$stmtCount->execute(); 
$contar_personagem = $stmtCount->fetchColumn();
}catch(PDOException  $er ){
echo "Error: ".$er;
}


 $action		=	aiRemove(antiSQL(anti_injection(isset($_GET["action"])))) ? aiRemove(antiSQL(anti_injection($_GET["action"]))) : '';
 
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
	.news-lists {
		border-bottom: 1px dotted #153348;
		margin-top:5px;
		height:34px;
		background-color: #091421;
	}
	.news-lists:hover {
    background: #091f2f;
    box-shadow: 14px 14px 43px -17px rgba(0, 0, 0, 0.7);
    color: #fff;
		
} 
</style>


<div style="box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Grades</b>:<br>

      - Your character will be permanently deleted.<br>

      - We are not responsible for any decision made.<br>
      
      - select the character you want to delete.<br>

      - You must be <font color="red"><u>OFFLINE</u></font> totally from your account.<br>
		
	  - The restoration costs 15k cash<br>
		 
	  - To delete your character it is necessary to have at least 2k of cash<br>
	  <div style="height:20px;"></div>

 </div>


<form name="delchar" id="delchar">

  <input type="hidden" name="personagem" value="<?=$personagem?>">

  <input type="hidden" name="token" value="<?=$SESSION['upDelchar']?>">
   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input  name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="DELETAR" onclick="new Ajax.Updater('errors', 'template/request/user/up_delchar.php?action=delchar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.delchar)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='delchar')
		{ 
			try{
					$stmtC = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE UserNum=:id");
				    $stmtC->bindParam(':id', $result_conta->UserNum, PDO::PARAM_INT);
					$stmtC->execute(); 
					$userCash = $stmtC->fetchObject();
                    }catch(PDOException  $er ){
                       echo "Error: ".$er;
                    }
			
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Sorry!", "you have no character to use this system.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem']))));
		   
		   $token   =  aiRemove(antiSQL(anti_injection($SESSION['upDelchar'])));
			
		
		
	       $object_personagem = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchObject();
          
		  $rowCountChar = $db->query("Select count(*) from server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchColumn();
			
			if($object_personagem->Login >=1){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "Log out of your character to delete.", "info") );</script>';
			}elseif($result_conta->Login >=1){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "you must log out of your account to delete the desired character", "info") );</script>';
			}elseif(!$_SESSION['my_login']){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "your panel session has expired, please log in again", "error") );</script>';
			}elseif(!is_numeric($personagem)){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "There was a technical problem with the system, please notify the administrator.", "warning") );</script>';
			}elseif($userCash->Cash<=0){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "You have no cash on your balance", "info") );</script>';
			}elseif($custDel > $userCash->Cash){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "you have insufficient cash to delete character", "info") );</script>';
			}elseif($personagem<=0){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "the character has already been deleted.", "info") );</script>';
			}elseif($rowCountChar<=0){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "the character has already been deleted.", "info") );</script>';
			}else{
			
				
			
				//INSERT LOGS DELETED//
				try{
			$sql = "INSERT INTO MWeb.dbo.cabal_m_delchar_logs (CharacterIdx,UserNum) VALUES (:Character,:UserNum)";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':Character', $personagem, PDO::PARAM_INT);
			$sth->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
				//RETIRA O VALOR COBRADO PARA DELETAR CHAR//
				try{
			$sql = "UPDATE CabalCash.dbo.CashAccount SET Cash=Cash-:retirar where UserNum=:userAcc";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':retirar', $custDel, PDO::PARAM_INT);
			$sth->bindParam(':userAcc', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
				
				try{
					$query=Database::conexao()->prepare("exec server01.dbo.cabal_sp_delchar :CharacterID");
					$query->bindParam(':CharacterID', $personagem, PDO::PARAM_INT);
                    $query->execute();
}catch(PDOException  $er ){
echo "Error: ".$er;
}
				
		echo '<script>console.log( swal("Excluded!", "You just deleted ['.$object_personagem->Name.'] '.$personagem.' your account.", "success") );</script>';
				
	
			
		}
		}
		





?>
