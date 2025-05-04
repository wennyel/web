<?php

require("../../../web_conexao/init.php");
Deslogado();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
	

?>




<div class="content-title title-carousel c-title">
		<span class="title">Distribuir meus pontos</span>
</div>

  <div  style="clear:right;"></div>

<div id="fbody" class="fbody">

  <div style="height:45px; width:100%;">
	  <b style="font-wieght:bold; font-family:Candara; font-size:16px;;">Requisitos:</b>
	  <br>
	  - O personagem selecionado deve está <font style="color: rgb(255, 5, 5); text-shadow: 0px 0px 10px rgb(255, 5, 5);	">OFFLINE</font> do jogo.
   </div>


<form name="addpontos" id="addpontos">

   <div class="flabel" style="">

	   <div class="fitem" style=""><label for="rusername"><b>Escolha seu char</b></label></div>

      <div class="finput" style="margin-bottom:11px; margin-top:10px;">

      

       <select name="personagem" class="ffield" style="color:#5b757b; font-family:Candara,Arial;">
<?php 
			$resumo_char = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."' AND Nation < 3");
			
			while($result_personagens = $resumo_char->fetch(PDO::FETCH_OBJ)){
				
				echo "<option value=".$result_personagens->CharacterIdx.">".$result_personagens->Name."&nbsp;-&nbsp;[FOR: ".$result_personagens->STR."]&nbsp;-&nbsp;[DES: ".$result_personagens->DEX."]&nbsp;-&nbsp;[INT: ".$result_personagens->INT."]&nbsp;-&nbsp;[Pontos: ".$result_personagens->PNT."]</option>";
		}
				?>
      

        </select> 

          </div>


   

<div class="pass first-pass">
<p>Força:</p>
<input name="STR" maxlength="4" onkeypress="return SomenteNumero(event)">
</div>

<div class="pass">
<p>Inteligência:</p>
<input name="INT" maxlength="4" onkeypress="return SomenteNumero(event)">
</div>
	
	<div class="pass" style="margin-left:27px;">
<p>Defesa:</p>
<input name="DEX" maxlength="4" onkeypress="return SomenteNumero(event)">
</div>
   

    <div class="flabel" style="text-align: center; margin-top:20px; margin-bottom:10px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Distribuir" onclick="new Ajax.Updater('errors', 'template/request/user/distribuir-pontos.php?action=distP', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addpontos)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='distP')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem']))));
		   $STR        = aiRemove(antiSQL(soNumero(anti_injection($_POST['STR']))));
		   $DEX        = aiRemove(antiSQL(soNumero(anti_injection($_POST['DEX']))));
		   $INT        = aiRemove(antiSQL(soNumero(anti_injection($_POST['INT']))));
			
		    if($STR == "") { $STR = 0;}
			if($DEX == "") { $DEX = 0;}
			if($INT == "") { $INT = 0;}
			
			
			$calc	=	($STR + $DEX + $INT);
			try{
			$stmtC = $db->prepare("select * from Server01.dbo.cabal_character_table where CharacterIdx=:personagem");
			$stmtC->bindParam(':personagem', $personagem, PDO::PARAM_INT);
			$stmtC->execute(); 
			$end_personagem = $stmtC->fetchObject();
			}catch(PDOException  $er ){
			echo "Error: ".$er;
			}
			
			if($end_personagem->PNT == 0){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Você não possui pontos para distribuir.", "info") );</script>';
			}elseif($calc > $end_personagem->PNT){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Você possui poucos pontos para distribuir no personagem desejado.", "info") );</script>';
			}elseif($calc==0){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "é necessário preencher um valor nos campos acima.", "info") );</script>';
			}elseif(!is_numeric($STR)){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "O Campo [força] requer apenas numeros", "error") );</script>';
			}elseif(!is_numeric($DEX)){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "O Campo [Defesa] requer apenas numeros", "error") );</script>';
			}elseif(!is_numeric($INT)){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "O Campo [Inteligência] requer apenas numeros", "error") );</script>';
			}elseif($end_personagem->Login>=1){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Você precisa está offline de sua conta para distribuir pontos", "info") );</script>';
			}else{
			
				
				try{
			$sql = "UPDATE Server01.dbo.cabal_character_table SET STR=STR+:STR, DEX=DEX+:DEX, INT=INT+:INT, PNT=PNT-:PNT WHERE CharacterIdx='".$personagem."'";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':STR', $STR, PDO::PARAM_STR);
			$sth->bindParam(':DEX', $DEX, PDO::PARAM_STR);
			$sth->bindParam(':INT', $INT, PDO::PARAM_STR);
			$sth->bindParam(':PNT', $calc, PDO::PARAM_STR);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				

           
				
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Obrigado!", "'.$end_personagem->Name.', seus pontos foram distribuidos com sucesso.", "success") );</script>';
			$sql = null;
			$sth = null;
			unset($sql);
			unset($sth);
			exit();
			}

     


		}






?>
