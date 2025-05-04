<?

   require('../../web_conexao/init.php');
   Deslogado();
   $personagem = htmlspecialchars(aiRemove(anti_injection(aiRemove(@$_GET['check']))));
   
   try{
				$query=Database::conexao()->prepare("SELECT * FROM server01.dbo.cabal_character_table where CharacterIdx=:idx");
				$query->bindParam(':idx', $personagem, PDO::PARAM_INT);
				$query->execute();
				$result = $query->fetchObject();
				
				
				$classe=Database::conexao()->prepare("select Style & (POWER(2, 3) - 1) from server01.dbo.cabal_character_table where CharacterIdx=:idx");
				$classe->bindParam(':idx', $personagem, PDO::PARAM_INT);
				$classe->execute();
				$result_classe = $classe->fetch(PDO::FETCH_BOTH);
				
				}catch(PDOException  $er ){
				echo '<script>console.log( swal("Connection fail!", "There were problems connecting to the database.", "error") );</script>';
				}
                $classeCharName    = decodificar($result->Style);
				
?>



<div class="account_light_cont char_info_cont">
						<div class="account_info" align="left">

							<ul class="account_info_main">
								<li id="displayname"><span>Character:</span><p id="NameChar"><?=$result->Name?></p></li>

								<?
								switch($result->Login){
									
									case 0 : echo '<p style="color:red;">offline</p>'; break;
									case 1 : echo '<p style="color:green;">Online</p>'; break;
									
								}
								?>
								</li>
						
						
						</ul>
							<div class="clear"></div>
							
						</div>
				</div>
				<div name="envAjax" id="envAjax">
				<ul id="accoun_panel_menu">
						<li>
							<a style="cursor:pointer;" onclick="new Ajax.Updater('envAjax', 'template/request/user/up_delchar.php?Idx=<?=$personagem?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#envAjax');">
							  <div id="icon" style="background-image:url(../images/icons/delchar.png);"></div>
							 <span>
							  <p>DELETE CHARACTER</p>
							  <p style="font-size: 11px;margin-top: -19px; text-transform: none;">Delete that mule character of yours.</p>
							 </span>
							</a>
						</li> 


						<li>
							<a onclick="new Ajax.Updater('envAjax', 'template/request/user/up_ClassChange.php?Idx=<?=$personagem?>', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#envAjax');" style="cursor:pointer;">
							  <div id="icon" style="background-image:url(../images/icons/repeat.png);"></div>
							 <span>
							  	<p>CLASS CHANGE</p>
							  <p style="font-size: 11px;margin-top: -19px; text-transform: none;">tired of playing with your class? change right now.</p>
							 </span>
							</a>
						</li>
						
												<li>
							<a href="https://caballegendary.com/event/event@@Period_27_nov-14_dec">
							  <div id="icon" style="background-image:url(../images/icons/restore.png);"></div>
							 <span>
							 <p>Restore character</p>
							  <p style="font-size: 11px;margin-top: -19px; text-transform: none;">What do you want to use that deleted char? recover right now.</p>
							 </span>
							</a>
						</li>
						

					</ul>
					<!-- Main Account menu.End -->
					
					</div><!--end envAjax-->