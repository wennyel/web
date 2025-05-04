<?php

require("../../../web_conexao/init.php");

Deslogado();
$nAtivar = 0; // Valor 0 = Desativado e 1 é igual ativado.c
if($nAtivar==0){
echo '<script>console.log( swal("Desculpe!"", "O Sistema de escolher nação está desabilitado pela administração.", "info") );</script>';
	exit();
	
}

//CONFIGURAÇÃO DO SISTEMA DE MUDAR NAÇÃO//

$valor_m_cash = "1000"; // Quanto será o valor em cash cobrado pelo sistema//
$valor_m_alz  = "10000000"; // Quanto será o valor em alz cobrado para os personagem que tiver nação neutra.
	
$level_m_troca_nation = "100"; //Qual o level minimo para quem quer trocar de nação
$level_m_add_nation   = "90"; // QUal o level minimo para quem quer adicionar nação pela primeira vez
try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}

 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
	

?>




 <div class="content-title title-carousel c-title">
		<span class="title">Escolha uma nação</span>
</div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

      <b>Requisitos</b>:<br>

      - Você tem direito a 1 nação por char.<br>
		
	  - Para alterar sua nação será cobrado uma taxa em Cash.<br>

      - Seu personagem selecionado deve estar no nível <font color="#FFFF00"><u>100</u></font> ou acima.<br>

      - Seu personagem selecionado deve ter no minimo <font color="#FFFF00"><u><?=number_format($valor_m_cash)?></u></font> <img src="images/pc.png">Cash.<br>
		
		- Personagens [S/N] pode adicionar nação por apenas <?=number_format($valor_m_alz)?> Alz.
      <br>

      <b>Notas</b>:<br>

      - Com este sistema não há necessidade de fazer quest.<br>
	  - Seu personagem poderá escolher apenas a nação que estiver em indice baixo nas estátisticas. <br>
	  - Seu personagem deve estar <font color="#FF0000"><u>OFFLINE</u></font> para obter sua nação.<br>

    </div>

   </div>
	<?php
			//count nation - statisticas //
			
$procyon_count = $db->query("select count(*) from Server01.dbo.cabal_character_table where Nation=2")->fetchColumn();
$capella_count = $db->query("select count(*) from Server01.dbo.cabal_character_table where Nation=1")->fetchColumn();
			
$total_nation = $procyon_count + $capella_count;
$total_procyon = $procyon_count;
$total_capella = $capella_count;
$soma_final_procyon =  $total_procyon / $total_nation * 100;
$soma_final_capella =  $total_capella / $total_nation * 100;
			
			?>
	<div style="width:100%; padding-top:26px;padding-bottom:15px;">
		<div style="float:left;"><img src="images/capella1.png" width="180"></div>
		<div style="float:left;margin-left: 39px;margin-top: 67px;">
<font style="font-size: 37px;color: #1e5dcd;font-weight: bold;font-family: Candara;margin-left: -40px; text-shadow: 0px 0px 10px #054c94;"><?=round($soma_final_capella)?>%</font> 
			
			<font style="font-size: 15px; font-weight: bold; font-family: Candara,Arial; margin-left: 20px; margin-top: 106px;">VS</font> 
			
			<font style="font-size: 37px;font-weight: bold;color: #a53331;font-family: Candara;margin-left: 18px; text-shadow: 0px 0px 10px rgba(189, 34, 26, 0.72);"><?=round($soma_final_procyon)?>%</font> </div>
		<div style="float:right;"><img src="images/procyon2.png" width="180"></div>
	</div>


<form name="addnation" id="addnation" style="width:100%;">

 
<div><div>
      
	<p style="margin-top: 167px;
    font-weight: bold;
    font-size: 14px;
    font-family: Candara;">selecione seu personagem</p>
       <select name="personagem" class="ffield" style="width:100%; margin-top:-6px; color: #5b757b; font-family: Candara,Arial;">
