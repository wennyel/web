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
	.input-re {
    background-color: #15171c;
    border: 1px solid #202125;
    height: 55px;
    width: 520px;
    box-shadow: inset 0 5px 20px 0 rgba(0,0,0,.75);
    color: #e7c195;
    text-align: center;
}
.h3 {
    color: #ffaf43;
    margin-bottom: 20px;
    line-height: 1.2;
    text-transform: uppercase;
    font-weight: 600;
}
.fitem{    margin-bottom: 6px;}
</style>

<div style=" width:97%; margin-left:12px;box-shadow: inset 0 0 0 1px rgba(255,255,255,.01), 0 0 45px 5px rgba(0,0,0,.65), 0 1px 1px rgba(0,0,0,.25);padding: 16px 30px;margin-top: 20px;font-size: 13px;border-radius: 5px;">
 
 <b style="font-weight:bold; font-size:16px;">Notas</b>:<br>

      - Para alterar sua senha, você deve preencher o formulário corretamente.<br>
	  </div>
	  <div style="height:20px;"></div>


<form name="mudarSenha" id="mudarSenha" style="text-align:center;">

   <div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Digite sua nova senha</label></div>
      <div class="finput" style="">
        <input name="nSenha" type="password" maxlength="15" class="input-re" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Confirmar nova senha</label></div>
      <div class="finput" style="">
        <input name="reSenha" type="password" maxlength="15" class="input-re" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>
	
	
	<div class="flabel" style="">
      <div class="fitem" style=""><label for="rusername">Codigo de segurança</label></div>
      <div class="finput" style="">
        <input name="Code" type="text" maxlength="8" class="input-re" style="margin-bottom:3px;">
          </div>
      <div class="clear"></div>
    </div>


   

    <div class="flabel" style="text-align: center;"><input name="sbmtAddPnt" class="button btn-submit" style="background-color: #121418;border: 1px solid #202125;"  type="button" value="Mudar" onclick="new Ajax.Updater('errors', 'template/request/user/up_MudarSenha.php?action=mudarSenha', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.mudarSenha)}); carregando('#errors');"></div>

    <div style="height: 5px;"></div>



</form>





<div id="errors" name="errors"></div>

</div>


<? }elseif($action=='mudarSenha')
		{ 
			
			$novaSenha = htmlentities(aiRemove(antiSQL(anti_injection($_POST['nSenha']))));
			
			$reSenha = htmlentities(aiRemove(antiSQL(anti_injection($_POST['reSenha']))));
			
			$Codigo = htmlentities(soNumero(aiRemove(antiSQL(anti_injection($_POST['Code'])))));
			
			
			if(!$novaSenha || !$reSenha || !$Codigo){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "preencha todos os campos.", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d]{4,15}$/i', $novaSenha)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "O Campo senha está em formato inválido..", "info") );</script>';
			}elseif(!preg_match('/^[a-z\d]{4,15}$/i', $reSenha)){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Desculpe!", "O Campo re-senha está em formato inválido.", "info") );</script>';
			}elseif($novaSenha!=$reSenha){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("desculpe!", "A senha não coicide com a confirmação de senha.", "info") );</script>';
			}elseif($result_conta->Chave!=$Codigo){
				echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Desculpe", "O código está incorreto.", "info") );</script>';
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
     $mail->SetFrom($caixaPostalEmailFrom, 'Notificação senha alterada'); //Your email
     $mail->AddReplyTo('contato@cabalvictory.com', 'Nome'); //Your email
     $mail->Subject = 'CABAL VICTORY';//Assunto do e-mail que receberá
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress($result_conta->Email, utf8_decode('ALTERAÇÃO DE SENHA - CABAL VICTORY'));
 
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
	   
     //Defines the email body
     $mail->MsgHTML(utf8_decode('Obrigado! sua senha foi alterada com sucesso, divirta-se. ;) ')); 
 
     ////Caso queirto place the contents of a file use the method below instead of the message in the body of the email.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
 
    //in case of any error is presented below with this exception.
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
				echo '<script>console.log( swal("Connection failure!", "There were problems connecting to the database.", "error") );</script>';
				}

			echo '<script type="text/javascript">document.mudarSenha.reset();</script>';
				echo '<script>console.log( swal("Obrigado.", "Sua nova senha foi alterada com sucesso. Por motivos de segurança, um alerta foi enviado ao seu e-mail registrado..", "success") );</script>';
				exit();
				
			}
		}elseif($action!="" AND $action!="mudarSenha"){
			
			
			header("Location: ../");
			
		}






?>
