<?php

require("../../../web_conexao/init.php");

Deslogado();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
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
		<span class="title">Limpar minha punição</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

        <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

      - Seu personagem será livre da punição de pk.<br>

      - Limpe seu PK mas sua honra será cobrada.<br>
      
      - Cada vez que usar o sistema de limpar pk  sua honra sera cobrada em dobro.<br>

      - Seu personagem selecionado deve estar <font color="red"><u>OFFLINE</u></font><br>

		
		<div class="nbody nbody_N">

  <div class="nbar nbar_N" onclick=" ">
    <div style="padding: 5px; 0px;">

      <div class="ndate" style="float: left;"></div>
      <div class="clear"></div>

  </div>

  </div>

  <div id="" name="" style="">

    <div class="ntext" align="justify">
	  
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Personagem</strong></td>
<td class="boss_title" align="center" width="72"><strong>Uso do painel</strong></td>
<td class="boss_title" align="center" width="65"><strong>Honra cobrada</strong></td>
<td class="boss_title" align="center" width="80"><strong>Honra Atual</strong></td>
</tr>
	

  <?php
			
			$result_PKPenalt_logs = $db->query("select * from MWeb.dbo.cabal_m_PKPenalty where UserNum='".$result_conta->UserNum."'");
			
			
			$result = $result_PKPenalt_logs->fetchAll();
	        foreach($result as $row){
			
			
				$iii = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx='".$row['CharacterIdx']."'")->fetchObject();
			
			?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['NameChar']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['usoPainel']?></strong></td>
<td class="boss_normal2" align="center"><?=$row['HCobrada']?></td>
<td class="boss_normal2" align="center"><?=number_format($iii->Reputation)?></td>
</tr>
<? } ?>
     

</tbody></table>



  

    </div>



    </div>

  </div>

     </div>

   </div>



<form name="limparpk" id="limparpk">

   <div class="flabel" style="">

      <div class="fitem" style="margin-top: 12px;
    margin-bottom: 5px; font-weight:bold;"><label for="rusername">Selecione seu personagem</label></div>

      <div class="finput" style="">

      

       <select name="personagem" class="ffield" style="width:100%; color:#5b757b; font-family:Candara,Arial;">
<?php 
			$resumo_char = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."' AND Nation < 3");
			
			while($result_personagens = $resumo_char->fetch(PDO::FETCH_OBJ)){
				if($result_personagens->PKPenalty==0){
					echo "<option value=".$result_personagens->CharacterIdx.">".$result_personagens->Name."&nbsp;-&nbsp;[PK: NÃO]</option>";
				}
				if($result_personagens->PKPenalty>0){
					
				echo "<option value=".$result_personagens->CharacterIdx.">".$result_personagens->Name."&nbsp;-&nbsp;[PK: ".number_format($result_personagens->PKPenalty)."]&nbsp;-&nbsp;[Custo: ".number_format($result_personagens->PKPenalty*3-12)." H]&nbsp;-&nbsp;[H.Atual: ".number_format($result_personagens->Reputation)."]</option>";
					
		}
			}
				?>
      

        </select> 

          </div>

      <div class="clear"></div>

    </div>


   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="LIMPAR" onclick="new Ajax.Updater('errors', 'template/request/user/limpa-pk.php?action=limparpk', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.limparpk)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='limparpk')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = antiSQL(soNumero(anti_injection($_POST['personagem'])));
			
	       $object_personagem = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchObject();
			
			$calcPKPenalty = $object_personagem->PKPenalty * 3 - 12;
			
			
			if($object_personagem->Login >=1){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Deslogue do seu personagem para limpar sua punição.", "info") );</script>';
			}elseif($object_personagem->PKPenalty==0){
				echo '<script>console.log( swal("Desculpe!", "'.$object_personagem->Name.', você não tem punições.", "info") );</script>';
			}elseif(!$_SESSION['my_login']){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "sua sessão no painel expirou , conecte-se novamente", "error") );</script>';
			}elseif($calcPKPenalty>$object_personagem->Reputation){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "'.$object_personagem->Name.', você não possui honra suficiente para limpar sua punição.", "info") );</script>';
			}elseif(!is_numeric($personagem)){
				echo '<script type="text/javascript">document.addpontos.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Houve um problema têcnico no sistema, favor notifique o administrador.", "warning") );</script>';
			}else{
			
				$log_penalty = $db->query("select distinct count(*) from MWeb.dbo.cabal_m_PKPenalty where UserNum='".$result_conta->UserNum."' AND CharacterIdx='".$personagem."'")->fetchColumn();
				
				
				if($log_penalty==0){ //se não houver registro de char ainda ele vai inserir na tabela//
				try{
			//Query para deixa o campo PKPenalty 0 e também registra logs na tabela//
		    $db->query("USE [MWeb]exec dbo.cabal_PKPenalty_clean '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			$db->query("USE [MWeb]exec dbo.cabal_m_insert_log_PKPenalty '".$result_conta->UserNum."', '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."', '".$object_personagem->Name."'");
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				
				}else{
					
					//se ja existir registro ele vai só atualizar a tabela do registro
					try{
			
		    $db->query("USE [MWeb]exec dbo.cabal_PKPenalty_clean '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			$db->query("USE [MWeb]exec dbo.cabal_m_update_log_PKPenalty '".$result_conta->UserNum."', '".$object_personagem->CharacterIdx."', '".$calcPKPenalty."'");
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
					echo '<script>console.log( swal("Obrigado!", "'.$object_personagem->Name.', sua punição foi retirada.", "success") );</script>';
				}
                
				echo '<script>console.log( swal("Obrigado!", "'.$object_personagem->Name.', sua punição foi retirada.", "success") );</script>';
	
			$db = null;
			unset($db);
			exit();
			}

     


		}






?>
