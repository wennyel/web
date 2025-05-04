<?php

require("../../../web_conexao/init.php");

Deslogado();
checkout_token();
///////CONFIGURAR SISTEMA///////////

try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
    echo $e;	
}

 $action		=	antiSQL(anti_injection(isset($_GET["ticket"]))) ? antiSQL(anti_injection($_GET["ticket"])) : '';
 $xClose		=	antiSQL(anti_injection(isset($_GET["closed"]))) ? antiSQL(anti_injection($_GET["closed"])) : '';

if($xClose=='fechar'){
exit();	
	
}

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
	ul{text-align: left !important;
    padding-right: 3px;
    padding-left: 25px;
    padding-top: 5px;}
</style>

  <div id="plink">

<div style="position:relative;z-index:0">          
          <a href="./">Home</a> - <a href="#">Historico de Tickets</a></div></div>

  <div  style="clear:right;"></div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc"><span style="color: #F00"><b>Introducao</b>:</span><br>
    
		 <ul>
			 <li>Verifique sempre os tickets respondidos.</li>
			 <li>Os tickets fechados não podem ser respondidos.</li>
			 <li>Caso o seu ticket foi resolvido, envie uma resposta final e marque a opção "SIM" para fechar o Ticket.</li>
		</ul>


    </div>

   </div>



<form name="roleta" id="roleta">

   

    

    <div class="flabel" style="height: 20px;
    line-height: 20px;
    border: 2px solid rgba(29, 29, 29, 0.94);
    font-weight: bold;">
		<?
			$count_tickets = $db->query("select count(*) from MWeb.dbo.cabal_ticket_suportes where UserNum='".$result_conta->UserNum."'")->fetchColumn();
			?>
  MEUS TICKETS (<?=$count_tickets?>)

     

      <div class="clear"></div>

    </div>
<?php
				
				?>
   
	<div id="" name="" style="">

    <div class="ntext" style="padding: 15px 15px 15px 15px;" align="justify">
     <table width="100%" border="0" cellspacing="1" cellpadding="1">

  <tbody><tr align="center" bgcolor="#999999" class="fitem2">
    <td width="25%"><font color="#000000">ID</font></td>
    <td width="20%"><font color="#000000">Tipo </font></td>
    <td width="25%"><font color="#000000">Data</font></td>
     <td width="20%"><font color="#000000">Status</font></td>
	  <td width="10%" align="center"><font color="#000000">&nbsp;</font></td>

  </tr>

				
   <?php
				
				if($count_tickets==0){
			echo '<tr><td colspan="5" style="font-size:12px; font-family:arial;"><div class="msg-box msg-warning"><div><div><div><div><div><div class="msg-content">
<span class="title">Informamos!</span> você não possui histórico de Tickets.</div>
</div></div></div></div></div></div>	</td></tr>';
				exit();
			}
				
				
				
		$result_t = $db->query("select * from MWeb.dbo.cabal_ticket_suportes where UserNum='".$result_conta->UserNum."' order by Data desc");	
		while($row = $result_t->fetchObject()){	
	?>
        
    <tr align="center" bgcolor="#202021" class="fitem2">
    <td>#<?=$row->ID_ticket?></td>
    <td><?
		switch($row->Assunto){
		    case 1 : echo 'Reportar Bug'; break;
			case 2 : echo 'Doação'; break;
			case 3 : echo 'Denúncia'; break;
			case 4 : echo 'Elógios'; break;
			case 5 : echo 'Outros'; break;
	}
		?></td>
    <td><?=date('d/m/Y', strtotime($row->Data))?> às <?=date('H:i a', strtotime($row->Data))?></td>
		<td><?
			switch($row->Status){
			case 0 : echo "<font style='color:#F48024;'>Pendente</font>"; break;
			case 1 : echo "<font style='color:#BCDF94;'>Respondido</font>"; break;
				case 2 : echo "<font style='color:#B22222;'>Fechado</font>"; break; 
		}
			?></td>
		<td align="center" style="text-align:center;">
		
		<input name="sbmtAddPnt" class="fsubmit" type="button" value="VER" onclick="new Ajax.Updater('exibir<?=$row->ID_ticket?>', 'template/request/support/get_select_ticket.php?ticket=<?=$row->ID_ticket?>', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.roleta)}); carregando('#exibir<?=$row->ID_ticket?>');">
			 
		</td> 
   </tr>
	  
	  
	  
	   <tr align="left" style="text-align:left !important;" bgcolor="#202021" class="fitem2">
		   
      <td colspan="5" style="text-align:left !important;" id="exibir<?=$row->ID_ticket?>" name="exibir<?=$row->ID_ticket?>"></td>			   
    </tr>
	  
	  
	  
	  
<? } ?>
     

</tbody></table>
		
		</div>
	
	</div>
	
	
	

	
	



</form>


