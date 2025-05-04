<?php

require("../../web_conexao/init.php");

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
		<span class="title">Recuperar minha senha </span>
</div>
<font class="Notas">Notas:</font><br>
<ul style="margin-bottom:10px;">
	<li>Para identificar a nova senha após recuperar é necessário verificar seu e-mail.</li>
</ul>
<form name="recSenha" id="recSenha">

<div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Sua ID do jogo</label></div>
<input name="ID" id="txtpass" autocomplete="off" type="text" required>
</div>
	
   <div class="pass first-pass">
<div class="fitem" style=""><label for="rusername">Endereço de e-mail</label></div>
<input name="email" id="txtpass" autocomplete="off" type="email" required>
</div>

<div class="pass">
<div class="fitem" style=""><label for="rusername">Código de segurança</label></div>
<input name="chave" id="txtrepass" onkeyup='if (isNaN(this.value)) {this.value = ""}' type="text" required>
</div>
	


    <div class="flabel" style="text-align: center;margin-top:15px;"><input name="sbmtAddPnt" class="fsubmit" type="button" value="ENVIAR" onclick="new Ajax.Updater('errors', 'template/request/recover_password.php?action=recSenha', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.recSenha)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='recSenha')
		{ 
	        $ID = antiSQL(anti_injection($_POST['ID']));		
	 
			$email = antiSQL(anti_injection($_POST['email']));
			
			$chave = antiSQL(anti_injection($_POST['chave']));
		function newPass($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
// Caracteres de cada tipo
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
// Variáveis internas
$retorno = '';
$caracteres = '';
// Agrupamos todos os caracteres que poderão ser utilizados
$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
// Calculamos o total de caracteres possíveis
$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
$rand = mt_rand(1, $len);
// Concatenamos um dos caracteres na variável $retorno
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}
	 $new_senha = newPass();
	   $login_and_email = $db->query("select count(*) from ACCOUNT.dbo.cabal_auth_table where ID='".$ID."' AND Email='".$email."'")->fetchColumn();
	 $conta_object = $db->query("select * from ACCOUNT.dbo.cabal_auth_table where ID='".$ID."' AND Email='".$email."'")->fetchObject();
	   $login = $db->query("select count(*) from ACCOUNT.dbo.cabal_auth_table where ID='".$ID."'")->fetchColumn(); 
	   $login_and_id = $db->query("select count(*) from ACCOUNT.dbo.cabal_auth_table where ID='".$ID."' AND Email='".$email."'")->fetchColumn(); 
	   $check = $db->query("select count(*) from ACCOUNT.dbo.cabal_auth_table where email='".$email."' AND chave='".$chave."'")->fetchColumn();
			
	        if(!$ID || !$email || !$chave){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "É necessário preencher todos os campos", "info") );</script>';
			}elseif(!validaEmail($email)){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Endereço de e-mail está em formato inválido..", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d_]{8}$/i', $chave)){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo código de segurança está em formato inválido.", "info") );</script>';
			}elseif(!is_numeric($chave)){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Campo do código de segurança requer apenas números", "info") );</script>';
			}elseif($check==0){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "E-mail ou código de segurança inválido.", "info") );</script>';
			}elseif($login_and_id==0){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "E-mail não corresponde ao login digitado.", "info") );</script>';
			}elseif($login==0){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "O Login é inválido ou não existe.", "info") );</script>';
			}elseif($login_and_email==0){
				echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Informamos!", "Login ou e-mail não conferem um com o outro", "info") );</script>';
			}else{
				
				// Inclui o arquivo class.phpmailer.php localizado na pasta class
require_once("../../web_conexao/PHPMailer/class.phpmailer.php");
 
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
     $mail->SetFrom($caixaPostalEmailFrom, 'Resgate de senha'); //Seu e-mail
     $mail->AddReplyTo('noreply@cabalicore.top', 'Nome'); //Seu e-mail
     $mail->Subject = 'CABAL iCore - Honra e Gloria';//Assunto do e-mail que receberá
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress($conta_object->Email, utf8_decode('Resgate de senha'));
 
     //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo

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
  <td><font style="position:absolute; z-index:9999; color:#fff; font-size:24px; text-shadow: 0px 0px 10px #FDFB69;	 margin-top:28px; margin-left:15px">RECUPERAÇÃO DE SENHA</font><img class="CToWUd" src="http://naimg.playthisgame.com/br/cabal_new/images/herosub/news.jpg" width="576" height="90" /></td>
</tr>
<tr>
<td height="16">&nbsp;</td>
</tr>
<tr>
<td align="left" bgcolor="#FFFFFF">
<div style="border: 1px solid #cccccc;">
<table style="background: url(\'https://lh4.googleusercontent.com/smcm9WyVwlpzTirvr5QxgrbGA06xR7gN__MbmH4ZD0mj7_RtdPbLxNvNhAnPV32iZkBKWhujst5Xi9dY6SY8=w1366-h609-rw\') no-repeat 370px 0px;" border="0" width="578" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td colspan="3" height="22">&nbsp;</td>
</tr>
<tr>
<td width="40">&nbsp;</td>
<td width="498">
<div style="font-family: arial,Arial,sans-serif;">
<div style="font-family: arial,Arial,sans-serif;">
<p>Ol&aacute;, '.$conta_object->Nome.'</p>
<p>Sua senha foi recuperada, verifique as informa&ccedil;&otilde;es abaixo contendo sua nova senha, favor realize a mudan&ccedil;a de sua senha ap&oacute;s exibir a senha gerada neste e-mail.</p>
<p><strong>Informa&ccedil;&atilde;o da a&ccedil;&atilde;o:</strong></p>
</div>
</div>
<ul>
<li>Usu&aacute;rio: '.$conta_object->ID.'</li>
<li>Nova senha: '.$new_senha.'</li>
<li>Endere&ccedil;o de IP: '.$exibir_ip.'</li>
<li>Data: dia '.date('d').' de '.$mes.' de '.date('Y').' &agrave;s '.date('H:i A').'</li>
</ul>
<div style="font-family: arial,Arial,sans-serif;">
<ul style="list-style: none; margin-left: -50px !important;">
<li>Se n&atilde;o foi voc&ecirc; que tentou redefinir sua senha recomendamos efetua o bloqueio agora mesmo de sua conta e entrar em contato com o administrador informando o ocorrido.</li>
</ul>
<p style="margin-left: 35px;"><a href="https://'.$_SERVER['SERVER_NAME'].'/index.php?auth=true&amp;b='.$keyCode.'" target="_blank" rel="noopener"> <button style="display: inline-block; height: 28px; border: solid 1px #d8d8d8; padding: 5px 10px; outline: 0; background-color: #2793e6; font-weight: bold; font-size: 11px; color: #ffffff; text-decoration: none; white-space: nowrap; word-wrap: normal; line-height: normal; vertical-align: middle; border-radius: 2px; border-color: #1b7fcc;" type="button">bloquear minha conta agora!</button> </a></p>
<div>
<p><strong>O que pode ter ocorrido?</strong><br /> Voc&ecirc; pode ter fornecido seus dados a algu&eacute;m que se diz ser seu amigo, ou voc&ecirc; pode t&ecirc; deixado seus dados salvos como senha no navegador onde voc&ecirc; utilizou o painel de usu&aacute;rio.</p>
<p>Mensagem criado no intuito de ajudar a impedir esses acontecimentos.</p>
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
<div style="font-family: arial,Arial,sans-serif; font-size: 11px; color: #999999; line-height: 14px;"><a style="text-decoration: none; color: #1c62b9;" href="https://www.facebook.com/Cabal.iCore/" target="_blank" rel="noopener">Central de Ajuda</a> &bull; <a style="text-decoration: none; color: #1c62b9;" title="CABAL Online - iCore Honra e Gl&oacute;ria" href="https://cabalicore.com.br/">Visite nosso site</a></div>
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
				
					$db->query("USE [MWeb]exec dbo.cabal_m_novaSenha '".$new_senha."', '".$conta_object->UserNum."', '".$keyCode."'");
					
				}catch(PDOException $e){
					
					echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Falha na conexão!", "Houve problemas na conexão com o banco de dados.", "error") );</script>';
				}
				
			
           
			echo '<script type="text/javascript">document.recSenha.reset();</script>';
				echo '<script>console.log( swal("Recuperação de senha", "Sua nova senha foi enviado para o e-mail correspondente a sua conta.", "success") );</script>';
				exit();
				
			}
		}elseif($action!="" AND $action!="recSenha"){
			
			
			header("Location: ../");
			
		}






?>
