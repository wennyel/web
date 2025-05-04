<?php

require("../../../web_conexao/init.php");

Deslogado();
AdminCP();
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
echo $e;	
}

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
.online {
		color: #7FFF00;
        text-shadow: 0px 0px 10px #ADFF2F;	
	font-weight:bold;
	}
.offline {
		color: #FF0000;
        text-shadow: 0px 0px 10px #FF6347;	
	font-weight:bold;
	}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Pesquisar usuarios</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>favor selecione a forma de pesquisar o usuario.</li>
</ul>
<form name="pesquisar" id="pesquisar">


	
	<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Pesquisar por:</label></div>
<select name="tipo" class="ffield" style="margin-bottom:3px;">
			<option value="1">Endereço de IP</option>
			<option value="2">Nome de usuário</option>
			<option value="3">Nome do personagem</option>
		  </select>
</div>

<div class="pass" style="width:265px !important; margin-left:40px;">
<div class="fitem" style=""><label for="rusername">Digite a informação da pesquisa:</label></div>
 <input name="pesquisa" type="text" maxlength="32" class="ffield" style="margin-bottom:3px; width:100%;">
</div>
	



   

    <div class="flabel" style="text-align: center; margin-top:10px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="pesquisar" onclick="new Ajax.Updater('errors', 'template/request/p/get_search_players.php?action=pesquisar', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.pesquisar)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>




