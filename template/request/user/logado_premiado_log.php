<?php
require('../../../web_conexao/init.php');
deslogado();
?>
<style>
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
	.informa {
		color: #FFE92D;
        text-shadow: 0px 0px 10px #FDFB69;	
	font-weight:bold;
	}
	.observar {
		color: #FFA500;
        text-shadow: 0px 0px 10px #EE9A00;	
	font-weight:bold;
	}
</style>
<div class="content-title title-carousel c-title">
		<span class="title" style="text-shadow: 0px 0px 10px #FFF;">Logado Premiado</span>
</div>

<font class="informa">Informações:</font><br>
<ul style="margin-bottom:10px;">
	<li>- O Logado premiado foi adicionado na intenção de recompensar aqueles jogadores que ficamm online no jogo.</li>
	<li>- Nosso sistema é completamente automatico e possui horários aleatórios para entregar o brinde a um jogador </li>
	<li>- O Sistema possui mais de 200 items registrados no sistema para lhe presentear. </li>
</ul>

<font class="observar">Observação:</font><br>
<ul style="margin-bottom:10px;">
	<li>- O Sistema só escolherá 1 jogador que estiver online no jogo.</li>
	<li>- O Sistema funciona em tempos aleatorios, nem mesmo a administração reconhece o horário certo. </li>
	<li>- Seu prêmio é entregue através de um e-mail no jogo. </li>
	<li>- O Sistema não elimina os que já ganharam, como informamos o sistema é algo aleatório, vem da sorte de cada um. </li>
</ul>



<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="border-right: 1px dotted #122d40;" align="center" width="120"><strong>Personagem</strong></td>
<td class="boss_title" align="center" width="65"><strong>Item ganho</strong></td>
<td class="boss_title" align="center" width="80"><strong>Data</strong></td>
</tr>
	<div style="height:5px; width:100%;"></div>
  <?php
	$LogadoPremiado = $db->query("select top 50 * from MWeb.dbo.cabal_m_logado_premiado_Log order by RegDate desc");
	$result = $LogadoPremiado->fetchAll();
	foreach($result as $row){
		
	$pdo = $db->query("select * from  server01.dbo.cabal_character_table where Name='".$row['Jogador']."'")->fetchObject();
	
		@$n+=1;
	?>
<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10"><?=$n?></td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['Jogador']?></td>
<td class="boss_normal2" align="center"><?=$row['NomeItem']?></td>
<td class="boss_normal2" align="center"><?=date('d-m-Y', strtotime($row['RegDate']))?> às <?=date('H:m a', strtotime($row['RegDate']))?></td>
</tr>
<? } ?>
	
</tbody>
</table>
