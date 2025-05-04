<?php

require("../../../web_conexao/init.php");
Deslogado();
AdminCP();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
echo $e;	
}

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
	

?>
<style>
	.fitem2 {
    font: 11px/17px Arial, sans-serif;
}
* {
    outline: 0;
    -moz-outline: 0 none;
}
.Notas {
		color: #FFE92D;
        text-shadow: 0px 0px 10px #FDFB69;	
	font-weight:bold;
	}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Adicionar video do Youtube</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Administrador favor não deixe de preenche is campos.</li>
</ul>
<form name="AdicionarVideo" id="AdicionarVideo">

   <div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Titulo do Youtube</label></div>
      <div class="finput" style="">
        <input name="title" type="text" maxlength="32" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">ID Youtube Video</label></div>
      <div class="finput" style="">
        <input name="Token" type="text" maxlength="32" class="ffield" style="margin-bottom:3px;"><img src="images/Tutorial_imagem/Token_Youtube.jpg" style="float:right; width:310px; height:33px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Imagem do video</label></div>
      <div class="finput" style="">
        <select name="imagem" style="margin-bottom:3px;">
			<?php
   function exibirNome($valor){
	$pontos = array("../../../images/Youtube_media/", "../../../images/Youtube_media/");
	$result = str_replace($pontos, "", $valor);
	return $result;
}
	  
	    /*nome da pasta onde está as imagens*/  
	    $pasta = "../../../images/Youtube_media";
	    /*recuperar as imagens e colocar em um array*/
	    $imagens = glob("$pasta/{*.jpg,*.png,*.gif}", GLOB_BRACE);

	    /*percorre o array*/
	    foreach($imagens as $img){
   /*Imprime a imagem*/ 
   echo "<option value='".base64_encode(exibirNome($img))."'>".exibirNome($img)."</option>";
	    }
    ?>
		  </select>
		  <img src="images/Tutorial_imagem/Youtube_Imagem_raiz.jpg" style="float:right; width:310p; height:33px;">
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Deseja destacar esté video?</label></div>
      <div class="finput" style="">
        <select name="Destaque">
			<option value="yes">Sim</option>
			<option value="no">Não</option>
		  </select>
          </div>
      <div class="clear"></div>
    </div>


   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Adicionar" onclick="new Ajax.Updater('errors', 'template/request/p/get_m_Youtube.php?action=AdicionarVideo', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.AdicionarVideo)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='AdicionarVideo')
		{ 
			function tiraCaracter($valor){
	$pontos = array("=");
	$result = str_replace($pontos, "", $valor);
	return $result;
     }
			
			$title = htmlentities(antiSQL(anti_injection($_POST['title'])));
			
			$Token = antiSQL(anti_injection($_POST['Token']));
			
			$Imagem = antiSQL(anti_injection($_POST['imagem']));
			
			$Destaque = antiSQL(anti_injection($_POST['Destaque']));
			
			$titleQuery = $db->query("select count(*) from MWeb.dbo.cabal_m_Youtube_video where TitleYoutube = '".$title."'")->fetchColumn();
			
			$TokenQuery = $db->query("select count(*) from MWeb.dbo.cabal_m_Youtube_video where Youtube_Token = '".$Token."'")->fetchColumn();
			
			if(!$title || !$Token || !$Imagem || !$Destaque){
				echo '<script type="text/javascript">
document.mudarSenha.reset();
</script><div class=\'ferrorbig\'><font style="font-wieght:bold;">Informação:</font> é necessário preencher todos os campos.</div>';
			}elseif(strlen($title) < 5 || strlen($title) > 31){
				echo '<script type="text/javascript">document.AdicionarVideo.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Campo titulo requer no minimo 5 caracteres e no maximo 30.", "info") );</script>';
				exit();
			}elseif($titleQuery>=1){
				echo '<script type="text/javascript">document.AdicionarVideo.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Já existe video com o mesmo titulo.", "info") );</script>';
				exit();
			}elseif($TokenQuery>=1){
				echo '<script type="text/javascript">document.AdicionarVideo.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O video que deseja adicionar já existe.", "info") );</script>';
				exit();
			}else{
		
			
				try{
					$db->query("USE [MWeb]exec dbo.cabal_m_insert_Youtube_Video '".$Token."', '".$Imagem."', '".$Destaque."','".$title."'");
					
				}catch(PDOException $e){
					echo '<script>console.log( swal("Atenção!", "Houve um error na execução de dados.", "error") );</script>';
				}
				
			
           
			echo '<script type="text/javascript">document.AdicionarVideo.reset();</script>';
			echo '<script>console.log( swal("Informamos!", "Seu video foi adicionado com sucesso.", "success") );</script>';
				exit();
				
			}
		}elseif($action!="" AND $action!="AdicionarVideo"){
			
			
			header("Location: ./");
			
		}






?>
