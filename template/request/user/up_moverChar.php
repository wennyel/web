<?
require('../../../web_conexao/init.php');
 Deslogado();
 try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}
?>
<div style="box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Note</b>:<br>

      - By transferring your inventory and alzes will be sent.<br>

      - Character transfer costs &nbsp;<img src="images/g-coin.png" style="width: 13px;">2,000 Gold<br>
      
      - Payment is made by the user who will receive the character.
	  <br>
	  - At the end of the transfer of character both accounts must be disconnected from their account.
	  </div>
	  <div style="height:20px;"></div>
	  
	  
	  <?php
	  
	  try{
			$search= $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where ToUserNum=:user AND ExpireDate > getdate()");
			$search->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
            $search->execute();
			$count_result = abs($search->rowCount());
		     unset($search);
		    }catch(PDOException $errr){ echo $errr; }
			
			if($count_result==0){
	  
	  ?>

<form name="delchar" id="delchar">

<font style="font-size: 12px;
    font-weight: bold;
    color: #8d7962;">Select the character to be transferred</font>
  <div style="height:4px;"></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="58%"><select name="personagem" style="color:#CEAD87;">
          <?php

$mJogador = $db->query("select top 6 * from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'");
                    $result = $mJogador->fetchAll();
                    foreach($result as $row){
						echo '<option value="'.$row['CharacterIdx'].'">'.$row['Name'].' Level - '.$row['LEV'].'</option>';

 

					}
?>
        </select></td>
        <td width="42%"><div class="flabel" style="text-align: center; ">
          <input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="TO MOVE" onClick="new Ajax.Updater('errors', 'template/request/user/up_moverCharTo.php?action=delchar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.delchar)}); carregando('#errors');" style="width:160px;">
        </div></td>
    </tr>
  </table>

    <div style="height: 5px;"></div>



</form>
<div style="height:20px"></div>

<div id="errors" name="errors"></div>


			<? }elseif($count_result>=1){
				
				
				try{
				  $retCs = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where ToUserNum=:usernum AND ExpireDate > getdate()");
				  $retCs->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				  $retCs->execute(); 
				  $countCodigo = abs($retCs->rowCount());
				  $resultadoCodigo = $retCs->fetchObject();
				  unset($retCs);
			  }catch(PDOException $error){ echo $error; }
			  
			  try{
				  $DadosCodigo = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:char");
				  $DadosCodigo->bindParam(':char', $resultadoCodigo->ToCharacterIdx, PDO::PARAM_INT);
				  $DadosCodigo->execute(); 
				  $resultDados = $DadosCodigo->fetchObject();
				  unset($DadosCodigo);
			  }catch(PDOException $error){ echo $error; }
			  
                	$classeChar    = decodificar($resultDados->Style);
// Definindo a variável $horaAtual
$horaAtual = date("H:i:s");  // Isso vai pegar a hora atual no formato HH:MM:SS

// Agora, sua consulta SQL
$moveTime = $db->query("SELECT count(*) FROM MWeb.dbo.cabal_moverChar_table WHERE ToUserNum = '".$result_conta->UserNum."' AND ExpireDate > CONVERT(datetime, CONVERT(char(10), GETDATE(), 102) + ' ".$horaAtual."') AND ToCharacterIdx = '".$resultDados->CharacterIdx."'")->fetchColumn();
			
			if(abs($moveTime)>=1){
              $Mover_Result = $db->query("select * from MWeb.dbo.cabal_moverChar_table where ToUserNum='".$result_conta->UserNum."' AND ToCharacterIdx='".$resultDados->CharacterIdx."'")->fetchObject();
			   
			    $tempoVote 	= '<span style="color:red; font-family:arial; font-size:13px;" data-time="' . strtotime(date('Y/m/d H:i:s', strtotime("+0 hours",strtotime($Mover_Result->ExpireDate)))) . '" class="kkcount-down"></span>';

				$habilitado	=	'Time left:';
	

			}else{
				
try{
			$toChars1= $db->prepare("DELETE MWeb.dbo.cabal_moverChar_table where TCodigo=:codigo AND ExpireDate < getdate()");
			$toChars1->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $toChars1->execute();
		     unset($toChars1);
		    }catch(PDOException $errr){ echo $errr; }
	
			}
				
				$memberGuild = $db->query("select * from server01.dbo.GuildMember where CharacterIndex='".$resultDados->CharacterIdx."'")->fetchObject();
								
								@$GuildNo = $db->query("select count(*) from server01.dbo.Guild where GuildNo='".$memberGuild->GuildNo."'")->fetchColumn();
								if($GuildNo>=1){
								$GuildNoA = $db->query("select * from server01.dbo.Guild where GuildNo='".$memberGuild->GuildNo."'")->fetchObject();
								}
				
				?>
			
			
			
			<h2 style="font-size:18px; color:#800000d6; text-align:center; font-weight:bold; text-shadow: 0px 1px 1px #000000;">Você já está no processo de transferência,aguarde o término.</h2>




			<table width="80%" border="0" cellspacing="0" style="margin-top:20px;" cellpadding="0">
  <tr>
    <td><div style="width:320px;margin-left:298px;"><?=$classeChar['Classe_Nome']; unset($classeChar); ?><img style="border-radius:0px;float:left; border: 1px solid #34393d;" src=""> <h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; margin-bottom:-2px; font-size:30px;text-transform: uppercase;float:left;">&nbsp;&nbsp;<?=$resultDados->Name?></h2></div>
	
	<div style="width:320px;margin-left:238px;"><font style="color:#46AE73; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level: <?=$resultDados->LEV?> </font>- Guild: <? if($GuildNo>=1){ echo $GuildNoA->GuildName; } else { echo "<font style='color:#EAAF10;'>without guild</font>"; }?></div>
	
	<div style="width:320px;margin-left:372px;margin-top:7px;"><?=$habilitado?>&nbsp;<?=$tempoVote?></div>
	
	</td>
  </tr>
</table>
			
			
			<? } ?>

<script type="text/javascript">

	$j(document).ready(function(){

		$j(".kkcount-down").kkcountdown({

			dayText : ' Day ',

			daysText : ' Days ',

			hoursText : ':',

			minutesText : ':',

			secondsText : '',

			displayZeroDays : false,

			textAfterCount : '<strong>This code has expired.</strong>'

		});

	}); 

</script>