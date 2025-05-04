<?php

require("../../../web_conexao/init.php");
Deslogado();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){ echo $e; }

try{
	$authVIP = $db->query("select * from ACCOUNT.dbo.cabal_charge_auth where UserNum='".$result_conta->UserNum."'")->fetchObject();	
	}catch(PDOException $roErr){ echo $roErr; }

if($authVIP->ServiceKind=25 AND $authVIP->cashVIP != 1){
	
	header('Location: ../Home.php'); 
	
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
.LivreC {
	 width: 8px;
     height: 8px;
	-webkit-box-shadow: 0px 0px 11px 0px rgba(173,173,168,1);
	-moz-box-shadow: 0px 0px 11px 0px rgba(173,173,168,1);
	 box-shadow: 0px 0px 11px 0px rgba(173,173,168,1);
	background-color: #b3b2ad;
    float: left;
    border-radius: 50%;
    margin-right: 3px;	
}
.ligadoaoP {
    width: 8px;
    height: 8px;
    -webkit-box-shadow: 0px 0px 16px 0px rgba(255,242,0,1);
	-moz-box-shadow: 0px 0px 16px 0px rgba(255,242,0,1);
	box-shadow: 0px 0px 16px 0px rgba(255,242,0,1);
    background-color: #e0bf07;
    float: left;
    border-radius: 50%;
    margin-right: 3px;	
} 
.LigadoaC {
    width: 8px;
    height: 8px;
    -webkit-box-shadow: 0px 0px 16px 0px #81DAF5;
	-moz-box-shadow: 0px 0px 16px 0px #81DAF5;
	box-shadow: 0px 0px 16px 0px #81DAF5;
    background-color: #58ACFA;
    float: left;
    border-radius: 50%;
    margin-right: 3px;	
} 
</style>



  <div class="content-title title-carousel c-title">
		<span class="title">SISTEMA EXCLUSIVO PARA USUÁRIOS VIP CASH</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

        <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

      - Você vai obter todas as dungeons listadas abaixo.<br>

      - As dgs seram entregues no Inventário especial.<br>

      - você precisa está <font color="red"><u>OFFLINE</u></font> de sua conta<br>
		 - Ao resgatar suas DG favor retirar todas do seu inventário cash para não have sobrecarga de items no inventário.<br>

		
		<div class="nbody nbody_N">

  <div class="nbar nbar_N" onclick=" ">
    <div style="padding: 5px; 0px;">

      <div class="ndate" style="float: left;"></div>
      <div class="clear"></div>

  </div>

  </div>
			<b style="font-weight:bold; font-size:16px;">Cronometro de tempo estimado</b>:<br>			
			<div style="height:5px;"></div>	
			
			<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Data do próximo resgate</strong></td>
<td class="boss_title" align="center" width="80"><strong>Total de resgate</strong></td>
</tr>
<?
			try{
			$sthVp = Database::conexao()->prepare("select * from MWeb.dbo.cabal_dungeon_users_resgate where DungeonUser=:user");
			$sthVp->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
			$sthVp->execute();	
				$Cronometro = $sthVp->fetchObject();
			}catch(PDOException $regs){ echo $regs; }
			
			?>
	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center">
	<? 
			$date_atual 	=	strtotime(date('Y-m-d H:i'));
	        $vencidoEm	    =	strtotime($Cronometro->DungeonDate);
			
			
			if($vencidoEm > $date_atual){ ?>
	dia <?=date("d", strtotime($Cronometro->DungeonDate))?> de <? switch(date("m", strtotime($Cronometro->DungeonDate))) {
				case 01 : echo 'Janeiro'; break;
					case 02 : echo 'Fevereiro'; break;
					case 03 : echo 'Março'; break;
					case 04 : echo 'Abril'; break;
					case 05 : echo 'Maio'; break;
					case 06 : echo 'Junho'; break;
					case 07 : echo 'Julho'; break;
					case 08 : echo 'Agosto'; break;
					case 09 : echo 'Setembro'; break;
					case 10 : echo 'Outubro'; break;
					case 11 : echo 'Novembro'; break;
					case 12 : echo 'Dezembro'; break;
	
			}?> às <?=date("H:m", strtotime($Cronometro->DungeonDate))?>
		<? }else{ echo "Já pode resgata suas dungeons."; } ?>
		
		</td>
<td class="boss_normal2" align="center"><?=round($Cronometro->countResgate)?></td>
</tr>
     
</tbody></table>
			
			<div style="height:5px;"></div>	
<b style="font-weight:bold; font-size:16px;">Legenda</b>:<br>			
			<div style="height:5px;"></div>	
			
<div style="width:100%;height:23px;">
	<div style="width:165px; position:relative; float:left;">
	<div class="ligadoaoP" style="margin-top:4px;"></div> &nbsp;Ligado ao personagem
	</div>
	<div style="width:150px; position:relative; float:left;">
	<div class="LivreC" style="margin-top:4px;"></div> &nbsp;Livre para Comercio
	</div>
	<div style="width:160px; position:relative; float:left;">
	<div class="LigadoaC" style="margin-top:4px;"></div> &nbsp;Ligado a conta
	</div>
</div>
  <div id="" name="" style="">

    <div class="ntext" align="justify">
		
		
		
	  <form name="resgatar" id="resgatar" method="post">
<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Nome</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level de entrada</strong></td>
<td class="boss_title" align="center" width="65"><strong>Mapa</strong></td>
<td class="boss_title" align="center" width="80"><strong>Tipo</strong></td>
</tr>
  <?php
			$list_dungeons = $db->query("select * from MWeb.dbo.cabal_dungeon_list_resgate where exibir=1 ");
			$result = $list_dungeons->fetchAll();
	        foreach($result as $row){
			
	?>
	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=utf8_encode($row['DungeonName'])?></td>
<td class="boss_normal2" align="center"><strong><?=$row['DungeonLev']?></strong></td>
<td class="boss_normal2" align="center"></td>
		<td class="boss_normal2" align="center">
			<?php
		switch($row['DungeonTipo']){
		case 1 : echo '<div class="LigadoaC" style="float: none !important; margin-right: 0px !important;"></div>'; break;
			case 2 : echo '<div class="ligadoaoP" style="float: none !important; margin-right: 0px !important;"></div>'; break;
			     case 3 : echo '<div class="LivreC" style="float: none !important; margin-right: 0px !important;"></div>'; break;
			
	}
		
		?>
			
		
		</td>
</tr>
<? } 
	?>
	
     
</tbody></table>
		  <? if($authVIP->ServiceKind=25 AND $authVIP->cashVIP != 1){ } else{ ?>
<div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Enviar" onclick="new Ajax.Updater('errors', 'template/request/user/get_resgate_dungeon.php?action=RegDungeon', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.resgatar)}); carregando('#errors');"></div>
		  <? } ?>
		  
		  <div id="errors" name="errors"></div>
		</form>
