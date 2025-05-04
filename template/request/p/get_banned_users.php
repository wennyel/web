<?
require('../../../web_conexao/init.php');

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
Deslogado();
AdminCP();

try{
$jConta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
}catch(PDOException $e){
	
echo  $e->getMessage();	
}
		if($action==""){
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<form name="addnotice" id="addnotice">
	<div class="content-title title-carousel c-title">
		<span class="title">Bloquear conta por duração de tempo</span>
</div>

  <div style="clear:right;"></div>
	
		
<div class="pass first-pass">
<p>Bloqueado por:</p>
	<select name="autor" id="txtpass"  style="width: 212px;">
		<?
			$chars= $db->query("select * from server01.dbo.cabal_character_table where CharacterIdx/8=96 AND Nation = 3");
						while($row = $chars->fetchObject()){
						
							echo '<option value='.$row->Name.'>'.$row->Name.'</option>';
							
						}
						
						
						?>
	</select>
</div>

<div class="pass" style="margin-left: 92px;">
<p>Nome do jogador:</p>
<input name="jogador" id="txtrepass" type="text" style="width: 209px;">
</div>
		
	<div class="pass first-pass">
<p>Tipo:</p>
<select style="width:212px;" name="duracao" style="margin-bottom:4px;">
		<?
		$durBan = $db->query("select * from MWeb.dbo.cabal_m_table_punicao");	
			while($rows = $durBan->fetchObject()){
				
			echo '<option value='.$rows->Duracao.'>'.$rows->Title_Punicao.'</option>';	
			}
	    ?>
	</select>
</div>	
		
<div class="pass" style="
    margin-left: 92px;
">
<p>pergaminho do perdão?</p>
<select name="pergaminho" style="margin-bottom:4px; width:209px;">
		<option value="1">Negar</option>
		<option value="2s">Permitir</option>
	</select>
</div>

	<p>Descreva o motivo do bloqueio</p>
  <textarea style="margin-bottom: 7px;
    width: 484px;
    height: 85px;" name="descricao"></textarea>
		<br><div style="text-align:center;">
		<input name="sbmtAddPnt" class="fsubmit" type="button" value="BLOQUEAR" onclick="new Ajax.Updater('errors', 'template/request/p/get_banned_users.php?action=bloquear', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addnotice)}); carregando('#errors');">
		</div>
	</form>
	<div id="errors"></div>
	
	<!--Inicio/List de Items logado premiado-->

 <div class="flabel" style="height: 20px;line-height: 20px;margin-top:10px;border: 1px solid #153348;font-weight: bold;">
    &nbsp; &nbsp;Jogadores bloqueados:

     

      <div class="clear"></div>

    </div>

   
	<div id="" name="" style="">
<?php
			$count_items = $db->query("select count(*) from MWeb.dbo.cabal_m_table_banidos")->fetchColumn();
			
			?>
    <div class="ntext" style="padding: 15px 15px 15px 15px;<? if($count_items==0){ echo 'margin-bottom:20px;'; } ?>" align="justify">
     
		
		<table id="fbody" class="fbody" style="margin-top: 0; margin-left:-15px;" width="540" border="0" cellspacing="0" cellpadding="0">
  <tr style="background: #091f2f; border-bottom: 1px dotted #153348; height: 30px;">
    <td width="40" align="center">ID</td>
    <td width="200" align="center">Jogador</td>
    <td width="140" align="center">Motivo</td>
    <td width="160" align="center">BloqueadoPor</td>
    <td width="160" align="center">Desban Em</td>
	 
  </tr>
  
   <?php
		
			$list = $db->query("select * from MWeb.dbo.cabal_m_table_banidos");
			
			if($count_items == 0){
				
			echo '<div style="position:absolute;margin-left: 120px;margin-top: 34px;margin-bottom: 20px;padding-bottom: 20px;">Ainda não existe items no logado premiado.</div>';	
				
			}
			
			while($rows = $list->fetchObject()){
			@$n+=1;
			?>
     <tr class="news-lists">
    <td colspan="5">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
    
      <tr style=" border-bottom: 1px dotted #153348;">
        <td width="40" height="32" align="center"><?=$n?></td>
        <td width="200" height="32" align="center"><?=$rows->NameChar?></td>
        <td width="140" height="32" align="center"><?=$rows->Motivo?></td>
        <td width="160" height="32" align="center"><?=$rows->BloqueadoPor?></td>
        <td width="160" align="center"><? if($rows->Duracao<9999){ echo date('d-m H:m:s', strtotime($rows->DesbloquearEM)); }else{ echo "Permamente"; }?></td>
		 
      </tr>
    </table></td>
  </tr>
   <? } ?>
  
</table>


</div> </div>
<!--End/List de Items logado premiado-->
</body>
</html>


<? }elseif($action=='bloquear')
		{ 
           
		   $autor = htmlentities(antiSQL(anti_injection($_POST['autor'])));
           $jogador = htmlentities(antiSQL(anti_injection($_POST['jogador'])));
		   $duracao        = htmlentities(antiSQL(anti_injection($_POST['duracao'])));
		   $pergaminho        = htmlentities(antiSQL(anti_injection($_POST['pergaminho'])));
		   $descricao        = htmlentities(antiSQL(anti_injection($_POST['descricao'])));
			
		   $get_jogador = $db->query("select * from server01.dbo.cabal_character_table where Name='".$jogador."'")->fetchObject();
			
		   $get_count_char  = $db->query("select count(*) from server01.dbo.cabal_character_table where Name='".$jogador."'")->fetchColumn();
			
			if($get_count_char>=1){
		   $get_account = $db->query("select * from account.dbo.cabal_auth_table where UserNum='".$get_jogador->CharacterIdx."'/8")->fetchObject();	
			}
			$evitar_inject = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','INSERT','INTO','DROP','DELETE','UPDATER','WHERE','FROM','insert','into','drop','from','delete','updater','where','hack','sony','machine','cabal','pirata','nexus','lotus','');
			
			if(!$autor || !$jogador || !$duracao || !$pergaminho || !$descricao){
			    echo '<script>console.log( swal("AVISO!", "é necessário preencher todos os campos,'.$autor.'", "info") );</script>';
			}elseif($get_count_char==0){
	            echo '<script>console.log( swal("AVISO!", "Não encontramos jogador com o nome digitado, verifique e tente novamente.", "info") );</script>';
            }elseif($get_jogador->Nation==3){
	            echo '<script>console.log( swal("AVISO!", "Você não pode bloquear um membro da EQUIPE.", "info") );</script>';
            }elseif($jConta->UserNum==$get_account->UserNum){
	            echo '<script>console.log( swal("AVISO!", "Você não pode bloquear sua própria conta.", "info") );</script>';
            }elseif($get_account->AuthType>=2){
	            echo '<script>console.log( swal("AVISO!", "Está conta já se encontra bloqueada.", "info") );</script>';
            }elseif(in_array($autor, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo Autor tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($duracao, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo Duracao tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($pergaminho, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo Pergaminho tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }elseif(in_array($descricao, $evitar_inject)){
	            echo '<script>console.log( swal("AVISO!", "o campo Descrição tem palavras semelhantes a execuções de inject, verifique e tente novamente.", "info") );</script>';
            }else{
				$new_date				=	date('Y-m-d H:i:s.B', strtotime('+'.$duracao.' hour'));
				
				
try{
	
       $stmte = $db->prepare("INSERT INTO MWeb.dbo.cabal_m_table_banidos(UserNum,NameChar,BloqueadoPor,RegDate,DesbloquearEM,Motivo,Pergaminho,Duracao) VALUES (:usernum,:namechar, :bloqueadopor, getdate(), '".$new_date."', :motivo, :pergaminho,:duracao)");
       $stmte->bindParam(":usernum", $get_account->UserNum , PDO::PARAM_INT);
       $stmte->bindParam(":namechar", $jogador , PDO::PARAM_STR);
	   $stmte->bindParam(":bloqueadopor", $autor , PDO::PARAM_STR);
	   $stmte->bindParam(":motivo", $descricao , PDO::PARAM_STR);
	   $stmte->bindParam(":pergaminho", $pergaminho , PDO::PARAM_STR);
	$stmte->bindParam(":duracao", $duracao , PDO::PARAM_INT);
       $executa = $stmte->execute();
       if($executa){
		   $db->query("UPDATE Account.dbo.cabal_auth_table set AuthType=2 where UserNum='".$get_account->UserNum."'");
          echo '<script>console.log( swal("BLOQUEIO", "O Jogador '.$jogador.' foi bloqueado com sucesso", "success") );</script>';
       }
       else{
          echo '<script>console.log( swal("Problema", "Houve um problema na inserção de dados", "warning") );</script>';
       }
   }
   catch(PDOException $e){
      echo $e->getMessage();   
   }
				
					
					
					
				
			}

     


		}






?>
