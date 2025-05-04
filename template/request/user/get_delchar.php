<?php

require("../../../web_conexao/init.php");

#################################
#### CUSTO PRA DELETAR CHAR #####
$custDel = "2000"; // 2k de cash
#################################

Deslogado();

try{
$retC = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:iD");
$retC->bindParam(':iD', $_SESSION['my_login'], PDO::PARAM_STR);
$retC->execute(); 
$result_conta = $retC->fetchObject();
}catch(PDOException  $er ){
echo "Error: ".$er;
}

try{
$stmtCount = $db->prepare("SELECT count(*) FROM server01.dbo.cabal_character_table where CharacterIdx/8=:UserNum");
$stmtCount->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
$stmtCount->execute(); 
$contar_personagem = $stmtCount->fetchColumn();
}catch(PDOException  $er ){
echo "Error: ".$er;
}


 $action		=	aiRemove(antiSQL(anti_injection(isset($_GET["action"])))) ? aiRemove(antiSQL(anti_injection($_GET["action"]))) : '';
 
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
    background: #091f2f;
    box-shadow: 14px 14px 43px -17px rgba(0, 0, 0, 0.7);
    color: #fff;
		
} 
</style>



  <div class="content-title title-carousel c-title">
		<span class="title">Eliminar personagem</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

        <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

      - Seu personagem será deletado definitivamente.<br>

      - Não nós responsabilizamos por qualquer decisão tomada.<br>
      
      - selecione o personagem na qual deseja deletar.<br>

      - Você deve está <font color="red"><u>OFFLINE</u></font> totalmente da sua conta.<br>
		
	  - A restauração é cobrada um valor de 15k de cash<br>
		 
	  - Para deletar seu personagem é necessário ter no minimo 2k de cash<br>

		
		<div class="nbody nbody_N">

  <div class="nbar nbar_N" onclick=" ">
    <div style="padding: 5px; 0px;">

      <div class="ndate" style="float: left;"></div>
      <div class="clear"></div>

  </div>

  </div>
<div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px; margin-bottom:7px; border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;Personagem deletados:

     

      <div class="clear"></div>

    </div>

  <div id="" name="" style="">

    <div class="ntext" align="justify">
	  
	  <table id="fbody" class="fbody" style="margin-top: 0;" border="0" width="100%" cellspacing="1" cellpadding="3" align="center">
<tbody>
<tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;" align="center">
<td class="boss_title" align="center" width="22" height="18"><strong>#</strong></td>
<td style="" align="center" width="120"><strong>Personagem</strong></td>
<td class="boss_title" align="center" width="72"><strong>Level</strong></td>
<td class="boss_title" align="center" width="65"><strong>Data</strong></td>
<td class="boss_title" align="center" width="80"><strong>opção</strong></td>
</tr>
	

  <?php //FAZ A LISTAGEM DE CHARACTER DELETED//
			try{
$stmtC = $db->prepare("select * from server01.dbo.DELETED_CABAL_CHARACTER_TABLE where CharacterIdx/8=:UserNumC order by deleted desc");
$stmtC->bindParam(':UserNumC', $result_conta->UserNum, PDO::PARAM_INT);
$stmtC->execute(); 
$userCash = $stmtC->fetchAll();
}catch(PDOException  $er ){
echo "Error: ".$er;
}
			 foreach($userCash as $row){
		
			
			?>

	<tr class="news-lists" align="center">
<td class="boss_normal2" align="center" height="10">#</td>
<td class="" style="padding-left: 10px;" align="center"><?=$row['Name']?></td>
<td class="boss_normal2" align="center"><strong><?=$row['LEV']?></strong></td>
<td class="boss_normal2" align="center"><?=date('d-m-Y H:m', strtotime($row['deleted']))?></td>
<td class="boss_normal2" align="center"><a href="#" class="blue-a profile-button">restaurar</a></td>
</tr>
<? } ?>
     

</tbody></table>



  

    </div>



    </div>

  </div>

     </div>

   </div>



<form name="delchar" id="delchar">

   <div class="flabel" style="">

      <div class="fitem" style="margin-top: 12px;
    margin-bottom: 5px; font-weight:bold;"><label for="rusername">Selecione seu personagem</label></div>

      <div class="finput" style="">

      

       <select name="personagem" class="ffield" style="width:100%; color:#5b757b; font-family:Candara,Arial;">
<?php 
			$resumo_char = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."' AND Nation < 3");
			
			while($result_personagens = $resumo_char->fetch(PDO::FETCH_OBJ)){
				
					
				echo "<option value=".$result_personagens->CharacterIdx.">".$result_personagens->Name."&nbsp;-&nbsp;[LEV: ".$result_personagens->LEV."]</option>";
					
		
			}
				?>
      

        </select> 

          </div>

      <div class="clear"></div>

    </div>


   

    <div class="flabel" style="text-align: center; margin-top:8px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="DELETAR" onclick="new Ajax.Updater('errors', 'template/request/user/get_delchar.php?action=delchar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.delchar)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='delchar')
		{ 
			try{
					$stmtC = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE UserNum=:id");
				    $stmtC->bindParam(':id', $result_conta->UserNum, PDO::PARAM_INT);
					$stmtC->execute(); 
					$userCash = $stmtC->fetchObject();
                    }catch(PDOException  $er ){
                       echo "Error: ".$er;
                    }
			
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = aiRemove(antiSQL(soNumero(anti_injection($_POST['personagem']))));
			
		
		
	       $object_personagem = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchObject();
          
			
			if($object_personagem->Login >=1){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Deslogue do seu personagem para efetuar a deletação.", "info") );</script>';
			}elseif($result_conta->Login >=1){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "é necessário deslogar de sua conta para deletar o personagem desejado", "info") );</script>';
			}elseif(!$_SESSION['my_login']){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "sua sessão no painel expirou , conecte-se novamente", "error") );</script>';
			}elseif(!is_numeric($personagem)){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Houve um problema têcnico no sistema, favor notifique o administrador.", "warning") );</script>';
			}elseif($userCash->Cash<=0){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "Você não possui cash em seu saldo", "info") );</script>';
			}elseif($custDel > $userCash->Cash){
				echo '<script type="text/javascript">document.delchar.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "você possui cash insuficiente para deletar personagem", "info") );</script>';
			}else{
			
				
			
				//INSERT LOGS DELETED//
				try{
			$sql = "INSERT INTO MWeb.dbo.cabal_m_delchar_logs (CharacterIdx,UserNum) VALUES (:Character,:UserNum)";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':Character', $personagem, PDO::PARAM_INT);
			$sth->bindParam(':UserNum', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
				//RETIRA O VALOR COBRADO PARA DELETAR CHAR//
				try{
			$sql = "UPDATE CabalCash.dbo.CashAccount SET Cash=Cash-:retirar where UserNum=:userAcc";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':retirar', $custDel, PDO::PARAM_INT);
			$sth->bindParam(':userAcc', $result_conta->UserNum, PDO::PARAM_INT);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; exit(); }
				
				try{
					$query=Database::conexao()->prepare("exec server01.dbo.cabal_sp_delchar :CharacterID");
					$query->bindParam(':CharacterID', $personagem, PDO::PARAM_INT);
                    $query->execute();
}catch(PDOException  $er ){
echo "Error: ".$er;
}
				
		echo '<script>console.log( swal("Excluida!", "Você acaba de deletar ['.$object_personagem->Name.'] de sua conta.", "success") );</script>';
				
	
			
		}
		}
		





?>
