<?php

require("../../../web_conexao/init.php");
   @$a1 = soNumero(antiSQL(anti_injection($_GET['item'])));
   @$b2 = htmlentities(antiSQL(anti_injection($_GET['m'])));
   @$c3 = soNumero(antiSQL(anti_injection($_GET['api'])));
   
  if($a1 > 0 AND $b2=="sim"){
	  try{
					$list_item = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos WHERE Category=:id");
				    $list_item->bindParam(':id', $a1, PDO::PARAM_INT);
					$list_item->execute(); 
					$mostrar =  $list_item->fetchAll();
		            $count = $list_item->rowCount();
				}catch(PDOException $err_rror) { echo $err_rror;}

	     if(abs($count)==0){
			 echo '<table style="width: 534px; background-color: #0c212f; margin-left: -15px; margin-bottom: 1px; margin-top: -2px;">
<tbody>
<tr style="height: 54px;">
<td style="width: 178px; height: 34px; text-align: center;"><img src="images/icons/warnings.png" width="19" /><br />There are no items in this category.</td>
</tr>
</tbody>
</table>';
		 }
	  
	foreach($mostrar as $row){
?>
<div name="listItem<?=$row['id']?>" id="listItem<?=$row['id']?>">
<table style="width: 534px; margin-left:-15px;">
<tbody>
<tr style="border-bottom: 1px dotted #153348; height: 25px;">
<td style="width: 178px;"><img style="position:absolute;margin-top: -2px; margin-left: 7px;" width="19" src="images/icons/apontador.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$row['Name']?></td>
<td style="width: 178px;" align="center"><?=tempoItem($row['Duracao'])?></td>
<td style="width: 178px;" align="right"><img width="22" src="images/icons/editar.png">&nbsp;&nbsp;&nbsp;<a onclick="new Ajax.Updater('listItem<?=$row['id']?>', 'template/request/p/shop_items_excluir.php?api=<?=$row['id']?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#listItem<?=$row['id']?>');"><img width="22" title="Delete" src="images/icons/excluir.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</tbody>
</table>
</div>
<? 
	}
  }elseif($a1 > 0 AND $b2=="nao"){
  } elseif(!$a1 || !$b2 AND $c3 > 0) { 
	  
	 try{
		             
					$item_most = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos WHERE id=:id");
				    $item_most->bindParam(':id', $c3, PDO::PARAM_INT);
					$item_most->execute(); 
					$exibir =  $item_most->fetchObject();
		            $countRow = $item_most->rowCount();       
					unset($item_most);
		            $item_most = null;
		 
		 
		 
					$process = $db->prepare("DELETE WebLT_SHOP.dbo.Produtos where id=:id");
				    $process->bindParam(':id', $c3, PDO::PARAM_INT);
					$process->execute(); 
		            unset($process);
		            $process = null;
		 
					
				}catch(PDOException $err_rror) { echo $err_rror;}
	  
	                 if(abs($countRow)>0){
      echo '<script>console.log( swal("Excluded!", "shop item was successfully deleted.", "info") );</script>';
  
					 }else{
						 echo '<script>console.log( swal("ERROR", "the selected item has already been deleted from the database.", "info") );</script>';
					 }
  }
?>