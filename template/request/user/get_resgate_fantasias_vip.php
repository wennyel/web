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

 $action		=	antiSQL(anti_injection(isset($_GET["resgate"]))) ? antiSQL(anti_injection($_GET["resgate"])) : '';
 
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
		<span class="title">Fantasias VIP</span>
</div>

  <div  style="clear:right;"></div>
<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc"><span style="color: #F00"><b>Introducao</b>:</span><br>



- O sistema é exclusivo para usuários que ajudam o servidor.<br>
- Você só pode utilizar este sistema uma vez, a cada compra de VIP .<br>
- É necessário que selecione 10 fantasias.  <br>
- você precisa está OFFLINE para recebe a fantasia. <br>
    </div>

   </div>



<form name="lendario" id="lendario">

   

    

    <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px; margin-bottom:7px;border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;LISTA DE FANTASIAS:
   <div class="clear"></div>
    </div>
<div class="ntext" align="justify">
	  
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="192"><strong>Nome da fantasia</strong></td>
<td class="boss_title" align="center" width="65"><strong>Duração</strong></td>
<td class="boss_title" align="center" width="80"><strong>opção</strong></td>
</tr>
	

  <?php
			
			$result_list_fantasias = $db->query("select * from MWeb.dbo.cabal_fantasias_list");
			
			
			$result = $result_list_fantasias->fetchAll();
	        foreach($result as $row){
			
			
			?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=utf8_encode($row['Nome'])?></td>
<td class="boss_normal2" align="center">30 dias</td>
<td class="boss_normal2" align="center"><input name="campo1[]" type="checkbox" style="display:block;" value="<?=$row['id']?>"></td>
</tr>
<? } ?>
     

</tbody></table>



  

    </div>
   
	<div id="" name="" style="">

    <div class="ntext" style="padding: 15px 15px 15px 15px; text-align:center;" align="center">
		


    </div>

    </div>


<?
			if($authVIP->ServiceKind=25 AND $authVIP->cashVIP == 1){
				?>
 <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="RECEBE" onclick="new Ajax.Updater('errors', 'template/request/user/get_resgate_fantasias_vip.php?resgate=enviar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.lendario)}); carregando('#errors');"></div>
	<? } ?>
</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=="enviar")
		{ 
			try{
			$regVIP = $db->query("SELECT count(*) FROM MWeb.dbo.cabal_fantasias_users where UserNum='".soNumero(aiRemove($result_conta->UserNum))."'")->fetchColumn();
			}catch(PDOException $logEr) { echo $logEr; }
			
			if($regVIP==0){
				
				try{
				$getInsert = $db->prepare("INSERT INTO MWeb.dbo.cabal_fantasias_users (UserNum,Ativacao) VALUES (:usernum,:ativacao)");
				$getInsert->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$getInsert->bindValue(':ativacao', 0, PDO::PARAM_INT);
				$getInsert->execute();	
				$getInsert = null;
				unset($getInsert);
				}catch(PDOException $logEr) { echo $logEr; }
				
			}
			
             
                $pergunta = soNumero($_POST["campo1"]);
			    $Calculator = count($pergunta);
			
			
			try{
				$getUpdates = $db->prepare("SELECT * FROM MWeb.dbo.cabal_fantasias_users where UserNum=:usernum");
				$getUpdates->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$getUpdates->execute();	
				$ObjUser = $getUpdates->fetchObject();
			}catch(PDOException $logEr) { echo $logEr; }
			
			if($authVIP->ServiceKind=25 AND $authVIP->cashVIP != 1){
				echo '<script>console.log( swal("OoOPs", "Houve um problema com seu VIP favor comunicar ao administrador.", "info") );</script>';
			}elseif($Calculator >10){
				echo '<script>console.log( swal("OoOPs", "você só pode selecionar 10 fantasias.", "info") );</script>';
			}elseif($Calculator==0){
				echo '<script>console.log( swal("OoOPs", "é necessário selecionar as 10 fantasias que você tem direito.", "info") );</script>';
			}elseif($Calculator != 10){
				echo '<script>console.log( swal("OoOPs", "é necessário seleciona 10 fantasias de sua escolha.", "info") );</script>';
			}elseif(!is_numeric($Calculator)){
				echo '<script>console.log( swal("OoOPs", "houve um problema de dados, favor entre em contato com o administrador.", "info") );</script>';
			}elseif($ObjUser->Ativacao >=1 ){
				echo '<script>console.log( swal("OoOPs", "você já resgatou as 10 fantasias que tem direito..", "info") );</script>';
			}elseif($result_conta->Login==1){
				echo '<script>console.log( swal("OoOPs", "Você precisa deslogar de sua conta para utilizar o sistema.", "info") );</script>';
			}else{
//Para cada checkbox selecionado
foreach($pergunta as $valor_pergunta){
    $valor_do_meu_checkbox = $valor_pergunta;

	try{ 
		         $pegaItem = $db->query("SELECT * FROM MWeb.dbo.cabal_fantasias_list where id='".soNumero(aiRemove($valor_pergunta))."'")->fetchObject();
				 $sth = Database::conexao()->prepare("exec CabalCAsh.dbo.up_AddMyCashItemByItem :usernum,0,0,:idx,:opt,:dur");
				 $sth->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				 $sth->bindParam(':idx', $pegaItem->Idx, PDO::PARAM_INT);
				 $sth->bindParam(':opt', $pegaItem->Options, PDO::PARAM_INT);
				 $sth->bindParam(':dur', $pegaItem->Duracao, PDO::PARAM_INT);
				 $sth->execute();	
		         $sth = null;
		         unset($sth);
			      }catch(PDOException $cheking) { echo $cheking; }
	            
	              try{
				$getUpdate = $db->prepare("UPDATE MWeb.dbo.cabal_fantasias_users SET Ativacao=:ativacao,RegDate=getdate() where UserNum=:usernum");
				$getUpdate->bindValue(':ativacao', 1, PDO::PARAM_INT);
				$getUpdate->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$getUpdate->execute();	
				$getUpdate = null;
				unset($getUpdate);
				}catch(PDOException $logEr) { echo $logEr; }

}
			   
				echo '<script>console.log( swal("Parabêns!", "vocÊ escolheu 10 fantasias de sua escolha, conecte-se no jogo e receba suas fantasias.", "success") );</script>';
				
				
			
			}
     


		}






?>
