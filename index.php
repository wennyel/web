<?php
 require('web_conexao/init.php');


try{
	$Online = $db->query("select count(*) from Server01.dbo.cabal_character_table where Login=1")->fetchColumn();
}catch(PDOExecption $e){
echo $e->getMesseger();	 
}
// Autenticar e bloquear conta /
    if(antiSQL(anti_injection(isset($_GET['auth'])))==true AND antiSQL(anti_injection(isset($_GET['auth'])))!=""){
		$Key = antiSQL(anti_injection($_GET['b']));
	    $Block = $db->query("select count(*) from MWeb.dbo.cabal_m_block_account where KeyCode='".$Key."' AND Autorizacao='sim'")->fetchColumn();
		if($Block>=1){
			$AccExec = $db->query("select * from Mweb.dbo.cabal_m_block_account where KeyCode='".$Key."'")->fetchObject();
			$db->query("update ACCOUNT.dbo.cabal_auth_table SET AuthType=2 where UserNum='".$AccExec->UserNum."'");
			$db->query("update MWeb.dbo.cabal_m_block_account SET Autorizacao='nao' where UserNum='".$AccExec->UserNum."' AND KeyCode='".$Key."'");
			echo '<script>console.log( swal("Procedimento", "sua conta foi bloqueada por motivos de segurança.", "info") );</script>';
		}else{ echo '<script>console.log( swal("Informamos!", "está url já foi utilizada para efetua essa ação.", "info") );</script>'; }  }
// -End - Autenticar e bloquear conta //


?>
<!DOCTYPE html>
<html lang="pt">

<!-- CabaliCore 2020 , www.cabaliCore.com -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8" />
	<title>CABAL iCore - O MMORPG </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Cabal - Cabal Online - Cabal Pirata - Cabal 2 - iCore - O mundo que você sempre imaginou - O lugar onde nascem as lendas. conheça os personagens do Cabal">
