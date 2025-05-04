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


<div style="line-height:1.3;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 12px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:12px; color: #86735e;margin-bottom:2px;">NOTE</b>:<br>

      - The activation code is sent after you register.<br>

      - If you have not used a valid or existing phone number, it will not be possible to activate this account.<br>
	  
	  - Add below the activation code sent to your cell phone.<br>
      
	  </div>
	  <div style="height:20px;"></div>
	  
	 
	  <form style="text-align:center;" name="ativacao">
	  <div style="padding: 5px">ENTER YOUR CODE</div>
	     <input style="width:500px;" type="text" pattern=".{6,6}" maxlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="codigo">
	  <br>
	   <input  name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;" type="button" value="Activate" onclick="new Ajax.Updater('errors', 'template/request/user/up_AtivarConta.php?action=envAtivacao', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.ativacao)}); carregando('#errors');">
	  <div name="errors" id="errors"></div>
	  </form>
	  
	  
	  
	  <? }elseif($action=='envAtivacao'){
		  
		  
		  $codigo = htmlspecialchars(antiSQL(soNumero(anti_injection($_POST['codigo']))));
		  
		  
		  if(!$codigo){
			  echo "<script>swal('ERROR!','The code field is empty, please enter your code.','info');</script>";
          }elseif(!is_numeric($codigo)){
			  echo "<script>swal('Sorry!','the field requires only numbers, please try again.','info');</script>";
		  }elseif(strlen($codigo)<> 6){
			  echo "<script>swal('Sorry!','the field requires only 6 digits, please check the field and try again','info');</script>"; 
		  }elseif($codigo != $result_conta->Chave){
			  echo "<script>swal('Sorry!','The Code is invalid, please enter your activation code correctly.','info');</script>"; 
		  }elseif($result_conta->Ativado=='sim'){
			  echo "<script>swal('Sorry!','Your account is activated.','info');</script>"; 
		  }elseif($result_conta->Ativado=='sim' AND $result_conta->AuthType != 1){
			  echo "<script>swal('Sorry!','There was a problem with the account activation ID, please contact your administrator.','info');</script>"; 
		  }elseif($result_conta->Ativado=='nao' AND $result_conta->AuthType == 1){
			  echo "<script>swal('Sorry!','There was a problem with the account activation identification, please contact the administrator.','info');</script>"; 
		  }else{
			  
			  try{
				  $retC = $db->prepare("UPDATE ACCOUNT.dbo.cabal_auth_table set AuthType=1, Ativado='sim' where UserNum=:usernum AND Chave=:codigo ");
				  $retC->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				  $retC->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				  $retC->execute(); 
				  unset($retC);
			  }catch(PDOException $error){ echo $error; }
		  
		 echo "<script>swal('Thanks!','Your account has been activated, have a good game.','success');</script>";
		 unset($retC);
		  }
		  
	  }else{
		  
		  echo "<script>swal('Sorry!','We identified a failure in execution.','info');</script>";
		  
	  }
	  
	  ?>