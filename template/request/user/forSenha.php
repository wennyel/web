<?php

require("../../../web_conexao/init.php");
Deslogado();
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
.Notas {
		color: #FFE92D;
        text-shadow: 0px 0px 10px #FDFB69;	
	font-weight:bold;
	}
</style>


<div class="content-title title-carousel c-title">
		<span class="title">Mudar minha senha</span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Por favor se estiver conectado no servidor deslogue-se e efetue sua redefinição de senha.</li>
</ul>
<form name="mudarSenha" id="mudarSenha">

   <div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Nova senha</label></div>
      <div class="finput" style="">
        <input name="nSenha" type="password" maxlength="15" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">confirmar nova senha</label></div>
      <div class="finput" style="">
        <input name="reSenha" type="password" maxlength="15" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Código de segurança</label></div>
      <div class="finput" style="">
        <input name="Code" type="text" onkeypress="return SomenteNumero(event)" maxlength="8" class="ffield" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>


   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="Solicitar" onclick="new Ajax.Updater('errors', 'template/request/user/forSenha.php?action=mudarSenha', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.mudarSenha)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='mudarSenha')
		{ 
			
			$novaSenha = htmlentities(aiRemove(antiSQL(anti_injection($_POST['nSenha']))));
			
			$reSenha = htmlentities(aiRemove(antiSQL(anti_injection($_POST['reSenha']))));
			
			$Codigo = htmlentities(aiRemove(antiSQL(soNumero(anti_injection($_POST['Code'])))));
			
			
			if(!$novaSenha || !$reSenha || !$Codigo){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "É necessário preencher todos os campos", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d]{4,15}$/i', $novaSenha)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo de nova senha está em formato inválido.", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d]{4,15}$/i', $reSenha)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo confirmar senha está em formato inválido.", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d_]{8}$/i', $Codigo)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo código de segurança está em formato inválido.", "info") );</script>';
			}elseif(!is_numeric($Codigo)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo do código de segurança requer apenas números", "info") );</script>';
			}elseif($novaSenha!=$reSenha){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo nova senha não corresponde o confirmar senha.", "info") );</script>';
			}elseif($result_conta->Chave!=$Codigo){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo Código de segurança está inválido.", "info") );</script>';
			}else{
				
				// Inclui o arquivo class.phpmailer.php localizado na pasta class
require_once("../../../web_conexao/PHPMailer/class.phpmailer.php");
 
// Inicia a classe PHPMailer
$mail = new PHPMailer(true);
 
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
 
try {
     $mail->Host = $caixaPostalServidorEmail; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
     $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = $caixaPostalServidorUser; // Usuário do servidor SMTP (endereço de email)
     $mail->Password = $caixaPostalServidorSenha; // Senha do servidor SMTP (senha do email usado)
     
     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom($caixaPostalEmailFrom, 'MUDAR MINHA SENHA'); //Seu e-mail
     $mail->AddReplyTo('noreply@cabalicore.top', 'Nome'); //Seu e-mail
     $mail->Subject = 'CABAL iCore - Honra e Gloria';//Assunto do e-mail que receberá
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress($result_conta->Email, utf8_decode('ALTERAÇÃO DE SENHA - CABAL iCORE'));
 
     //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
    $inf = $db->query("select * from ACCOUNT.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
    $exibir_ip = $_SERVER["REMOTE_ADDR"];
	switch (date("m")) {
        case "01":    $mes = "Janeiro";     break;
        case "02":    $mes = "Fevereiro";   break;
        case "03":    $mes = "Março";       break;
        case "04":    $mes = "Abril";       break;
        case "05":    $mes = "Maio";        break;
        case "06":    $mes = "Junho";       break;
        case "07":    $mes = "Julho";       break;
        case "08":    $mes = "Agosto";      break;
        case "09":    $mes = "Setembro";    break;
        case "10":    $mes = "Outubro";     break;
        case "11":    $mes = "Novembro";    break;
        case "12":    $mes = "Dezembro";    break; 
 }    
	$strCode = "AaBbCcDdEeFf1234567890ghijlm";
                $keyCode = str_shuffle($strCode);
	   
     //Define o corpo do email
     $mail->MsgHTML(utf8_decode('<table border="0" width="620" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td bgcolor="#F0F0F0">
<table border="0" width="578" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td height="16">&nbsp;</td>
</tr>
<tr>
<td><img class="CToWUd" src="https://lh5.googleusercontent.com/x1lMYn8iNkBNpEqo7bunezj9Zpd7QCnAXdtyKH23hQnv13nPPFnKGzqg6m5ZqzQVj85026USGQRaQ06aAR_I=w1366-h609" /></td>
</tr>
<tr>
<td height="16">&nbsp;</td>
</tr>
<tr>
<td align="left" bgcolor="#FFFFFF">
<div style="border: 1px solid #cccccc;">
<table border="0" style="background:url(https://lh4.googleusercontent.com/smcm9WyVwlpzTirvr5QxgrbGA06xR7gN__MbmH4ZD0mj7_RtdPbLxNvNhAnPV32iZkBKWhujst5Xi9dY6SY8=w1366-h609-rw) no-repeat 370px 0px; " width="578" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td colspan="3" height="22">&nbsp;</td>
</tr>
<tr>
<td width="40">&nbsp;</td>
<td width="498">
<div style="font-family: arial,Arial,sans-serif;">
<div style="font-family: arial,Arial,sans-serif;">
<p>Ol&aacute;, '.$inf->Nome.'</p>
<p>Houve uma possivel mudan&ccedil;a de senha em sua conta, caso voc&ecirc; tenha efetuado essa a&ccedil;&atilde;o desconsidere esta mensagem.</p>
<p><strong>Informa&ccedil;&atilde;o da a&ccedil;&atilde;o:</strong></p>
</div>
</div>
<ul>
<li>Usu&aacute;rio: '.$inf->ID.' </li>
<li>Endere&ccedil;o de IP: '.$exibir_ip.'</li>
<li>Data: dia '.date('d').' de '.$mes.' de '.date('Y').' &agrave;s '.date('H:i A').'</li>
</ul>
<div style="font-family: arial,Arial,sans-serif;">
<ul style="list-style: none; margin-left:-50px !important;">
<li>Se n&atilde;o foi voc&ecirc; que efetuou essa mudan&ccedil;a efetue o bloqueio agora mesmo de sua conta e entre em contato com o administrador.</li>
</ul>
<p style="margin-left: 35px;"><a href="https://'.$_SERVER['SERVER_NAME'].'/index.php?auth=true&b='.$keyCode.'" target="_blank" rel="noopener"> <button style="display: inline-block; height: 28px; border: solid 1px #d8d8d8; padding: 5px 10px; outline: 0; background-color: #2793e6; font-weight: bold; font-size: 11px; color: #ffffff; text-decoration: none; white-space: nowrap; word-wrap: normal; line-height: normal; vertical-align: middle; border-radius: 2px; border-color: #1b7fcc;" type="button">bloquear minha conta agora!</button> </a></p>
<div>
<p><strong>O que pode ter ocorrido?</strong><br /> Voc&ecirc; pode ter fornecido seus dados a algu&eacute;m que se diz ser seu amigo, ou voc&ecirc; pode t&ecirc; deixado seus dados salvos como senha no navegador onde voc&ecirc; utilizou o painel de usu&aacute;rio.</p>
<p>Mensagem criado no intuito de ajudar a impedi esses acontecimentos.</p>
<p>- Equipe Cabal iCore</p>
</div>
</div>
</td>
<td width="40">&nbsp;</td>
</tr>
<tr>
<td colspan="3" height="22">&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td height="16">&nbsp;</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td width="40">&nbsp;</td>
<td width="498">
<div style="font-family: arial,Arial,sans-serif; font-size: 11px; color: #999999; line-height: 14px;"><a style="text-decoration: none; color: #1c62b9;" href="https://www.facebook.com/Cabal.iCore/" target="_blank" rel="noopener">Central de Ajuda</a> &bull; <a style="text-decoration: none; color: #1c62b9;" title="CABAL Online - iCore Honra e Gl&oacute;ria" href="https://cabalicore.top/">Visite nosso site</a></div>
</td>
<td width="40">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="16">&nbsp;</td>
</tr>
<tr>
<td align="left">
<table border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td width="40">&nbsp;</td>
<td width="498">
<div style="font-family: arial,Arial,sans-serif; font-size: 11px; color: #999999; line-height: 13px;">&copy;2017 - 2018 Todos os direitos reservados pelos seus respectivos propriet&aacute;rios. N&atilde;o somos de forma alguma afiliada / associada / associada &agrave; ESTSoft Corp.</div>
</td>
<td width="40">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="22">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>')); 
 
     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
 
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
				
				
				
				try{
				$query=Database::conexao()->prepare("exec MWeb.dbo.cabal_m_novaSenha :novaSenha,:usernum,:keycode");
				$query->bindParam(':novaSenha', $novaSenha, PDO::PARAM_STR);
				$query->bindParam(':usernum', $result_conta->UserNum, PDO::PARAM_INT);
				$query->bindParam(':keycode', $keyCode, PDO::PARAM_STR);
				$query->execute();
				}catch(PDOException  $er ){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Falha na conexão!", "Houve problemas na conexão com o banco de dados.", "error") );</script>';
				}

			echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Sua nova senha foi alterada com sucesso, por motivos de segurança foi enviado uma alerta para seu e-mail cadastrado.", "success") );</script>';
				exit();
				
			}
		}elseif($action!="" AND $action!="mudarSenha"){
			
			
			header("Location: ../");
			
		}






?>
