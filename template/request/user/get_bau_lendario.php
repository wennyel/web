<?php

require("../../../web_conexao/init.php");
Deslogado();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
$authVIP = $db->query("select * from ACCOUNT.dbo.cabal_charge_auth where UserNum='".$result_conta->UserNum."'")->fetchObject();
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
		
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Baú Lendário</span>
</div>

  <div  style="clear:right;"></div>
<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc"><span style="color: #F00"><b>Introducao</b>:</span><br>



- O sistema é exclusivo para usuários que ajudam o servidor.<br>
- durante o seu tempo de VIP você poderá abrir o baú diáriamente.<br>
- para utilizar a função é necessário está deslogado de sua conta  <br>
- os prêmios obtido são de formas aléatoria <br>
    </div>

   </div>



<form name="lendario" id="lendario">

   
	<div style="height:7px;"></div>	
  <b style="font-weight:bold; font-size:14px;">Cronometro de tempo estimado</b>:<br>			
			<div style="height:5px;"></div>	
			
			<table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Data do próximo baú</strong></td>
<td class="boss_title" align="center" width="80"><strong>Total aberto</strong></td>
</tr>
<?
			try{
			$sthVp = Database::conexao()->prepare("select * from MWeb.dbo.cabal_bau_lendario_users where Lendario_usernum=:user");
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
	        $vencidoEm	    =	strtotime($Cronometro->Lendario_date);
			
			
			if($vencidoEm > $date_atual){ ?>
	dia <?=date("d", strtotime($Cronometro->Lendario_date))?> de <? switch(date("m", strtotime($Cronometro->Lendario_date))) {
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
	
			}?> às <?=date("H:m", strtotime($Cronometro->Lendario_date))?>
		<? }else{ echo "Já pode abrir seu baú lendário."; } ?>
		
		</td>
<td class="boss_normal2" align="center"><?=round($Cronometro->Lendario_count)?></td>
</tr>
     
</tbody></table>
			
			<div style="height:5px;"></div>	

   
	<div id="" name="" style="">

    <div class="ntext" style="padding: 15px 15px 15px 15px; text-align:center;" align="center">
		
    <img src="images/LegendChest.png" width="250">


    </div>

    </div>


<?
			if($authVIP->ServiceKind=25 AND $authVIP->cashVIP == 1){
				?>
 <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ABRIR" onclick="new Ajax.Updater('errors', 'template/request/user/get_bau_lendario.php?action=abrir', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.lendario)}); carregando('#errors');"></div>
	<? } ?>
</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='abrir')
		{ 


		
				$countLendario  = $db->query("select count(*) from MWeb.dbo.cabal_bau_lendario_users where Lendario_usernum='".$result_conta->UserNum."'")->fetchColumn();
				
				$resultLendario = $db->query("SELECT * FROM MWeb.dbo.cabal_bau_lendario_users where Lendario_usernum='".$result_conta->UserNum."'")->fetchObject();
		
				
			
            $date_atual 	=	strtotime(date('Y-m-d H:i'));
   		    $vencidoEm	    =	strtotime($resultLendario->Lendario_date);

			
			if($authVIP->ServiceKind=25 AND $authVIP->cashVIP != 1){
			   echo '<script>console.log( swal("INVASOR!", "você está tentando burlar o sistema sem ter VIP, seus dados foram gravado e será analisado pela administração.", "error") );</script>';
			   exit();
		   }elseif($contar_personagem==0){ 
				echo '<script>console.log( swal("Desculpe!", "você não possui personagem nesta conta", "info") );</script>';
			   exit(); 
			}elseif($result_conta->AuthType>=2){
				echo '<script>console.log( swal("Desculpe!", "sua conta está bloqueada ou desativada", "info") );</script>';
			   exit(); 
			}elseif($vencidoEm > $date_atual){
		echo '<script>console.log( swal("OoOPS!", "você não pode abrir seu baú lendário ainda.", "info") );</script>';
		exit();
	}elseif($countLendario==0){
				echo '<script>console.log( swal("OoOPS!", "houve uma falha no sistema , favor verifique com o administrador para tentar soluciona seu problema.", "info") );</script>';
		exit();
			}else{
              
				
				$obs = $db->query("select top 1 * from MWeb.dbo.cabal_items_bau_lendario order by newid(); ")->fetchObject();
				switch($obs->Tipo){
					   case 1 : $nid = $obs->Idx + 4096;   break;
					   case 2 : $nid = $obs->Idx + 524288; break;
					   case 3 : $nid = $obs->Idx; break;
					   }
				try{
				$ValueDate = 1; // definir quantos dias será para abrir o baú novamente
				$query=$db->prepare("exec MWeb.dbo.cabal_bau_lendario_update_date :usernum,:dates,:idx,:options,:duracao,:nome");
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->bindParam(':dates', $ValueDate, PDO::PARAM_STR);
				$query->bindParam(':idx', $nid, PDO::PARAM_INT);
				$query->bindParam(':options', $obs->Option, PDO::PARAM_INT);
				$query->bindParam(':duracao', $obs->Duracao, PDO::PARAM_INT);
				$query->bindParam(':nome', $obs->Nome, PDO::PARAM_STR);
				$query->execute();
				}catch(PDOException $exception) {
                  printf('Não foi possível realizar a operação: %s' , $exception);
                 }
				
				
				
               
				echo '<script>console.log( swal("Parabêns!", "Você acaba de obter ['.$obs->Nome.'].", "success") );</script>';
				
				
			}
				
     


		}






?>
