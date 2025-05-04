<?  require("../../web_conexao/init.php"); ?>
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
		<span class="title">Faça o download do cliente ou patchs</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

        <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

       Escolha uma das opçoes desejada abaixo e efetue o download do cliente ou patch oficial cabal icore.

		
		<div class="nbody nbody_N">

  <div class="nbar nbar_N" onclick=" ">
    <div style="padding: 5px; 0px;">

      <div class="ndate" style="float: left;"></div>
      <div class="clear"></div>

  </div>

  </div>
<div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px; margin-bottom:7px; border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;URL DISPONIVEIS:

     

      <div class="clear"></div>

    </div>

  <div id="" name="" style="margin-bottom:20px;">

    <div class="ntext" align="justify">
	  
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Titulo</strong></td>
<td class="boss_title" align="center" width="72"><strong>Servidor</strong></td>
<td class="boss_title" align="center" width="65"><strong>Update</strong></td>
<td class="boss_title" align="center" width="80"><strong>opção</strong></td>
</tr>
	
<?
try{
	$val = 1;
$stmtC = $db->prepare("SELECT * FROM MWeb.dbo.cabal_url_download WHERE id>=:id order by UpdateDate desc");
$stmtC->bindParam(':id', $val, PDO::PARAM_INT);
$stmtC->execute(); 
$download = $stmtC->fetchAll();
$getCount = $stmtC->rowCount();
}catch(PDOException  $er ){ echo "Error: ".$er; exit();}

if($getCount==0){
	
	echo ' <tr>
    <td colspan="5" style="padding-top:4px; padding-bottom:4px; text-align:center;">Não existe links para efetuar o download do jogo.</td>
  </tr>';
	
}else{

			 foreach($download as $rows){
		
		
?>


	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$rows['Title']?></td>
<td class="boss_normal2" align="center"><strong><?
			switch($rows['Servidor']){
			case 1 : echo 'Mega'; break;
			case 2 : echo 'Mediafire'; break;
		    case 3 : echo 'GoogleDriver'; break;
		    case 4 : echo '4Shared'; break;
		    case 5 : echo 'Utorrent'; break;	
		    case 6 : echo 'OneDriver'; break;
		}
			
			?></strong></td>
<td class="boss_normal2" align="center"><?=date('d-m-Y',strtotime($rows['UpdateDate']))?></td>
<td class="boss_normal2" align="center"><a href="<?=base64_decode($rows['URL_encode']);?>" class="blue-a profile-button">Baixar</a></td>
</tr>

     <? } } ?>

</tbody></table>



  

    </div>



    </div>

  </div>

     </div>

   </div>





<div id="errors" name="errors"></div>

</div>
