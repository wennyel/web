<?
require('../../../web_conexao/init.php');

Deslogado();
$personagem = htmlspecialchars(aiRemove(anti_injection(aiRemove(@$_GET['Idx']))));


$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();


   try{
				$query=Database::conexao()->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:idx");
				$query->bindParam(':idx', $personagem, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetchObject();
				}catch(PDOException  $er ){
				echo '<script>console.log( swal("Connection fail!", "There were problems connecting to the database2.", "error") );</script>';
				}
				

				
				 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){

				
?>



<style>
.input-re {
    background-color: #15171c;
    border: 1px solid #202125;
    height: 55px;
    width: 520px;
    box-shadow: inset 0 5px 20px 0 rgba(0,0,0,.75);
    color: #e7c195;
    text-align: center;
}
.h3 {
    color: #ffaf43;
    margin-bottom: 20px;
    line-height: 1.2;
    text-transform: uppercase;
    font-weight: 600;
}

</style>
<center>
<div style="margin-top:20px;">
<span id="DescPNT" class="h3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Total point (<?=$result->PNT?>)</font></font></span>
<h5><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-weight: normal;font-size: 13px;">To reset statistics, 5 eCoins are required</font></font></span></h5>

</div>
<form id="formPNT" name="formPNT" action="" method="post">
					<input type="hidden" name="_token" value="Emy6PTm0EbOhkXaToscdtzUV4mn7WpkPiVikrOgK">
					<input type="hidden" name="personagem" value="<?=$personagem?>">
					<p><input class="input-re" id="CharacterIdxPNT" type="hidden" name="CharacterIdx" value="106138" autocomplete="off" required=""></p>
					<p><input class="input-re" id="str" type="number" name="STR" placeholder="STR" value="" autocomplete="off" min="0" max="9999" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" required=""></p>
					<p><input class="input-re" id="int" type="number" name="INT" placeholder="INT" value="" autocomplete="off" min="0" max="9999" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" required=""></p>
					<p><input class="input-re" id="dex" type="number" name="DEX" placeholder="DEX" value="" autocomplete="off" min="0" max="9999" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" required=""></p>
					<div class="formButton">
							<input type="button" value="Add" class="button btn-submit"  style="background-color: #121418;border: 1px solid #202125;" onclick="new Ajax.Updater('errors', 'template/request/user/up_AddPontos.php?action=distP&Idx=<?=$result->CharacterIdx?>', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.formPNT)}); carregando('#errors');">
							

					</div>
					</form>
					
					</center>
					<div id="errors" name="errors"></div>

					
					<?
		}elseif($action=='distP')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Sorry!", "you have no character to use this system.", "info") );</script>';
			   exit();
		   }
		 
           $CharacterIdx = aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem']))));
		   $STR        = aiRemove(antiSQL(soNumero(anti_injection($_POST['STR']))));
		   $DEX        = aiRemove(antiSQL(soNumero(anti_injection($_POST['DEX']))));
		   $INT        = aiRemove(antiSQL(soNumero(anti_injection($_POST['INT']))));
		
		    if($STR == "") { $STR = 0;}
			if($DEX == "") { $DEX = 0;}
			if($INT == "") { $INT = 0;}
			
			
			$calc	=	abs($STR + $DEX + $INT);
			try{
			$stmtC = $db->prepare("select * from Server01.dbo.cabal_character_table where CharacterIdx=:personagem");
			$stmtC->bindParam(':personagem', $CharacterIdx, PDO::PARAM_INT);
			$stmtC->execute(); 
			$end_personagem = $stmtC->fetchObject();
			}catch(PDOException  $er ){
			echo "Error: ".$er;
			}
		
			if($end_personagem->PNT == 0){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "You have no points to distribute.", "info") );</script>';
			}elseif($calc > $end_personagem->PNT){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("We inform!", "You have few points to distribute in the desired character.", "info") );</script>';
			}elseif($calc==0){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "you must fill in a value in the fields above.", "info") );</script>';
			}elseif(!is_numeric($STR)){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "The [force] field requires only numbers", "error") );</script>';
			}elseif(!is_numeric($DEX)){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "The [Defense] Field requires only numbers", "error") );</script>';
			}elseif(!is_numeric($INT)){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Sorry!", "The [Intelligence] field requires only numbers", "error") );</script>';
			}elseif($end_personagem->Login>=1){
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("We inform!", "You need to be offline from your account to distribute points", "info") );</script>';
			}else{
			
				
				try{
			$sql = "UPDATE Server01.dbo.cabal_character_table SET STR=STR+:STR, DEX=DEX+:DEX, INT=INT+:INT, PNT=PNT-:PNT WHERE CharacterIdx=:Idx";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':Idx', $end_personagem->CharacterIdx, PDO::PARAM_INT);
			$sth->bindParam(':STR', $STR, PDO::PARAM_STR);
			$sth->bindParam(':DEX', $DEX, PDO::PARAM_STR);
			$sth->bindParam(':INT', $INT, PDO::PARAM_STR);
			$sth->bindParam(':PNT', $calc, PDO::PARAM_STR);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				

           
				
				echo '<script type="text/javascript">document.formPNT.reset();</script>';
				echo '<script>console.log( swal("Thanks!", "'.$end_personagem->Name.', your points have been successfully distributed.", "success") );</script>';
			$sql = null;
			$sth = null;
			unset($sql);
			unset($sth);
			exit();
			}

     


		}
					
					
					
					
					?>