<meta name="content-language" content="pt-br">
<meta name="author" content="CabaliCore">
<meta name="keywords" content="Cabal, Cabal Online, Cabal Pirata, Cabal 2, Cabal2, Pirata, Online, Cabal Cadastro, Cabal Download, cabal br, cabal online brasil, cabal online download, cabal pirata download, cabalpirata, cabalonline, cabal private, nexus">
<meta name="google-site-verification" content="Io1gFGW729yBtQfaa9AteO6miJsPudkZE-Wp_YoHBqs">
<meta http-equiv="keywords" content="Cabal, Cabal Online, Cabal Pirata, Cabal 2, Cabal2, Pirata, Online, Cabal Cadastro, Cabal Download, cabal br, cabal online brasil, cabal online download, cabal pirata download, cabalpirata, cabalonline, cabal private, nexus">
<meta http-equiv="description" content="Cabal - Cabal Online - Cabal Pirata - Cabal 2 - iCore - NEXUS - O mundo que você sempre imaginou - O lugar onde nascem as lendas. conheça os personagens do Cabal">
<meta http-equiv="DC.Description" content="Cabal - Cabal Online - Cabal Pirata - Cabal 2 - iCore - NEXUS - O mundo que você sempre imaginou - O lugar onde nascem as lendas. conheça os personagens do Cabal">
<link rel="canonical" href="https://www.cabalicore.com.br/">
<meta property="og:title" content="Cabal Online - iCore - Cabal Pirata - Cabal 2">
<meta property="og:image" content="//www.cabalicore.com.br/img/logo.png">
<meta property="og:url" content="https://www.cabalicore.com.br/">
<meta property="og:site_name" content="Cabal Online - NEXUS - Cabal Pirata - Cabal 2">
<meta property="og:description" content="Cabal - iCore - Cabal Online - Cabal Pirata - Cabal 2 - NEXUS - O mundo que você sempre imaginou - O lugar onde nascem as lendas. conheça os personagens do Cabal">
<meta name="identifier-url" content="https://www.cabalicore.com.br/">
<meta property="og:url" content="https://www.cabalicore.com.br/">
<meta property="og:image" content="https://www.cabalicore.com.br/img/logo.png">
<link rel="publisher" href="https://plus.google.com/communities/105514209159094142802">
<meta name="DC.Creator" content="Cabal">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="requiresActiveX=true">
<meta name="application-name" content="Fixar do Cabal Nexus">
<meta name="msapplication-starturl" content="https://www.cabalicore.com.br/">
<meta name="msapplication-navbutton-color" content="#3480C0">
<meta name="msapplication-window" content="width=1024;height=768">
<meta name="msapplication-tooltip" content="Navegar no site do Cabal iCore">
<!-- Insira aqui as configurações do FIXAR -->
<!-- Insira aqui as configurações do menu do FIXAR -->
<meta name="msapplication-task" content="name=Cadastro;
action-uri=https://cabalicore.com.br/#!register;
icon-uri=images/favicon.ico">
<meta name="msapplication-task" content="name=Ranking Players;
action-uri=https://cabalicore.com.br/#!ranking;
icon-uri=images/favicon.ico">
<meta name="msapplication-task" content="name=Guia do Jogo;
action-uri=https://cabalicore.com.br/#!guia;
icon-uri=images/favicon.ico">
<meta name="distribution" content="all">
<meta name="robots" content="all">
<meta name="googlebot" content="noindex">
<meta name="revisit" content="3 days">

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <link href="css/css-reset.css" rel="stylesheet">
    <link href="css/style.css?v=<?=md5(date("H:i:s.B A"))?>" rel="stylesheet">
	
	<!-- Style of Responsive Mega menu -->
	<link href="css/layout-menu.css?v=<?=md5(date("H:i:s.B A"))?>" rel="stylesheet">
	
	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css?v=<?=md5(date("H:i:s.B A"))?>">
	
	<script type="text/javascript" src='js/jquery_1.9.1/jquery.min.js'></script>
  	<script src="js/modalx.js"></script>

	
	
	<script type="text/javascript" src="js/prototip.js"></script>
  <script type="text/javascript" src="js/propios.js"></script>
  <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/kkcountdown.min.js"></script>
	
	 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js" ></script>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" rel="stylesheet" type="text/css" />
   
   
   
   <style>
	   .mySlides {display:none;}
	</style>
   
   
   <script>
    var $j = jQuery.noConflict();
	
  </script>
  <!-- jQuery -->
  <script type="text/javascript">
    $j(document).ready(function(){
      $j(".kkcount-down-eventos").kkcountdown({
        dayText : ' Dia ',
        daysText : ' Dias ',
        hoursText : ':',
        minutesText : ':',
        secondsText : '',
        displayZeroDays : false,
        textAfterCount : '<img src="template/images/war.png" style="margin-left:10px; margin-top:6px;">'
      });	
    }); 
	  
	  function ReCaptchA(){
	document.getElementById('captcha').src='template/request/captcha.php?'+Math.random();
    document.getElementById('captcha').focus(null);   
	return false;
		   }
	  function optionCheckSelect(){
        var option = document.getElementById("options").value;
        
		if(option == "cashcupom"){
            document.getElementById("myinputs").style.visibility="visible";

         }else if(option === "tpoint" || option === "cash" || option === "ticket"){
            document.getElementById("myinputs").style.visibility ="hidden";
        }
    } 
	 
	</script>
	
	
	<script>
function sweet(){
swal("Good job!", "You clicked the button!", "warning");
}
</script>
	    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/jQuery-iCore.js"></script>
   <script language="javascript" src="js/script.js" type="text/javascript"></script>
	<script type="text/javascript">

            function gerarCodigo() {

                var alfabeto = "abcdefghijklmnopqrstuvwxyz";

                // letras aleatorias
                //var letras = [];
                //for (var i = 0; i < 4; ++i)
                 //   letras[i] = alfabeto.charAt(Math.floor(Math.random() * 25));

                // numero aleatorios
                var numeros = [];
                for (var i = 0; i < 8; ++i) {
                    var sorteio = Math.floor(Math.random() * 9);

                    if (sorteio == 0)
                        sorteio = 1; // 1 - 9

                    numeros[i] = sorteio; 
                }

                var senha = numeros.join('');

                document.getElementById('txtchave').value = senha;
            }
        </script>    

