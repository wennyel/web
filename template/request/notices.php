<?php
require("../../web_conexao/init.php");
 $action = htmlentities(antiSQL(anti_injection($_GET['MyNotices'])));
 
 if($action=='geral'){
?> 
 <div class="tab-s media active">
 <div class="tab-n news active" id="news-1">
	 
	 <?

	 $geral = $db->query("select top 1 * from MWeb.dbo.cabal_m_get_notices where Destacar='sim' order by DateCreate desc");
	 
	  while($row = $geral->fetchObject()){
					  
					  ?>
									<div class="last-news-block">
										<div class="news-img">
											<img src="images/notice/<?=base64_decode($row->Imagem)?>" alt="news-img">
										</div>
										<div class="last-news-info">
											<h2 title="<?=$row->Title?>"><a href="#"><?=$row->Title?></a></h2>
											<div class="news-text"><?=substr_replace($row->Msg, (strlen($row->Msg) > 200 ? '...' : ''), 200);?></div>
											<div class="news-b">
												<a href="<?=base64_decode($row->Url)?>" target="_blank" class="blue-a"><span>Leia mais</span></a> <span><?=date('d-m-Y H:i', strtotime($row->DateCreate));?></span>
											</div><!-- last-news-info -->
										</div>
									</div>
	 
	 <? } ?>
	 <?
	  $geral = $db->query("select top 7 * from MWeb.dbo.cabal_m_get_notices where Destacar='nao' order by DateCreate desc");
	  while($row = $geral->fetchObject()){
		  @$n+=1;
	 if($n>1){
	 ?>
									<div class="news-info">
										<a href="#" class="blue-a green-a news-read-more">Leia mais</a>
										<span><?=date('d-m-Y H:m',strtotime($row->DateCreate))?> </span> - <?=$row->Title?>
									</div>
									
	 <? } } ?>
								</div><!-- tab -->
</div>
 <? }elseif($action=='event'){ ?>
 
 <div class="tab-s media active">
  <div class="tab-n news active" id="news-2">
	  
							 <?

	 $geral = $db->query("select top 1 * from MWeb.dbo.cabal_m_get_notices where Category = 'evento' order by DateCreate desc");
	 
	  while($row = $geral->fetchObject()){
					  
					  ?>
									<div class="last-news-block">
										<div class="news-img">
											<img src="images/notice/<?=base64_decode($row->Imagem)?>" alt="news-img">
										</div>
										<div class="last-news-info">
											<h2 title="<?=$row->Title?>"><a href="#"><?=$row->Title?></a></h2>
											<div class="news-text"><?=substr_replace($row->Msg, (strlen($row->Msg) > 200 ? '...' : ''), 200);?></div>
											<div class="news-b">
												<a href="<?=base64_decode($row->Url)?>" target="_blank" class="blue-a"><span>Leia mais</span></a> <span><?=date('d-m-Y H:i', strtotime($row->DateCreate));?></span>
											</div><!-- last-news-info -->
										</div>
									</div>
	 
	 <? } ?>
	 <?
	  $geral = $db->query("select top 7 * from MWeb.dbo.cabal_m_get_notices where Category = 'evento' order by DateCreate desc");
	  while($row = $geral->fetchObject()){
		  @$n+=1;
	 if($n>1){
	 ?>
									<div class="news-info">
										<a href="#" class="blue-a green-a news-read-more">Leia mais</a>
										<span><?=date('d-m-Y H:m',strtotime($row->DateCreate))?> </span> - <?=$row->Title?>
									</div>
									
	 <? } } ?>
								</div><!-- tab -->
  
  </div>
  
 <? }elseif($action=='updat'){ ?>
 
  <div class="tab-s media active">
 <div class="tab-n news active" id="news-3">
									 <?

	 $geral = $db->query("select top 1 * from MWeb.dbo.cabal_m_get_notices where Category = 'updat' order by DateCreate desc");
	 
	  while($row = $geral->fetchObject()){
					  
					  ?>
									<div class="last-news-block">
										<div class="news-img">
											<img src="images/notice/<?=base64_decode($row->Imagem)?>" alt="news-img">
										</div>
										<div class="last-news-info">
											<h2 title="<?=$row->Title?>"><a href="#"><?=$row->Title?></a></h2>
											<div class="news-text"><?=substr_replace($row->Msg, (strlen($row->Msg) > 200 ? '...' : ''), 200);?></div>
											<div class="news-b">
												<a href="<?=base64_decode($row->Url)?>" target="_blank" class="blue-a"><span>Leia mais</span></a> <span><?=date('d-m-Y H:i', strtotime($row->DateCreate));?></span>
											</div><!-- last-news-info -->
										</div>
									</div>
	 
	 <? } ?>
	 <?
	  $geral = $db->query("select top 7 * from MWeb.dbo.cabal_m_get_notices where Category = 'updat' order by DateCreate desc");
	  while($row = $geral->fetchObject()){
		  @$n+=1;
	 if($n>1){
	 ?>
									<div class="news-info">
										<a href="<?=base64_decode($row->Url)?>" target="_blank" class="blue-a green-a news-read-more">Leia mais</a>
										<span><?=date('d-m-Y H:m',strtotime($row->DateCreate))?> </span> - <?=$row->Title?>
									</div>
									
	 <? } } ?>
								</div><!-- tab -->
  </div>
  
 <? }else{echo 'ERROR Ajax';    }?>
  
 