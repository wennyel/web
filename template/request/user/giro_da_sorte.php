<?php

require("../../../web_conexao/init.php");

Deslogado();
///////CONFIGURAR SISTEMA///////////

$qnt_tickets = "1"; // Quantos tickets será necessários para fazer o giro da sorte //

try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
$tickets = $db->query("select * from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$result_conta->UserNum."'")->fetchObject();
			
$itens_logs = $db->query("select count(*) from MWeb.dbo.cabal_m_history_giro where UserNum='".$result_conta->UserNum."'")->fetchColumn();
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
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Giro da sorte</span>
</div>

  <div  style="clear:right;"></div>
<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc"><span style="color: #F00"><b>Introducao</b>:</span><br>



- A Roleta Premiada irá te bonificar de forma aleatória com Itens. Para isso, você vai precisar de Ticket.<br>
- O sistema de sorteio e aleatorio e automatico<br>
- Para obter Ticket sera preciso adquirir Cash em nossa loja.  <br>
- A cada R$ 100,00 em valor doado voce adquiri 1 Ticket.  <br>
- Para utilizar o giro da sorte é preciso ter no minimo <img src="images/tickett.png"><?=$qnt_tickets?> Ticket<br>
- Ticket tambem podera ser obtido em eventos que sera feitos em nosso servidor.  <br>
    </div>

   </div>



<form name="roleta" id="roleta">

   

    

    <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;INFORMAÇÕES:

     

      <div class="clear"></div>

    </div>

   
	<div id="" name="" style="">

    <div class="ntext" style="padding: 15px 15px 15px 15px;" align="justify">
      <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Tickets Atual</strong></td>
<td class="boss_title" align="center" width="72"><strong>Ticket Gastos</strong></td>
<td class="boss_title" align="center" width="65"><strong>Items Obtidos</strong></td>
<td class="boss_title" align="center" width="80"><strong>Opção</strong></td>
</tr>



		<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><img src="images/tickett.png"><?=$tickets->Tickets?></td>
<td class="boss_normal2" align="center"><strong><?=$tickets->Tickets_gastos?></strong></td>
<td class="boss_normal2" align="center"><?=$itens_logs?></td>
			<td class="boss_normal2" align="center"><a href="#">VER</a></td>
</tr>
     

</tbody></table>



  

    </div>



    </div>
	
	 <div class="flabel" style="height: 20px;line-height: 20px;background-color:#061723;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;LISTA DE ITEMS

     

      <div class="clear"></div>

    </div>
	
	<div class="flabel" style="height: 80px; padding: 4px 4px 4px 4px; line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">

		<marquee scrollamount="10" behavior="alternate">
			<?php
			$list_items_giro = $db->query("select * from MWeb.dbo.cabal_m_items_giro");
			while($item_register = $list_items_giro->fetch(PDO::FETCH_OBJ)){
			?>
	  <img style="border-radius:5px;" width="80" height="80" src="images/items/<?=$item_register->ImagemURL?>" title="" border="0">
	
<? } ?>
      
      	  </marquee>

      

      <div class="clear"></div>

    </div>

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="GIRAR" onclick="new Ajax.Updater('errors', 'template/request/user/giro_da_sorte.php?action=giro', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.roleta)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='giro')
		{ 
           
			
			if($tickets->Tickets==0){
				
			echo '<script>console.log( swal("OPS! Falhou", "Você não possui tickets.", "info") );</script>';

				
			}else{

				$Item_rand = $db->query("select * from MWeb.dbo.cabal_m_Items_giro order by newid()")->fetchObject(); //consultar DB
				//insert log de item ganho
				try{
				$query=Database::conexao()->prepare("exec MWeb.dbo.cabal_m_insert_log_giro :usernum,:itemName");
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->bindParam(':itemName', $Item_rand->ItemNome, PDO::PARAM_STR);
				$query->execute();
				}catch(PDOException  $er ){ echo "Error: ".$er; }
                  $mod1 = 0;
				//Envia item ganho
				try{
				$query=Database::conexao()->prepare("exec CabalCash.dbo.up_AddMyCashItemByItem :usernum,:mod1,:mod2,:item,:option,:duracao");
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->bindParam(':mod1', $mod1, PDO::PARAM_INT);
				$query->bindParam(':mod2', $mod1, PDO::PARAM_INT);
				$query->bindParam(':item', $Item_rand->IdxItem, PDO::PARAM_INT);
				$query->bindParam(':option', $Item_rand->IdxOption, PDO::PARAM_INT);
				$query->bindParam(':duracao', $Item_rand->IdxDuration, PDO::PARAM_INT);
				$query->execute();
				}catch(PDOException  $er ){ echo "Error: ".$er; }
				
				//Retira o ticket//
			    try{
				$query=Database::conexao()->prepare("exec MWeb.dbo.cabal_m_update_tickets :usernum");
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->execute();
				}catch(PDOException  $er ){ echo "Error: ".$er; }
				
				
			
				
				echo '<script>console.log( swal("Parabêns!", "Você acaba de obter ['.$Item_rand->ItemNome.'].", "success") );</script>';
				
				
			}
				
     


		}






?>