</head>
<script src="//code.jivosite.com/widget/mqBt1fhr52" async></script>

<body>

	
	<div class="wrapper">
		<!--menu left-->
			<div style="margin-top: 520px;margin-left: -1px;">
				<ul class="puerto-menu">
		<li>
			<a href="./">
				<i class="fa fa-home"></i>
				<strong>Home</strong>
				<small>página principal</small>
			</a>
		</li>
		<li>
			<a onclick='new modal("#reg_modal"); return false' class="active">
				<i class="fa fa-edit"></i>
				<strong>Register</strong>
				<small>crie sua conta!</small>
			</a>
		</li>
		<li>
			<a href="#!download" onClick="new Ajax.Updater('container', 'template/request/download.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');">
				<i class="fa fa-cloud-download"></i>
				<strong>Download</strong>
				<small>client oficial</small>
			</a>
		</li>
		<li>
			<a href="#!user/doacao" onClick="new Ajax.Updater('container', 'template/request/user/doacao.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');">
				<i class="fa fa-shopping-basket"></i>
				<strong>Donate</strong>
				<small>faça sua doação!</small>
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-trophy"></i>
				<strong>Ranking</strong>
				<small>os melhores!</small>
			</a>
			<ul>
				<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=1', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa fa-group"></i>Jogadores</a></li>
				<li>
					<a href="#"><i class="fa fa-sort-numeric-desc"></i>Pontuação War</a>
					<ul>
						<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=7', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa"><img src="images/icons/fa-capella.png" width="16" height="16"></i>Capella</a></li>
						<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=8', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa"><img src="images/icons/fa-procyon.png" width="16" height="16"></i>Procyon</a></li>
						<li><a target="_blank" href="https://weekly.cabalicore.com.br/"><i class="fa fa-area-chart" aria-hidden="true"></i>Estatísticas  War</a></li>
					</ul>
				</li>
				<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=2', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa fa-trophy"></i>Guild</a></li>
				<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=4', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa fa-cube"></i>Combo</a></li>
				<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=5', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa fa-clock-o"></i>Horas Online</a></li>
				<li><a href="#!ranking" onClick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=6', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');"><i class="fa fa-ban"></i>Hall da vergonha</a>
			</ul>
		</li>
		<li>
			<a href="https://www.facebook.com/cabaliCore/" target="_blank">
				<i class="fa fa-envelope-o"></i>
				<strong>Fale conosco</strong>
				<small>Messeger facebook</small>
			</a>
		</li>
		<li class="float">
			<a class="search">
				<input type="text" value="pesquisar ...">
				<button><i class="fa fa-search"></i></button>
			</a>
			<a href="#" class="search-mobile">
				<i class="fa fa-search"></i>
			</a>
		</li>
	</ul>
				
	</div>
		<!--EFEITO-->
		<div class="light">
			</div>
		<!--END EFEITO-->
	<!-- .end menu-->
			<div class="container">
				<main class="content">
					<div class="top-content-block">
						<div class="download-bonus-block">
							<div class="download">
								<a href="#!download" onClick="new Ajax.Updater('container', 'template/request/download.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');">
									<span>Baixe e divirta-se</span>
								</a>
							</div><!-- download -->
							<div class="bonus-block">
								<a href="#!user/doacao" onClick="new Ajax.Updater('container', 'template/request/user/doacao.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');" class="bonus">
									<p>BONUS</p>
									<span>Ganhe Doando</span>
								</a>
								<a href="https://www.facebook.com/groups/123456/" target="_blank" class="facebook">
									<p>Facebook</p>
									<span>Page Oficial</span>
								</a>
								<a href="https://www.facebook.com/cabaliCore/?modal=admin_todo_tour" target="_blank" class="support">
									<p>Suporte</p>
									<span>Online 24/7</span>
								</a>
								<a style="cursor:pointer;" onclick="new Ajax.Updater('container', 'template/request/getSHOP/_getHome.php', {method: 'get', asynchronous:true, evalScripts:true}); new Ajax.Updater('MenuShop', 'template/request/getSHOP/index.php?pag=menu', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); esperar('MenuShop'); carregando(); return false;" class="shop">
									<p>Item Shop</p>
									<span>Comprar Items</span>
								</a>
							</div><!-- bonus-block -->
						</div><!-- download-bonus-block -->
						<div class="slider">
                  
						<div class="w3-content w3-section" style="max-width:640px;">
 						 <img class="mySlides" src="images/iCoreNovidades2018.jpg" style="width:100%">
 						 <img class="mySlides" src="images/SLIDER_YOUTUBE.png" style="width:100%">
 						 <img class="mySlides" src="images/SLIDER_DOACAO.png" style="width:100%">
