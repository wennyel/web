
<?

 require('../../web_conexao/init.php');
 Deslogado();
 $check = htmlentities(aiRemove(antiSQL(anti_injection($_GET['box']))));
 if($check=="true"){
	 
echo '<script>console.log( swal("Error", "Você precisa criar um personagem para selecionar esta opção.", "warning") );</script>'; 
exit(); 
	 
 }
 try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}
 try{
		 		$GetCash = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE ID=:id AND UserNum=:usernum");
		 		$GetCash->bindParam(':id', $_SESSION["my_login"], PDO::PARAM_STR);
				$GetCash->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
		 		$GetCash->execute(); 
		 		$CashAccount = $GetCash->fetchObject();
		 		}catch(PDOException  $er ){ echo '<script>console.log( swal("Erro", "Houve um problema técnico no sistema, atualize a página e tente novamente. Número de protocolo m-Fx34p", "warning") );</script>'; exit(); }
                try{
		 		$GetTPoint = $db->prepare("SELECT * FROM Netcafebilling.dbo.Point WHERE UserNum=:usernum");
				$GetTPoint->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
		 		$GetTPoint->execute(); 
		 		$TPoint = $GetTPoint->fetchObject();
				
				$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();

		 		}catch(PDOException  $er ){ echo '<script>console.log( swal("Error", "Houve um problema técnico no sistema, atualize a página e tente novamente. Número de protocolo m-Fx3ws", "warning") );</script>'; exit(); }
                
			
	
?>

