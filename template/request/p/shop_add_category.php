<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
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
	.news-lists:hover {
    background-color: #091f2f;
}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">ADD AND DELETE CATEGORIES</span>
</div>
<font class="Notas">Notes:</font><br>
<ul style="margin-bottom:10px;">
	<li>Administrator please be sure to fill in the fields.</li>
</ul>
<form name="addItem" id="addItem">

  <div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Category Name</label></div>
<input name="name" id="txtpass" autocomplete="off" type="text" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Image</label></div>
<input name="imagem" type="text" id="txtpass" autocomplete="off" type="text" required>
</div>
	
	<div class="pass" style="margin-left:26px;">
<div class="fitem" style=""><label for="rusername">Category Description</label></div>
<input name="descrytion" type="text"  id="txtpass" max="2" autocomplete="off" required>
</div>
	
	
	
   

    <div class="flabel" style="text-align: center; margin-top:10px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ADD" onclick="new Ajax.Updater('errors', 'template/request/p/shop_add_category.php?action=addItem', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addItem)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>
<div id="errors" name="errors"></div>

<!--Home / List of Items logged award winning-->

 <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
<div class="clear"></div>
	 NOTE: Category items will also be deleted. </div>
     
   
	<div id="" name="" style="">
<?php
			$count_items = $db->query("select count(*) from WebLT_SHOP.dbo.Category")->fetchColumn();
			
			?>
    <div class="ntext" style="padding: 15px 15px 15px 15px;<? if($count_items==0){ echo 'margin-bottom:20px;'; } ?>" align="justify">
     
		
	
  
   <?php
		
			$list = $db->query("select * from WebLT_SHOP.dbo.Category");
			
			if($count_items == 0){
				
			echo '<div style="position:absolute;margin-left: 120px;margin-top: 34px;margin-bottom: 20px;padding-bottom: 20px;">There are no Categories yet to be displayed in the list to exclude items.</div>';	
				
			}
			$result = $list->fetchAll();
	foreach($result as $rows){
			@$n+=1;
				$resultRow = $db->query("SELECT COUNT(*) FROM WebLT_SHOP.dbo.Produtos where Category='".$rows['Category_id']."'")->fetchColumn();
			?>
		<div name="listItem<?=soNumero($rows['Category_id'])?>" id="listItem<?=soNumero($rows['Category_id'])?>">
		<table id="fbody" class="fbody news-lists" style="margin-top: 0; margin-left:-15px; margin-bottom:3px;" width="534" border="0" cellspacing="0" cellpadding="0">
  <tr  style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;margin-bottom:3px;">
    <td width="100%" align="left">&nbsp;&nbsp;&nbsp;<img src="images/icons/adicao.png" style="width:12px; position:absolute; margin-top:2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$rows['Category_name']?> ~ [<?=$resultRow?>] <a onclick="new Ajax.Updater('listItem<?=soNumero($rows['Category_id'])?>', 'template/request/p/shop_add_category.php?action=cleaner&category=<?=$rows['Category_id']?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#listItem<?=$rows['Category_id']?>');" class="blue-a" style="float:right; margin-right:10px;">Delete</a></td>

  </tr>
  
</table>
		
		
		
		</div>
		
   <? } ?>



 </div> </div>
<!--End/List de Items logado premiado-->

<? }elseif($action=='addItem')
		{ 
			
			$name       = htmlentities(antiSQL(anti_injection($_POST['name'])));
			
			$imagem     = htmlentities(antiSQL(anti_injection($_POST['imagem'])));
			
			$descrytion     = htmlentities(antiSQL(anti_injection($_POST['descrytion'])));

			
			try{
				$result_item = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Category where Category_name=:name");
				$result_item->bindParam(':name', $name, PDO::PARAM_INT);
				$result_item->execute();
				$count_item = $result_item->rowCount();
				if(abs($count_item)==1){
					echo '<script>console.log(swal("Information!", "This category already exists", "info"));</script>';
			        exit();
				}
			}catch(PDOException $error){ echo $error; }
			
			
			
			if(!$name || !$imagem || !$descrytion){
				echo '<script>console.log(swal("Information!", "fill in all fields.", "info"));</script>';
			}elseif(strlen($name) < 3 || strlen($name) > 40){
			 echo '<script>console.log(swal("Information!", "Item name field requires a minimum of 3 characters and a maximum of 20.", "info"));</script>';
			 exit();
			}elseif(strlen($descrytion) < 5 || strlen($descrytion) > 40){
			 echo '<script>console.log(swal("INJECTION ALERT!", "Field name Description requires a minimum of 5 characters and a maximum of 40", "error"));</script>';
			 exit();
			}else{
				
				try{
				
			$logados = Database::conexao()->prepare('INSERT INTO WebLT_SHOP.dbo.Category (Category_name,Category_imagem,Category_descri) VALUES (:name,:imagem,:descricao)');
			$logados->bindParam(':name', $name, PDO::PARAM_STR);
			$logados->bindParam(':imagem', $imagem, PDO::PARAM_STR);
			$logados->bindParam(':descricao', $descrytion, PDO::PARAM_STR);
			$logados->execute();		
			unset($logados);
					
				}catch(PDOException $e){
					echo '<script>console.log( swal("Attention!", "There was an error executing data.", "error") );</script>';
				}
				
							// echo '<script type="text/javascript">document.addItem.reset();</script>';

				echo '<script>console.log( swal("Information!", "The Category '.$name.' was added.", "success") );</script>';
			}
		}elseif($action=='cleaner'){
		
			   $idCat = htmlentities(soNumero(antiSQL(anti_injection($_GET['category']))));
			   try{
				   $excluir = $db->prepare("DELETE WebLT_SHOP.dbo.Category where Category_id=:id");
				   $excluir->bindParam(':id',$idCat, PDO::PARAM_INT);
				   $excluir->execute();
				   
				   $excluir_item = $db->prepare("DELETE WebLT_SHOP.dbo.Produtos where Category=:id");
				   $excluir_item->bindParam(':id',$idCat, PDO::PARAM_INT);
				   $excluir_item->execute();
			   }catch(PDOException $error){ echo $error; }
			echo '<script>console.log(swal("Information!", "your category has been deleted", "info"));</script>';
			 
			
		}






?>