</div>
							
							
					</div><!-- slider-block -->
						<script>
var myIndexs = 0;
carouselss();

function carouselss() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndexs++;
    if (myIndexs > x.length) {myIndexs = 1}    
    x[myIndexs-1].style.display = "block";  
    setTimeout(carouselss, 4000); // Change image every 2 seconds
}
</script>

						
					</div><!-- top-content-block -->
					
					<div class="content-block-info">
						<div class="left-content-block-info">
						
		 <div id="container" name="container">
		 
		
							
							Carregando Feed de noticias....
							
							
							
							</div> <!--DIV Container-->
							<div class="carousel-block">
								<div class="content-title title-carousel c-title">
									<a href="#">Mais</a>
									<span class="title">ADICIONADOS NO SHOP RECENTEMENTE</span>
								</div><!-- content-title -->
								<div id="carousel" class="carousel">
							    	<button class="arrow prev"></button>
									    <div class="gallery">
									      <ul class="images">
											  <?
												  $ItemShop = $db->query("select top 5 * from WebLT_SHOP.dbo.Produtos");
												  
												  $resultItem = $ItemShop->fetchAll();
												  foreach($resultItem as $rowss){
	#images/items/<?=$row['Imagem']
											  ?>
									        
											  	<li>
									        	<div class="item-s">
									        		<img src="images/items/<?=$rowss['Imagem']?>" alt="">
									        	</div>
									        	<div class="item-price">
									        		<p style="font-size:12px; font-weight:normal;"><marquee behavior="scroll" scrollamount="5"><?=$rowss['Name']?></marquee></p>
									        		<span><?=number_format($rowss['valor'])?></span>
									        		<button class="green-a" onClick="new Ajax.Updater('container', 'template/request/getSHOP/env_function/_getBuy.php?item=<?=aiRemove(soNumero(abs($rowss['id'])))?>', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');">comprar</button>
									        	</div>
									        </li>
											  <? } ?>
											  <div id="errors"></div>
									        
									      </ul>
									    </div>
								    <button class="arrow next"></button>
							  	</div><!-- carousel -->
							</div><!-- carousel-block -->
							
							
							
							
							
							
							
							
							
							
						</div><!-- left-content-block-info -->
						
					
						
						<div name="MenuShop" id="MenuShop"> <!--Abre Menu shop-->
						
						<div class="right-content-block-info">
							<div class="media-block-i">
								<div class="content-title">
									<a href="#">Mais</a>
									<span class="title">Media</span>
								</div><!-- content-title -->
								<div class="media-tab tab-button">
									<button onclick="new Ajax.Updater('PagMedia', 'template/request/media_ajax.php?media=video', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#PagMedia');" class="btn-block-s active button-n">Video</button>
									<button onClick="new Ajax.Updater('PagMedia', 'template/request/media_ajax.php?media=screen', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#PagMedia');" class="btn-block-s button-n">Screens</button>
									<button  onClick="new Ajax.Updater('PagMedia', 'template/request/media_ajax.php?media=Artes', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#PagMedia');" class="btn-block-s button-n">Fan Art</button>
								</div>
								
								<div id="PagMedia" name="PagMedia">

								<div class="tab-s media active" id="media-1">
									<div class="media-block">
										<?php
                                 $Youtube_principal = $db->query("select TOP 1* from MWeb.dbo.cabal_m_Youtube_video where Destaque = 'yes' order by RegDate desc");
                                      while($yout = $Youtube_principal->fetch(PDO::FETCH_OBJ)){
										  
										  echo '<div class="media-block-top"><a onclick=\'new modal("#video_modal'.$yout->YoutubeID.'"); return false\'><img src="images/Youtube_media/'.base64_decode($yout->Youtube_Imagem).'" title="'.$yout->TitleYoutube
.'" alt="Video"></a>
										</div>';
										  echo '<!-- Video Modal -->
	<div class=\'modal_window video_modal\' id="video_modal'.$yout->YoutubeID.'">
		<a href="#" class=\'close_mw close-r\'></a>
        <iframe id="player" type="text/html" width="1000" height="540" src="https://www.youtube.com/embed/'.str_replace(' ', '', $yout->Youtube_Token).'?enablejsapi=1&origin=https://cabalicore.com.br" allowfullscreen></iframe>
	</div>';
									  }
                                        ?>
										
										
										
									<div class="media-block-bottom">
										<?php
                   $Youtube_dual = $db->query("select TOP 2 * from Mweb.dbo.cabal_m_Youtube_video where Destaque = 'no' order by RegDate desc");
                        while($dual = $Youtube_dual->fetch(PDO::FETCH_OBJ)){
							@$n+=1;
							if($n>=1){
							echo '<a onclick=\'new modal("#video_modal'.$dual->YoutubeID.'"); return false\'><img src="images/Youtube_media/'.base64_decode($dual->Youtube_Imagem).'" title="'.$dual->TitleYoutube
.'" alt="Video"></a>';
								
								echo '<!-- Video Modal -->
	<div class=\'modal_window video_modal\' id="video_modal'.$dual->YoutubeID.'">
		<a href="#" class=\'close_mw close-r\'></a>
        <iframe  id="player" type="text/html" width="1000" height="540" src="https://www.youtube.com/embed/'.str_replace(' ', '', $dual->Youtube_Token).'?enablejsapi=1&origin=https://cabalicore.com.br" allowfullscreen></iframe>
	</div>';
							
							}
							}

 
 ?>
									</div>
					
										
									</div><!--media-block -->
								
									
									</div><!-- tab -->
								<div class="tab-s media" id="media-2">
									2
								</div><!-- tab -->
								<div class="tab-s media" id="media-3">
									3
								</div><!-- tab -->

							</div><!-- media-block -->
							</div>
							
							<div class="discussion-block">
								<div class="content-title c-title">
									<a href="#">Forum</a>
									<span class="title">GUERRA</span>
								</div><!-- content-title -->
								
								<div class="forum">
                                <center>
									<div class="forum-title">
										<a href="#">Quantidade entre nações</a>
									</div>
									<?php
									try{
									$nationcount = $db->prepare("select count(*) from server01.dbo.cabal_character_table where Nation=1");
									$nationcount->execute();
									$capella = $nationcount->fetchColumn();
										
									$nationcount2 = $db->prepare("select count(*) from server01.dbo.cabal_character_table where Nation=2");
									$nationcount2->execute();
									$procyon = $nationcount2->fetchColumn();
										
									}catch(PDOException $erro) { echo $erro; }
									?>
									<div class="forum-autor">
										<font style="color:#da06dd;">Capella</font> <?=number_format($capella)?><span><?=number_format($procyon)?> <font style="color:#3ab6e0;">Procyon</font></span>
									</div>
									
						
									</center>
								</div>
								
								
								
								<div class="forum">
                                <center>
									<?php
	$forcecalibur = $db->prepare("select * from server01.dbo.cabal_Forcecalibur_Owner order by RegDate desc");
	$forcecalibur->execute();
	$resultCalibur = $forcecalibur->fetchObject();
	$countcalibur = abs($forcecalibur->rowCount());
										unset($forcecalibur);
										

	?>
									<div class="forum-title">
										<a href="#">Dono da arma memorial</a>
									</div>
								
									<div class="forum-autor">
                                        <?
										 if($countcalibur>=1){
											try{ $namePersonagem = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx='".$resultCalibur->CharacterIdx."'")->fetchObject();
											   }catch(PDOException $err) { echo $err; }
											
											 echo '<font style="color:#FFD13B;">'.$namePersonagem->Name.'</font>';
										 }else{
											 echo 'Niguém ainda!';
										 }
										
