<style>
	.boxError { 
    padding-top:10px;
		padding-bottom:10px;
    border-radius: 3px;
    text-align: center;
    margin-top: 16px;
		vertical-align: middle !important;
    background-color: rgba(247, 4, 4, 0.36);
    box-shadow: 0px 0px 29px 1px rgba(255, 0, 0, 0.27);
	}
	.boxSuccess {
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 3px;
    color: #fff;
    text-align: center;
    font-weight: normal;
    font-size: 13px;
    margin-top: 16px;
    vertical-align: middle !important;
    background-color: rgb(5, 109, 50);
    box-shadow: 0px 0px 29px 1px rgba(5, 134, 39, 0.33);
}
	
</style>

<?php
require('../../web_conexao/init.php');

//Determines the type of page encoding
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formulário
extract($_GET); 
if(aiRemove(anti_injection(array_key_exists("Token", $_GET)))){
  $txtNome    = htmlentities(antiSQL(anti_injection($_GET['txtNome'])));
  $txtEmail   = anti_injection($_GET['txtEmail']);
  $txtUser    = htmlentities(aiRemove(antiSQL(anti_injection($_GET['txtUser']))));
  $txtpass    = htmlentities(aiRemove(antiSQL(anti_injection($_GET['txtpass']))));
  $txtrepass  = htmlentities(aiRemove(antiSQL(anti_injection($_GET['txtrepass']))));
  $txtchave   = htmlentities(aiRemove(antiSQL(anti_injection($_GET['txtchave']))));
  $Token      = htmlentities(aiRemove(antiSQL(anti_injection($_GET['Token']))));
	
	//COUNT REGISTERS//
		try{
		$stmtC = $db->prepare("select count(*) from  Account.dbo.cabal_auth_table where ID=:id");
		$stmtC->bindParam(':id', $txtUser, PDO::PARAM_STR);
		$stmtC->execute(); 
		$Query_R = $stmtC->fetchColumn();
		}catch(PDOException  $er ){ echo "Error: ".$er; exit(); }

	//COUNT E-MAIL//
		try{
		$stmtM = $db->prepare("select count(*) from  Account.dbo.cabal_auth_table where Email=:email");
		$stmtM->bindParam(':email', $txtEmail, PDO::PARAM_STR);
		$stmtM->execute(); 
		$Query_E = $stmtM->fetchColumn();
		}catch(PDOException  $er ){ echo "Error: ".$er; exit(); }	
	$ClassArrAy = array('-1','-2','-3','-4','-5','-6','-7','-8','-9','INSERT','INTO','DROP','DELETE','UPDATER','WHERE','FROM','insert','into','drop','from','delete','updater','where','hack','sony','machine','cabal','pirata','nexus','lotus','');

 if(!$txtNome || !$txtEmail || !$txtUser || !$txtpass || !$txtrepass || !$txtchave){
   echo utf8_decode('<div class="boxError">Please fill in all fields above.</div>');	
 }elseif($Query_R>=1){
	echo utf8_decode('<div class="boxError">The login you want to use is already in use.</div>');				  
 }elseif($Query_E>=1){
	echo utf8_decode('<div class="boxError">The email you want to use is already in use.</div>');				
 }elseif(!preg_match('/^[a-z\d_]{4,28}$/i', $txtUser)){
	echo utf8_decode('<div class="boxError">Login field requires only letters / numbers, do not use accents or space, and login requires a minimum of 4 characters and a maximum of 28.</div>');
 }elseif(in_array($txtUser, $ClassArrAy)){
	echo utf8_decode('<div class="boxError">You used system-protected words in the login field, verify your login and try again.</div>');
 }elseif(!preg_match('/^[a-z\d]{4,15}$/i', $txtpass)){
	echo utf8_decode('<div class="boxError">Password field requires only letters / numbers, do not use accents or space, password requires at least 4 characters and at most 15.</div>');
 }elseif(in_array($txtpass, $ClassArrAy)){
	echo utf8_decode('<div class="boxError">You used system protected words in the password field, verify your password and try again.</div>');
 }elseif($txtpass!=$txtrepass){
	echo utf8_decode('<div class="boxError">Password fields are not the same, please check your password and try again.</div>');
 }elseif(!validaEmail($txtEmail)){
	echo utf8_decode('<div class="boxError">The entered email is invalid, our server only allows popular email providers like: outlook, hotmail, live, gmail, uol, bol, infonetfibra, infonetcurvelo ..</div>');
 }elseif(!preg_match('/^[A-Za-z]+$/', $txtNome)){
	echo utf8_decode('<div class="boxError">type only letters in the name field, and please enter only your first name without spaces or accents.</div>');
 }elseif(in_array($txtNome, $ClassArrAy)){
	echo utf8_decode('<div class="boxError">field name has characters that are not allowed to check and try again.", "info") );</script>');
 }elseif(!preg_match('/^[a-z\d]{4,}$/i', $txtchave)){
	echo utf8_decode('<div class="boxError">Security code field only requires letters / numbers, do not use accents or space, the field requires at least 4 characters.</div>');
 }else{
	 $gerarCodigo = abs(rand(1000000000000000000, 999999999999999999));
	
	 
	 try
        {
	       
		 
			$sql = 'exec Account.dbo.cabal_tool_registerAccount_web :login, :senha, :email, :chave, :nome, :codigo';
			$sth = $db->prepare($sql);
			$sth->bindParam(':login', $txtUser, PDO::PARAM_STR);
			$sth->bindParam(':senha', $txtpass, PDO::PARAM_STR);
			$sth->bindParam(':email', $txtEmail, PDO::PARAM_STR);
			$sth->bindValue(':chave', $txtchave, PDO::PARAM_STR);
			$sth->bindParam(':nome', $txtNome, PDO::PARAM_STR);
			$sth->bindParam(':codigo', $gerarCodigo, PDO::PARAM_STR);
			
			$sth->execute();		
			
			
			
		}catch (PDOException $e)
        {
            
           print_r("Connection Error: " . $e->getMessage());

        }	
	 
	 
	  
     echo '<script>limparForm("#register")</script>';
	 echo utf8_decode('<div class="boxSuccess">Obrigado por se registrar! Você ganhou 7 dias de VIP!</div>');
	
}
 
}//requisição array_key_exists//
else{
	
    echo "Notfoud";	
	
}


?>
