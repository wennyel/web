<?php
  
require('../../../web_conexao/init.php');
Deslogado();
AdminCP();
if(anti_injection(!array_key_exists("adcVIP", $_GET))){


 $v1 = soNumero(antiSQL(anti_injection($_GET['v1'])));
 $v2 = htmlentities(antiSQL(anti_injection($_GET['v2'])));
 try{
$jConta = $db->query("select * from account.dbo.cabal_auth_table where UserNum='".$v1."' AND ID='".$v2."'")->fetchObject();
	
$jPersonagem = $db->query("select  * from server01.dbo.cabal_character_table where CharacterIdx/8='".$jConta->UserNum."' AND Login=1")->fetchObject();
$jOnCount = $db->query("select  count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$jConta->UserNum."' AND Login=1")->fetchColumn();

$count_charge = $db->query("select count(*) from ACCOUNT.dbo.cabal_charge_auth where UserNum='".$v1."'")->fetchColumn();
}catch(PDOException $e){
	
echo  $e->getMessage();	
}
$mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );



?>
<style>
	.efBVerde {
		color: #74c564;
        text-shadow: 0px 0px 10px #74c564;	
	}
	.efBVermelho {
		color: #e22f2f;
        text-shadow: 0px 0px 10px #e22f2f;
	}
	.CashColor {
		color: #FED61F;
        text-shadow: 0px 0px 10px #FED61F;
	}
	.GuildLider {
		color:#E0FFFF;
		text-shadow: 0px 0px 10px #E0FFFF;
	}
	.TPointColor {
		color: #6D7179;
        text-shadow: 0px 0px 10px #6D7179;
	}
	.TicketColor {
		color: #cc7b39;
        text-shadow: 0px 0px 10px #cc7b39;
	}
</style>
<div class="content-title title-carousel c-title">
		<span class="title">Informações de conta</span>
</div>

<div class="news-info"><span>Nome de usuário (ID) </span> - <?=$jConta->ID?>.</div>

<div class="news-info"><span>UserNum da ID </span> - <?=$jConta->UserNum?>.</div>

<div class="news-info"><span>Estado da conta </span> - <? if($jConta->AuthType==1) { echo '<font class="efBVerde">Normal</font>'; }else{ echo "<font class='efBVermelho'>Bloqueado</font>"; } ?>.</div>

<div class="news-info"><span>E-mail </span> - <?=$jConta->Email?>.</div>

<div class="news-info"><span>Nome </span> - <?=$jConta->Nome?>.</div>

<div class="news-info"><span>Conta Criada </span> - Dia <? echo  date('d', strtotime($jConta->createDate)).'&nbsp;de&nbsp;' . $mes_extenso[date('M',strtotime($jConta->createDate))] . " de ". date('Y', strtotime($jConta->createDate)); ?> às <?=date('H:m', strtotime($jConta->createDate))?> da <? switch(date('A',strtotime($jConta->createDate))){ case 'AM' : echo 'Manhã'; break; case 'PM' : echo 'Tarde'; break; } ?>.</div>


<div class="news-info"><span>Status </span> -
<?

	
	if($jOnCount==1){
		$PegaNome = $jPersonagem->Name;
		$PegaCanal = $jPersonagem->ChannelIdx;
		$PegaMapa = maps($jPersonagem->WorldIdx);
		$PegaIdx  = $jPersonagem->CharacterIdx;
		echo '<font class="efBVerde" title="'.$PegaNome.' / Canal: '.$PegaCanal.' / Mapa: '.$PegaMapa.'">Online</font>';
	}elseif($jOnCount==0){
	echo '<font class="efBVermelho">Offline</font>';
	}

?>
	.</div>


<div class="news-info"><span>Tipo de VIP </span> - <font class="CashColor">
	<?php
	  $VIP = $db->query("select * from account.dbo.cabal_charge_auth where UserNum='".$jConta->UserNum."'")->fetchObject();
	 if($VIP->ServiceKind==25 AND $VIP->cashVIP==1){ echo "VIP CASH"; }
	 if($VIP->ServiceKind==25 AND $VIP->cashVIP<1){ echo "NORMAL"; }


	?>
	</font></div>
<button class="gold-a" style="float:right; margin-top:-33px; margin-right:5px;" onclick="new Ajax.Updater('adccVIP', 'template/request/p/get_search_upgrade_result.php?adcVIP=enVIP&ping=<?=$v1?>', {method: 'post', asynchronous:true, evalScripts:true}); carregando('#adccVIP');">adicionar vip</button>
	

	
	<div id="adccVIP"></div>
	
<div class="news-info"><span>Tempo de jogo </span> - 
<?php
 $minutos = $jConta->PlayTime; 
 $horas = ((int) ($minutos / 60));
 $dia   = ((int) ($horas / 24));
    if($minutos < 60 ) { echo $minutos.' Minutos'; }
    if($horas == 1 ) { echo $horas.'Hora'; }
    if($horas > 1 AND $horas < 24) { echo $horas.' Horas '; }
    if($dia == 1 ) { echo  $dia.' Dia'; }
    if($dia > 1 ) { echo $dia.' Dias'; }
    

?>

</div>

<div class="news-info" style="font-size:12.6px;"><span>Chars </span>
	<?
 $MyAccount = $db->query("select * from account.dbo.cabal_auth_table where ID='".$jConta->ID."'")->fetchObject();
	$mJogador = $db->query("select top 6 * from server01.dbo.cabal_character_table where CharacterIdx/8='".$MyAccount->UserNum."'");
 $result = $mJogador->fetchAll();
	foreach($result as $row){
		echo ' - <font title="CharacterIdx: '.$row['CharacterIdx'].'">'.$row['Name'].'</font>';
	}

?>

	
	
	<?
$jCash = $db->query("select * from CabalCash.dbo.CashAccount where UserNum='".$jConta->UserNum."'")->fetchObject();
  $jTPoint = $db->query("select * from Netcafebilling.dbo.Point where UserNum='".$jConta->UserNum."'")->fetchObject();
  $jTickets = $db->query("select * from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$jConta->UserNum."'")->fetchObject();
	?>
	.</div>

<div class="news-info"><span>Lider de Guild </span> - <font class="GuildLider">
	
<?php
    $MyAccount = $db->query("select * from account.dbo.cabal_auth_table where ID='".$jConta->ID."'")->fetchObject();
	$mJogador = $db->query("select top 6 * from server01.dbo.cabal_character_table where CharacterIdx/8='".$MyAccount->UserNum."'");
 $result = $mJogador->fetchAll();
	foreach($result as $row){
		
		$GuildC = $db->query("select count(*) from server01.dbo.GuildMember where CharacterIndex='".$row['CharacterIdx']."'")->fetchColumn();
		
		if($GuildC >= 1){
		
		$member = $db->query("select * from server01.dbo.GuildMember where CharacterIndex='".$row['CharacterIdx']."'")->fetchObject();
        $lider =  $db->query("select * from server01.dbo.GuildGroup where GroupIndex='".$member->GroupIndex."' AND GuildNo='".$member->GuildNo."'")->fetchObject();
		$countlider=$db->query("select count(*) from server01.dbo.GuildGroup where GroupIndex='".$member->GroupIndex."' AND GuildNo='".$member->GuildNo."'")->fetchColumn();
		
		if($lider->GroupPermission==495){
		
			echo '<font title="Minha ID: '.$lider->GuildNo.'">'.$row['Name'].' - </font>';
			
		}elseif($countlider==0){
		 echo "Você não possui personagem lider de guild.";	
		}
		
	
	}
	}
?>
	</font>.
	</div>

<div class="news-info"><span>Saldo de cash </span> - <font class="CashColor"><?=number_format($jCash->Cash)?></font>.
	<button class="gold-a" style="float:right;">deposita</button></div>

<div class="news-info"><span>T-Point </span> - <font class="TPointColor"><?=number_format($jTPoint->TPoint)?></font>.</div>

<?  

}elseif(htmlentities(antiSQL(anti_injection($_GET['adcVIP'])))=="enVIP"){
	$usernum = soNumero(antiSQL(anti_injection($_GET['ping'])));
    
	 try{
$authVIPS = $db->prepare("SELECT * FROM ACCOUNT.dbo.cabal_charge_auth WHERE UserNum=:id");
$authVIPS->bindParam(':id', $usernum, PDO::PARAM_INT);
$authVIPS->execute(); 
$PegaVIP = $authVIPS->fetchObject();
}catch(PDOException  $er ){ echo "Error: ".$er; exit();}
	$countV = $db->query("select count(*) from account.dbo.cabal_charge_auth where UserNum='".$usernum."'")->fetchColumn();
	$results = $db->query("select * from account.dbo.cabal_auth_table where UserNum='".$usernum."'")->fetchObject();
	
	 if($PegaVIP->ServiceKind==25 AND $PegaVIP->cashVIP==1){
		 echo '<script>console.log( swal("DESCULPE!", "está conta já possui VIP cash, o mesmo deve aguardar o termino do VIP.", "info") );</script>';
	 }elseif($countV==0){
		 echo '<script>console.log( swal("DESCULPE!", "está conta não está registrado em charge_auth.", "info") );</script>';
	 }else{
			
		  try{
		$new_date				=	date('Y-m-d H:i:s.B', strtotime('+30 day'));
		$sth = Database::conexao()->prepare("UPDATE ACCOUNT.dbo.cabal_charge_auth set ExpireDate=:dataNew , ServiceKind=25, cashVIP=1 where UserNum=:usernum");
		$sth->bindParam(':usernum', $usernum, PDO::PARAM_INT);
		$sth->bindParam(':dataNew', $new_date, PDO::PARAM_STR);
		$sth->execute();	
		}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
		 echo '<script>console.log( swal("VIP ADICIONADO", "você acaba de adicionar VIP de 30 Dias para '.$results->ID.'", "success") );</script>';
	
			}

	try{
		$getMontaria = $db->prepare("exec CabalCash.dbo.up_AddMyCashItemByItem :num,0,0,5469,0,17");
		$getMontaria->bindParam(':num', $usernum, PDO::PARAM_INT);
		$getMontaria->execute();	
		$getMontaria = null;
		unset($getMontaria);
	}catch(PDOException $jos) { echo $jos; }	
	
	try{
		$countReg  = $db->query("select count(*) from MWeb.dbo.cabal_dungeon_users_resgate where DungeonUser='".$usernum."'")->fetchColumn();
		
		$countLendarios = $db->query("select count(*) from MWeb.dbo.cabal_bau_lendario_users where Lendario_usernum='".$usernum."'")->fetchColumn();
		
	}catch(PDOException $jos) { echo $jos; }	
	
	if($countReg==0){
		try{	   
            $sth = Database::conexao()->prepare("INSERT INTO MWeb.dbo.cabal_dungeon_users_resgate (DungeonUser,DungeonDate) VALUES (:num,getdate())");
			$sth->bindParam(':num', $usernum, PDO::PARAM_INT);
			$sth->execute();			
		}catch(PDOException $jo) { echo $jo; }		   
				     
			   }else{
		try{	   
            $sth = Database::conexao()->prepare("UPDATE MWeb.dbo.cabal_dungeon_users_resgate set DungeonDate=getdate() where DungeonUser=:user");
			$sth->bindParam(':user', $usernum, PDO::PARAM_INT);
			$sth->execute();			
		}catch(PDOException $jo) { echo $jo; }
			   }
	
	//REGISTRA NA TABLE CABAL_BAU_LENDARIO_USERS//
	if($countLendarios==0){
		try{	   
            $sthS = Database::conexao()->prepare("INSERT INTO MWeb.dbo.cabal_bau_lendario_users (Lendario_usernum,Lendario_date,Lendario_count) VALUES (:num,getdate(),0)");
			$sthS->bindParam(':num', $usernum, PDO::PARAM_INT);
			$sthS->execute();
			unset($sthS);
		}catch(PDOException $jo) { echo $jo; }	
   
			   }else{
		try{	   
            $sthB = Database::conexao()->prepare("UPDATE MWeb.dbo.cabal_bau_lendario_users set Lendario_date=getdate(),Lendario_count=0 where Lendario_usernum=:user");
			$sthB->bindParam(':user', $usernum, PDO::PARAM_INT);
			$sthB->execute();			
		}catch(PDOException $jo) { echo $jo; }
		
		//UPDATE DAS FANTASIAS RESGATE//
		try{	   
            $sthB = Database::conexao()->prepare("UPDATE MWeb.dbo.cabal_fantasias_users set Ativacao=:ativacao where UserNum=:user");
			$sthB->bindParam(':user', $usernum, PDO::PARAM_INT);
			$sthB->bindValue(':ativacao', 0, PDO::PARAM_INT);
			$sthB->execute();			
		}catch(PDOException $jo) { echo $jo; }

	
	}
			
			
		
	    
	 
	
	
 }
?>
