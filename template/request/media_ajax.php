<?php
require('../../web_conexao/init.php');
 $action = htmlentities(antiSQL(anti_injection($_GET['media'])));
 
 if($action=='video'){
?>
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
        <iframe width="1000" height="540" src="https://www.youtube.com/embed/'.str_replace(' ', '', $yout->Youtube_Token).'" allowfullscreen></iframe>
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
        <iframe width="1000" height="540" src="https://www.youtube.com/embed/'.str_replace(' ', '', $dual->Youtube_Token).'" allowfullscreen></iframe>
	</div>';
							
							}
							}

 
 ?>
									</div>
					
										
									</div><!--media-block -->
								</div><!-- tab -->

 <? }elseif($action=='screen'){ ?>
 
 <div class="tab-s media active" id="media-1">
									<div class="media-block">
										<div class="media-block-bottom">
						<a onclick='new modal("#screen1"); return false'><img src="https://scontent.fthe1-1.fna.fbcdn.net/v/t1.0-9/34307248_1718584894893414_4106208809100247040_n.jpg?_nc_cat=0&oh=1a73d9ebc4b074020cc00958c0836137&oe=5BBB840D" title="Cabal" alt="Video"></a>
								
								<!-- Video Modal -->
	<div class='modal_window imagem_modal' id="screen1">
		<a href="#" class='close_mw close-r'></a>
        <img src="https://scontent.fthe1-1.fna.fbcdn.net/v/t1.0-9/34307248_1718584894893414_4106208809100247040_n.jpg?_nc_cat=0&oh=1a73d9ebc4b074020cc00958c0836137&oe=5BBB840D" allowfullscreen>
	</div>
					
											
											
											
												<a style="margin-left:20px;" onclick='new modal("#screen2"); return false'><img src="https://scontent.fthe1-1.fna.fbcdn.net/v/t1.0-9/34369183_1824257964262785_6764451582848270336_n.jpg?_nc_cat=0&oh=76d44f6e89bbf3c199f0ded5f5b2a927&oe=5BAEF70D" title="Cabal" alt="Video"></a>
								
								<!-- Video Modal -->
	<div class='modal_window imagem_modal' id="screen2">
		<a href="#" class='close_mw close-r'></a>
        <img src="https://scontent.fthe1-1.fna.fbcdn.net/v/t1.0-9/34369183_1824257964262785_6764451582848270336_n.jpg?_nc_cat=0&oh=76d44f6e89bbf3c199f0ded5f5b2a927&oe=5BAEF70D" allowfullscreen>
	</div>
											
											
										
									</div><!--media-block -->
										
										
										
										
										
										
					
					
										
								
										
										
										
										
										
								</div><!-- tab -->
  
 <? }elseif($action=='Artes'){ ?>
 
  <div class="tab-s media active" id="media-1">
  Artes
  </div>
  
 <? }else{echo 'ERROR Ajax';    }?>
  
 