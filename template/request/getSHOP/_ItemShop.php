
<style>
	.news-info {
    color: #7a939d;
    padding: 15px 10px 15px 30px;
    border-bottom: 1px dotted #153348;
    position: relative;
}
</style>
<?php
require('../../../web_conexao/init.php');
Deslogado();
$Category_id = soNumero(antiSQL(anti_injection($_GET['id'])));
 
try{
	$sthVp = Database::conexao()->prepare("select * from WebLT_SHOP.dbo.Produtos where Category=:id");
	$sthVp->bindParam(':id', $Category_id, PDO::PARAM_INT);
	$sthVp->execute();	
	$result = $sthVp->fetchAll();
    $count_cat = $sthVp->rowCount();
	
	
	$nameCategory = $db->prepare("select * from WebLT_SHOP.dbo.Category where Category_id=:ids");
	$nameCategory->bindParam(':ids', $Category_id, PDO::PARAM_INT);
	$nameCategory->execute();
	$resultado = $nameCategory->fetchObject();
	
}catch(PDOException $warning) {
echo $warning;	
}

echo '<div class="sidebar-title sidebar-title-light shop-title">
							<a href="../">+ Home</a>
							'.$resultado->Category_name.' 
						</div>';


  if(abs($count_cat)==0){
	  echo '<div style="width:100%; margin-bottom:10px; height:60px; line-height:40px; border-radius:4px !important; text-align:center; background-color:#102A3C;"><img style="width:36px; height:36px;" src="images/icons/4137157-alert-building-construction-industry_114069.png"><div><div style="margin-top:-24px;">There are no products in this category!</div></div><div>';
	   exit();
	  
  }
	       ?> 
<div name="container" id="container">
<table width="100%" border="0" style="float:left; margin-bottom:30px;" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
<?
foreach($result as $row){ 
?>
		<form name="encaminhar" id="encaminhar">
<table width="149" style="    border: 1px solid #0b1d2b;margin-right:5px; margin-top:5px;" border="0" align="left"  cellpadding="0" cellspacing="0">
      <tr>
        <td style="background:url(../../../images/items/<?=$row['Imagem']?>) no-repeat;" width="149" height="154" bgcolor="#111113"></td>
      </tr>
      <tr>
        <td height="28" align="center" valign="top" bgcolor="#131316"><table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top"><font class="item-name" style="width:80%;height:auto !important;text-transform: uppercase; font-size:12px; color:#fff;">
              <?php if(strlen($row['Name']) > 20){ echo '<marquee style="100%;">'.$row['Name'].'</marquee>'; } elseif(strlen($row['Name']) <= 20){ echo $row['Name']; } ?>
            </font></td>
          </tr>
        </table>
          <div class="item-info" style="height:auto;"></td>
      </tr>
      <tr>
        <td height="24" align="center" valign="middle" bgcolor="#131316"><span class="item-price" style="font-family: 'Open Sans', sans-serif;
    color: #de694a;
    font-size: 14px;">
          <?=number_format($row['valor'])?>
          &nbsp;<img src="images/pc.png" width="12" height="12" /></span></td>
      </tr>
      <tr>
        <td height="33" align="center" valign="middle" bgcolor="#131316"><input  style="width: 70px; height: 23px; padding: 1px; font-size: 10px; border-radius: unset; z-index: 9999; cursor:pointer;" onClick="new Ajax.Updater('container', 'template/request/getSHOP/env_function/_getBuy.php?item=<?=$row['id']?>', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');" class="button-bg" type="button" value="BUY"></td>
      </tr>
    </table>
		
		</form>
<? } ?>
		
		</td>
  </tr>
</table>
</div>