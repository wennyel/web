<?
require('../../../web_conexao/init.php');
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
$action		=	aiRemove(antiSQL(anti_injection(isset($_GET["action"])))) ? aiRemove(antiSQL(anti_injection($_GET["action"]))) : '';
 
		if($action=="delchar"){
           
		    if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }

			$idx = htmlentities(aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem'])))));
			
			
			try{
			$upP = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where ToUserNum=:toUser AND ToCharacterIdx=:character");
			$upP->bindParam(':toUser', $result_conta->UserNum, PDO::PARAM_INT);
			$upP->bindParam(':character', $idx, PDO::PARAM_INT);
			$upP->execute();
			$upCount = abs($upP->rowCount());
			unset($upP);
			
			$checkAcc = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where ToUserNum=:toUser AND ToCharacterIdx=:character");
			$checkAcc->bindParam(':toUser', $result_conta->UserNum, PDO::PARAM_INT);
			$checkAcc->bindParam(':character', $idx, PDO::PARAM_INT);
			$checkAcc->execute();
			$CountUser = abs($checkAcc->rowCount());
			unset($checkAcc);
			
			$quntTransf = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where ToUserNum=:toUser");
			$quntTransf->bindParam(':toUser', $result_conta->UserNum, PDO::PARAM_INT);
			$quntTransf->execute();
			$transfCount = abs($quntTransf->rowCount());
			unset($quntTransf);
			}catch(PDOException $errr){ echo $errr; }
			
			if(!$idx){
				echo '<script>swal("DESCULPE!","Não foi possivel identificar o personagem que deseja transferir.","info");</script>';
				
			}elseif(!is_numeric($idx)){
				echo '<script>swal("DESCULPE!","Houve uma falha na segurança, nosso sistema foi notificado e em breve nossa equipe verificará o motivo do problema.","info");</script>';
			}elseif($CountUser>=1){
				echo '<script>swal("DESCULPE!","você só pode efetuar transferência uma vez, no momento existe uma transferência pendente.","info");</script>';
			}elseif($transfCount>=1){
				echo '<script>swal("DESCULPE!","Já existe transferencia em sua conta, favor aguarde o termino da transferencia para realizar uma nova, casó não esteja em processo de transferencia atualize a página e tente novamente.","info");</script>';
			}elseif($result_conta->Login>=1){
				echo '<script>swal("DESCULPE!","Você precisa está desconectado de sua conta.","info");</script>';
			}elseif($upCount>=1){
				echo '<script>swal("DESCULPE!","Personagem já está em processo de transferencia, aguarde o termino da transferencia para tentar realizar uma nova operação.","info");</script>';
			}else{
							try{
								$serial = Serial('aleatorio');
			$moveChar = $db->prepare("INSERT INTO MWeb.dbo.cabal_moverChar_table (ToUserNum,ToCharacterIdx,MulaCharacterIdx,TCodigo,RegDate,ExpireDate) VALUES (:toUserNum,:toCharacterIdx,0,:TCodigo,getdate(),DATEADD(day, 1, getdate()))");
			$moveChar->bindParam(':toUserNum', $result_conta->UserNum, PDO::PARAM_INT);
			$moveChar->bindParam(':toCharacterIdx', $idx, PDO::PARAM_INT);
			$moveChar->bindParam(':TCodigo', $serial, PDO::PARAM_STR);
            $moveChar->execute();
			unset($moveChar);
		
			
				}catch(PDOException $errr){ echo $errr; }
			
			echo '<script>console.log( swal("TRANSFERENCIA EM PROGRESSO!", "a transferencia do personagem já está em andamento, favor entregue o código gerado para o jogador que vai receber seu personagem.", "success") );</script>';
			
		
			}
?>


<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
	  
<tbody>
<tr style="background: #14171e; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>proprietário</strong></td>
<td class="boss_title" align="center" width="72"><strong>Personagem</strong></td>
<td class="boss_title" align="center" width="65"><strong>Codigo</strong></td>
<td class="boss_title" align="center" width="80"><strong>Tempo restante</strong></td>
</tr>
	

  <?php
  
       if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }
  
			$horaAtual	=	date("H:i");
			$Mover = $db->query("select * from MWeb.dbo.cabal_moverChar_table where ToUserNum='".$result_conta->UserNum."' AND ExpireDate > getdate()");
			$result = $Mover->fetchAll();
			
			
			try{
			$toChars= $db->prepare("DELETE MWeb.dbo.cabal_moverChar_table where ToUserNum=:user AND ExpireDate < getdate()");
			$toChars->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
            $toChars->execute();
		     unset($toChars);
		    }catch(PDOException $errr){ echo $errr; }
			
			
			
			
	        foreach($result as $row){
			
				try{
								
			$toChar = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:Idx");
			$toChar->bindParam(':Idx', $row['ToCharacterIdx'], PDO::PARAM_INT);
            $toChar->execute();
			$rows = $toChar->fetchObject();
		     unset($toChar);
		    }catch(PDOException $errr){ echo $errr; }
			
			
			
			
			
			$moveTime		=	$db->query("SELECT count(*) FROM MWeb.dbo.cabal_moverChar_table WHERE ToUserNum='".$result_conta->UserNum."' AND ExpireDate>convert(datetime,convert(char(10),GETDATE(),102) + ' ".$horaAtual."') AND ToCharacterIdx='".$rows->CharacterIdx."'")->fetchColumn();
			
			if(abs($moveTime)>=1){
              $Mover_Result = $db->query("select * from MWeb.dbo.cabal_moverChar_table where ToUserNum='".$result_conta->UserNum."' AND ToCharacterIdx='".$rows->CharacterIdx."'")->fetchObject();
			   
			    $tempoVote 	= '<span style="color:red; font-family:arial; font-size:13px;" data-time="' . strtotime(date('Y/m/d H:i:s', strtotime("+0 hours",strtotime($Mover_Result->ExpireDate)))) . '" class="kkcount-down"></span>';

				$habilitado	=	'Código Expira em:';
	

			}else{
				
try{
			$toChars1= $db->prepare("DELETE MWeb.dbo.cabal_moverChar_table where ToUserNum=:user AND ExpireDate < getdate()");
			$toChars1->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
            $toChars1->execute();
		     unset($toChars1);
		    }catch(PDOException $errr){ echo $errr; }
	
			}
			
			if(abs($moveTime)>=1){
			?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$result_conta->ID?></td>
<td class="boss_normal2" align="center"><strong><?=$rows->Name?></strong></td>
<td class="boss_normal2" align="center"><?=$row['TCodigo']?></td>
<td class="boss_normal2" align="center"><p style="margin-bottom:5px;"><?=$habilitado?></p><?=$tempoVote?></td>
</tr>
			<? }				} ?>
     

</tbody></table>



		<?
			
			
			
		}

	?>
	
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