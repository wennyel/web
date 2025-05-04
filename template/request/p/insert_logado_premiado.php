<?php

require("../../../web_conexao/init.php");
Deslogado();
AdminCP();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
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
.Notas {
		color: #FFE92D;
        text-shadow: 0px 0px 10px #FDFB69;	
	font-weight:bold;
	}
	.news-lists:hover {
    background-color: #091f2f;
}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Gerenciar logado premiado</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Administrador favor não deixe de preenche os campos.</li>
</ul>
<form name="Lpremiado" id="Lpremiado">

   <div class="flabel" style="margin-bottom:5px;">
      <div class="fitem" style=""><label for="rusername">Nome do Item</label></div>
      <div class="finput" style="">
        <input name="item" autocomplete="off" type="text" maxlength="25" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Idx</label></div>
<input name="idx" onkeyup='if (isNaN(this.value)) {this.value = ""}' id="txtpass" autocomplete="off" type="text" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Option</label></div>
<input name="option" id="txtrepass" onkeyup='if (isNaN(this.value)) {this.value = ""}' type="text" required>
</div>
	
	<div class="pass" style="margin-left:26px;">
<div class="fitem" style=""><label for="rusername">Duração</label></div>
<select name="duracao" id="txtrepass" required>
	<option value="31">Permanente</option>
<option value="0">Sem duracao</option>
<option value="1">1 hora</option>
<option value="2">2 horas</option>
<option value="3">3 horas</option>
<option value="4">4 horas</option>
<option value="5">5 horas</option>
<option value="6">6 hora</option>
<option value="7">10 horas</option>
<option value="8">12 horas</option>
<option value="9">1 dia</option>
<option value="10">3 dias</option>
<option value="11">5 dias</option>
<option value="12">7 dias</option>
<option value="13">10 dias</option>
<option value="14">14 dias</option>
<option value="15">15 dias</option>
<option value="16">20 dias</option>
<option value="17">30 dias</option>
<option value="18">45 dias</option>
<option value="19">60 dias</option>
<option value="20">90 dias</option>
<option value="21">100 dias</option>
<option value="22">120 dias</option>
<option value="23">128 dias</option>
<option value="24">270 dias</option>
<option value="25">365 dias</option>
<option value="22">120 dias</option>
<option value="22">120 dias</option>
		</select>
</div>
	
<div class="flabel" style="margin-bottom:5px;">
      <div class="fitem" style=""><label for="rusername">Tipo</label></div>
      <div class="finput" style="">
        <select name="tipo" class="ffield" style="margin-top:3px;">
			<option value="1">Normal</option>
			<option value="2">Ligado a conta</option>
			<option value="3">Ligado ao personagem</option>
			<option value="4">Ligado a conta e ao personagem</option>
		  </select>
          </div>
      <div class="clear"></div>
    </div>

   

    <div class="flabel" style="text-align: center; margin-top:10px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Adicionar" onclick="new Ajax.Updater('errors', 'template/request/p/insert_logado_premiado.php?action=Lpremiado', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.Lpremiado)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>
<div id="errors" name="errors"></div>

<!--Inicio/List de Items logado premiado-->

 <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;Items adicionados:

     

      <div class="clear"></div>

    </div>

   
	<div id="" name="" style="">
<?php
			$count_items = $db->query("select count(*) from MWeb.dbo.cabal_m_logado_premiado")->fetchColumn();
			
			?>
    <div class="ntext" style="padding: 15px 15px 15px 15px;<? if($count_items==0){ echo 'margin-bottom:20px;'; } ?>" align="justify">
     
		
		<table id="fbody" class="fbody" style="margin-top: 0; margin-left:-15px;" width="540" border="0" cellspacing="0" cellpadding="0">
  <tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;">
    <td width="40" align="center">ID</td>
    <td width="300" align="center">Item</td>
    <td width="140" align="center">Tipo</td>
    <td width="60" align="center">Deletar</td>
  </tr>
  
   <?php
		
			$list = $db->query("select * from MWeb.dbo.cabal_m_logado_premiado");
			
			if($count_items == 0){
				
			echo '<div style="position:absolute;margin-left: 120px;margin-top: 34px;margin-bottom: 20px;padding-bottom: 20px;">Ainda não existe items no logado premiado.</div>';	
				
			}
			
			while($rows = $list->fetchObject()){
			@$n+=1;
			?>
     <tr class="news-lists">
    <td colspan="4">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
    
      <tr style=" border-bottom: 1px dotted #153348;">
        <td width="40" height="32" align="center"><?=$n?></td>
        <td width="300" height="32" align="center"><?=$rows->ItemName?></td>
        <td width="140" height="32" align="center">Ligado ao personagem</td>
        <td width="60" height="32" align="center">Del</td>
      </tr>
    </table></td>
  </tr>
   <? } ?>
  
