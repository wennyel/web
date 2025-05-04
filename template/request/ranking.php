<?php
  
require('../../web_conexao/init.php');
 
Deslogado();
try{
	$jConta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
	$calibur=$db->query("select top 1 * from Server01.dbo.cabal_Forcecalibur_Owner order by RegDate desc")->fetchObject();
	$tg=$db->query("select * from server01.dbo.cabal_LordOfWar_table")->fetchObject();
}catch(PDOException $e){ echo  $e->getMessage(); }

$ranking  = aiRemove(soNumero(antiSQL(anti_injection($_GET['ranking']))));
//o numero 3 é a lista de membros de cada guild//
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
	.TPointColor {
		color: #6D7179;
        text-shadow: 0px 0px 10px #6D7179;
	}
	.TicketColor {
		color: #cc7b39;
        text-shadow: 0px 0px 10px #cc7b39;
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
	.calibur {
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
	.CaliburFont {
		color: rgba(255,242,0,1);
        text-shadow: 0px 0px 10px rgba(173,173,168,1);	
	}
	.LiderGuild {
	 width: 8px;
     height: 8px;
	-webkit-box-shadow: 0px 0px 5px 0px rgba(68,226,250,1);
-moz-box-shadow: 0px 0px 5px 0px rgba(68,226,250,1);
box-shadow: 0px 0px 5px 0px rgba(68,226,250,1);
	background-color: #16bdc9;
    float: left;
    border-radius: 50%;
    margin-right: 3px;	
}
	.LiderGuildFont {
		color: #0ca5b0;
        text-shadow: 0px 0px 10px rgba(53,201,227,1);	
	}
	.PortadorLuz {
		color: #b3b2ad;
        text-shadow: 0px 0px 10px rgba(173,173,168,1);	
	}
	.portador-luz {
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
.online {
color: #74c564;
text-shadow: 0px 0px 10px #74c564;
	}
.offline{
color:#fa3e3e;
text-shadow: 0px 0px 10px #fa3e3e;
</style>

<?
   if($ranking==1){
?>

<div class="content-title title-carousel c-title">
		<span class="title">Ranking de Jogadores</span>
</div>

<div style="width:100%;height:23px;">
	<div style="width:105px; position:relative; float:left;">
	<div class="calibur" style="margin-top:4px;"></div> &nbsp;Espada Calibu
	</div>
	<div style="width:200px; position:relative; float:left;">
	<div class="portador-luz" style="margin-top:4px;"></div> &nbsp;Portador da Luz
	</div>
</div>


<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="194"><strong>Jogador Nome</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Classe</strong></td>
<td class="boss_title" align="center" width="53"><strong>Sexo</strong></td>
<td class="boss_title" align="center" width="69"><strong>Na&ccedil;&atilde;o</strong></td>
<td class="boss_title" align="center" width="194"><strong>Honra</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankJogador = $db->query("select top 50 * from Server01.dbo.cabal_character_table where Nation < 3 order by LEV desc, Reputation desc");
	$result = $rankJogador->fetchAll();
	foreach($result as $row){
		$tgs = $db->query("select count(*) from server01.dbo.cabal_LordOfWar_table where CharacterIdx='".$row['CharacterIdx']."'")->fetchColumn();
	 $classeChar    = decodificar($row['Style']);
     $sexoChar1     = decodificar($row['Style']);
		
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="<? if($row['CharacterIdx']==$calibur->CharacterIdx){ echo 'CaliburFont';} ?><? if($tgs>=1){ echo 'PortadorLuz';} ?>" style="padding-left: 10px;" align="center"><?=$row['Name']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['LEV']?></strong></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
<td class="boss_normal2" align="center"><?=$sexoChar1['Sexo']; unset($sexoChar1); ?></td>
<td class="boss_normal2" align="center"><strong> <img src="images/utilitares/<? if($row['Nation']==1) { echo 'capella'; } if($row['Nation']==2){ echo 'procyon'; } if($row['Nation']==0){ echo '2753'; } ?>.png" width="16" height="16" /></strong></td>
	<td class="boss_normal2" style="padding-left: 10px;" align="center"><strong><?=number_format($row['Reputation'])?></strong></td>

</tr>
<? } ?>
	
</tbody>
</table>

<? } ?>



<!--Ranking Guild -->

<?
   if($ranking==2){
?>
<div name="members" id="members"><!--Atualizar membros-->
<div class="content-title title-carousel c-title">
		<span class="title">Ranking Guild</span>
</div>

<div style="width:100%;height:50px;">
	<font class="PortadorLuz" style="font-wieght:bold;font-size:14px;">Informamos:</font> Para que seu emblema fique visivel no ranking do site envie a imagem em formato PNG no tamanho 32x32 pixel para o e-mail
    emblema@cabalicore.com.br contendo o Nome da guild e a ID do Lider da guild.
	</div>
	

<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="194"><strong>Nome da guild</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Point</strong></td>
<td class="boss_title" align="center" width="53"><strong>Membros</strong></td>
<td class="boss_title" align="center" width="69"><strong>Lider</strong></td>
	<td class="boss_title" align="center" width="69"><strong>Emblema</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankGuild = $db->query("select top 50 * from Server01.dbo.Guild order by Point desc");
	$result = $rankGuild->fetchAll();
	foreach($result as $row){
		
	$Members = $db->query("select count(*) from  server01.dbo.GuildMember where GuildNo='".$row['GuildNo']."'")->fetchColumn();	
	$Guild_lider = $db->query("select * from server01.dbo.GuildGroup where GuildNo = '".$row['GuildNo']."' AND GroupPermission=495")->fetchObject();
	$G_name_lider = $db->query("select * from server01.dbo.GuildMember where GroupIndex = '".$Guild_lider->GroupIndex."'")->fetchObject();
	$G_Name_Char = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx = '".$G_name_lider->CharacterIndex."'")->fetchObject();
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['GuildName']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['Level']?></strong></td>
<td class="boss_normal2" align="center"><?=$row['Point']?></td>
<td class="boss_normal2" align="center">
	<div class="player-info">
<div class="top-r" style="text-align:center !important;">
									<span><?=$Members?></span> <a onclick="new Ajax.Updater('members', 'template/request/ranking.php?ranking=3&GuildNo=<?=$row['GuildNo']?>&MemberLider=<?=$G_Name_Char->CharacterIdx?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#members');" class="blue-a profile-button">veja</a>
								</div>
								</div>
	</td>
<td class="boss_normal2" align="center"><strong><?=$G_Name_Char->Name?></strong></td>
	<td class="boss_normal2" align="center">#</td>
</tr>
<? } ?>
	
</tbody>
</table>

<? } ?>
	
</div><!--end atualizar membros-->


<!---INICIO - Lista de membros de cada guild-->
<?
   if($ranking==3){
	   $Guild_ID = soNumero(antiSQL(anti_injection($_GET['GuildNo'])));
	   $MemberLider = soNumero(antiSQL(anti_injection($_GET['MemberLider'])));
?>

<div class="content-title title-carousel c-title">
		<span class="title">Membros da guild</span>
</div>

<div style="width:100%;height:23px;">
	<div style="width:105px; position:relative; float:left;">
	<div class="LiderGuild" style="margin-top:4px;"></div> &nbsp;GuildMaster
	</div>
	<div style="width:105px; position:relative; float:left;">
	<div class="calibur" style="margin-top:4px;"></div> &nbsp;Espada Calibu
	</div>
	<div style="width:200px; position:relative; float:left;">
	<div class="portador-luz" style="margin-top:4px;"></div> &nbsp;Portador da Luz
	</div>
	
</div>


<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="194"><strong>Jogador Nome</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Classe</strong></td>
<td class="boss_title" align="center" width="53"><strong>Sexo</strong></td>
<td class="boss_title" align="center" width="69"><strong>Na&ccedil;&atilde;o</strong></td>
<td class="boss_title" align="center" width="194"><strong>AXP Point</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	   
	$Members = $db->query("select * from  server01.dbo.GuildMember where GuildNo='".$Guild_ID."' order by GuildAxpPoint desc");
	$result = $Members->fetchAll();
	foreach($result as $rows){
     $row = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$rows['CharacterIndex']."' order by LEV desc, Reputation desc")->fetchObject();
		
	 $classeChar    = decodificar($row->Style);
     $sexoChar1     = decodificar($row->Style);
		
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="<? if($row->CharacterIdx==$calibur->CharacterIdx){ echo 'CaliburFont';} ?><? if($row->CharacterIdx==$tg->CharacterIdx){ echo 'PortadorLuz';}  ?><? if($MemberLider==$row->CharacterIdx){ echo 'LiderGuildFont';} ?>" style="padding-left: 10px;" align="center"><?=$row->Name?></td>
<td class="boss_normal2" align="center"><strong><?=$row->LEV?></strong></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
<td class="boss_normal2" align="center"><?=$sexoChar1['Sexo']; unset($sexoChar1); ?></td>
<td class="boss_normal2" align="center"><strong> <img src="images/utilitares/<? if($row->Nation==1) { echo 'capella'; } if($row->Nation==2){ echo 'procyon'; } if($row->Nation==0){ echo '2753'; } ?>.png" width="16" height="16" /></strong></td>
	<td class="boss_normal2" style="padding-left: 10px;" align="center"><strong><?=number_format($rows['GuildAxpPoint'])?></strong></td>

</tr>
<? }?>
	
</tbody>
</table>

<? } ?>

<!---/End - Lista de membros de cada guild-->





<!--Ranking Combo-->
<?
   if($ranking==4){
?>

<div class="content-title title-carousel c-title">
		<span class="title">Ranking Combo</span>
</div>



<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="120"><strong>Nome do jogador</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Combo</strong></td>
<td class="boss_title" align="center" width="80"><strong>Data</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankCombo = $db->query("select top 50 * from Server01.dbo.cabal_record_combo order by cntcombo desc");
	$result = $rankCombo->fetchAll();
	foreach($result as $row){
		
	$combista = $db->query("select * from  server01.dbo.cabal_character_table where CharacterIdx='".$row['charIdx']."'")->fetchObject();
		$contar_jogador = $db->query("select count(*) from server01.dbo.cabal_character_table where CharacterIdx='".$row['charIdx']."'")->fetchColumn();
	if($contar_jogador>=1){
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="" style="padding-left: 10px;" align="center"><?=$combista->Name?></td>
<td class="boss_normal2" align="center"><strong><?=$combista->LEV?></strong></td>
<td class="boss_normal2" align="center"><?=$row['cntcombo']?></td>
<td class="boss_normal2" align="center"><?=date('d-m-Y', strtotime($row['RegDate']))?> às <?=date('H:m a', strtotime($row['RegDate']))?></td>
</tr>
<? }} ?>
	
</tbody>
</table>

<? } ?>
	
<!--END Ranking combo-->

<!--Ranking PlayOnline-->
<?
   if($ranking==5){
?>

<div class="content-title title-carousel c-title">
		<span class="title">Ranking Jogadores Ativos</span>
</div>



<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="120"><strong>Nome do jogador</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Tempo</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankCombo = $db->query("select top 50 * from server01.dbo.cabal_character_table order by PlayTime desc");
	$result = $rankCombo->fetchAll();
	foreach($result as $row){
		
	
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['Name']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['LEV']?></strong></td>
<td class="boss_normal2" align="center">
	<?php
			$segundosmy = $row['PlayTime'];
            $minutosmy  = round($segundosmy/60);
			$daytime    = round($minutosmy/24);
			
			
			
			if($segundosmy<60) {
				
				if($segundosmy==1) { echo $segundosmy.'&nbsp;Minuto';} elseif($segundosmy >1) {echo $segundosmy.'&nbsp;Minutos';}
			
			
			}
			
			if($segundosmy>60 AND $segundosmy <1440) {
				
				if($minutosmy==1) { echo $minutosmy.'&nbsp;Hora';} elseif($minutosmy>1) {echo $minutosmy.'&nbsp;Horas';}
			}
			
			if($minutosmy>=24){
				
				if($daytime==1){ echo $daytime.'&nbsp;Dia';} elseif($daytime>1) {echo $daytime.'&nbsp;Dias';}
				
				
			}
			
			

			
			?>
	</td>
</tr>
<? } ?>
	
</tbody>
</table>

<? } ?>
	
<!--END Ranking PlayOnline-->





<!--Ranking Banidos-->
<?
   if($ranking==6){
?>

<div class="content-title title-carousel c-title">
		<span class="title">Hall da vergonha</span>
</div>



<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="120"><strong>Nome do jogador</strong></td>
<td class="boss_title" align="center" width="72"><strong>Data do bloqueio</strong></td>
<td class="boss_title" align="center" width="65"><strong>Status</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankBan = $db->query("select * from MWeb.dbo.cabal_m_table_banidos order by NameChar desc");
	$result = $rankBan->fetchAll();
	foreach($result as $row){
		
	
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['NameChar']?></td>
<td class="boss_normal2" align="center"><strong><?=date('d-m-Y H:m', strtotime($row['RegDate']))?></strong></td>
<td class="boss_normal2" align="center">
	<?php
			$segundosmy = $row['Duracao'];
            $minutosmy  = round($segundosmy/24);
			
			
			if($segundosmy>=999){
				
				echo "Permanente";
				
			}else{
			
			if($segundosmy<24) {
				
				if($segundosmy==1) { echo $segundosmy.'&nbsp;Hora';} elseif($segundosmy >1) {echo $segundosmy.'&nbsp;Horas';}
			
			
			}
			
			if($segundosmy>=24) {
				
				if($minutosmy==1) { echo $minutosmy.'&nbsp;Dia';} elseif($minutosmy>1) {echo $minutosmy.'&nbsp;Dias';}
			}
			}
			
	

			
			?>
	</td>
</tr>
<? } ?>
	
</tbody>
</table>

<? } ?>
	
<!--END Ranking Banidos-->

<!--Ranking Pontuaçao Capella-->
<?
   if($ranking==7){
?>


<div class="content-title title-carousel c-title">
		<span class="title">Pontuação de Guerra</span>
</div>
<style>
	$color: #fd7000;
$size: 12px;
$time: 1;

main {
   width: 100vw;
   height: 100vh;
   display: flex;
   justify-content: center;
   align-items: center;
}

.dank-ass-loader {
   display: flex;
   flex-direction: column;
   align-items: center;
   
   .row {
      display: flex;
   }
}

.arrow {
   width: 0; 
   height: 0;
   margin: 0 (-$size / 2);
   border-left: $size solid transparent;
   border-right: $size solid transparent;
   border-bottom: ($size * 1.8) solid $color;
   animation: blink $time + s infinite;
   filter: drop-shadow(0 0 ($size * 1.5) $color);
    
   &.down {
      transform: rotate(180deg);
   }
   
   @for $i from 1 through 18 {
      &.outer-#{$i} {
         animation-delay: -($time / 18) * $i + s;
      }  
   }

   @for $i from 1 through 6 {
      &.inner-#{$i} {
         animation-delay: -($time / 6) * $i + s;
      }  
   }  
}

@keyframes blink {
  0% { opacity: 0.1; }
  30% { opacity: 1; }
  100% { opacity: 0.1; }
}
</style>
<!--EXIBIR PORTADORES-->
<div style="width:534px; height:256px;">
<div style="width:230px; height:60px; float:left;"><!--TESTE--><main>
   <div class="dank-ass-loader">
      <div class="row">
         <div class="arrow up outer outer-18"></div>
         <div class="arrow down outer outer-17"></div>
         <div class="arrow up outer outer-16"></div>
         <div class="arrow down outer outer-15"></div>
         <div class="arrow up outer outer-14"></div>
      </div>
      <div class="row">
         <div class="arrow up outer outer-1"></div>
         <div class="arrow down outer outer-2"></div>
         <div class="arrow up inner inner-6"></div>
         <div class="arrow down inner inner-5"></div>
         <div class="arrow up inner inner-4"></div>
         <div class="arrow down outer outer-13"></div>
         <div class="arrow up outer outer-12"></div>
      </div>
      <div class="row">
         <div class="arrow down outer outer-3"></div>
         <div class="arrow up outer outer-4"></div>
         <div class="arrow down inner inner-1"></div>
         <div class="arrow up inner inner-2"></div>
         <div class="arrow down inner inner-3"></div>
         <div class="arrow up outer outer-11"></div>
         <div class="arrow down outer outer-10"></div>
      </div>
      <div class="row">
         <div class="arrow down outer outer-5"></div>
         <div class="arrow up outer outer-6"></div>
         <div class="arrow down outer outer-7"></div>
         <div class="arrow up outer outer-8"></div>
         <div class="arrow down outer outer-9"></div>
      </div>
   </div>
</main><!--END TESTE--><img src="images/capella1.png" style="margin-top:30px;" width="230" height="215"></div>

<div style="width:300px; height:60px; float:right;">
	<div class="content-title title-carousel c-title">
		<span class="title" style="font-size:15px;">Portadores atual</span>
</div>
<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="300" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="19" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="121"><strong>Nome</strong></td>

<td class="boss_title" align="center" width="74"><strong>Pontuação</strong></td>
<td class="boss_title" align="center" width="57"><strong>Classe</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	   try{
		   $nation_type=1;
	   $stmtC = $db->prepare("SELECT * FROM Server01.dbo.cabal_LordOfWar_table where Nation=:nation");
	   $stmtC->bindParam(':nation', $nation_type, PDO::PARAM_INT);
	   $stmtC->execute(); 
	   $get_list_portadores = $stmtC->fetchAll();
	   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
	   foreach($get_list_portadores as $rows){
		   
		   try{
		   $stmtC = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table WHERE CharacterIdx=:idx");
		   $stmtC->bindParam(':idx', $rows['CharacterIdx'], PDO::PARAM_INT);
		   $stmtC->execute(); 
		   $getPort = $stmtC->fetchObject();
		   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
		   
		   try{
		   $stmtC = $db->prepare("SELECT * FROM server01.dbo.cabal_LordOfWar_Point_Acumulado WHERE CharacterIdx=:id");
		   $stmtC->bindParam(':id', $rows['CharacterIdx'], PDO::PARAM_INT);
		   $stmtC->execute(); 
		   @$WarPoints = $stmtC->fetchObject();
		   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
		   
		   $classeChar    = decodificar($getPort->Style);
	   
	   ?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$getPort->Name?></td>
<td class="boss_normal2" align="center"><?=number_format(@$WarPoints->WarPoint);?></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
</tr>
<? } ?>
	
</tbody>
</table>
</div>


</div>
<!--END PORTADORES-->






<div style="width:100%;height:23px;margin-top:30px;">
	<div style="width:105px; position:relative; float:left;">
	<div class="calibur" style="margin-top:4px;"></div> &nbsp;Espada Calibu
	</div>
	<div style="width:200px; position:relative; float:left;">
	<div class="portador-luz" style="margin-top:4px;"></div> &nbsp;Portador da Luz
	</div>
</div>


<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="230"><strong>Participante</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Classe</strong></td>
<td class="boss_title" align="center" width="53"><strong>Sexo</strong></td>
<td class="boss_title" align="center" width="69"><strong>Na&ccedil;&atilde;o</strong></td>
<td class="boss_title" align="center" width="217"><strong>Pontuação</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankJogador = $db->query("select * from Server01.dbo.cabal_LordOfWar_Point_Acumulado where Nation = 1 order by WarPoint desc");
	@$result = $rankJogador->fetchAll();
	foreach($result as $rows){
	  $row = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx='".$rows['CharacterIdx']."'")->fetchObject();
		$tgs = $db->query("select count(*) from server01.dbo.cabal_LordOfWar_table where CharacterIdx='".$rows['CharacterIdx']."'")->fetchColumn();
	 $classeChar    = decodificar($row->Style);
     $sexoChar1     = decodificar($row->Style);
		
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="<? if($row->CharacterIdx==$calibur->CharacterIdx){ echo 'CaliburFont';} ?><? if($tgs>=1){ echo 'PortadorLuz';} ?>" style="padding-left: 10px;" align="center"><?=$row->Name?></td>
<td class="boss_normal2" align="center"><strong><?=$row->LEV?></strong></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
<td class="boss_normal2" align="center"><?=$sexoChar1['Sexo']; unset($sexoChar1); ?></td>
<td class="boss_normal2" align="center"><strong> <img src="images/utilitares/<? if($row->Nation==1) { echo 'capella'; } if($row->Nation==2){ echo 'procyon'; } if($row->Nation==0){ echo '2753'; } ?>.png" width="16" height="16" /></strong></td>
	<td class="boss_normal2" style="padding-left: 10px;" align="center"><strong><?=number_format(@$rows['WarPoint'])?></strong></td>

</tr>
<? } ?>
	
</tbody>
</table>


<? } ?>
	
<!--END Ranking Pontuaçao Capella-->


<!--Ranking Pontuaçao Procyon-->
<?
   if($ranking==8){
?>


<div class="content-title title-carousel c-title">
		<span class="title">Pontuação de Guerra</span>
</div>
<!--EXIBIR PORTADORES-->
<div style="width:534px; height:256px;">
<div style="width:230px; height:60px; float:left;"><img src="images/procyon2.png" style="margin-top:30px;" width="230" height="215"></div>

<div style="width:300px; height:60px; float:right;">
	<div class="content-title title-carousel c-title">
		<span class="title" style="font-size:15px;">Portadores atual</span>
</div>
<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="300" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="19" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="121"><strong>Nome</strong></td>

<td class="boss_title" align="center" width="74"><strong>Pontuação</strong></td>
<td class="boss_title" align="center" width="57"><strong>Classe</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	   try{
		   $nation_type=2;
	   $stmtC = $db->prepare("SELECT * FROM Server01.dbo.cabal_LordOfWar_table where Nation=:nation");
	   $stmtC->bindParam(':nation', $nation_type, PDO::PARAM_INT);
	   $stmtC->execute(); 
	   $get_list_portadores = $stmtC->fetchAll();
	   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
	   foreach($get_list_portadores as $rows){
		   
		   try{
		   $stmtC = $db->prepare("SELECT * FROM server01.dbo.cabal_character_table WHERE CharacterIdx=:idx");
		   $stmtC->bindParam(':idx', $rows['CharacterIdx'], PDO::PARAM_INT);
		   $stmtC->execute(); 
		   $getPort = $stmtC->fetchObject();
		   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
		   
		   try{
		   $stmtC = $db->prepare("SELECT * FROM server01.dbo.cabal_LordOfWar_Point_Acumulado WHERE CharacterIdx=:id");
		   $stmtC->bindParam(':id', $rows['CharacterIdx'], PDO::PARAM_INT);
		   $stmtC->execute(); 
		   @$WarPoints = $stmtC->fetchObject();
		   }catch(PDOException  $er ){ echo "Error: ".$er; exit(); }
		   
		   $classeChar    = decodificar($getPort->Style);
	   
	   ?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$getPort->Name?></td>
<td class="boss_normal2" align="center"><?=number_format(@$WarPoints->WarPoint);?></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
</tr>
<? } ?>
	
</tbody>
</table>
</div>


</div>
<!--END PORTADORES-->






<div style="width:100%;height:23px;margin-top:30px;">
	<div style="width:105px; position:relative; float:left;">
	<div class="calibur" style="margin-top:4px;"></div> &nbsp;Espada Calibu
	</div>
	<div style="width:200px; position:relative; float:left;">
	<div class="portador-luz" style="margin-top:4px;"></div> &nbsp;Portador da Luz
	</div>
</div>


<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="230"><strong>Participante</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Classe</strong></td>
<td class="boss_title" align="center" width="53"><strong>Sexo</strong></td>
<td class="boss_title" align="center" width="69"><strong>Na&ccedil;&atilde;o</strong></td>
<td class="boss_title" align="center" width="217"><strong>Pontuação</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$rankJogador = $db->query("select * from Server01.dbo.cabal_LordOfWar_Point_Acumulado where Nation = 2 order by WarPoint desc");
	$result = $rankJogador->fetchAll();
	foreach($result as $rows){
	  $row = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx='".$rows['CharacterIdx']."'")->fetchObject();
		$tgs = $db->query("select count(*) from server01.dbo.cabal_LordOfWar_table where CharacterIdx='".$rows['CharacterIdx']."'")->fetchColumn();
	 $classeChar    = decodificar($row->Style);
     $sexoChar1     = decodificar($row->Style);
		
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="<? if($row->CharacterIdx==$calibur->CharacterIdx){ echo 'CaliburFont';} ?><? if($tgs>=1){ echo 'PortadorLuz';} ?>" style="padding-left: 10px;" align="center"><?=$row->Name?></td>
<td class="boss_normal2" align="center"><strong><?=$row->LEV?></strong></td>
<td class="boss_normal2" align="center"><?=$classeChar['Classe_Nome']; unset($classeChar); ?></td>
<td class="boss_normal2" align="center"><?=$sexoChar1['Sexo']; unset($sexoChar1); ?></td>
<td class="boss_normal2" align="center"><strong> <img src="images/utilitares/<? if($row->Nation==1) { echo 'capella'; } if($row->Nation==2){ echo 'procyon'; } if($row->Nation==0){ echo '2753'; } ?>.png" width="16" height="16" /></strong></td>
	<td class="boss_normal2" style="padding-left: 10px;" align="center"><strong><?=number_format($rows['WarPoint'])?></strong></td>

</tr>
<? } ?>
	
</tbody>
</table>


<? } ?>
	
<!--END Ranking Pontuaçao Procyon-->