#echo $resultCalibur->CharacterIdx;										
										?>  
									</div>
									
						
									</center>
								</div>
								
								
								
								<div class="forum">
                                <center>
									<?php
	$victoryGrra = $db->prepare("select count(*) from server01.dbo.cabal_instantWar_results where VictoryNation=1");
	$victoryGrra->execute();
	$VicoryCapella = $victoryGrra->fetchColumn();
    unset($victoryGrra);
									
	$victoryGrra1 = $db->prepare("select count(*) from server01.dbo.cabal_instantWar_results where VictoryNation=2");
	$victoryGrra1->execute();
	$VicoryProcyon = $victoryGrra1->fetchColumn();
    unset($victoryGrra1);
										

	?>
									<div class="forum-title">
										<a href="#">Estatisticas de vitorias</a>
									</div>
								
									<div class="forum-autor">
                                       <font style="color:#da06dd;">Capella</font> <?=$VicoryCapella?> x <?=$VicoryProcyon?> <font style="color:#3ab6e0;">Procyon</font>
									</div>
									
						
									</center>
								</div>

							
							</div><!--discussion-block -->
						</div><!-- right-content-block-info -->
					</div>
					</div>
				</main><!-- .content -->
					
				<aside class="sidebar">
					<div class="shop-block">
						<div class="shop ninja">
							<p>USUÁRIOS ONLINE</p>
							<span><font style="color: #66ea07; font-size: 12px; font-weight: bold !important;  text-shadow: 0px 0px 10px #74c564;"><? echo $Online;?></font> jogadores online</span>
							<a href="#" class="blue-a">Veja mais</a>
						</div>
						<div class="shop sura">
							<p>Logado Premiado</p>
							<span>Obtenha items logado!</span>
							<a href="#!user/logado_premiado_log" onClick="new Ajax.Updater('container', 'template/request/user/logado_premiado_log.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');" class="blue-a green-a">veja mais</a>
						</div>
						<div class="shop szarfa">
							<p>Giro da Sorte</p>
							<span>Ganhe tickets e participe</span>
							<a href="#!user/giro_da_sorte" onClick="new Ajax.Updater('container', 'template/request/user/giro_da_sorte.php', {method: 'get', asynchronous:true, evalScripts:true}); esperar('container'); carregando(); mover('#container');" class="blue-a">Participar!</a>
						</div>
					</div><!-- shop-block -->
					<div class="login-block">
						<div class="login-block-b">
							<form class="login-form block-p" action="#" id="logar" name="logar">
  
					
                            </form>
							
							
							
							
							
							<form class="lk-form block-l" style="display:none;">
								<div class="lk-title">
									<button class="gold-a">deposit</button>
									<span class="coins">500 coins</span>
									<span class="username">Username</span>
								</div>
								<ul>
									<li><a href="#">Items Shop</a></li>
									<li><a href="#">My Friends <b>+2</b> <span>234</span></a></li>
									<li><a href="#">Account Settings</a></li>
									<li><a href="#">Vote For Coins</a></li>
									<li><a href="#">Buy Coins</a></li>
									<li><a href="#">Log out</a></li>
								</ul>
							</form>
						</div>
					</div><!-- login-block -->
					
					<!--Ranking Jogadores-->
					<div class="best-players">
						<div class="sidebar-title best-players-title">
							Jogadores <span>TOP  <b>5</b></span>
						</div>
						<div class="top-players block-p block-bt">
							<?php
                       $rkJogador=$db->query("select top 5 * from Server01.dbo.cabal_character_table where Nation < 3 order by EXP desc, Rank desc, HP desc, SwdPNT desc, MagPNT desc, PlayTime desc"); 
                        while($rowChar = $rkJogador->fetch(PDO::FETCH_OBJ)){
							$classeChar    = decodificar($rowChar->Style);
							@$nJ+=1;
                            ?>
							<div class="player-info">
								<div class="top-number">
									<?=$nJ?>.
								</div>
								<div class="top-ava">
									<img style="width:19px !important; height:17px !important;" src="images/utilitares/<?=$classeChar['Classe_Sigla']; unset($classeChar); ?>.gif" width="19" height="19" title="Espadachin Arcano"/>
								</div>
								<div class="top-name">
									<?=$rowChar->Name?>
								</div>
								<div class="top-r">
									<?=number_format($rowChar->LEV)?>
								</div>
							</div>
							<?php } ?>
							<!--End while jogador-->
					
						</div>
					</div><!--End/ Ranking Jogador -->
					
					
					<!--Ranking Jogadores-->
					<div class="best-players">
						<div class="sidebar-title best-players-title-red">
							Guild <span>TOP  <b>5</b></span>
						</div>
						<div class="top-players block-p block-bt">
							<?php
                       $rkGuild=$db->query("select top 5 * from Server01.dbo.Guild order by Point desc, RegDate desc "); 
                        while($row = $rkGuild->fetch(PDO::FETCH_OBJ)){
							
							$Members = $db->query("select count(*) from  server01.dbo.GuildMember where GuildNo='".$row->GuildNo."'")->fetchColumn();	
	$Guild_lider = $db->query("select * from server01.dbo.GuildGroup where GuildNo = '".$row->GuildNo."' AND GroupPermission=495")->fetchObject();
	$G_name_lider = $db->query("select * from server01.dbo.GuildMember where GroupIndex = '".$Guild_lider->GroupIndex."'")->fetchObject();
	$G_Name_Char = $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx = '".$G_name_lider->CharacterIndex."'")->fetchObject();
							
							
							@$nG+=1;
                            ?>
							
							<div class="player-info">
								<div class="top-number">
									<?=$nG?>.
								</div>
								<div class="top-ava">
									<img src="images/dota-ava-1.png" alt=""> <img src="images/dota-ava-1.png" alt="" class="bloor-ava">
								</div>
								<div class="top-name">
									<?=$row->GuildName?>
								</div>
								<div class="top-r" style="color:#b92323 !important;">
									<span><?=number_format($row->Point)?></span> <a onclick="new Ajax.Updater('container', 'template/request/ranking.php?ranking=3&GuildNo=<?=$row->GuildNo?>&MemberLider=<?=$G_Name_Char->CharacterIdx?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container'); mover('#container');"  class="blue-a profile-button">ver membros</a>
								</div>
							</div>
							<?php } ?>
							<!--End while-->
							
						</div>
					</div><!--End/ Ranking Jogador -->
	
				</aside><!-- sidebar -->
			
			
			</div><!-- .container-->

		<footer class="footer">
			<div class="footer-links-block">
				<div class="footer-links-block-i">
					
				</div>
			</div><!-- footer-links-block -->
			<div class="footer-nav">
				<div class="soc-links">
					<a href="#" class="facebook"></a> <a href="#" class="inst"></a> <a href="#" class="twitter"></a>
				</div>
				<div class="banner">
					<a href="#"><img src="images/banner-bg.png" alt=""></a>
				</div>
				<div class="f-menu">
					<ul>
						<li><a href="#">Dedicado Host</a></li>
						<li><a href="#">mShield</a></li>
					</ul>
				</div>
			</div><!-- footer-nav -->
			<div class="footer-info">
				<div class="terms">
					Programação Equipe Cabal iCore</a>
				</div>
				<div class="copyright">
					© Copyright - www.cabaliCore.com <br>
					All Right Reserved.<br>
					A Equipe iCore não tem de modo algum vinculo com a empresa oficial do jogo "ESTSoft".
					<br>
					O Jogo está online para finz de lazer e diversão, sem nenhuma intenção lucrativa.
				</div>
				<div id="toTop"></div>
			</div><!-- footer-info -->
		</footer><!-- .footer -->

	</div><!-- .wrapper -->

	

	
	<!-- reg Modal -->
	<div class='modal_window' id="reg_modal">
		<a href="#" class='close_mw close-r'></a>
	    <div class="popup-block">
	    	<div class="reg-title">
				<span>ou <a href="#">Faça seu login</a></span>
				INSCREVA-SE
			</div><!--Connect via facebook-->
			<!--<div class="connect-f">
				<button class="button-n"></button>
			</div>
			<div class="or">
				<span>ou</span>
			</div>-->
			<div class="reg-form">
			
				
