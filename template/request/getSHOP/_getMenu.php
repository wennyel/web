<?
require('../../../web_conexao/init.php');

?>
<div style="width: 245px;margin-left: 22px;">
<?

if(in_array($_SESSION['my_login'], $AdminCP)){
?>
<div class="content-title c-title">
<span class="title">TO MANAGE <font style="color:#FFB05C;">SHOP</font></span>
</div><!-- content-title -->
 <div class="cbPs">
									<img src="images/icons/1486503758-bag-cart-goods-items-shopping_81288.png" alt="cbPs-ava">
									<div class="cbPs-title">
										<a onclick="new Ajax.Updater('ItemShop', 'template/request/p/shop_add_items.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#ItemShop');">MANAGE ITEM'S</a>
									</div>
									<div class="cbPs-autor">
										<p>Add and delete store items</p>
									</div>
								</div>

 <div class="cbPs">
									<img src="images/icons/1486486297-attribute-category-label-shop-price-price-tag-tag_81213.png" alt="cbPs-ava">
									<div class="cbPs-title">
										<a onclick="new Ajax.Updater('ItemShop', 'template/request/p/shop_add_category.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#ItemShop');">CATEGORIES</a>
									</div>
									<div class="cbPs-autor">
										<p>Add and delete shop categories</p>
									</div>
								</div>

<? } ?>





<div class="sidebar-title" style=" font-size:16px;padding-left: 1px;padding-bottom: 16px;width: 97%; font-family: 'Open Sans', sans-serif;"><font style="color: #879021;">MENU</font> <font style="color: #E6E6E6;">SHOP</font></div>
<?php
   
   try{
	$number_category = $db->query("SELECT count(*) FROM WebLT_SHOP.dbo.Category")->fetchColumn();
   }catch(PDOException $execute){ echo $execute; }
   if($number_category==0){
	   echo '<div style="width:100%; height:60px; line-height:40px; border-radius:2px !important; text-align:center; background-color:#102A3C;"><img style="width:36px; height:36px;" src="images/icons/4137157-alert-building-construction-industry_114069.png"><div><div style="margin-top:-24px;">There are currently no categories!</div></div><div>';
	   exit();
   }


   try{
	   $Categorys = $db->prepare("SELECT * FROM WebLT_SHOP.dbo.Category order by Category_Order desc");
	   $Categorys->execute();
	   $result = $Categorys->fetchAll();
	   
   }catch(PDOException $aaer){ echo $aaer;}

			
	        foreach($result as $row){
			
 ?>
                                    <div class="cbPs scale-up-center">
									<img src="images/icons/basket.png" alt="cbPs-ava">
									<div class="cbPs-title">
										<a onclick="new Ajax.Updater('ItemShop', 'template/request/getSHOP/_ItemShop.php?id=<?=soNumero(antiSQL(anti_injection($row['Category_id'])))?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#ItemShop');"><?=$row['Category_name']?></a>
									</div>
									<div class="cbPs-autor">
										<p><?=$row['Category_descri']?></p>
									</div>
								</div>

<? } ?>
                                 
</div>
				 