</table>


 </div> </div>
<!--End/List de Items logado premiado-->

<? }elseif($action=='Lpremiado')
		{ 
			
			$item_name = htmlentities(antiSQL(anti_injection($_POST['item'])));
			
			$idx       = soNumero(antiSQL(anti_injection($_POST['idx'])));
			
			$option    = soNumero(antiSQL(anti_injection($_POST['option'])));
			
			$duracao   = soNumero(antiSQL(anti_injection($_POST['duracao'])));
			
			$tipo      = soNumero(antiSQL(anti_injection($_POST['tipo'])));
			
			if($option == "") { $option = 0; } //se o campo option for vazio ele vai enviar com o valor 0//
			
			if(!$item_name || !$idx || !$tipo){
				echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
				echo '<script>console.log(swal("Informamos!", "preencha todos os campos.", "info"));</script>';
			}elseif(strlen($item_name) < 5 || strlen($item_name) > 40){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("Informamos!", "Campo nome item requer no minimo 5 caracteres e no máximo 20.", "info"));</script>';
			 exit();
			}elseif(!is_numeric($idx)){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("Informamos!", "o campo Idx requer apenas numeros", "info"));</script>';
			 exit();
			}elseif(!is_numeric($option)){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("Informamos!", "o campo option requer apenas numeros", "info"));</script>';
			 exit();
			}elseif(!is_numeric($duracao)){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("Informamos!", "o campo duração requer apenas numeros", "info"));</script>';
			 exit();
			}elseif(!is_numeric($tipo)){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("Informamos!", "o campo Tipo requer apenas numeros", "error"));</script>';
			 exit();
			}elseif($idx <= 0){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("ALERTA DE INJECTION!", "tentativa de injection, ação registrada.", "error"));</script>';
			 exit();
			}elseif($option < 0){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("ALERTA DE INJECTION!", "tentativa de injection, ação registrada.", "error"));</script>';
			 exit();
			}elseif($duracao < 0){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("ALERTA DE INJECTION!", "tentativa de injection, ação registrada.", "error"));</script>';
			 exit();
			}elseif($tipo < 0){
			 echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			 echo '<script>console.log(swal("ALERTA DE INJECTION!", "tentativa de injection, ação registrada.", "error"));</script>';
			 exit();
			}else{
			
				
				try{
				
			$sql_logado = 'exec MWeb.dbo.cabal_insert_logado_premiado_item :nome, :idx, :option, :duracao, :tipo';
			$logados = Database::conexao()->prepare($sql_logado);
			$logados->bindValue(':nome', $item_name, PDO::PARAM_STR);
			$logados->bindValue(':idx', $idx, PDO::PARAM_STR);
			$logados->bindValue(':option', $option, PDO::PARAM_STR);
			$logados->bindValue(':duracao', $duracao, PDO::PARAM_STR);
			$logados->bindValue(':tipo', $tipo, PDO::PARAM_STR);
			$logados->execute();		
			unset($sql_logado);
			unset($logados);
					
				}catch(PDOException $e){
					echo '<script>console.log( swal("Atenção!", "Houve um error na execução de dados.", "error") );</script>';
				}
				
			
           
			echo '<script type="text/javascript">document.Lpremiado.reset();</script>';
			echo '<script>console.log( swal("Informamos!", "Foi adicionado '.$item_name.' ao logado premiado.", "success") );</script>';
				exit();
				
			}
		}elseif($action=='formEliminar'){
			$id = soNumero(htmlentities(antiSQL(anti_injection($_GET['id']))));
			$inf = $db->query("select * from MWeb.dbo.cabal_m_logado_premiado where id='".$id."'")->fetchObject();
			$db->query("DELETE MWeb.dbo.cabal_m_logado_premiado where id='".$id."'");
			echo '<script>console.log( swal("Informamos!", "O Item ['.$inf->ItemName.'] foi deletado com sucesso", "success") );</script>';
			exit();
		}elseif($action != 'Lpremiado' OR $action != 'formEliminar'){
			
			echo '<script>console.log( swal("Houve um error!", "não é possivel efetua o procedimento['.$action.'].", "error") );</script>';
			
		}






?>