<form id="register" name="register" action="template/request/register.php" method="post" onsubmit="setarCampos(this); enviarForm('template/request/register.php', campos, 'divResultado'); return false; javascript:gerarCodigo();"> 

<p>Primeiro nome</p>
<input name="txtNome" id="txtNome" type="text" placeholder="digite seu nome">

<p>Endereço de e-mail</p>
<input name="txtEmail" id="txtEmail" type="text" placeholder="digite seu e-mail">

<p>Nome de usuário</p>
<input name="txtUser" id="txtUser" type="text" placeholder="digite seu login">

<div class="pass first-pass">
<p>Digite uma senha:</p>
<input name="txtpass" id="txtpass" type="password" placeholder="digite uma senha">
</div>

<div class="pass">
<p>Confirmar senha:</p>
<input name="txtrepass" id="txtrepass" type="password" placeholder="repetir senha">
</div>

<p>Código de segurança</p>
<input name="txtchave" id="txtchave" type="text" style="width:190px;" onkeypress="return SomenteNumero(event)" maxlength="8" placeholder="código" readonly>
<button class="but button-n" onclick="javascript:gerarCodigo()">Gerar</button>

<input name="Token" id="Token" type="hidden" value="<?=md5(date('d-m-Y H:i'));?>">	
	
	<div class="reg-buttons">
						<button type="submit" onclick="javascript:gerarCodigo()" class="cont button-n login-button">Register</button>
					</div>
	
