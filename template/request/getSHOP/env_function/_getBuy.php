<?
require('../../../../web_conexao/init.php');
Deslogado();

try{
	
$retC = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:iD");
$retC->bindParam(':iD', $_SESSION['my_login'], PDO::PARAM_STR);
$retC->execute(); 
$result_conta = $retC->fetchObject();
}catch(PDOException  $er ){
echo "Error: ".$er;
}
#if($result_conta->ID !='blabla'){
#	echo '<script>console.log( swal("ERROR", "Action prohibited, please check the situation and try again.", "warning") );</script>';
#}
@$id_item = abs(soNumero(antiSQL(anti_injection($_GET['item']))));
 
 $buy		=	abs(aiRemove(antiSQL(anti_injection(isset($_GET["buy"]))))) ? abs(aiRemove(antiSQL(anti_injection($_GET["buy"])))) : '';
 if($buy != "" AND !is_numeric($buy)){ echo '<script>console.log( swal("ERROR", "Action prohibited, please check the situation and try again.", "warning") );</script>';
					   exit();
					  }
		if($buy==""){
	

                   try{
					$stmtC = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos WHERE id=:id");
				    $stmtC->bindParam(':id', $id_item, PDO::PARAM_INT);
					$stmtC->execute(); 
					$information = $stmtC->fetchObject();
                    }catch(PDOException  $er ){
                       echo "Error: ".$er;
                    }
?>



<div name="ItemShop" id="ItemShop">
	<div class="sidebar-title sidebar-title-light shop-title" style="margin-bottom:10px;">
							<a href="../">+ Home</a>
							Finalize purchase
						</div>
<form name="buy<?=$information->id?>" id="buy<?=$information->id?>" oninput="total.value = (nights.valueAsNumber * <?=$information->valor?>)">
<center><font style="color:#FFFFFF;">You have selected the item </font> "<font style="color:#FFB05C;"><?=$information->Name?></font>" cost: <img src="images/pc.png"><?=number_format($information->valor)?><br>Select desired quantity!
	<br>
	<input type="number" id="nights" style="border-radius:2px; width:36px;" name="nights" value="1" min="1" max="20" required>
	<br>
Total to pay: <img src="images/pc.png"> <output style="background:transparent;" id="total" name="total"><?=number_format($information->valor)?></output><br>
	<input name="sbmtAddPnt" class="blue-a green-a" style="border-radius:0px; margin-bottom:6px; margin-top:3px;" type="button" value="FINISH PURCHASE" onclick="new Ajax.Updater('obter<?=$information->id?>', 'template/request/getSHOP/env_function/_getBuy.php?buy=<?=$information->id?>', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.buy<?=$information->id?>)}); carregando('#obter<?=$information->id?>');">	
</center>
	<div id="obter<?=$information->id?>" name="obter<?=$information->id?>"></div>
</form>
<? }elseif($buy!="")
		{ 
		$Quantity = abs(aiRemove(soNumero(antiSQL(anti_injection($_POST['nights']))))); // n esta indo o total
		
		$idItem = abs(aiRemove(soNumero(antiSQL(anti_injection($_GET['buy']))))); // n esta indo o total
		try{
					$stmtC = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos WHERE id=:id");
				    $stmtC->bindParam(':id', $idItem, PDO::PARAM_INT);
					$stmtC->execute(); 
					$information = $stmtC->fetchObject();
                    }catch(PDOException  $er ){
                       echo "Error: ".$er;
                    }
		
		
			$Quantity = abs(aiRemove(soNumero(antiSQL(anti_injection($_POST['nights']))))); // n esta indo o total
			if($Quantity<1){
				 echo '<script>console.log( swal("Sorry!", "You have selected an invalid quantity, check the field and try again.", "info") );</script>';
			}elseif(!is_numeric($Quantity)){
				 echo '<script>console.log( swal("Sorry!", "the information contained in quantities is not a numerical value.", "info") );</script>';
			}elseif(!$Quantity){
				 echo '<script>console.log( swal("Sorry!", "You must place at least one unit of the item you wish to purchase.", "info") );</script>';
			}elseif($Quantity>20){
				 echo '<script>console.log( swal("Sorry!!", "Only 20 units allowed per purchase.", "info") );</script>';
			}else{
				
				
				#----Quantity + Item Value----#
				$Preco_total = $Quantity * aiRemove(soNumero(antiSQL(anti_injection($information->valor))));
				
				
				#---INFORMATION TPOINT---#
				try{
					$TPoint = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE UserNum=:id");
				    $TPoint->bindParam(':id', $result_conta->UserNum, PDO::PARAM_INT);
					$TPoint->execute(); 
					$process = $TPoint->fetchObject();
				}catch(PDOException $err_rror) { echo $err_rror;}
				
				if($process->Cash==0){
					echo '<script>console.log( swal("Sorry!", "Your Cash Balance is 0.", "info") );</script>';
				}elseif($process->Cash<1){
					echo '<script>console.log( swal("Sorry!", "Your Cash Balance is 0.", "info") );</script>';
				}elseif($process->Cash < 0){
					echo '<script>console.log( swal("There was a problem!", "Your balance is negative, please contact the administrator", "info") );</script>';
				}elseif($process->Cash < $Preco_total){
					echo '<script>console.log( swal("excuse me!", "Your balance is insufficient to purchase the desired item..", "info") );</script>';
				}else{
				
				    
				
				
				
			
			try{
					$stmtC = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Produtos WHERE id=:id");
				    $stmtC->bindParam(':id', $buy, PDO::PARAM_INT);
					$stmtC->execute(); 
					$execute = $stmtC->fetchObject();
				    
				 
				    #SAVE REGISTER BUY ITEM
				    $LogItem = $db->prepare("INSERT INTO WebLT_SHOP.dbo.Produtos_Logs (Name,Quantidade,Preco,Presente_para,Login) VALUES (:name,:quantity,:preco,'para mim',:login)");
				    $LogItem->bindParam(':name', $execute->Name, PDO::PARAM_STR);
				    $LogItem->bindParam(':quantity', $Quantity, PDO::PARAM_INT);
				    $LogItem->bindParam(':preco', $execute->valor, PDO::PARAM_INT);
				    $LogItem->bindParam(':login', $result_conta->ID, PDO::PARAM_STR);
				    $LogItem->execute(); 
				
				           $up_tpoint = $db->prepare("UPDATE CabalCash.dbo.CashAccount SET Cash=Cash-:total where UserNum=:user");
						  $up_tpoint->bindParam(':total', $Preco_total, PDO::PARAM_INT);
						  $up_tpoint->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
						  $up_tpoint->execute();
						  unset($up_tpoint);
						  $up_tpoint = null;
				
                    }catch(PDOException  $er ){
                       echo "Error: ".$er;
                    }
					
					if($execute->Tipo==1) { $Idx = $execute->Idx; }
					if($execute->Tipo==2) { $Idx = $execute->Idx + 4096; }
					if($execute->Tipo==3) { $Idx = $execute->Idx + 524288; }
					if($execute->Tipo==4) { $Idx = $execute->Idx + 4096 + 524288; }
					
				$contador = 0;
                while($contador < $Quantity)
                   {
		
					   
					
					  try{
						  
						  $execItem = $db->prepare("exec CabalCash.dbo.up_AddMyCashItemByItem :user,1,1,:4,:5,:6");
						  $execItem->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
						  $execItem->bindParam(':4', $Idx, PDO::PARAM_INT);
						  $execItem->bindParam(':5', $execute->Options, PDO::PARAM_INT);
						  $execItem->bindParam(':6', $execute->Duracao, PDO::PARAM_INT);
						  $execItem->execute();   
					  }catch(PDOException $e_rror){  echo $e_rror; }
					
					
				$contador++;    	
				}#WHILE LIST
				
				
				
              echo '<script>console.log( swal("Congrats!", "You just purchased ['.$execute->Name.'] in our Cash store you spent  '.number_format($Preco_total).' Cash.", "success") );</script>';
					 unset($execItem);
					  $execItem = null;
		}
		}
		}

?>
</div>