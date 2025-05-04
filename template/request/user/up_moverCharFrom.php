
	  
	  <?
 require("../../../web_conexao/init.php");
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
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


<h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; font-size:16px;">INSIRA O CÓDIGO PARA RECEBER PERSONAGEM:</h2>	  
	 
	  <form style="text-align:center;" name="ativacao">
	  <div style="padding: 5px">COLE O CÓDIGO AQUI!</div>
	     <input style="width:500px;" type="text" pattern=".{6,6}" maxlength="6" name="codigo">
	  <br>
	   <input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;"  type="button" value="PESQUISAR" onclick="new Ajax.Updater('errors', 'template/request/user/up_moverCharFrom.php?action=process', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.ativacao)}); carregando('#errors');">
	  <div name="errors" id="errors"></div>
	  </form>
<div style="height:20px"></div>
	  
	  
	  <? }elseif($action=='process'){
		  
		  
		  $codigo = htmlspecialchars(aiRemove(antiSQL(anti_injection($_POST['codigo']))));
		  
		  try{
				  $retCs = $db->prepare("SELECT * FROM MWeb.dbo.cabal_moverChar_table where TCodigo=:codigo AND ExpireDate > getdate()");
				  $retCs->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				  $retCs->execute(); 
				  $countCodigo = abs($retCs->rowCount());
				  unset($retCs);
			  }catch(PDOException $error){ echo $error; }
			  
			  
		  if(!$codigo){
			  echo "<script>swal('ERROR!','O Campo do código está vazio, por favor digite seu código.','info');</script>";
          }elseif($countCodigo==0){
			  echo "<script>swal('Desculpe!','O Código é inválido ou não existe.','info');</script>";
		  }elseif(strlen($codigo)<> 6){
			  echo "<script>swal('Desculpe!','O Código deve ser formado por 6 caracteres dentre eles Letras e Numeros.','info');</script>"; 
		  }elseif($result_conta->AuthType != 1){
			  echo "<script>swal('Desculpe!','Você não pode utilizar esse sistema, sua conta encontra-se bloqueada.','info');</script>"; 
		  }else{
			  
			 echo '
		  <script>$j(document).ready(function() {
						new Ajax.Updater(\'errors\', \'template/request/user/up_moverCharCod.php?serial='.$codigo.'\', {method: \'post\', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.ativacao)}); carregando(\'#errors\');
					});
               
	
</script>';
	  } }else{
		  
		  echo "<script>swal('Desculpe!','Identificamos uma falha na execução.','info');</script>";
		  
	  }
	  
	  
	  ?>
	  