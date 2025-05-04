<?
require('../../web_conexao/init.php'); 


if(htmlspecialchars(aiRemove(anti_injection(array_key_exists("my_login", $_SESSION))))){
     if(isset($_SESSION["my_login"])){
		 
		 		try{
		 		$getLogin = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:id");
		 		$getLogin->bindParam(':id', $_SESSION["my_login"], PDO::PARAM_STR);
		 		$getLogin->execute(); 
		 		$rows = $getLogin->fetchObject();
		 		}catch(PDOException  $er ){ echo '<script>console.log( swal("Error", "Houve um problema técnico no sistema, atualize a página e tente novamente.", "warning") );</script>'; exit(); }
                try{
		 		$GetCash = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE ID=:id AND UserNum=:usernum");
		 		$GetCash->bindParam(':id', $_SESSION["my_login"], PDO::PARAM_STR);
				$GetCash->bindParam(':usernum', $rows->UserNum, PDO::PARAM_INT);
		 		$GetCash->execute(); 
		 		$CashAccount = $GetCash->fetchObject();
				unset($GetCash);
				
				$donateinfor = $db->prepare("SELECT * FROM MWeb.dbo.ConfPgmt_historico WHERE IdxUser=:id AND Confirmado=1");
		 		$donateinfor->bindParam(':id', $rows->UserNum, PDO::PARAM_INT);
		 		$donateinfor->execute(); 
				$donateCount = $donateinfor->rowCount();
		 		$Donates = $donateinfor->fetchObject();
				unset($donateinfor);
		 		}catch(PDOException  $er ){ echo '<script>console.log( swal("Error", "Houve um problema técnico no sistema, atualize a página e tente novamente. m-Fx34p", "warning") );</script>'; exit(); }
                try{
		 		$GetTPoint = $db->prepare("SELECT * FROM Netcafebilling.dbo.Point WHERE UserNum=:usernum");
				$GetTPoint->bindParam(':usernum', $rows->UserNum, PDO::PARAM_INT);
		 		$GetTPoint->execute(); 
		 		$TPoint = $GetTPoint->fetchObject();
				
				$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$rows->UserNum."'")->fetchColumn();

		 		}catch(PDOException  $er ){ echo '<script>console.log( swal("Error", "Houve um problema técnico no sistema, atualize a página e tente novamente. m-Fx34p", "warning") );</script>'; exit(); }
                
			
	
?>

<style>


</style>

<h2 style="text-shadow: 3px 2px 8px #000000; color:#FFF; font-size:36px;">Painel de usuário</h2>
<div class="top-content" style="margin-bottom:40px;">
				<div class="user-panel"><!--Last News-->
					
					<div class="user-panel-text">
					<div name="shopMenu" id="shopMenu">
					<div class="user-panel-title">
						<a onClick="new Ajax.Updater('contain', 'template/request/user.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('contain'); carregando(); mover('#contain');" style="position: absolute;margin-left: 220px;margin-top: 41px; cursor:pointer;" class="tab-more bright"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
						<span style="margin-left: -49px;" class="tab-button active"><?=$rows->ID?></span>
					</div>
						<div class="user flex-s-cs active "><a><span class="user-1">Minha conta</span> </a></div>
						<? if($contar_personagem>=1){ ?>
						<div class="user flex-s-cs "><a onclick="new Ajax.Updater('content2', 'template/request/characters.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#content2'); sweet();"><span class="user-1">Personagems</span> </a></div>
						<? }else{ ?>
						<div class="user flex-s-cs "><a onclick="sweet('DESCULPE!','Você não possui personagem','info');"><span class="user-1">Characters <img style="width:14px;" src="images/security.png"></span> </a></div>
						<? } ?>
						<div class="user flex-s-cs "><a onclick="new Ajax.Updater('content2', 'template/request/user/up_MudarSenha.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#content2');" class="user-1"><span class="user-1">Mudar minha senha </span> </a></div>
						<div class="user flex-s-cs "><a onclick="new Ajax.Updater('content2', 'template/request/doar.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#content2');"><span class="user-1">Doar agora!</span> </a></div>
						<div class="user flex-s-cs "><a onclick="new Ajax.Updater('content2', 'template/request/user/up_confDonate.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#content2');"><span class="user-1">Confirmar doação </span> </a></div>
                        <div class="user flex-s-cs "><a onclick="new Ajax.Updater('shopMenu', 'template/request/Loja/Home.php?action=nao', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#shopMenu');"><span class="user-1">WebShop</span> </a></div>
						<!-- <a onclick="javascript: exibe('conteudo<¹¹?=//$rows['Idx']?>');">-->
						
					    <div class="user flex-s-cs "><a onclick="javascript: exibe('btTransf');"><span class="user-1">Transferencia de Personagem</span>                             </a></div>
						
						<div id="btTransf" style="display: none;">
						<div class="user flex-s-cs "><a onclick="new Ajax.Updater('extraAccount', 'template/request/user/up_moverChar.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');"><li style="margin-left:20px; cursor:pointer;"><span class="user-1">Enviar</span> </li></a></div>
							
							<div class="user flex-s-cs "><a onclick="new Ajax.Updater('extraAccount', 'template/request/user/up_moverCharFrom.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');"><li style="margin-left:20px; cursor:pointer;"><span class="user-1">Receber</span></li> </a></div>
						
						</div>
						
							 
						<div class="user flex-s-cs "><a onClick="new Ajax.Updater('AjaxDel', 'template/request/Validar.php?sair=sair', {method: 'get', asynchronous:true, evalScripts:true});"><span class="user-1">Deslogar</span> </a></div>
                     
					
					 </div>
				<?
if(in_array($_SESSION['my_login'], $AdminCP)){ 
?>				
					 <div class="user-panel-title">
						<a onClick="new Ajax.Updater('contain', 'template/request/user.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('contain'); carregando(); mover('#contain');" style="position: absolute;margin-left: 220px;margin-top: 41px; cursor:pointer;" class="tab-more bright"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
						<span style="margin-left: -49px;" class="tab-button active">Gerenciar shop</span>
					</div>
						<div class="user flex-s-cs " style="border-top: 1px solid #2c2c2c; box-shadow: 0 4px 5px -3px rgba(0,0,0,.45);">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/shop_add_items.php?acao=add', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Adicionar Items </span> </a></div>
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/shop_add_categoria.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Adicionar Categorias</span> </a></div>
						
						
						 <div class="user-panel-title">
						<a onClick="new Ajax.Updater('contain', 'template/request/user.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('contain'); carregando(); mover('#contain');" style="position: absolute;margin-left: 220px;margin-top: 41px; cursor:pointer;" class="tab-more bright"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
						<span style="margin-left: -49px;" class="tab-button active">ADMINISTRAÇÃO</span>
					</div>
						<div class="user flex-s-cs " style="border-top: 1px solid #2c2c2c; box-shadow: 0 4px 5px -3px rgba(0,0,0,.45);">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/get_insert_notice.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount'); mover('#extraAccount');" class="user-1"><span class="user-1">Adicionar noticias</span> </a></div>
						
						<div class="user flex-s-cs " style="border-top: 1px solid #2c2c2c; box-shadow: 0 4px 5px -3px rgba(0,0,0,.45);">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/get_env_donate.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount'); mover('#extraAccount');" class="user-1"><span class="user-1">Entregar doações</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/get_search_players.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount'); mover('#extraAccount');" class="user-1"><span class="user-1">Pesquisar personagem</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/sendItem.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Enviar items</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/sendMail.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Mensagem de gm</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/p/get_send_cash.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Enviar cash</span> </a></div>

                       
	 <? }elseif(in_array($_SESSION['my_login'], $gmCP)){  ?>
						
						<div class="user-panel-title">
						<a onClick="new Ajax.Updater('contain', 'template/request/user.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('contain'); carregando(); mover('#contain');" style="position: absolute;margin-left: 220px;margin-top: 41px; cursor:pointer;" class="tab-more bright"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
						<span style="margin-left: -49px;" class="tab-button active">GM Panel</span>
					</div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/gm/get_players_search.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Pesquisar players</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/gm/get_mail_players.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">Enviar email</span> </a></div>
						
						<div class="user flex-s-cs ">
						<a onclick="new Ajax.Updater('extraAccount', 'template/request/gm/get_online_players.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#extraAccount');" class="user-1"><span class="user-1">verifica players</span> </a></div>
						
						<? } ?>

					</div>
																			</div><!--END Last News-->				
				<div style="width:1px;height:1px;" id="erroBox" name="erroBox"></div>
				<div class="user-panel2" name="content2" id="content2">
				<div class="user-panel2-content">
				
				
					<!-- Main Account info -->
					<div class="account_light_cont account_info_cont">
						<div class="account_info" align="left">

							<ul class="account_info_main">
								<li id="displayname"><span>Name:</span><p><?=$rows->Nome?></p></li>
								<li><span>Status:</span><? switch($rows->AuthType){ case 0 : echo '<p style="color:#FF6427;">Status Inválido</p>'; break; case 1 : echo '<p style="color:#7BAC3B;">Activated</p>'; break; case 2 : echo '<p style="color:#FE0056;">Bloqueado - <a style="cursor:pointer;" onclick="new Ajax.Updater(\'accountativacao\', \'template/request/user/up_AtivarConta.php\', {method: \'get\', asynchronous:true, evalScripts:true}); carregando(\'#accountativacao\');">Ativar Agora!</a></p>'; break; case 4 : echo '<p style="color:#FFA300;">Erro de subsenha</p>'; break; } ?></li>
								<li><span>Username:</span><p><?=$rows->ID?></p></li>
								<li><span>Email:</span><p><?=$rows->Email?></p></li>
																<li id="gcoins"><span><?=Cash?>:</span><div></div><p><?=number_format($CashAccount->Cash)?></p></li>
								<li id="scoins"><span><?=TPoint?>:</span><div></div><p><?=number_format($TPoint->TPoint)?></p></li>
															</ul>

							<ul class="account_info_second">
								
								<li><span>Last login:</span><p>
								<?
								if($rows->LogoutTime==NULL){
									
									echo 'nunca';


								}else{
                                  echo date('d-m-Y H:i A' ,strtotime($rows->LogoutTime));

								}									
								 
								
								?>
								
								</p></li>
								<li><span>Last IP Address:</span><p>
								
								<?
								if($rows->LastIp==NULL){
									
									echo 'nunca';


								}else{
                                  echo $rows->LastIp;

								}									
								 
								
								?>
								
								</p></li>
								<br>
								<li><span>Registration date:</span><p><?=date('d-m-Y H:s A', strtotime($rows->createDate))?></p></li>
								<br>

                               <li><span>Playtime:</span><p>
							   <?php
 $minutos = $rows->PlayTime; 
 $horas = ((int) ($minutos / 60));
 $dia   = ((int) ($horas / 24));
    if($minutos < 60 ) { echo $minutos.' Minutos'; }
    if($horas == 1 ) { echo $horas.'Hora'; }
    if($horas > 1 AND $horas < 24) { echo $horas.' Horas '; }
    if($dia == 1 ) { echo  $dia.' Day'; }
    if($dia > 1 ) { echo $dia.' Days'; }
    

?>
							   
							   </p></li>
							                                  <li><span>Total donations:</span><p><?=abs($donateCount)?> &nbsp;&nbsp;<a style="cursor:pointer;color:#355b5e;text-shadow: 1px 1px 0px #000000;" onclick="new Ajax.Updater('accountativacao', 'template/request/user/up_historico.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#accountativacao');">[View History]</a></p></li>
							</ul>
							<div class="clear"></div>
						</div>
					</div>
					<div name="extraAccount" id="extraAccount"></div>
					<div name="accountativacao" id="accountativacao">
					<?php
					
					try{
$getCount = $db->prepare("select count(*) from  Account.dbo.cabal_auth_table where ID=:idC");
$getCount->bindParam(':idC', $_SESSION["my_login"], PDO::PARAM_STR);
$getCount->execute(); 
$count = $getCount->fetchColumn();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-Du74S1", "warning") );</script>'; exit(); }

if($count>=1 AND !in_array($_SESSION['my_login'], $AdminCP)){
					
					?>
					
				
						<div name="extraAccount" id="extraAccount"></div>
					 
<? }  ?>
					 
					 
					<!-- Main Account menu.End -->
					</div><!--End actived account-->



				</div>
				</div>
				
	</div>
	
	<?
	 }else{
		  
		   echo 'Não existe sessão para exibir o painel de usuário, favor tente conectar-se novamente no painel.';
		 
	 }
}else{
	
echo '<script>console.log( swal("Warning", "A Sessão de Login expirou aguarde, iremos atualizar a página.", "warning") );</script>';
echo '<script>
	
	$j(document).ready(function() {
						
						setTimeout(function() {
    window.location.href = "./";
}, 3000);
					});
               
	
</script>';
	
}
	
	
	?>