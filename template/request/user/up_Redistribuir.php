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



<div style="box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;margin-bottom:2px;">Nota</b>:<br><br>

      &nbsp;&nbsp;The objective of this tool is to make it easier for players who wish to redistribute their points, to use this tool you just need to have at least
5,000,000 in your inventory.
	  <br>
	  <br>
	  For you to use the tool it is necessary to be disconnected from the server.
	  <div style="height:20px;"></div>

 </div>


<form name="reADDpontos" id="reADDpontos">

  <input type="hidden" name="personagem" value="<?=$personagem?>">


   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;"  type="button" value="DELETAR" onclick="new Ajax.Updater('errors', 'template/request/user/up_Redistribuir.php?action=reADDpontos', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.reADDpontos)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>

<div id="errors" name="errors"></div>

<?

		}elseif($action=="reADDpontos"){
	
	$personagem = aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem']))));
	
	try{
        $stmtC = $db->prepare("SELECT * FROM Server01.dbo.cabal_character_table WHERE CharacterIdx=:id");
        $stmtC->bindParam(':id', $personagem, PDO::PARAM_INT);
        $stmtC->execute(); 
        $resultChar = $stmtC->fetchObject();
        }catch(PDOException  $er ){
        echo "Error: ".$er;
        }
	     $totalPonts = $resultChar->STR + $resultChar->INT + $resultChar->DEX;
		 $calcularPontosTotal = $totalPonts + $resultChar->PNT;
		 
	if(!$personagem){
		echo '<script>console.log( swal("Sorry!", "We didn't find the character in the database.", "info") );</script>';
	}elseif($totalPonts==0){
		echo '<script>console.log( swal("Sorry!", "The character is already reset.", "info") );</script>';
		
	}elseif($result_conta->Login>=1){
		echo '<script>console.log( swal("Sorry!", "Your character must be disconnected from the server to perform this action.", "info") );</script>';
		
	}elseif(!is_numeric($personagem)){
		echo '<script>console.log( swal("Sorry!", "Authentication of character not performed, please contact the administrator.", "info") );</script>';
		
	}else{

		try{
        $execute = $db->prepare("UPDATE Server01.dbo.cabal_character_table set STR=0,INT=0,DEX=0,PNT=:pontos WHERE CharacterIdx=:id");
        $execute->bindParam(':id', $personagem, PDO::PARAM_INT);
		$execute->bindParam(':pontos', $calcularPontosTotal, PDO::PARAM_INT);
        $execute->execute(); 
        }catch(PDOException  $er ){
        echo "Error: ".$er;
        }
		echo '<script>console.log( swal("Sorry!", "Your character's points have been reset.", "success") );</script>';
		
	}
	
}
?>