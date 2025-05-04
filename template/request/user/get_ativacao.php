<?php

require("../../../web_conexao/init.php");
Deslogado();


 $action		=	antiSQL(anti_injection(isset($_GET["action"]))) ? antiSQL(anti_injection($_GET["action"])) : '';
 
		if($action==""){
	

?>




  <div id="plink">

<div style="position:relative;z-index:0">          
          <a href="./">Home</a> - <a href="#">Ativação de conta</a></div></div>

  <div  style="clear:right;"></div>

<div id="fbody" class="fbody">

  <div style="">

    <div class="fdesc">

      <b>OBSERVAÇÃO</b>:<br>

       - Após ter efetuado o cadastro em nosso site, foi enviado um e-mail contendo as informações necessárias de sua conta contendo também o código de ativação de conta, verifique a caixa de ENTRADA ou a caixa de SPAM de seu e-mail cadastrado.

      <br> 

     </div>

   </div>



<form name="ativar" id="ativar">

   

   
    

    <div class="flabel" style="">

      <div class="fitem" style=""><label for="rusername">Digite o codigo de ativação</label></div>

      <div class="finput" style="">

        <input name="codigo" class="ffield">

          </div>

      <div class="clear"></div>

    </div>

   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ATIVAR" onclick="new Ajax.Updater('errors', 'template/request/user/get_ativacao.php?action=ativacao', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.ativar)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='ativacao')
		{ 
           
		   
           $Codigo = antiSQL(anti_injection($_POST['codigo']));
			$conta_logada = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
			$varCode = $db->query("select count(*) from MWeb.dbo.cabal_m_ativacao_conta where UserNum='".$conta_logada->UserNum."' Codigo = '".$Codigo."' ")->fetchColumn();
			$ObjectAt = $db->query("select * from MWeb.dbo.cabal_m_ativacao_conta where UserNum='".$conta_logada->UserNum."' Codigo = '".$Codigo."' ")->fetchObject();
		   
			if(!$Codigo){
				echo '<script type="text/javascript">
document.ativar.reset();
</script><div class=\'ferrorbig\'>favor preencha o campo código</div>';
			}elseif(!preg_match('/^[a-z\d_]{5,32}$/i', $Codigo)){
				echo '<script type="text/javascript">
document.ativar.reset();
</script><div class=\'ferrorbig\'>O Campo código está inválido.</div>';
			}elseif($varCode<=0){
				echo '<script type="text/javascript">
document.ativar.reset();
</script><div class=\'ferrorbig\'>Desculpe! O código digitado é inválido.</div>';
			}elseif($ObjectAt->Ativacao=='sim'){
				echo '<script type="text/javascript">
document.ativar.reset();
</script><div class=\'ferrorbig\'>Desculpe! esté código já foi utilizado.</div>';
			}else{
				
				$db->query("UPDATE Account.dbo.cabal_auth_table set AuthType=1 where UserNum='".$ObjectAt->UserNum."'");
				$db->query("UPDATE MWeb.dbo.cabal_m_ativacao_conta set Ativacao='sim' where UserNum='".$ObjectAt->UserNum."' AND Codigo = '".$Codigo."'");
				
			echo '<script type="text/javascript">
document.ativar.reset();
</script><div class=\'ferrorbig\'>Sua conta foi ativada com sucesso!</div>';	
			}
     


		}






?>
