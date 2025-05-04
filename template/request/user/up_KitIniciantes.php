<?php

require("../../../web_conexao/init.php");
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
Deslogado();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}

if($_SESSION['my_login']){
	
	 echo '<script>console.log( swal("Sorry!", "System under construction.", "info") );</script>';
	 exit();
}
$xn_kits = @$db->query("select * from MWeb.dbo.cabal_Kit_iniciante WHERE UserNum='".$result_conta->UserNum."'")->fetchObject();
$xn_kits_count = @$db->query("select count(*) from MWeb.dbo.cabal_Kit_iniciante WHERE UserNum='".$result_conta->UserNum."'")->fetchColumn();

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
    background: #1a1d22;
    box-shadow: 14px 14px 43px -17px rgba(0, 0, 0, 0.7);
    color: #fff;
		
} 
.kit:hover{
	padding-left;30px;
}
</style>
 <div style="height:60px;"></div>
<div style="line-height:1.3;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Notes</b>:<br>

      - You can only receive a kit on account<br>

      - We've added the starter kit to help newcomers to the server<br>
      
      - once you use the system, it cannot be undone.<br>

      - Your selected character must be <font color="red"><u>OFFLINE</u></font><br>
	  </div>
	  <div style="height:20px;"></div>

  <div id="" name="" style="">

    <div class="ntext" align="justify">
	  
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #1a1d22; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Open gift for:</strong></td>
<td class="boss_title" align="center" width="72"><strong>Delivery date:</strong></td>
	
<?
  if($xn_kits_count==0){
	  
	  $text="you haven't received your starter kit yet";
	  echo '<tr  align="center">
  <td height="18" colspan="5" align="center" class="boss_title">'.$text.'</td>
  </tr>
';
	  
	  
  }else{

?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center">
<? 
		switch($xn_kits->Kit){

	case 1 : // Warrior
	
		echo "<font color='#00FF00'>Warrior</font>";
		
	break;
		
		
	case 2 : //Force Shielder
	
		echo "<font color='#00FF00'>Force Shielder</font>";
	
	break;
	
	
	case 3 : //Force Blader
	
		echo "<font color='#00FF00'>Force Blader</font>";
	
	break;
	
	case 4 : //Force Archer
	
		echo "<font color='#00FF00'>Force Archer</font>";
	
	break;
	
	case 5 : //Wizard
	
		echo "<font color='#00FF00'>Wizard</font>";
	
	break;
	
	case 6 : //Blader
	
		echo "<font color='#00FF00'>Blader</font>";
	
	break;
	
		case 'No One' :
		
		echo "<font color='#FF0000'>No One</font>";
		
		break;
	
		
		}
		
		?>
</td>
<td class="boss_normal2" align="center"><strong>
<?
		if ($xn_kits->Enviado >= 1){
			
			echo '

      
        <div class="finput" style=" color:#00FF00">'.
		
		date('d/m/Y ',strtotime($xn_kits->DataCriacao))
		
		
		.' at '.
		
		date('H:i:s a ',strtotime($xn_kits->DataCriacao))
		
		
		.'</div>';
			
		}
		
		?>
</strong></td>
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
    margin-bottom: 5px; font-weight:bold;
    font-size: 12px;"><label for="rusername">Select the class you want to receive the kit</label></div>

      <div class="finput" style="">

      

        <select id="kit" name="fcKit" class="kit" style="padding: 12px; text-align: left; height:40px; border-radius:0px; color:#977646; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; width: 100%; margin: 0;">
          <option value="1">Warrior</option>
          <option value="2">Force Shielder</option>
		  <option value="3">Force Blader</option>
          <option value="4">Force Archer</option>
          <option value="5">Wizard</option>
          <option value="6">Blader</option>

        </select>

          </div>

      <div class="clear"></div>

    </div>


   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input style="width:20px;" name="sbmtAddPnt" class="fsubmit" type="button" value="Receber Kit" onclick="new Ajax.Updater('errors', 'template/request/user/up_KitIniciantes.php?action=limparpk', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.limparpk)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='limparpk')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("excuse me", "you have no character to use this system.", "info") );</script>';
			   exit();
		   }
		   
		   $kit = anti_injection(aiRemove(soNumero(AntSQL($_POST["fcKit"]))));
		   
		   $evitar_inject = array('1','2','3','4','5','6');
		   
		   if($xn_kits->Enviado>=1){
			echo    '<script>console.log( swal("excuse me", "Your Starter gift has already been MAX CLAIM!.", "info") );</script>';
			   
		   }elseif($result_conta->Login>=1){
			   			    '<script>console.log( swal("OPS!", "Please log out of your game account to redeem your Starter Gift.", "info") );</script>';

		   }elseif($result_conta->AuthType!=1){
			   			    '<script>console.log( swal("OPS!", "You cannot receive a starter kit because your account is locked out.", "info") );</script>';

		   }elseif(!in_array($kit, $evitar_inject)){
			   			    '<script>console.log( swal("OPS!", "An injection attempt was made, this action has been recorded and will be reviewed by our analyst.", "info") );</script>';
			   
		   }else{
		   
		   try{
				
				$query=$db->prepare("exec CabalCash.dbo.cabal_send_starter_kit :usernum, :kit ");
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->bindParam(':kit', $kit, PDO::PARAM_INT);
				$query->execute();
				}catch(PDOException $exception) {
                  printf('Unable to perform the operation: %s' , $exception);
                 }
		   
          
  
     			   echo '<script>console.log( swal("Congrats!", "Starter Already Sent! Please Check Your Cash Inventory.", "info") );</script>';
		   }


		}




?>
