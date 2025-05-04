 <?
require("../../../web_conexao/init.php");
Deslogado();
$coins = "1900";
$personagem = htmlspecialchars(aiRemove(anti_injection(aiRemove(@$_GET['Idx']))));

try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
			
			?>
<div style="box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Grades</b>:<br>

      - You must be logged out of your account completely.<br>

      - Class change has a cost of &nbsp;<img src="images/g-coin.png" style="width: 13px;"><?=number_format($coins)?>.<br>
      
      - after performing the class change your points will be reset to distribute again.
	  <br>
	  - Be aware that the Class change has nothing to do with converting Items.
	  <br>
	  - Your character must be at Level 200 to effect the class change.
	  </div>
	  <div style="height:20px;"></div>
	  
	  
<form name="delchar" id="delchar">

  <input type="hidden" name="personagem" value="<?=$personagem?>">
<font style="font-size: 12px;
    font-weight: bold;
    color: #8d7962;">CHOOSE THE CLASS YOU WANT TO OBTAIN</font>
	<div style="height:4px;"></div>
<select name="Class" style="color:#CEAD87;">
<option value="1">Warrior</option>
<option value="2">Blader</option>
<option value="3">Wizzard</option>
<option value="4">Force Archer</option>
<option value="5">Force Shielder</option>
<option value="6">Force Blader</option>
</select>
   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="TO CHANGE" onclick="new Ajax.Updater('errors', 'template/request/user/up_ClassChange.php?action=delchar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.delchar)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>


		<? }elseif($action=="delchar"){
			
			$idx = htmlentities(aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem'])))));
			
			$class = htmlentities(aiRemove(antiSQL(soNumero(anti_injection($_POST['Class'])))));
			
			
			try{
				$prepare = $db->prepare("select * from server01.dbo.cabal_character_table where CharacterIdx=:idx");
				$prepare->bindParam(':idx', $idx, PDO::PARAM_INT);
				$prepare->execute();
				$charTable = $prepare->fetchObject();
				unset($prepare);
				
				
				$skillist = $db->prepare("select * from server01.dbo.cabal_skilllist_table where CharacterIdx=:idx");
				$skillist->bindParam(':idx', $idx, PDO::PARAM_INT);
				$skillist->execute();
				$skillCount = $skillist->rowCount();
				unset($skillist);
				
				$quickslot = $db->prepare("select * from server01.dbo.cabal_quickslot_table where CharacterIdx=:idx");
				$quickslot->bindParam(':idx', $idx, PDO::PARAM_INT);
				$quickslot->execute();
				$quickslotCount = $quickslot->rowCount();
				unset($quickslot);
				
				$personagemTable = $db->prepare("select * from server01.dbo.cabal_character_table where CharacterIdx=:idx");
				$personagemTable->bindParam(':idx', $idx, PDO::PARAM_INT);
				$personagemTable->execute();
				$countChar = $personagemTable->rowCount();
				unset($personagemTable);
				
				$Cash = $db->prepare("select * from CabalCash.dbo.CashAccount where UserNum=:usernum");
				$Cash->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$Cash->execute();
				$meuCash = $Cash->fetchObject();
				unset($Cash);
			}catch(PDOException $error){ echo $error; }

			
			$permitir = array(1,2,3,4,5,6);
			if(!$idx || !$class){
				echo '<script>console.log( swal("We inform!", "Data authentication failed, please contact your administrator.", "warning") );</script>';
			}elseif($meuCash->Cash==0){
				echo '<script>console.log( swal("We inform!", "You have no cash in your account.", "info") );</script>';
			}elseif($meuCash->Cash<$coins){
				echo '<script>console.log( swal("We inform!", "Insufficient cash to perform the Class exchange.", "info") );</script>';
			}elseif(abs($countChar)==0){
				echo '<script>console.log( swal("We inform!", "We were unable to identify the character in your account.", "info") );</script>';
			}elseif($charTable->Login>=1){
				echo '<script>console.log( swal("We inform!", "you must be logged out of your account.", "info") );</script>';
			}elseif($charTable->LEV < 200){
				echo '<script>console.log( swal("We inform!", "you need to be at Level 200 to make the class transfer.", "info") );</script>';
			}elseif(!in_array($class, $permitir)){
				echo '<script>console.log( swal("There was a failure", "refresh the page and try again.", "warning") );</script>';
			}elseif(abs($skillCount)<=0){
				echo '<script>console.log( swal("We inform!", "It was not possible to identify your skill data, please contact the administrator.", "info") );</script>';
			}elseif(abs($quickslotCount)<=0){
				echo '<script>console.log( swal("We inform!", "it was not possible to identify data from your slots, please contact the administrator.", "info") );</script>';
			}else{
				try{
			$Changes = $db->prepare("EXEC server01.dbo.NCK_CHANGE_CHARACTER_CLASS :id, :myclass, :values");
			$Changes->bindParam(':id', $idx, PDO::PARAM_INT);
			$Changes->bindParam(':myclass', $class, PDO::PARAM_INT);
			$Changes->bindValue(':values', '0', PDO::PARAM_INT);
            $Changes->execute();
			
			unset($Changes);
			
			$retirarC = $db->prepare("UPDATE CabalCash.dbo.CashAccount set Cash=Cash-:cash where UserNum=:usernum");
			$retirarC->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
			$retirarC->bindParam(':cash', $coins, PDO::PARAM_INT);
            $retirarC->execute();
			unset($retirarC);
				}catch(PDOException $errr){ echo $errr; }
			
			echo '<script>console.log( swal("CONGRATULATIONS ^^", "You just changed class.", "success") ); saldorefresh();</script>';
			
		
			exit();
			}
			
			
          
			
	
 

			
		}

	?>