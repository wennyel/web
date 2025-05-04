<?

require('../../../web_conexao/init.php');
// Define o preço da transferência de personagem
define('CSH_PRECO', 3000); // Valor em "Cash" necessário para transferir

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
 Deslogado();
 try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}
if(htmlentities(aiRemove(anti_injection(array_key_exists("serial", $_GET))))){
	
	$action		=	aiRemove(antiSQL(anti_injection(isset($_GET["action"])))) ? aiRemove(antiSQL(anti_injection($_GET["action"]))) : '';
 
		if($action==""){
			
			$codigo = htmlspecialchars(antiSQL(anti_injection($_GET['serial'])));
		 
		  try{
				  $retCs = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where TCodigo=:codigo AND ExpireDate > getdate()");
				  $retCs->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				  $retCs->execute(); 
				  $countCodigo = abs($retCs->rowCount());
				  $resultadoCodigo = $retCs->fetchObject();
				  unset($retCs);
				  
				  $userTo = $db->prepare("SELECT * FROM ACCOUNT.dbo.cabal_auth_table where UserNum=:toUserNum");
				  $userTo->bindParam(':toUserNum', $resultadoCodigo->ToUserNum, PDO::PARAM_INT);
				  $userTo->execute(); 
				  $execTo = $userTo->fetchObject();
				  unset($retCs);
			  }catch(PDOException $error){ echo $error; }
			  
			  
			  if($countCodigo==0){
				  
				  echo "<script>swal('ERROR!','O Código de transferencia é inválido ou não existe!.','info');</script>";
				  exit();
			  }
			  
			  
		  if(!$codigo){
			  echo "<script>swal('ERROR!','O Campo do código está vazio, por favor digite seu código.','info');</script>";
          }elseif($countCodigo==0){
			  echo "<script>swal('Desculpe!','O Código é inválido ou não existe.','info');</script>";
		  }elseif(strlen($codigo)<> 6){
			  echo "<script>swal('Desculpe!','O Código deve ser formado por 6 caracteres dentre eles Letras e Numeros.','info');</script>"; 
		  }elseif($result_conta->AuthType != 1){
			  echo "<script>swal('Desculpe!','Você não pode utilizar esse sistema, sua conta encontra-se bloqueada.','info');</script>"; 
		  }elseif($result_conta->Login >=1){
			  echo "<script>swal('AVISO!','Ambas contas devem está deslogadas do jogo!.','info');</script>"; 
		  }elseif($execTo->Login >=1){
			  echo "<script>swal('AVISO!','A Conta do seu enviante está conectado, favor peça que ele deslogue da conta in-game.','info');</script>"; 
		  }elseif($execTo->AuthType != 1){
			  echo "<script>swal('AVISO!','O Parceiro que enviou sua conta , está bloqueado e por esse motivo é impossivel de realizar a transferencia de personagem.','info');</script>"; 
		  }elseif($resultadoCodigo->ToUserNum == $result_conta->UserNum){
			  echo "<script>swal('Desculpe!','Você não pode receber um personagem que já faz parte de sua conta.','info');</script>"; 
		  }else{
			  
			  try{
				  $DadosCodigo = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:char");
				  $DadosCodigo->bindParam(':char', $resultadoCodigo->ToCharacterIdx, PDO::PARAM_INT);
				  $DadosCodigo->execute(); 
				  $resultDados = $DadosCodigo->fetchObject();
				  unset($DadosCodigo);
			  }catch(PDOException $error){ echo $error; }
			  
	$classeChar    = decodificar($resultDados->Style);
	
			
			
			
			
			
$horaAtual = date('H:i:s');  // Define a hora atual no formato "HH:MM:SS"
$moveTime = $db->query("SELECT count(*) FROM MWeb.dbo.cabal_moverChar_table 
                        WHERE TCodigo='".$codigo."' 
                        AND ExpireDate > convert(datetime, convert(char(10), GETDATE(), 102) + ' ".$horaAtual."') 
                        AND ToCharacterIdx='".$resultDados->CharacterIdx."'")
               ->fetchColumn();
			
			if(abs($moveTime)>=1){
              $Mover_Result = $db->query("select * from MWeb.dbo.cabal_moverChar_table where TCodigo='".$codigo."' AND ToCharacterIdx='".$resultDados->CharacterIdx."'")->fetchObject();
			   
			    $tempoVote 	= '<span style="color:red; font-family:arial; font-size:13px;" data-time="' . strtotime(date('Y/m/d H:i:s', strtotime("+0 hours",strtotime($Mover_Result->ExpireDate)))) . '" class="kkcount-down"></span>';

				$habilitado	=	'Tempo restante:';
	

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



<table width="80%" border="0" cellspacing="0" style="margin-top:20px;" cellpadding="0">
  <tr>
    <td><div style="width:320px;margin-left:298px;"><?=$classeChar['Classe_Nome']; unset($classeChar); ?><img style="border-radius:0px;float:left; border: 1px solid #34393d;" src=""> <h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; margin-bottom:-2px; font-size:30px;text-transform: uppercase;float:left;">&nbsp;&nbsp;<?=$resultDados->Name?></h2></div>
	
	<div style="width:238px;margin-left:287px;"><font style="color:#46AE73; font-weight:bold;">Level: <?=$resultDados->LEV?> </font>- <? if($GuildNo>=1){ echo $GuildNoA->GuildName; } else { echo "<font style='color:#EAAF10;'>sem guild</font>"; }?></div>
	
	<div style="width:320px;margin-left:277px;margin-top:7px;"><?=$habilitado?>&nbsp;<font style="font-weight:bold;"><?=$tempoVote?></font></div>
	
	</td>
  </tr>
</table>




<form name="transferir" id="transferir">
<input type="hidden" onkeypress="return SomenteNumero(event)" name="ToCharacter" value="<?=$resultadoCodigo->ToCharacterIdx?>">
<input type="hidden" onkeypress="return SomenteNumero(event)" name="TCodigo" value="<?=$codigo?>">
<input type="hidden" onkeypress="return SomenteNumero(event)" name="ToUserNum" value="<?=$resultadoCodigo->ToUserNum?>">
<h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; font-size:16px;">Selecione abaixo o <font style="color:#EE2C3C;font-weight:bold;">personagem destino</font> que será substituido:</h2>	 
<select onkeypress="return SomenteNumero(event)" name="mula">

<?
try{
				  $jogadores = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx/8=:UserNum");
				  $jogadores->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
				  $jogadores->execute(); 
				  $result = $jogadores->fetchAll();
				  unset($jogadores);
			  }catch(PDOException $error){ echo $error; }
			  
			  foreach($result as $rows){
				  
				  echo '<option value="'.$rows['CharacterIdx'].'"><font style="color:red;">Nome:</font> '.$rows['Name'].' Level: '.$rows['LEV'].' Dinheiro: '.number_format($rows['Alz']).'</option>';
			  }
?>


</select>
<div style="text-align:left;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;color:#EE2C3C;margin-bottom:2px;    text-shadow: 1px 2px 0px #000000;">LEIA ANTES DE TRANSFERIR!</b>:<br><br>

  <ul>
 	- O Código possui uma duração de 24Horas.<br>
 	- Seu personagem,Alz e invetário serão transferidos.<br>
  	- Seus rankings de dungeons solo serão removidos.<br>
  	- Se você for portador ou guardião irá perder seus titulos.<br>
	- Sua pontuação semanal de guerra de nação será restado.<br>
	- Recomendamos que ambos os personagens estejam sem guild.
  </ul>
	  <div style="height:20px;"></div>

 </div>
<table width="80%" border="0" cellspacing="0" style="margin-top:20px;" cellpadding="0">
  <tr>
    <td>
	<h2 style="font-size:30px; text-shadow: 2px 2px 0px #000000; color:#FFF;">Preço: <font style="color:#e1e400cf;">3,000 Gold</font></h2>
	<font style="color:red; font-weight:bold;">Atenção:</font> Ambas as contas devem está deslogadas do jogo.</font>
</table>

 <input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;"  type="button" value="TRANSFERIR" onclick="new Ajax.Updater('errors1', 'template/request/user/up_moverCharCod.php?action=moverChar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.ativacao)}); carregando('#errors1');">
	  <div name="errors1" id="errors1"></div>
</form>
<div style="height:23px;"></div>
	<script type="text/javascript">

	$j(document).ready(function(){

		$j(".kkcount-down").kkcountdown({

			dayText : ' Day ',

			daysText : ' Days ',

			hoursText : ':',

			minutesText : ':',

			secondsText : '',

			displayZeroDays : false,

			textAfterCount : '<strong>Este código expirou.</strong>'

		});

	}); 

</script>



		  <? } }else{

               //ERROR Corre quando alguém está tentando usar uma URL com o $_GET , Action , o get action na primeira base não ser para nada e sim na segunda que é para 
			   //enviar a transferencia que no caso seu valor é moverChar
				echo '<script>swal("ERROR 923","Houve um problema em nosso sistema , favor informe a um de nossos membros.","warning");</script>';

} }elseif(aiRemove(antiSQL(anti_injection(isset($_GET["action"])))) ? aiRemove(antiSQL(anti_injection($_GET["action"]))) : '' == "moverChar"){
	ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
 
 $ToCharacter = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_POST['ToCharacter'])))));
 $ToUserNum = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_POST['ToUserNum'])))));
 $mula = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_POST['mula'])))));
  $TCodigo = htmlentities(aiRemove(antiSQL(anti_injection($_POST['TCodigo']))));
 
             try{
				  $ToUserN = $db->prepare("SELECT * FROM ACCOUNT.dbo.cabal_auth_table where UserNum=:toUserNum");
				  $ToUserN->bindParam(':toUserNum', $ToUserNum, PDO::PARAM_INT);
				  $ToUserN->execute(); 
				  $userResult = $ToUserN->fetchObject();
				  unset($ToUserN);
				  
				  $checkChar = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:idxChar");
				  $checkChar->bindParam(':idxChar', $ToCharacter, PDO::PARAM_INT);
				  $checkChar->execute(); 
				  $checkResultadoidx = $checkChar->fetchObject();
				  $rowCountChar = abs($checkChar->rowCount());
				  unset($checkChar);
				  
				  $deletedPersonal = $db->prepare("SELECT * FROM server01.dbo.deleted_cabal_character_table where CharacterIdx=:idxChar AND Name=:name");
				  $deletedPersonal->bindParam(':idxChar', $checkResultadoidx->CharacterIdx, PDO::PARAM_INT);
				  $deletedPersonal->bindParam(':name', $checkResultadoidx->Name, PDO::PARAM_STR);
				  $deletedPersonal->execute(); 
				  $rowCountCharacter = abs($deletedPersonal->rowCount());
				  unset($deletedPersonal);
				  
				  $SaldoCash = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount where UserNum=:usernum");
				  $SaldoCash->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				  $SaldoCash->execute(); 
				  $saldo_result = $SaldoCash->fetchObject();
				  unset($SaldoCash);
				  
			  }catch(PDOException $error){ echo $error; }
			  
			  if($rowCountCharacter>=2){
				try{  
				 $deletedBackup = $db->prepare("EXEC MWeb.dbo.cabal_deleted_duplication_character_backup :idxPersonagem,:nomeChar");
				  $deletedBackup->bindParam(':idxPersonagem', $checkResultadoidx->CharacterIdx, PDO::PARAM_INT);
				  $deletedBackup->bindParam(':nomeChar', $checkResultadoidx->Name, PDO::PARAM_STR);
				  $deletedBackup->execute(); 
				  unset($deletedBackup);
				   }catch(PDOException $error){ echo $error; }
			  }
			  
			  try{
			 
				$memberGuild = $db->prepare("select * from server01.dbo.GuildMember where CharacterIndex=:charIdx");		
			    $memberGuild->bindParam(':charIdx', $checkResultadoidx->CharacterIdx, PDO::PARAM_INT);
				$memberGuild->execute();
                $checkGuildCount = $memberGuild->rowCount();				
			     unset($memberGuild);
				 
				$memberGuildMula = $db->prepare("select * from server01.dbo.GuildMember where CharacterIndex=:charIdx");		
			    $memberGuildMula->bindParam(':charIdx', $mula, PDO::PARAM_INT);
				$memberGuildMula->execute();
                $checkGuildMulaCount = $memberGuildMula->rowCount();				
			     unset($memberGuildMula);
			  
			    $checaMula = $db->prepare("select * from server01.dbo.cabal_character_table where CharacterIdx=:charIdx");		
			    $checaMula->bindParam(':charIdx', $mula, PDO::PARAM_INT);
				$checaMula->execute();
                $analiseMula = $checaMula->fetchObject();
			     unset($checaMula);
								
								
				}catch(PDOException $error){ echo $error; }
			  
 
 if(!$ToCharacter || !$mula || !$ToUserNum){
     echo '<script>swal("Warning 241!","Houve uma falha no envio de parametros, favor informe ao administrador.","warning");</script>';
 }elseif(!is_numeric($ToCharacter)){
	 echo '<script>swal("Houve uma falha! 522","Houve uma falha na identificação do personagem a receber.","warning");</script>';
 }elseif(!is_numeric($mula)){
	 echo '<script>swal("Houve uma falha! 672","Houve uma falha na identificação do personagem a ser substituido.","warning");</script>';
 }elseif($rowCountChar==0){
	 echo '<script>swal("Houve um problema!","não foi possivel identificar o personagem que será transferido.","warning");</script>';
 }elseif(strlen($ToCharacter)>7){
	 echo '<script>swal("ERROR INTERNO","Houve uma falha na identiif.","warning");</script>';
 }elseif(strlen($mula)>7){
	 echo '<script>swal("Houve uma falha! 672","Houve uma falha na identificação do personagem a ser substituido.","warning");</script>';
 }elseif($userResult->Login>=1){
	 echo '<script>swal("Desculpe!","O Jogador que lhe enviou o personagem está online no jogo, é necessário ambas as contas se desconectarem do servidor.","info");</script>';
 }elseif($result_conta->Login>=1){
	 echo '<script>swal("Desculpe!","Você precisa deslogar do servidor para transferir o personagem.","info");</script>';
 }elseif($saldo_result->Cash <= 0){
	 echo '<script>swal("Desculpe!","Você não possui cash para efetuar a transferencia.","info");</script>';
 }elseif(CSH_PRECO > $saldo_result->Cash){
	 echo '<script>swal("Desculpe!","Você não possui saldo para realizar a transferencia de personagem.","info");</script>';
 }elseif(abs($checkGuildCount) >=1){
	 echo '<script>swal("Desculpe!","O Personagem que você está tentando receber está em Guild, o sistema de transferencia requer que o jogador esteja fora de guild.","info");</script>';
 }elseif(abs($checkGuildMulaCount) >=1){
	 echo '<script>swal("Desculpe!","O personagem que você escolheu para ser substituido está em guild, favor pedimos que saia da guild e tente receber novamente seu personagem.","info");</script>';
 }elseif($analiseMula->ChannelIdx == 0){
	 echo '<script>swal("Desculpe!","2Para evitar possiveis bug pedimos que entre no personagem que foi selecionado, e em seguida deslogar da conta por completo.","info");</script>';
 }elseif($analiseMula->LoginTime == NULL){
	 echo '<script>swal("Desculpe!","3Para evitar possiveis bug pedimos que entre no personagem que foi selecionado, e em seguida deslogar da conta por completo.","info");</script>';
 }else{
	 
	 
	      try{
			$Changes = $db->prepare("EXEC server01.dbo.transfer_personagem_server :toCharacter,:fromCharacter,:TitularAccount");
			$Changes->bindParam(':toCharacter', $ToCharacter, PDO::PARAM_INT);
			$Changes->bindParam(':fromCharacter', $mula, PDO::PARAM_INT);
			$Changes->bindParam(':TitularAccount', $ToUserNum, PDO::PARAM_INT);
            $Changes->execute();
			unset($Changes);
			
			
			$excluir = $db->prepare("EXEC server01.dbo.cabal_tool_deleteCharacter :deleted");
			$excluir->bindParam(':deleted', $ToCharacter, PDO::PARAM_INT);
			$excluir->execute();
			unset($excluir);
			
			$precoDocash = CSH_PRECO;
			$myupdatecash = $db->prepare("UPDATE CabalCash.dbo.CashAccount set Cash=Cash-:retirarCash");
			$myupdatecash->bindParam(':retirarCash', $precoDocash, PDO::PARAM_INT);
			$myupdatecash->execute();
			unset($myupdatecash);
			
			
			$excCodigo = $db->prepare("DELETE MWeb.dbo.cabal_moverChar_table where TCodigo=:meucodigo");
			$excCodigo->bindParam(':meucodigo', $TCodigo, PDO::PARAM_STR);
			$excCodigo->execute();
			unset($myupdatecash);
			
			$logMover = $db->prepare("INSERT INTO MWeb.dbo.cabal_log_transferencia_char (CharEnviado,CharMula,EnviadoPor,RegDate,Valor) VALUES (:charenviado,:charmula,:enviadoPor,getdate(),:preco)");
			$logMover->bindParam(':charenviado', $ToCharacter, PDO::PARAM_INT);
			$logMover->bindParam(':charmula', $mula, PDO::PARAM_INT);
			$logMover->bindParam(':enviadoPor', $ToUserNum, PDO::PARAM_INT);
			$logMover->bindParam(':preco', $precoDocash, PDO::PARAM_INT);
			$logMover->execute();
			unset($logMover);
			
				}catch(PDOException $errr){ echo $errr; }
 
         echo '<script>swal("OoOPaa!","Seu personagem foi entregue com sucesso, obrigado.","success");</script>';
      
	  } 

}	?>
