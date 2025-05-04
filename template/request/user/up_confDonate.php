<?php

require("../../../web_conexao/init.php");
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

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
	

?>




<h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; font-size:20px; padding: 13px 28px;">CONFIRMAR DOAÇÃO</h2>
  <div  style="clear:right;"></div>

<div id="fbody" class="fbody" style="margin-top:-17px;">

<div style=" width:93%; margin-left:30px;line-height:1.3;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 10px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Requisito</b>:<br>

      - Por favor envie a confirmação de sua doação apenas uma vez.<br>

      - forneça sempre os dados corretamente, e antes de finalizar a confirmação revise os dados com atenção.<br>
      
      - qualquer tentativa de manipular a doação,  sua conta será bloqueado.<br>

      - As doações via Boleto demora no minimo 48Horas.<br>
	  </div>
	  <div style="height:20px;"></div>

<form name="addpontos" id="addpontos" style="margin-top: 20px; margin-left: 58px;">

<table width="50%" style="width:93%;" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	  <input type="hidden" name="UserNum" value="<?=$result_conta->UserNum?>">
    <td width="38%">  <div class="flabel" style=""><div class="fitem" style=""><label for="rusername"><b>Data da Doação</b></label></div>
     <div class="finput" style="margin-bottom:11px; margin-top:10px;">
         <input name="dataehora" class="ffield" type="date" style="color:#5b757b; font-family:Candara,Arial;">
     </div></td>
    <td width="62%">  <div class="flabel" style=""><div class="fitem" style=""><label for="rusername"><b>Código da Transação</b></label></div>
     <div class="finput" style="margin-bottom:11px; margin-top:10px;">
         <input name="codigo" class="ffield" type="text" style="text-transform:uppercase;color:#5b757b; font-family:Candara,Arial; width:90%;">
     </div></td>
  </tr>
  <tr>
    <td><div class="flabel" style=""><div class="fitem" style=""><label for="rusername"><b>Selecione o pacote adquirido:</b></label></div>
     <div class="finput" style="margin-bottom:11px; margin-top:10px;">
         <select name="PacoteCash" class="ffield" style="color:#5b757b; font-family:Candara,Arial;width:90%;">
        <?php

                	$search		=	$db->query("SELECT * FROM MWeb.dbo.ConfPgmt_Pacotes");

					while($rows=$search->fetch(PDO::FETCH_OBJ)){

				?>
      <option value="<?=$rows->Idx?>"> Doando R$ <?=number_format($rows->Valor) . '.00'?> você recebe <?=number_format($rows->Cash + $rows->Bonus)?>
  Gold
        </option>
      <?php

					}

				?>
         </select>
     </div></td>
    <td><div class="flabel" style=""><div class="fitem" style=""><label for="rusername"><b>Forma de doação</b></label></div>
     <div class="finput" style="margin-bottom:11px; margin-top:10px;">
         <select name="forma" class="ffield" type="text" style="color:#5b757b; font-family:Candara,Arial; width:90%;">
          <option value="1">MercadoPago (Boleto Bancário)</option>
	      <option value="2">MercadoPago (Cartão de Crédito)</option>
		  <option value="3">PayPal (Boleto)</option>
		  <option value="4">PayPal (Cartão de Crédito)</option>
         </select>
     </div></td>
  </tr>
  <tr>
    <td height="111" colspan="2"><div class="flabel" style=""><div class="fitem" style=""><label for="rusername"><b>Note:</b></label></div>
     <div class="finput" style="margin-bottom:11px; margin-top:10px;">
         <textarea name="msg" class="ffield" style="color:#5b757b; background-color:#1d1e2354; font-family:Candara,Arial; width:90%;"></textarea>
     </div></td>
  </tr>
</table>



	   


    <div class="flabel" style="text-align: center; margin-top:20px; margin-bottom:10px;"><input  name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="CONFIRMAR DOAÇÃO" onClick="new Ajax.Updater('errors', 'template/request/user/up_confDonate.php?action=donate', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addpontos)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='donate')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }

		$UserNum	=	htmlspecialchars(soNumero(aiRemove(protecao($_POST["UserNum"]))));

		$PacoteCash		=	htmlspecialchars(soNumero(aiRemove(protecao($_POST["PacoteCash"]))));

		$forma		=	htmlspecialchars(soNumero(aiRemove(protecao($_POST["forma"]))));

		$codigo		=	htmlspecialchars(aiRemove(protecao($_POST["codigo"])));

		$dataehora	=	htmlspecialchars(aiRemove(protecao($_POST["dataehora"])));

		$msg		=	htmlspecialchars(aiRemove(protecao($_POST["msg"])));
		
		
		     if(!$PacoteCash || !$codigo || !$dataehora || !$msg){
				echo '<script>console.log( swal("Ops!", "preencha todos os campos.", "info") );</script>';
			}elseif(!is_numeric($PacoteCash)){
				
				echo '<script>console.log( swal("Ops!", "Aviso, ocorreu um erro grave no sistema para confirmar a doação, entre em contato com a administração do servidor !.", "info") );</script>';
			}elseif(!is_numeric($forma)){
				
				echo '<script>console.log( swal("Ops!", "Aviso, ocorreu um erro grave no sistema para confirmar a doação, entre em contato com a administração do servidor!.", "info") );</script>';
			}elseif(!preg_match("([a-zA-Z0-9 ])", $codigo)){
				
				echo '<script>console.log( swal("Ops!", "Aviso, o código digitado é inválido !. ", "info") );</script>';
			}elseif(!preg_match("([a-zA-Z0-9 ])", $msg)){
				echo '<script>console.log( swal("Ops!", "Aviso, o código digitado é inválido! 2.", "info") );</script>';
			}else{

            $search    = $db->query("SELECT * FROM MWeb.dbo.ConfPgmt_Pacotes WHERE Idx='".$PacoteCash."'");

			$row		=	$search->fetchObject();

            $value_Cash =  $row->Valor;
			
			try{
				
				$insertDados = $db->prepare("INSERT INTO MWeb.dbo.ConfPgmt_historico (IdxPacote, IdxUser, FormaDePgmt, Valor, Codigo, Msg, Data) VALUES (:packCash, :UserNum, :forma, :price, :codigo, :msg, '".date('Y/m/d h:i:s', strtotime($dataehora))."')");
				$insertDados->bindParam(':packCash', $PacoteCash, PDO::PARAM_INT);
				$insertDados->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
				$insertDados->bindParam(':forma', $forma, PDO::PARAM_INT);
				$insertDados->bindParam(':price', $value_Cash, PDO::PARAM_INT);
				$insertDados->bindParam(':codigo', $codigo, PDO::PARAM_STR);
				$insertDados->bindParam(':msg', $msg, PDO::PARAM_STR);
				$insertDados->execute();	
				unset($insertDados);
				
			}catch(PDOException $error){ echo $error; }

			echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Obrigado", "em breve entregaremos o Gold doado.", "success") );</script>';
		
		}
					}
					








?>
