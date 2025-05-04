<?
require('../../../web_conexao/init.php');
 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
Deslogado();
AdminCP();
		if($action==""){
?>
<!DOCTYPE html>
<html>
<head>
<style>
	.fitem2 {
    font: 11px/17px Arial, sans-serif;
}
* {
    outline: 0;
    -moz-outline: 0 none;
}
	.news-lists {
		border-bottom: 1px dotted #153348;
		margin-top:5px;
		height:34px;
		background-color: #091421;
	}
	.news-lists:hover {
    background: #091f2f;
    box-shadow: 14px 14px 43px -17px rgba(0, 0, 0, 0.7);
    color: #fff;
		
} 
</style>
</head>
<body>
	<form name="addurl" id="addurl">
	<div class="content-title title-carousel c-title">
		<span class="title">Adicionar ou deletar links</span>
</div>

  <div style="clear:right;"></div>
	
		
<div class="pass first-pass">
<p>Titulo da URL:</p>
<input name="titulo" id="txtpass" type="text" style="width: 212px;">
</div>

<div class="pass" style="margin-left: 92px;">
<p>Post Date:</p>
<input name="post" value="<?=date('d-m-Y H:i')?>" id="txtrepass" type="text" style="width: 209px;">
</div>
		
	<div class="pass first-pass">
<p>Servidor:</p>
<select style="width:212px;" name="servidor" style="margin-bottom:4px;">
		<option value="1">Mega.co.nz</option>
		<option value="2">Mediafire.com.br</option>
		<option value="3">GoogleDriver.com</option>
	<option value="4">4Shared.com.br</option>
	<option value="5">Utorrent</option>
	<option value="6">OneDriver</option>
	</select>
</div>	
		
<div class="pass" style="
    margin-left: 92px;
">
	<p>URL encode <a href="https://www.base64encode.org/" target="_blank">encode aqui!</a></p>
	<input name="url" id="txtpass" type="text" style="margin-bottom:4px; width:209px;">

</div>


		<br><div style="text-align:center;">
		<input name="sbmtAddPnt" class="fsubmit" type="button" value="Adicionar" onclick="new Ajax.Updater('errors', 'template/request/p/get_url_download.php?action=baixar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addurl)}); carregando('#errors');">
		</div>
	</form>
	<div id="errors"></div>
	
	
	
	
	<!--TABLE LISTAR DOWNLOAD ADICIONADOS-->
	<div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px; margin-bottom:7px; border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;GERENCIAR URLS:

     

      <div class="clear"></div>

    </div>
	 <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Titulo</strong></td>
<td class="boss_title" align="center" width="72"><strong>Servidor</strong></td>
<td class="boss_title" align="center" width="65"><strong>Update</strong></td>
<td class="boss_title" align="center" width="80"><strong>opção</strong></td>
</tr>
	
<?
try{
	$val = 1;
$stmtC = $db->prepare("SELECT * FROM MWeb.dbo.cabal_url_download WHERE id>=:id order by UpdateDate desc");
$stmtC->bindParam(':id', $val, PDO::PARAM_INT);
$stmtC->execute(); 
$download = $stmtC->fetchAll();
$getCount = $stmtC->rowCount();
}catch(PDOException  $er ){ echo "Error: ".$er; exit();}

if($getCount==0){
	
	echo ' <tr>
    <td colspan="5" style="padding-top:4px; padding-bottom:4px; text-align:center;">Não existe links para efetuar o download do jogo.</td>
  </tr>';
	
}else{

			 foreach($download as $rows){
		
		
?>


	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$rows['Title']?></td>
<td class="boss_normal2" align="center"><strong><?
			switch($rows['Servidor']){
			case 1 : echo 'Mega'; break;
			case 2 : echo 'Mediafire'; break;
		    case 3 : echo 'GoogleDriver'; break;
		    case 4 : echo '4Shared'; break;
		    case 5 : echo 'Utorrent'; break;
			case 6 : echo 'OneDriver'; break;
		}
			
			?></strong></td>
<td class="boss_normal2" align="center"><?=date('d-m-Y',strtotime($rows['UpdateDate']))?></td>
<td class="boss_normal2" align="center"><a onclick="new Ajax.Updater('final<?=$rows['id']?>', 'template/request/p/get_url_download.php?action=finalizar&id=<?=$rows['id']?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#final<?=$rows['id']?>');" class="blue-a profile-button">DELETAR</a></td>
</tr>
	<div style="visibility:hidden; width:1px; height:1px;" id="final<?=$rows['id']?>"></div>
     <? } } ?>

</tbody></table>
	
	
</body>
</html>


<? }elseif($action=='baixar' AND $action!='finalizar')
		{ 
           
		   
           $titulo = htmlentities(aiRemove(antiSQL(anti_injection($_POST['titulo']))));
		   $servidor        = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_POST['servidor'])))));
		   $url        = htmlentities(aiRemove(antiSQL(anti_injection($_POST['url']))));
			
			$evitar_inject = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','INSERT','INTO','DROP','DELETE','UPDATER','WHERE','FROM','insert','into','drop','from','delete','updater','where','hack','sony','machine','cabal','pirata','nexus','lotus','');
			
			if(!$titulo || !$servidor || !$url){
			    echo '<script>console.log( swal("AVISO!", "é necessário preencher todos os campos", "info") );</script>';
			}elseif(in_array($titulo, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo titulo tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($servidor, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo servidor tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(!is_numeric($servidor)){
	            echo '<script>console.log( swal("AVISO!", "Houve um problema ao selecionar servidor, verifique a opção e tente novamente.", "warning") );</script>';
            }elseif(in_array($url, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo URL encode tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }else{
			
				
	try{
	$date_register = date("Y-m-d H:m:s");
	$sth = Database::conexao()->prepare("INSERT INTO MWeb.dbo.cabal_url_download (Servidor,UpdateDate,URL_encode,Title) VALUES (:s,:u,:e,:t)");
	$sth->bindParam(':s', $servidor, PDO::PARAM_INT);
	$sth->bindParam(':u', $date_register, PDO::PARAM_STR);
	$sth->bindParam(':e', $url, PDO::PARAM_STR);
	$sth->bindParam(':t', $titulo, PDO::PARAM_STR);
	$sth->execute();	
	}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
				
				echo '<script>console.log( swal("URL ADICIONADO!", "Seu novo link de download foi adicionado com sucesso!", "success") );</script>';
			
			}

     


		}elseif($action=='finalizar' AND $action!='baixar')
		{
			 $id = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_GET['id'])))));
			
			try{
			$stmtC = $db->prepare("DELETE MWeb.dbo.cabal_url_download WHERE id=:id");
			$stmtC->bindParam(':id', $id, PDO::PARAM_INT);
			$stmtC->execute(); 
			}catch(PDOException  $er ){ echo "Error: ".$er; exit();}

			echo '<script>console.log( swal("URL DELETADA", "A URL foi deletada", "success") );</script>';
			
		}





?>