</div>


<? }elseif(isset($action)){
		
		$support = $db->query("select * from MWeb.dbo.cabal_ticket_suportes where ID_ticket = '".$action."'")->fetchObject();
			echo '
			<ul>
			   <li><font style="font-weight:bold !important; color:#CCAC61;">Eu:</font> '.$support->Msg.'</li>
			';
			
			$conversa = $db->query("select * from MWeb.dbo.cabal_ticket_suportes_conversas where id_conversas = '".$support->ID_ticket."' ORDER BY Data asc");
			while($row = $conversa->fetchObject()){
			
				
				switch($row->Tipo){
					case 'admin  ' : 	echo '<li><font style="font-weight:bold !important; color:#ed7215;">'.$row->Nome_usuario.'</font> '.$row->msg.'</li>'; break;	
					case 'usuario' : echo '<li><font style="font-weight:bold !important; color:#D6B346;">Eu:&nbsp;</font>'.$row->msg.'</li>'; break;
						
				}	
				
			}
			
			
			echo '</ul>';
		
	 if($support->Status>=2){
		 
		 echo '<div class="ferrorbig"><font color="#B22222">Informação:</font> <font style="font-size:11px; font-weight:normal !important;">Esté ticket de suporte foi fechado e por esse motivo não é possivel enviar respostas, favor abra um novo ticket para discutir um novo assunto.</font></div>';
	 }else{
		 
		 if($support->Status>=1){
	?>


<form name="formticket<?=$conversa->id_conversas?>" id="formticket<?=$conversa->id_conversas?>" method="post">
	
<textarea name="textResp" style="font-size:12px;width:54%; height:99px; float:left; margin-left:23px;border: 1px solid #292727;border-radius:0px; margin-bottom:4px;"></textarea>
	<div style="padding-left:6px;margin-bottom:10px; float:left;">
   <div style="border-radius:; background: none repeat scroll 0% 0% rgba(70, 70, 70, 0.5); border: 1px solid rgba(70, 70, 70, 0.5); overflow: hidden; width: 200px;">
     
   
	   
	   <a onclick="
    document.getElementById('captcha').src='template/request/captcha.php?'+Math.random();
    document.getElementById('register').focus();"
    id="change-image" style="cursor:pointer;">
	   <img style="position:absolute; z-index:999; width:25px; height:25px; margin-left:170px; margin-top:3.5px; border-left:1px solid #bcbcbc; border-bottom:1px solid #bcbcbc; border-bottom-left-radius:40%;" src="template/images/atualizar.png">
	   </a>
	   
	   <a onclick="
    document.getElementById('captcha').src='template/request/captcha.php?'+Math.random();
    document.getElementById('register').focus();"
    id="change-image" style="cursor:pointer;">
	   <img src="template/request/captcha.php" style="border-radius: 3px 3px 0px 0px; width: 97%; margin-left: 3px; margin-top: 3px;" id="captcha" /><br/>
	   </a>
<!-- CHANGE TEXT LINK -->
<input type="text" style="border: medium none; border-radius: 0; width: 200px; margin: 3px 3px 2px 3px; padding: 3px 5px;" name="captcha" id="captcha" autocomplete="off" /><br/>
	   
	   
	   
	
  </div>
</div>
	   <br>
	<div style="text-align:center;">
	Deseja fecha o ticket ao enviar sua resposta? [Sim: <input style="margin-bottom:8px; margin-left: -2.1; position: absolute;" type="radio" name="status" value="1">&nbsp;&nbsp;&nbsp;&nbsp;]&nbsp;&nbsp;--&nbsp; [Não: <input style="margin-bottom:8px; margin-left: -2.1; position: absolute;" type="radio" name="status" value="0" checked>&nbsp;&nbsp;&nbsp;&nbsp;]
		<br>
		<input name="sbmtAddPnt<?=$conversa->id_conversas?>" class="fsubmit" type="button" value="ENVIAR RESPOSTA" onclick="document.getElementById('captcha').src='template/request/captcha.php?'+Math.random(); new Ajax.Updater('openew<?=$action?>', 'template/request/support/get_respond_tickek.php?id_ticket=<?=$action?>', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.roleta)}); carregando('#openew<?=$action?>'); ReCaptchA();" style="margin-bottom:6px;margin-top:5px;">
		
		<input name="sbmtAddPnt<?=$conversa->id_conversas?>" class="fsubmit" type="button" value="FECHAR ABA" onclick="new Ajax.Updater('closeaba<?=$action?>', 'template/request/support/get_select_ticket.php?ticket=<?=$action?>&closed=fechar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.roleta)}); carregando('#closeaba<?=$action?>');" style="margin-bottom:6px;margin-top:5px;">
	</div>
	

</form>
<div id="openew<?=$action?>" name="openew<?=$action?>"></div>

<? }}} ?>