</div></div></div></div></div></div>


<? }elseif($action=='RegDungeon')
		{ 
			try{
				
	  $authVIP = $db->query("select * from ACCOUNT.dbo.cabal_charge_auth where UserNum='".$result_conta->UserNum."'")->fetchObject();
      $inforC  = $db->query("select * from MWeb.dbo.cabal_dungeon_users_resgate where DungeonUser='".$result_conta->UserNum."'")->fetchObject();
	  $countReg  = $db->query("select count(*) from MWeb.dbo.cabal_dungeon_users_resgate where DungeonUser='".$result_conta->UserNum."'")->fetchColumn();
			}catch(PDOException $check){ echo $check; }

			$date_atual 	=	strtotime(date('Y-m-d H:i:s.B'));
   		    $vencidoEm	    =	strtotime($inforC->DungeonDate);


			
           if($contar_personagem==0){
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "error") );</script>';
			   exit();
		   }elseif($result_conta->Login>=1){
			   echo '<script>console.log( swal("Desculpe!", "você precisa está deslogado de sua conta.", "error") );</script>';
			   exit();
		   }elseif($result_conta->AuthType>1){
			   echo '<script>console.log( swal("Desculpe!", "sua conta está bloqueada ou está desativada.", "info") );</script>';
			   exit();
		   }elseif($authVIP->ServiceKind=25 AND $authVIP->cashVIP != 1){
			   echo '<script>console.log( swal("INVASOR!", "você está tentando burlar o sistema sem ter VIP, seus dados foram gravado e será analisado pela administração.", "error") );</script>';
			   exit();
		   }elseif($vencidoEm > $date_atual){
		echo '<script>console.log( swal("OoOPS!", "você não pode resgatar seu pack de dungeons ainda.", "info") );</script>';
		exit();
	}else{
			   
        $new_date				=	date('Y-m-d H:i:s.B', strtotime('+1 day'));
			   
			   
		 if($countReg==0){
		try{	   
            $sth = Database::conexao()->prepare("INSERT INTO MWeb.dbo.cabal_dungeon_users_resgate (DungeonUser,DungeonDate,countResgate) VALUES (:num,:newDate2,:count)");
			$sth->bindParam(':num', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->bindParam(':newDate2', $new_date, PDO::PARAM_STR);
			$sth->bindValue(':count', 1, PDO::PARAM_INT);
			$sth->execute();			
		}catch(PDOException $jo) { echo $jo; }		   
				     
			   }else{
		try{	   
            $sth = Database::conexao()->prepare("UPDATE MWeb.dbo.cabal_dungeon_users_resgate set DungeonDate=:newDate, countResgate=countResgate+:count where DungeonUser=:user");
			$sth->bindParam(':newDate', $new_date, PDO::PARAM_STR);
			$sth->bindParam(':user', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->bindValue(':count', 1, PDO::PARAM_INT);
			$sth->execute();			
		}catch(PDOException $jo) { echo $jo; }
			   }
			   
			   try{
				   
				$dungeons_list = $db->query("select * from MWeb.dbo.cabal_dungeon_list_resgate");
				$pegaList = $dungeons_list->fetchAll();
				   
			   }catch(PDOException $cheking) { echo $cheking; }
			   
			   foreach($pegaList as $rows){
				   
				   switch($rows['DungeonTipo']){
					   case 1 : $nid = $rows['DungeonID'] + 4096;   break;
					   case 2 : $nid = $rows['DungeonID'] + 524288; break;
					   case 3 : $nid = $rows['DungeonID']; break;
					   }
				   
				 try{ // Envia o pack de items listados ao banco de dados.
				 $sth = Database::conexao()->prepare("EXEC CabalCash.dbo.up_AddMyCashItemByItem :usernum,0,0,:idx,:opt,:dur");
				 $sth->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				 $sth->bindParam(':idx', $nid, PDO::PARAM_INT);
				 $sth->bindParam(':opt', $rows['DungeonOpt'], PDO::PARAM_INT);
				 $sth->bindParam(':dur', $rows['DungeonDur'], PDO::PARAM_INT);
				 $sth->execute();	
			      }catch(PDOException $cheking) { echo $cheking; }
				   
				   
				   switch($rows['DungeonTipo']){
					   case 1 : $ItemName = 'Ligado a conta';   break;
					   case 2 : $ItemName = 'Ligado ao personagem'; break;
					   case 3 : $ItemName = 'Livre para comercio'; break;
					   }
				   
				    try{ // Envia logs dos itens que o usuário resgatou
				 $sth = Database::conexao()->prepare("INSERT INTO MWeb.dbo.cabal_dungeons_logs_env (ID,DungeonName,DungeonData,DungeonTipo) VALUES (:id,:nameItem,getdate(),:TipoItem)");
				 $sth->bindParam(':id', $result_conta->UserNum, PDO::PARAM_INT);
				 $sth->bindParam(':nameItem', $rows['DungeonName'], PDO::PARAM_STR);
				 $sth->bindParam(':TipoItem', $ItemName, PDO::PARAM_STR);
				 $sth->execute();	
			      }catch(PDOException $cheking) { echo $cheking; }
				   
				   
				   
			   }
			   
			   
			   
			  echo '<script>console.log(swal("ooOPa!", "você acaba de obter um pack de dungeons.", "success"));</script>';
			   
			   
		   }
		}





?>