</form>



			<div id="divResultado" style="text-align:center;"></div>





				
			
			</div><!-- reg-form -->
	    </div>
	    <!-- popup-block -->
	</div>
<script>
	    var lis = document.getElementsByTagName('li');
	    
	    var width = 150;
	    var count = 4; 

	    var carousel = document.getElementById('carousel');
	    var list = carousel.querySelector('ul');
	    var listElems = carousel.querySelectorAll('li');

	    var position = 0; 

	    carousel.querySelector('.prev').onclick = function() {
	      position = Math.min(position + width * count, 0)
	      list.style.marginLeft = position + 'px';
	    };

	    carousel.querySelector('.next').onclick = function() {
	      position = Math.max(position - width * count, -width * (listElems.length - count));
	      list.style.marginLeft = position + 'px';
	    };
	
	
	</script>


	<script>
		$(function() {
			$(window).scroll(function() {
				if($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();
				} else {
				$('#toTop').fadeOut();
				}
				});
				$('#toTop').click(function() {
				$('body,html').animate({scrollTop:0},800);
			});
		});
	</script>
	
<script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {

campos = "txtNome="+encodeURI(document.getElementById('txtNome').value).
toUpperCase()+"&txtEmail="+encodeURI(document.getElementById('txtEmail').value)+"&txtUser="+encodeURI(document.getElementById('txtUser').value)+"&txtpass="+encodeURI(document.getElementById('txtpass').value)+"&txtrepass="+encodeURI(document.getElementById('txtrepass').value)+"&txtchave="+encodeURI(document.getElementById('txtchave').value)+"&Token="+encodeURI(document.getElementById('Token').value);


}

</script>
</body>

<!-- CabaliCore 2020 , www.cabaliCore.com -->
</html>