<style>
.top-content{display:flex}
.user-panel{float:left;width:300px;margin-right:2px;background:url(../images/fon-news.jpg) repeat}
.user-panel-title{position:relative;display:flex}
.user-panel-title span{display:block;color:#ffaf43;font-size:20px;font-weight:700;padding:40px 40px 20px;text-transform:uppercase;position:relative}
.user-panel-text{padding:0 40px 40px}
span.user-1{color:#8d7962}
.user:hover{height:42px;padding-top:13px;background-color:#191c20;border-bottom:1px solid #2c2f33;padding-left:33px;padding-right:47px;transition:.3s;box-shadow:0 8px 10px -3px rgba(0,0,0,.45)}
.user:hover .user-1{color:#e7c195}
.user:hover .date{color:#e7c195}
.user:hover a{color:#ffaf43}
.user{height:45px;margin:0 -40px;padding-left:40px;padding-right:40px;padding-top:13px;box-shadow:0 4px 5px -3px rgba(0,0,0,.45);border-bottom:1px solid #2c2c2c}
.user.active,.btn:hover{height:50px;padding-top:13px;background-color:#191c20;border-bottom:1px solid #2c2f33;padding-left:33px;padding-right:47px;transition:.3s;box-shadow:0 8px 10px -3px rgba(0,0,0,.45)}
.flex-s-cs {
    display: flex;
    justify-content: space-between;
}
.user a{width:400px;text-decoration:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#f7ddbf}
.user-panel2{float:right;margin-left:2px;width:100%;background:url(../images/fon-news.jpg) repeat}
.user-panel2-content{padding:10px}
.character-panel{float:left;width:300px;margin-right:2px;background:url(../images/fon-news.jpg) repeat}.character-panel-title{position:relative;display:flex}.character-panel-title span{display:block;color:#ffaf43;font-size:20px;font-weight:700;padding:40px 40px 20px;text-transform:uppercase;position:relative}.character-panel-text{padding:0 40px 40px}span.character-1{color:#8d7962}.character:hover{height:42px;padding-top:13px;background-color:#342b29;border-bottom:1px solid #5c432b;padding-left:33px;padding-right:47px;transition:.3s;box-shadow:0 8px 10px -3px rgba(0,0,0,.45)}.character:hover .character-1{color:#e7c195}.character:hover .date{color:#e7c195}.character:hover a{color:#ffaf43}.character{height:50px;margin:0 -40px;padding-left:40px;padding-right:40px;padding-top:13px;box-shadow:0 4px 5px -3px rgba(0,0,0,.45);border-bottom:1px solid #4f2702}.character a{width:400px;text-decoration:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#f7ddbf}.character-panel2{float:right;margin-left:2px;width:100%;background:url(../images/fon-news.jpg) repeat}.character-panel2-content{padding:10px}
.account{padding:1px 0 0}
.character-panel{float:left;width:300px;margin-right:2px;background:url(../images/fon-news.jpg) repeat}.character-panel-title{position:relative;display:flex}.character-panel-title span{display:block;color:#ffaf43;font-size:20px;font-weight:700;padding:40px 40px 20px;text-transform:uppercase;position:relative}.character-panel-text{padding:0 40px 40px}span.character-1{color:#8d7962}.character:hover{height:42px;padding-top:13px;background-color:#342b29;border-bottom:1px solid #5c432b;padding-left:33px;padding-right:47px;transition:.3s;box-shadow:0 8px 10px -3px rgba(0,0,0,.45)}.character:hover .character-1{color:#e7c195}.character:hover .date{color:#e7c195}.character:hover a{color:#ffaf43}.character{height:50px;margin:0 -40px;padding-left:40px;padding-right:40px;padding-top:13px;box-shadow:0 4px 5px -3px rgba(0,0,0,.45);border-bottom:1px solid #4f2702}.character a{width:400px;text-decoration:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#f7ddbf}.character-panel2{float:right;margin-left:2px;width:100%;background:url(../images/fon-news.jpg) repeat}.character-panel2-content{padding:10px}.account{padding:1px 0 0}
.account_light_cont,.account-wide{width:100%;padding:0}
.account_info_cont{height:240px;border-radius:3px;box-shadow:inset 0 0 0 1px rgba(255,255,255,.01),0 0 45px 5px rgba(0,0,0,.65),0 1px 1px rgba(0,0,0,.25);margin:0;margin-top:10px}
.char_info_cont{height:250px;border-radius:3px;box-shadow:inset 0 0 0 1px rgba(255,255,255,.01),0 0 45px 5px rgba(0,0,0,.65),0 1px 1px rgba(0,0,0,.25);margin:0;margin-top:120px}
.account_info{height:240px;text-shadow:0 0 4px rgba(0,0,0,.3),0 1px 0 rgba(0,0,0,.2); margin-bottom:20px;}
.account_info ul{float:left}
.account_info ul.account_info_main{width:349px}
.account_info ul.account_info_second{width:315px}
.account_info ul.account_info_main li,.account_info ul.account_info_second li{margin:0 0 0 28px}
.account_info ul li{display:block}
.account_info ul li span{display:inline-block;color:#74634d}
.account_info ul li div{display:inline-block}
.account_info ul li p{display:inline-block;color:#817464}
.account_info ul.account_info_main li span{width:100px;text-align:left}
.account_info ul.account_info_main li#displayname p{color:#c2a269}
.account_info ul.account_info_main li#rank{}
.account_info ul.account_info_main li#gcoins{margin:15px 0 3px 28px}
.account_info ul.account_info_main li#gcoins p{color:#b38e47;margin:0 0 0 8px}
.account_info ul.account_info_main li#scoins p{color:#969696;margin:0 0 0 8px}
.account_info ul.account_info_main li#gcoins div{width:13px;height:13px;background-image:url(https://heroes-wow.com/template/style/images/misc/g-coin.png);background-size:100%;top:2px}
.account_info ul.account_info_main li#scoins div{width:13px;height:13px;background-image:url(https://heroes-wow.com/template/style/images/misc/s-coin.png);background-size:100%;top:2px}
.account_info ul.account_info_second li span{width:135px}#accoun_panel_menu{height:auto;float:left;margin-top:30px}
#accoun_panel_menu li{display:block;float:left;width:400px;height:55px;border-radius:3px;background:rgba(0,0,0,.12);box-shadow:none;margin:0 23px 24px 0}
.account_info ul.account_info_main li#displayname,.account_info ul.account_info_second li:first-child{margin:20px 0 0 28px}
#accoun_panel_menu li{display:block;float:left;height:55px;border-radius:3px;background:rgba(0,0,0,.12);box-shadow:none}
#accoun_panel_menu li a{display:block;width:400px;height:55px}
#accoun_panel_menu li a div#icon{width:37px;height:37px;background-size:100%;float:left;border-radius:50%;box-shadow:inset 0 0 0 1px #746c5a,inset 0 0 6px 3px rgba(0,0,0,.7),0 0 5px rgba(0,0,0,.8),0 1px 1px rgba(0,0,0,.5);margin:8px 10px 0}
#accoun_panel_menu li a span{float:left;display:block;text-align:left;margin:2px 0 0;color:#565147;text-shadow:0 1px 1px rgba(0,0,0,.4),0 0 4px rgba(0,0,0,.6)}
#accoun_panel_menu li a span p{color:#90856e;font-size:17px;text-transform:uppercase;margin-top:12px}
#accoun_panel_menu li,#accoun_panel_menu li a,#accoun_panel_menu li a div #icon,#accoun_panel_menu li a span,#accoun_panel_menu li a span p{transition:all 500ms;-moz-transition:all 500ms;-webkit-transition:all 500ms;-o-transition:all 500ms}
#accoun_panel_menu li:hover{background:rgba(0,0,0,.16);box-shadow:inset 0 0 10px 2px rgba(0,0,0,.06),0 0 3px rgba(0,0,0,.13)}
#accoun_panel_menu li a:hover div#icon{box-shadow:inset 0 0 0 1px #f2bc39,inset 0 0 6px 3px rgba(0,0,0,.7),0 0 5px rgba(0,0,0,.8),0 1px 1px rgba(0,0,0,.5)}
#accoun_panel_menu li a:hover span{color:#7d776c}
#accoun_panel_menu li a:hover span p{color:#d5a83c}
#accoun_panel_menu li #boost{width:570px;height:60px;margin:30px 0 55px;padding:0;background:0 0;box-shadow:none}
#accoun_panel_menu li#boost a{display:block;width:570px;height:60px;background-position:0 0;border-radius:4px;overflow:hidden;box-shadow:0 0 8px rgba(0,0,0,.4),0 1px 1px rgba(0,0,0,.2)}
#accoun_panel_menu li#boost a p{position:absolute;top:0;left:0;display:block;width:570px;height:60px;background-position:0 -60px;opacity:0;transition:all 500ms;-moz-transition:all 500ms;-webkit-transition:all 500ms;-o-transition:all 500ms}
#accoun_panel_menu li#boost a:hover p{opacity:1}
#character_list{height:auto;float:left;margin-top:30px}
#character_list li{display:block;float:left;width:135px;height:40px;border-radius:3px;background:rgba(0,0,0,.12);box-shadow:none;margin:0 10px 10px 0}
#character_list li{display:block;float:left;height:50px;border-radius:3px;background:rgba(0,0,0,.12);box-shadow:none}
#character_list li a{display:block;width:200px;height:55px}
#character_list li a div#icon{width:30px;height:30px;background-size:100%;float:left;border-radius:3px;box-shadow:inset 0 0 0 1px #746c5a,inset 0 0 6px 3px rgba(0,0,0,.7),0 0 5px rgba(0,0,0,.8),0 1px 1px rgba(0,0,0,.5);margin:8px 10px 0}
#character_list li a span{float:left;display:block;text-align:left;margin:2px 0 0;color:#565147;text-shadow:0 1px 1px rgba(0,0,0,.4),0 0 4px rgba(0,0,0,.6)}
#character_list li a span p{color:#90856e;font-size:11px;text-transform:uppercase}
#character_list li,#character_list li a,#character_list li a div #icon,#character_list li a span,#character_list li a span p{transition:all 500ms;-moz-transition:all 500ms;-webkit-transition:all 500ms;-o-transition:all 500ms}
#character_list li:hover{background:rgba(0,0,0,.16);box-shadow:inset 0 0 10px 2px rgba(0,0,0,.06),0 0 3px rgba(0,0,0,.13)}
#character_list li a:hover div#icon{box-shadow:inset 0 0 0 1px #f2bc39,inset 0 0 6px 3px rgba(0,0,0,.7),0 0 5px rgba(0,0,0,.8),0 1px 1px rgba(0,0,0,.5)}
#character_list li.active div#icon{box-shadow:inset 0 0 0 1px #f2bc39,inset 0 0 6px 3px rgba(0,0,0,.7),0 0 5px rgba(0,0,0,.8),0 1px 1px rgba(0,0,0,.5)}
#character_list li.active span p{color:#d5a83c}
#character_list li a:hover span{color:#7d776c}
#character_list li a:hover span p{color:#d5a83c}
#character_list li #boost{width:570px;height:60px;margin:30px 0 55px;padding:0;background:0 0;box-shadow:none}
#character_list li#boost a{display:block;width:570px;height:60px;background-position:0 0;border-radius:4px;overflow:hidden;box-shadow:0 0 8px rgba(0,0,0,.4),0 1px 1px rgba(0,0,0,.2)}
#character_list li#boost a p{position:absolute;top:0;left:0;display:block;width:570px;height:60px;background-position:0 -60px;opacity:0;transition:all 500ms;-moz-transition:all 500ms;-webkit-transition:all 500ms;-o-transition:all 500ms}
#character_list li#boost a:hover p{opacity:1}.tabs{display:flex;flex-wrap:wrap;//makesureitwraps}.tabs label{order:1;//Putthelabelsfirstdisplay:block;padding:1rem;margin-right:.2rem;cursor:pointer}
 @font-face {
    font-family: WebLT;
    src: url(White Smith.otf);
	}

</style>
<div class="user-panel2-content">
<h2 style="text-shadow: 3px 2px 8px #90856e;
    color: #c5b69a;
    font-size: 32px;
    margin-bottom: -15px;
	font-family:WebLT;
">Character</h2>
				<!-- Main Account info -->
					<ul id="character_list">
					<?
					$mJogador = $db->query("select top 6 * from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'");
                    $result = $mJogador->fetchAll();
                    foreach($result as $row){
                    $classeChar    = decodificar($row['Style']);
					
					switch($row['Nation']){
						
						
						
					}

					?>
						<li>
							<a onmouseover="Tip('Forca: <?=$row['STR']?> <br>Defesa: <?=$row['DEX']?> <br> Intelig&ecirc;ncia: <?=$row['INT']?> <br> Na&ccedil;&atilde;o: <?=$nation?>', TITLEBGCOLOR, '#515c62', BORDERCOLOR, '#515c62', TITLE, 'INFORMA&Ccedil;&Otilde;ES&nbsp;&nbsp;', TITLEFONTFACE, 'Verdana,sans-serif')" style="cursor:pointer;" id="character" onclick="new Ajax.Updater('content3', 'template/request/userPainel.php?check=<?=$row['CharacterIdx']?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#content3');">
							 <div id="icon" style="background-image:url(images/<?=$classeChar['Classe_Sigla']; unset($classeChar); ?>.gif);"></div><div class="tooltip-sweet-strong" style="left: 284px; top: 140px; opacity: 0; margin-top: 10px;">Warrior</div>
							 <span>
							  <p style="margin-top: 8px;margin-bottom: 5px;"><?=$row['Name']?></p>
							  <p>Level : <?=$row['LEV']?></p>
							 </span>
							</a>
						</li>
	<? } ?>	
																		
						
					</ul>
					
					<div name="content3" id="content3">
					
					<div class="account_light_cont char_info_cont">
					 
						<div class="account_info" align="left">

							<ul class="account_info_main">
								<li id="displayname"><span>Personagem:</span><p id="NameChar">Selecione seu personagem</p></li>
								<a id="outputstat"></a>
							<div class="clear"></div>
							
						</div>
				</div>
				
					
					</div> <!--End LoadPainel-->