<? }elseif($action=='pesquisar')
		{ 
			
			$tipo = soNumero(antiSQL(anti_injection($_POST['tipo'])));
			$pesquisa = htmlentities(antiSQL(anti_injection($_POST['pesquisa'])));
			
			 if(isset($action)&&!empty($pesquisa))
    {
     
	 switch($tipo){
		 case 1 :
		//Inicio de pesquisa//
		 try {
                        $stmt = $db->prepare("select * from account.dbo.cabal_auth_table where LastIp = :pesquisa");
                        $stmt->bindValue(':pesquisa', $pesquisa,PDO::PARAM_STR);
                        $stmt->execute();
                        $resultado =  $stmt->fetchAll();
			            
                } catch (PDOException $e) {
                        echo $e->getMessage();
                }    
                  
			 
			 
				 if(count($stmt) >=1){
					 echo '<table id="fbody" class="fbody" style="margin-top: 0; margin-left:3px;" width="540" border="0" cellspacing="0" cellpadding="0">
  <tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;">
    <td width="40" align="center">#</td>
    <td width="280" align="center">Endereço de IP</td>
    <td width="140" align="center">Status</td>
    <td width="80" align="center">opção</td>
  </tr>';
			
					foreach($resultado as $row){
			        @$n+=1;
				echo '<tr class="news-lists">
    <td colspan="4">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
    
      <tr style=" border-bottom: 1px dotted #153348;">
        <td width="40" height="32" align="center">'.$n.'</td>
        <td width="280" height="32" align="center">'.$row['LastIp'].'</td>
        <td width="140" height="32" align="center">';
					if($row['Login']==0){ echo '<font class="offline">Offline</font>'; }
						if($row['Login']==1){ echo '<font class="online">Online</font>'; }
							
						echo '</td>
        <td width="80" height="32" align="center"><a onClick="new Ajax.Updater(\'container\', \'template/request/p/get_search_upgrade_result.php?v1='.$row['UserNum'].'&v2='.$row['ID'].'\', {method: \'get\', asynchronous:true, evalScripts:true}); esperar(\'container\'); carregando(); mover(\'#container\');" class="blue-a">Ver</a></td>
      </tr>
    </table></td>
  </tr>';
					 }
					 
					 
					 echo '</table>';
				 }else{
					
				    echo "não existe informações referente a esta pesquisa.";	 
				 }
				 break;

			 
			  case 2 :
		//Inicio de pesquisa//
		 try {
                        $stmt = $db->prepare("select * from ACCOUNT.dbo.cabal_auth_table where ID LIKE :pesquisa");
                        $stmt->bindValue(':pesquisa', '%'.$pesquisa.'%',PDO::PARAM_STR);
                        $stmt->execute();
                        $resultado =  $stmt->fetchAll();
			            
                } catch (PDOException $e) {
                        echo $e->getMessage();
                }    
  
				 if(count($stmt) >=1){
					 echo '<table id="fbody" class="fbody" style="margin-top: 0; margin-left:3px;" width="540" border="0" cellspacing="0" cellpadding="0">
  <tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;">
    <td width="40" align="center">#</td>
    <td width="300" align="center">Nome de usuário</td>
    <td width="140" align="center">Status</td>
    <td width="60" align="center">opção</td>
  </tr>';
					 
					foreach($resultado as $row){
			        @$n+=1;
				echo '<tr class="news-lists">
    <td colspan="4">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
    
      <tr style=" border-bottom: 1px dotted #153348;">
        <td width="40" height="32" align="center">'.$n.'</td>
        <td width="300" height="32" align="center">'.$row['ID'].'</td>
        <td width="140" height="32" align="center">';
					if($row['Login']==0){ echo '<font class="offline">Offline</font>'; }
						if($row['Login']==1){ echo '<font class="online">Online</font>'; }
							
						echo '</td>
        <td width="60" height="32" align="center"><a onClick="new Ajax.Updater(\'container\', \'template/request/p/get_search_upgrade_result.php?v1='.$row['UserNum'].'&v2='.$row['ID'].'\', {method: \'get\', asynchronous:true, evalScripts:true}); esperar(\'container\'); carregando(); mover(\'#container\');" class="blue-a">Ver</a></td>
      </tr>
    </table></td>
  </tr>';
					 }
					 
					 
					 echo '</table>';
				 }else{
				    echo "não existe informações referente a esta pesquisa.";	 
				 }
				 break;
			 
			 
			 case 3 :
		//Inicio de pesquisa//
		 try {
                        $stmt = $db->prepare("select * from server01.dbo.cabal_character_table where Name LIKE :pesquisa");
                        $stmt->bindValue(':pesquisa', '%'.$pesquisa.'%',PDO::PARAM_STR);
                        $stmt->execute();
                        $resultado =  $stmt->fetchAll();
			            
                } catch (PDOException $e) {
                        echo $e->getMessage();
                }    
  
				 if(count($stmt) >=1){
					 echo '<table id="fbody" class="fbody" style="margin-top: 0; margin-left:3px;" width="540" border="0" cellspacing="0" cellpadding="0">
  <tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;">
    <td width="40" align="center">#</td>
    <td width="300" align="center">Personagem</td>
    <td width="140" align="center">Status</td>
    <td width="60" align="center">opção</td>
  </tr>';
					 
					foreach($resultado as $row){
						$usernum = $db->query("select * from Account.dbo.cabal_auth_table where '".$row['CharacterIdx']."'/8=UserNum")->fetchObject();
			        @$n+=1;
				echo '<tr class="news-lists">
    <td colspan="4">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
    
      <tr style=" border-bottom: 1px dotted #153348;">
        <td width="40" height="32" align="center">'.$n.'</td>
        <td width="300" height="32" align="center">'.$row['Name'].'</td>
        <td width="140" height="32" align="center">';
					if($row['Login']==0){ echo '<font class="offline">Offline</font>'; }
						if($row['Login']==1){ echo '<font class="online">Online</font>'; }
							
						echo '</td>
        <td width="60" height="32" align="center"><a onClick="new Ajax.Updater(\'container\', \'template/request/p/get_search_upgrade_result.php?v1='.$usernum->UserNum.'&v2='.$usernum->ID.'\', {method: \'get\', asynchronous:true, evalScripts:true}); esperar(\'container\'); carregando(); mover(\'#container\');" class="blue-a">Ver</a></td>
      </tr>
    </table></td>
  </tr>';
					 }
					 
					 
					 echo '</table>';
				 }else{
				    echo '<script>console.log( swal("Pesquisa!", "Não existe informações referente a está pesquisa.", "info") );</script>'; 
				 }
				 break;
	 }
			 }else{
			 
				  echo "preencha o campo da pesquisa.";
				 
			 }
				 
		
			
		}


		
?>