<?php 
				try{
$stmtC = $db->prepare("select * from Server01.dbo.cabal_character_table where CharacterIdx/8=:usernum");
$stmtC->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
$stmtC->execute(); 
$resultC = $stmtC->fetchAll();
}catch(PDOException  $er ){
echo "Error: ".$er;
}
			//$resumo_char = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."' AND Nation < 3");
			
			
			foreach($resultC as $result_personagens){
				
		switch($result_personagens['Nation']){
						
		  case 0 : echo "<option value=".$result_personagens['CharacterIdx'].">".$result_personagens['Name']."&nbsp;[Nação: S/N]"."&nbsp;--&nbsp;[Dinheiro: ".number_format($result_personagem['Alz'])."]"."&nbsp;--&nbsp;[LEV: ".$result_personagens['LEV']."]"."</option>";  break;
		  case 1 : echo "<option value=".$result_personagens['CharacterIdx'].">".$result_personagens['Name']."&nbsp;[Nação: Capella]"."&nbsp;--&nbsp;[LEV: ".$result_personagens['LEV']."]"."</option>";  break;
		  case 2 : echo "<option value=".$result_personagens['CharacterIdx'].">".$result_personagens['Name']."&nbsp;[Nação: Procyon]"."&nbsp;--&nbsp;[LEV: ".$result_personagens['LEV']."]"."</option>";  break;
		  case 3 : echo "<option value=".$result_personagens['CharacterIdx'].">".$result_personagens['Name']."&nbsp;[Nação: GM]"."&nbsp;--&nbsp;[LEV: ".$result_personagens['LEV']."]"."</option>";  break;
						
				}
				
		}
				?>
      

        </select> 

          </div>

      <div class="clear"></div>

    </div>
	
	
   

    


    <div class="flabel" style="">

      <div class="fitem" style="margin-bottom:3px; margin-top:10px; font-size:14px; font-weight:bold;"><label for="rusername">Selecione a nação desejada:</label></div>

      <div class="finput" style="">

         <select name="nation" class="ffield" style="width:40%; color: #5b757b; font-family: Candara,Arial;">
			 <option value="1">Capella</option>
			 <option value="2">Procyon</option>
		  </select>

          </div>

      <div class="clear"></div>

    </div>

   

    <div class="flabel" style="text-align: center; margin-top:15px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ADICIONAR" onclick="new Ajax.Updater('errors', 'template/request/user/get_nation_selection.php?action=NationAdd', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.addnation)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='NationAdd')
		{ 
           if($contar_personagem==0){
			   
			   echo '<script>console.log( swal("Desculpe!", "você não possui personagem para utilizar esse sistema.", "info") );</script>';
			   exit();
		   }
		   
           $personagem = antiSQL(soNumero(anti_injection($_POST['personagem'])));
		   $nation     = antiSQL(soNumero(anti_injection($_POST['nation'])));
			
$procyon_count = $db->query("select count(*) from Server01.dbo.cabal_character_table where Nation=2")->fetchColumn();
$capella_count = $db->query("select count(*) from Server01.dbo.cabal_character_table where Nation=1")->fetchColumn();
			
$total_nation = $procyon_count + $capella_count;
$total_procyon = $procyon_count;
$total_capella = $capella_count;
$soma_final_procyon =  round($total_procyon / $total_nation * 100);
$soma_final_capella =  round($total_capella / $total_nation * 100);
			
		    if($personagem == "") { $personagme = 0;}
			if($nation     == "") { $nation     = 0;}
			
			if($soma_final_procyon > $soma_final_capella){ $per_m_ocupacao = 2; }
			if($soma_final_capella > $soma_final_procyon){ $per_m_ocupacao = 1; }
			
	$cash_account = $db->query("select * from CabalCash.dbo.CashAccount where UserNum='".$result_conta->UserNum."' AND ID='".$_SESSION['my_login']."'")->fetchObject();
		
		$end_personagem = $db->query("select * from Server01.dbo.cabal_character_table where CharacterIdx='".$personagem."'")->fetchObject();
	    $count_table_cash = $db->query("select count(*) from CabalCash.dbo.CashAccount where UserNum='".$result_conta->UserNum."' AND ID='".$_SESSION['my_login']."'")->fetchColumn();
	if($end_personagem->Nation >=1){
			
			if(!$personagem || !$nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif($nation_web == 0){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("DESATIVADO!", "o sistema na qual deseja utilizar está desativado.", "info") );</script>';
			}elseif($contar_personagem == 0){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Negativo!", "Você não usar o sistema pois não possui personagem na conta..", "info") );</script>';
			}elseif($per_m_ocupacao == $nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "As Porcentagem indicam que CAPELLA tem maior quantidade, por isso não é possivel adicionar a nação selecionada.", "info") );</script>';
			}elseif($count_table_cash==0){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "Ocorreu uma falha no banco de dados, parece que não existe registro de sua conta no banco de Cash.", "info") );</script>';
			}elseif($nation < 1 AND $nation > 2){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif(!is_numeric($personagem)){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif(!is_numeric($nation)){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif($valor_m_cash > $cash_account->Cash){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Sem Saldo!", "Você não possui cash suficiente para adicionar sua nação", "info") );</script>';
			}elseif($cash_account->Cash <= 0){
		$db->query("UPDATE CabalCash.dbo.CashAccount set Cash=0 where UserNum='".$result_conta->UserNum."' AND ID='".$_SESSION['my_login']."'");
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Cash Zerado!", "Você não possui Cash para efetua a mudança de nação", "info") );</script>';
			}elseif($end_personagem->Login >=1){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "você precisa está OFFLINE do seu personagem para adicionar uma nação.", "info") );</script>';
			}elseif($result_conta->Login){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "você precisa está OFFLINE da conta para adicionar uma nação.", "info") );</script>';
			}elseif($end_personagem->Nation == $nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "Você já possui a nação selecionada.", "info") );</script>';
			}elseif(!$_SESSION['my_login']){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "Sua sessão no painel expirou efetue o login novamente.", "info") );</script>';
			}elseif($end_personagem->LEV < $level_m_troca_nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "Você precisa está no minimo LEV '.$level_m_troca_nation.'.", "info") );</script>';	
			}else{
			
				
				try{
			$sql = "EXEC MWeb.dbo.cabal_m_nation_alter :nation, :nationAntes, :cash, :usernum, :idxchar";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':nation', $nation, PDO::PARAM_STR);
			$sth->bindParam(':nationAntes', $end_personagem->Nation, PDO::PARAM_STR);
			$sth->bindParam(':cash', $valor_m_cash, PDO::PARAM_STR); // COLOCAR O VALOR DE CASH NA PROCEDURE //
			$sth->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_STR);
			$sth->bindParam(':idxchar', $personagem, PDO::PARAM_STR);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				
   
           switch($nation){
				   
			   case 1 : 
				echo '<script type="text/javascript">document.addnation.reset();</script>';
			    echo '<script>console.log( swal("Obrigado!", "'.$end_personagem->Name.' sua nação foi adicionado, agora você faz parte do clân [CAPELLA].", "success") );</script>';  
				   
			   break;
				   
			   case 2 : 
				echo '<script type="text/javascript">document.addnation.reset();</script>';
			    echo '<script>console.log( swal("Obrigado!", "'.$end_personagem->Name.' sua nação foi adicionado, agora você faz parte do clân [PROCYON].", "success") );</script>';    
				 
			   break;
	
		   } //end switch
				unset($sql);
				unset($sth);
			    unset($db);
				$sql = null;
				$sth = null;
				$db  = null;
				exit();
			}
		
	}elseif($end_personagem->Nation == 0){
		
		if(!$personagem || !$nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif($end_personagem->Login){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe"", "é necessário deslogar da sua conta para continuar.", "infor") );</script>';
		   }elseif(!$_SESSION['my_login']){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe"", "sua sessão expirou entre no painel de usuário novamente.", "infor") );</script>';
		}elseif(!is_numeric($personagem)){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif(!is_numeric($nation)){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Tentativa de invasão", "burlar sistemas é crime, essa ação foi registrada.", "error") );</script>';
			}elseif($end_personagem->Alz < $valor_m_alz){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe!", "você precisa ter no minimo '.number_format($valor_m_alz).' de Alzs, para adicionar uma nação.", "info") );</script>';
			}elseif($end_personagem->LEV < $level_m_add_nation){
			echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("Desculpe"", "Desculpe, Você precisa ter no minimo LEV '.$level_m_add_nation.'.", "infor") );</script>';
		}else{
			
				
				try{
			$sql = "EXEC MWeb.dbo.cabal_m_nation_alter :nation, :nationAntes, :cash, :usernum, :idxchar";
			$sth = Database::conexao()->prepare($sql);
			$sth->bindParam(':nation', $nation, PDO::PARAM_STR);
			$sth->bindParam(':nationAntes', $end_personagem->Nation, PDO::PARAM_STR);
			$sth->bindParam(':cash', $valor_m_cash, PDO::PARAM_STR); // COLOCAR O VALOR DE CASH NA PROCEDURE //
			$sth->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_STR);
			$sth->bindParam(':idxchar', $personagem, PDO::PARAM_STR);
			$sth->execute();			
			}catch(PDOException $e) { echo 'OPS! Error'.$e; }
				
   
           switch($nation){
				   
			   case 1 : 
		    echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("OBriGadOo!"", "'.$end_personagem->Name.' sua nação foi adicionado, agora você faz parte do clân [CAPELLA].", "success") );</script>';
				
			   break;
				   
			   case 2 : 
			 echo '<script type="text/javascript">document.addnation.reset();</script>';
			echo '<script>console.log( swal("OBriGadOo!"", "'.$end_personagem->Name.' sua nação foi adicionado, agora você faz parte do clân [Procyon].", "success") );</script>';
			   break;
	
		   } //end switch
				unset($sql);
				unset($sth);
			    unset($db);
				$sql = null;
				$sth = null;
				$db  = null;
				exit();
			}
		
	}
		
	

     


		}






?>
