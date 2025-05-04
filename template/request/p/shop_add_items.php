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
		<span class="title">ADD AND DELETE SHOP ITEMS</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Administrator please be sure to fill in the fields.</li>
</ul>
<form name="addItem" id="addItem">

  <div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Name Item</label></div>
<input name="name" id="txtpass" autocomplete="off" type="text" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Image</label></div>
<input name="imagem" type="text" placeholder="ex: 1022.png" id="txtpass" autocomplete="off" type="text" required>
</div>
	
	<div class="pass" style="margin-left:26px;">
<div class="fitem" style=""><label for="rusername">Price</label></div>
<input name="coins" type="number" onkeyup='if (isNaN(this.value)) {this.value = ""}' id="txtpass" max="2" autocomplete="off" required>
</div>
	
	
	<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Idx</label></div>
<input name="idx" onkeyup='if (isNaN(this.value)) {this.value = ""}' id="txtpass" autocomplete="off" type="text" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Option</label></div>
<input name="option" id="txtrepass" onkeyup='if (isNaN(this.value)) {this.value = ""}' type="text" required>
</div>
	
	<div class="pass" style="margin-left:26px;">
<div class="fitem" style=""><label for="rusername">Duration</label></div>
<select name="duracao" id="txtrepass" required>
	<option value="31">Permanente</option>
<option value="1">1 hour</option>
<option value="2">2 hours</option>
<option value="3">3 hours</option>
<option value="4">4 hours</option>
<option value="5">5 hours</option>
<option value="6">6 hours</option>
<option value="7">10 hours</option>
<option value="8">12 hours</option>
<option value="9">1 day</option>
<option value="10">3 days</option>
<option value="11">5 days</option>
<option value="12">7 days</option>
<option value="13">10 days</option>
<option value="14">14 days</option>
<option value="15">15 days</option>
<option value="16">20 days</option>
<option value="17">30 days</option>
<option value="18">45 days</option>
<option value="19">60 days</option>
<option value="20">90 days</option>
<option value="21">100 days</option>
<option value="22">120 days</option>
<option value="23">128 days</option>
<option value="24">270 days</option>
<option value="25">365 days</option>
<option value="22">120 days</option>
<option value="22">120 days</option>
		</select>
</div>
	
	<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Stock</label></div>
<input name="estoque" onkeyup='if (isNaN(this.value)) {this.value = ""}' id="txtpass" autocomplete="off" type="number" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Type</label></div>
 <select name="tipo" id="txtrepass" class="ffield" style="margin-top:3px; width:167px;">
			<option value="1">Normal</option>
			<option value="2">Linked to account</option>
			<option value="3">Linked to the character</option>
			<option value="4">Linked to account and character</option>
		  </select>
</div>
	
	<div class="pass" style="margin-left:26px;">
<div class="fitem" style=""><label for="rusername">Description</label></div>
		<input name="descricao" id="txtpass" autocomplete="off" type="text" required>
</div>
	
	<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Categories</label></div>
<select name="category">
	<?php
			try{
				$cat = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Category");
				$cat->execute();
				$result = $cat->fetchAll();
				$count = $cat->rowCount();
				if(abs($count)==0){
					echo '<option>There are no categories</option>';
				}else{
				foreach($result as $row){
					echo '<option value="'.$row['Category_id'].'">'.$row['Category_name'].'</option>';
				}}
			}catch(PDOException $error) { echo "There was an error displaying categories"; }
			?>
		</select>
</div>
   

    <div class="flabel" style="text-align: center; margin-top:10px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ADD" onclick="new Ajax.Updater('errors', 'template/request/p/shop_add_items.php?action=addItem', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addItem)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>
<div id="errors" name="errors"></div>

<!--Inicio/List de Items logado premiado-->

 <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
