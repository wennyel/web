<?
require('../../../web_conexao/init.php');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';

Deslogado();
AdminCP();
		if($action==""){
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<form name="addnotice" id="addnotice">
	<div class="content-title title-carousel c-title">
		<span class="title">Adicionar noticias</span>
</div>

  <div style="clear:right;"></div>
	
		
<div class="pass first-pass">
<p>Titulo da noticia:</p>
<input name="titulo" id="txtpass" type="text" style="width: 212px;">
</div>

<div class="pass" style="margin-left: 92px;">
<p>Post by:</p>
<input name="post" id="txtrepass" type="text" style="width: 209px;">
</div>
		
	<div class="pass first-pass">
<p>Categoria:</p>
<select style="width:212px;" name="category" style="margin-bottom:4px;">
		<option value="notice">Noticias</option>
		<option value="event">Evento</option>
		<option value="updat">Update</option>
	</select>
</div>	
		
<div class="pass" style="
    margin-left: 92px;
">
<p>Deseja destacar?</p>
<select name="destaque" style="margin-bottom:4px; width:209px;">
		<option value="sim">Sim</option>
		<option value="nao">Não</option>
	</select>
</div>
		
<p>URL:<br>encode a url que deseja: <a href="https://www.base64encode.org/" target="_blank">clique aqui!</a></p>
<input name="url" id="txtrepass" type="text" style="width: 209px;">

		
<p>IMAGEM DA NOTICIA</p>
		<select name="imagem" style="margin-bottom:3px;">
			<?php
   function exibirNome($valor){
	$pontos = array("../../../images/notice/", "../../../images/notice/");
	$result = str_replace($pontos, "", $valor);
	return $result;
}
	  
	    /*nome da pasta onde está as imagens*/  
	    $pasta = "../../../images/notice";
	    /*recuperar as imagens e colocar em um array*/
	    $imagens = glob("$pasta/{*.jpg,*.png,*.gif}", GLOB_BRACE);

	    /*percorre o array*/
	    foreach($imagens as $img){
   /*Imprime a imagem*/ 
   echo "<option value='".base64_encode(exibirNome($img))."'>".exibirNome($img)."</option>";
	    }
    ?>
		  </select>
		
		
		
	<p>Descrição da noticia</p>
  <textarea style="margin-bottom: 7px;
    width: 484px;
    height: 85px;" name="descricao"></textarea>
		<br><div style="text-align:center;">
		<input name="sbmtAddPnt" class="fsubmit" type="button" value="ADICIONAR" onclick="new Ajax.Updater('errors', 'template/request/p/get_insert_notice.php?action=enviaa', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addnotice)}); carregando('#errors');">
		</div>
	</form>
	<div id="errors"></div>
</body>
</html>


<? }elseif($action=='enviaa')
		{ 
			function is_base64($s)
{
      return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
}
           
		   
           $titulo = htmlentities(aiRemove(antiSQL(anti_injection($_POST['titulo']))));
		   $autor        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['post']))));
		   $categoria        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['category']))));
		   $destaque        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['destaque']))));
		   $descricao        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['descricao']))));
			$imagem        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['imagem']))));
			$URL        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['url']))));
			
			$evitar_inject = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','INSERT','INTO','DROP','DELETE','UPDATER','WHERE','FROM','insert','into','drop','from','delete','where','hack','sony','machine','cabal','pirata','nexus','lotus','');
			
			if(!$titulo || !$autor || !$categoria || !$destaque || !$descricao || !$imagem){
			    echo '<script>console.log( swal("AVISO!", "é necessário preencher todos os campo.", "info") );</script>';
			}elseif(in_array($titulo, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo titulo tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($autor, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo autor tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($descricao, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo Descrição tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(strlen($titulo)>40){
	            echo '<script>console.log( swal("AVISO!", "Você não pode escrever um titulo com mais de 40 caracteres", "info") );</script>';
            }elseif(!base64_encode(!base64_decode($URL, true)) === $URL){
				echo '<script>console.log( swal("AVISO!", "O Campo url não é base64, por favor encode a url.", "info") );</script>';
			}else{
			
				
				
				try{
					$Pimage = "requires";
					$noticeEnv = $db->prepare("INSERT INTO MWeb.dbo.cabal_m_get_notices (Title,Msg,DateCreate,Destacar,PostBy,Category,Imagem,Url) VALUES (:title,:msg,getdate(),:destaque,:postby,:category,:imagem,:Urls)");
					$noticeEnv->bindParam(':title', $titulo, PDO::PARAM_STR);
					$noticeEnv->bindParam(':msg', $descricao, PDO::PARAM_STR);
					$noticeEnv->bindParam(':destaque', $destaque, PDO::PARAM_STR);
					$noticeEnv->bindParam(':postby', $autor, PDO::PARAM_STR);
					$noticeEnv->bindParam(':category', $categoria, PDO::PARAM_STR);
					$noticeEnv->bindParam(':imagem', $imagem, PDO::PARAM_STR);
					$noticeEnv->bindParam(':Urls', $URL, PDO::PARAM_STR);
					$noticeEnv->execute();
				}catch(PDOException $fail){ echo $fail; }
			
				echo '<script>console.log( swal("oOoPAaa", "sua noticia foi adicionada ao site.'.$descricao.'", "info") );</script>';
			
			}

     


		}






?>
