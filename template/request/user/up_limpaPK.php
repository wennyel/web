 <?
 require("../../../web_conexao/init.php");

Deslogado();

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
 
 <div style="line-height:1.3;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

      - Your character will be free from the punishment of pk.<br>

      - Clean your PK but your honor will be charged.<br>
      
      - Each time you use the pk cleaning system your honor will be charged twice.<br>

      - Your selected character must be <font color="red"><u>OFFLINE</u></font><br>
	  </div>
	  <div style="height:20px;"></div>
	  
	  <div style="font-size: 12px;font-weight: bold;margin: 9px 3px;">PK CLEANING HISTORY</div>
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
	  
<tbody>
<tr style="background: #14171e; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Character</strong></td>
<td class="boss_title" align="center" width="72"><strong>Use of the panel</strong></td>
<td class="boss_title" align="center" width="65"><strong>Honor collected</strong></td>
<td class="boss_title" align="center" width="80"><strong>Current Honor</strong></td>
</tr>
	

  <?php
			
			$result_PKPenalt_logs = $db->query("select * from MWeb.dbo.cabal_m_PKPenalty where UserNum='".$result_conta->UserNum."'");
			
			
			$result = $result_PKPenalt_logs->fetchAll();
	        foreach($result as $row){
			
			
				$iii = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx='".$row['CharacterIdx']."'")->fetchObject();
			
			?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['NameChar']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['usoPainel']?></strong></td>
<td class="boss_normal2" align="center"><?=$row['HCobrada']?></td>
<td class="boss_normal2" align="center"><?=number_format($iii->Reputation)?></td>
</tr>
<? } ?>
     

</tbody></table>


<form name="limparpk" id="limparpk">

  <input type="hidden" value="<?=$personagem?>" name="personagem">

    <div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="TO CLEAN" onclick="new Ajax.Updater('errors', 'template/request/user/up_limpaPK.php?action=limparpk', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.limparpk)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>




<? }elseif($action=='limparpk')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Sorry!", "you have no character to use this system.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = antiSQL(soNumero(anti_injection($_POST['personagem'])));
			
	       $object_personagem = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchObject();
			
		   $calcPKPenalty = $object_personagem->PKPenalty * 3 - 12;
			
		   ##CHECK SE PERSONAGEM É DESTA CONTA
		   
		   $verificarConta = $db->query("select * from account.dbo.cabal_auth_table where '".$personagem."'/8=UserNum")->fetchObject();
			
			if($object_personagem->Login >=1){
				echo '<script type="text/javascript">document.limparpk.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "Log out of your character to clear your punishment.", "info") );</script>';
			}elseif($result_conta->Login>=1){
				echo '<script>console.log( swal("Sorry!", "log out of your account to clear pk.", "info") );</script>';
			}elseif($verificarConta->ID != $result_conta->ID){
				echo '<script>console.log( swal("Sorry!", "Character does not belong to the logged in account.", "info") );</script>';
			}elseif($object_personagem->PKPenalty==0){
				echo '<script>console.log( swal("Sorry!", "'.$object_personagem->Name.', you have no punishments.", "info") );</script>';
			}elseif(!$_SESSION['my_login']){
				echo '<script type="text/javascript">document.limparpk.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "your panel session has expired, please log in again", "error") );</script>';
			}elseif($calcPKPenalty>$object_personagem->Reputation){
				echo '<script type="text/javascript">document.limparpk.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "'.$object_personagem->Name.', you dont have enough honor to clear your punishment.", "info") );</script>';
			}elseif(!is_numeric($personagem)){
				echo '<script type="text/javascript">document.limparpk.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "There was a technical problem with the system, please notify the administrator.", "warning") );</script>';
			}else{
			
				$log_penalty = $db->query("select distinct count(*) from MWeb.dbo.cabal_m_PKPenalty where UserNum='".$result_conta->UserNum."' AND CharacterIdx='".$personagem."'")->fetchColumn();
				
				
				if($log_penalty==0){ //if there is no char record yet it will insert in the table//
				try{
			//Query para deixa o campo PKPenalty 0 e também registra logs na tabela//
		    $db->query("USE [MWeb]exec dbo.cabal_PKPenalty_clean '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			$db->query("USE [MWeb]exec dbo.cabal_m_insert_log_PKPenalty '".$result_conta->UserNum."', '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."', '".$object_personagem->Name."'");
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				
				}else{
					
					//se ja existir registro ele vai só atualizar a tabela do registro
					try{
			
		    $db->query("USE [MWeb]exec dbo.cabal_PKPenalty_clean '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			$db->query("USE [MWeb]exec dbo.cabal_m_update_log_PKPenalty '".$result_conta->UserNum."', '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
					echo '<script>console.log( swal("Thanks!", "'.$object_personagem->Name.', his punishment was withdrawn.", "success") );</script>';
				}
                
				echo '<script>console.log( swal("Thanks!", "'.$object_personagem->Name.',his punishment was withdrawn.", "success") );</script>';
	
			$db = null;
			unset($db);
			exit();
			}

     


		}






?>

	  