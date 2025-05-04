<?php
  
require('../../web_conexao/init.php');
 
Deslogado();
try{
	$jConta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
	$jPersonagem = $db->query("select  * from server01.dbo.cabal_character_table where CharacterIdx/8='".$jConta->UserNum."' AND Login=1")->fetchObject();
	$jOnCount = $db->query("select  count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$jConta->UserNum."' AND Login=1")->fetchColumn();
	$jCharge = $db->query("select * from account.dbo.cabal_charge_auth where UserNum='".$jConta->UserNum."'")->fetchObject();
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

	.Diamante {
		color: #00c8ff;
		text-shadow: 0px 0px 10px #00c8ff;
	}

	.GuildLider {
		color: #E0FFFF;
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

<div class="news-info"><span>Estado da conta </span> -
	<? if($jConta->AuthType==1) { echo '<font class="efBVerde">Normal</font>'; }else{ echo "<font class='efBVermelho'>Bloqueado</font>"; } ?>.
</div>

<div class="news-info"><span>Tipo VIP </span> -
	<? if($jCharge->ServiceKind==1) { echo 'Free'; }elseif($jCharge->ServiceKind==35){ echo "<font class='Diamante'>Diamante</font>"; }else{ echo "Platina"; } ?>.
</div>

<? if ($jCharge->ServiceKind!=1) { ?>
<div class="news-info"><span>Seu VIP Expira </span> - Dia
	<? echo  date('d', strtotime($jCharge->ExpireDate)).'&nbsp;de&nbsp;' . $mes_extenso[date('M',strtotime($jCharge->ExpireDate))] . " de ". date('Y', strtotime($jCharge->ExpireDate)); ?>
	às <?=date('H:i', strtotime($jCharge->ExpireDate))?>h.
</div>
<? } ?>

<div class="news-info"><span>E-mail </span> - <?=$jConta->Email?>.</div>

<div class="news-info"><span>Nome </span> - <?=$jConta->Nome?>.</div>

<div class="news-info"><span>Conta Criada </span> - Dia
	<? echo  date('d', strtotime($jConta->createDate)).'&nbsp;de&nbsp;' . $mes_extenso[date('M',strtotime($jConta->createDate))] . " de ". date('Y', strtotime($jConta->createDate)); ?>
	às <?=date('H:i', strtotime($jConta->createDate))?>h.
</div>


<div class="news-info"><span>Status </span> -
	<?

	
	if($jOnCount==1){
		$PegaNome = $jPersonagem->Name;
		$PegaCanal = $jPersonagem->ChannelIdx;
		$PegaMapa = maps($jPersonagem->WorldIdx);
		echo '<font class="efBVerde" title="'.$PegaNome.' / Canal: '.$PegaCanal.' / Mapa: '.$PegaMapa.'">Online</font>';
	
	}elseif($jOnCount==0){
	echo '<font class="efBVermelho">Offline</font>';
	}

?>
	.</div>

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
		echo ' - '.$row['Name'];
	}

?>



	<?
	$jCash = $db->query("select * from CabalCash.dbo.CashAccount where UserNum='".$jConta->UserNum."'")->fetchObject();
	$jTPoint = $db->query("select * from Netcafebilling.dbo.Point where UserNum='".$jConta->UserNum."'")->fetchObject();
	$jTickets = $db->query("select * from MWeb.dbo.cabal_m_tickets_usuarios where UserNum='".$jConta->UserNum."'")->fetchObject();
	?>
	.</div>

<div class="news-info"><span>Meus lideres de guild </span> - <font class="GuildLider">

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
	<button class="gold-a" style="float:right;" onClick="new Ajax.Updater('container', 'template/request/user/doacao.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');">depositar</button>
</div>
<div class="news-info"><span>T-Point </span> - <font class="TPointColor"><?=number_format($jTPoint->TPoint)?></font>.
</div>