<div class="clear"></div>
&nbsp;&nbsp;MANAGE ITEMS
    </div>
     
   
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
			
			while($rows = $list->fetchObject()){
			@$n+=1;
			?>
		<table id="fbody" class="fbody news-lists" style="margin-top: 0; margin-left:-15px; margin-bottom:3px;" width="534" border="0" cellspacing="0" cellpadding="0">
  <tr  style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;margin-bottom:3px;">
    <td width="100%" align="left">&nbsp;&nbsp;&nbsp;<img src="images/icons/adicao.png" style="width:12px; position:absolute; margin-top:2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$rows->Category_name?> <a onclick="new Ajax.Updater('listItem<?=soNumero($rows->Category_id)?>', 'template/request/p/shop_items_excluir.php?item=<?=$rows->Category_id?>&m=sim', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#listItem<?=$rows->Category_id?>');" class="blue-a" style="float:right; margin-right:10px;">To show</a>&nbsp;&nbsp;&nbsp;<a onclick="new Ajax.Updater('listItem<?=soNumero($rows->Category_id)?>', 'template/request/p/shop_items_excluir.php?item=<?=soNumero($rows->Category_id)?>&m=nao', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#listItem<?=soNumero($rows->Category_id)?>');" class="blue-a" style="float:right; margin-right:10px;">Hides</a></td>

  </tr>
  
</table>
		
		
		<div name="listItem<?=$rows->Category_id?>" id="listItem<?=$rows->Category_id?>">
		</div>
		
   <? } ?>



 </div> </div>
<!--End/List de Items logado premiado-->

<? }elseif($action=='addItem')
		{ 
			
			$name       = htmlentities(antiSQL(anti_injection($_POST['name'])));
			
			$imagem     = htmlentities(antiSQL(anti_injection($_POST['imagem'])));
			
			$coins      = abs(soNumero(antiSQL(anti_injection($_POST['coins']))));
			
			$idx        = abs(soNumero(antiSQL(anti_injection($_POST['idx']))));
			
			$option     = abs(soNumero(antiSQL(anti_injection($_POST['option']))));
			
			$duracao    = abs(soNumero(antiSQL(anti_injection($_POST['duracao']))));
			
			$estoque    = abs(soNumero(antiSQL(anti_injection($_POST['estoque']))));
			
			$tipo       = abs(soNumero(antiSQL(anti_injection($_POST['tipo']))));
			
			$descricao      = htmlentities(antiSQL(anti_injection($_POST['descricao'])));
			
			$category      = htmlentities(antiSQL(anti_injection($_POST['category'])));
			
			try{
				$result_item = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos where Idx=:idx");
				$result_item->bindParam(':idx', $idx, PDO::PARAM_INT);
				$result_item->execute();
				$count_item = $result_item->rowCount();
				if(abs($count_item)==10){
					echo '<script>console.log(swal("Information!", "The Idx you are trying to add already exists!", "info"));</script>';
			        exit();
				}
			}catch(PDOException $error){ echo $error; }
			
			
			if($option == "") { $option = 0; }
			
			if(!$name || !$imagem || !$coins || !$idx || !$duracao || !$estoque || !$tipo || !$descricao){
				echo '<script>console.log(swal("Information!", "fill in all fields.", "info"));</script>';
			}elseif(!$category){
			 echo '<script>console.log(swal("Information!", "you did not select any categories", "info"));</script>';
			 exit();
			}elseif(strlen($name) < 5 || strlen($name) > 40){
			 echo '<script>console.log(swal("Information!", "Item name field requires a minimum of 5 characters and a maximum of 20.", "info"));</script>';
			 exit();
			}elseif(strlen($descricao) < 10 || strlen($descricao) > 40){
			 echo '<script>console.log(swal("Information!", "Description field requires a minimum of 20 characters and a maximum of 40.", "info"));</script>';
			 exit();
			}elseif(!is_numeric($idx)){
			 echo '<script>console.log(swal("Information!", "Idx field only requires numbers", "info"));</script>';
			 exit();
			}elseif(!is_numeric($option)){
			 echo '<script>console.log(swal("Information!", "option field only requires numbers", "info"));</script>';
			 exit();
			}elseif(!is_numeric($duracao)){
			 echo '<script>console.log(swal("Information!", "the duration field only requires numbers", "info"));</script>';
			 exit();
			}elseif(!is_numeric($tipo)){
			 echo '<script>console.log(swal("Information!", "the Type field only requires numbers", "error"));</script>';
			 exit();
			}elseif(!is_numeric($estoque)){
			 echo '<script>console.log(swal("Information!", "the stock field only requires numbers", "error"));</script>';
			 exit();
			}elseif($idx <= 0){
			 echo '<script>console.log(swal("INJECTION ALERT!", "injection attempt, recorded action.", "error"));</script>';
			 exit();
			}elseif($option < 0){
			 echo '<script>console.log(swal("INJECTION ALERT!", "injection attempt, recorded action.", "error"));</script>';
			 exit();
			}elseif($duracao < 0){
			 echo '<script>console.log(swal("INJECTION ALERT!", "injection attempt, recorded action.", "error"));</script>';
			 exit();
			}elseif($tipo < 0){
			 echo '<script>console.log(swal("INJECTION ALERT!", "injection attempt, recorded action.", "error"));</script>';
			 exit();
			}elseif($estoque < 0){
			 echo '<script>console.log(swal("INJECTION ALERT!", "injection attempt, recorded action.", "error"));</script>';
			 exit();
			}else{
				
				try{
				
			$logados = Database::conexao()->prepare('INSERT INTO WebLT_SHOP.dbo.Produtos (Name,Idx,Options,Duracao,Tipo,Estoque,Descricao,valor,Category,Imagem) VALUES (:name,:idx,:options,:duracao,:tipo,:estoque,:description,:coins,:category,:imagem)');
			$logados->bindParam(':name', $name, PDO::PARAM_STR);
			$logados->bindParam(':idx', $idx, PDO::PARAM_INT);
			$logados->bindParam(':options', $option, PDO::PARAM_INT);
			$logados->bindParam(':duracao', $duracao, PDO::PARAM_INT);
			$logados->bindParam(':tipo', $tipo, PDO::PARAM_INT);
			$logados->bindParam(':estoque', $estoque, PDO::PARAM_INT);
			$logados->bindParam(':description', $descricao, PDO::PARAM_STR);
			$logados->bindParam(':coins', $coins, PDO::PARAM_INT);
			$logados->bindParam(':category', $category, PDO::PARAM_INT);
			$logados->bindParam(':imagem', $imagem, PDO::PARAM_STR);
			$logados->execute();		
			unset($sql_logado);
			unset($logados);
					
				}catch(PDOException $e){
					echo '<script>console.log( swal("Attention!", "There was an error executing data.", "error") );</script>';
				}
				
							// echo '<script type="text/javascript">document.addItem.reset();</script>';

				echo '<script>console.log( swal("Information!", "Was added '.$name.' to the item categories.", "success") );</script>';
			}
		}






?>
