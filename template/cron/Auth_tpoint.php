<?php
     require('../../web_conexao/init.php');


if(htmlentities(anti_injection(!array_key_exists("point", $_GET)))){
	
	echo "fatal error!";
	exit();
	
}
if(htmlentities(anti_injection(antiSQL($_GET['point'])))!="fdescpoint"){
	
	echo "fatal error!";
	exit();
}
$tpoint_config = $db->query("select * from MWeb.dbo.Cabal_m_TPoint_resgate_config where id='1' ")->fetchObject();
//Comparações de data//
    $date_atual 	=	strtotime(date('Y-m-d H:i:s.B'));
    $vencidoEm	    =	strtotime($tpoint_config->DatePremio);
    $new_date		=	date('Y-m-d H:i:s.B', strtotime('+'.$tpoint_config->TempoRespaw.' hour'));

if($vencidoEm > $date_atual){
		echo 'Desculpe! Ainda não é hora de distribuir T-Point.';
		exit();
	unset($db);
	$db = null;
	}

 $auth_usernum = $db->query("select * from account.dbo.cabal_auth_table where Login='1' order by ID asc");
 $resultado = $auth_usernum->fetchAll();

			            foreach($resultado as $row){
							$countL = $db->query("select count(*) from Server01.dbo.cabal_character_table where CharacterIdx/8='".$row['UserNum']."' AND Login=1")->fetchColumn();
							
							if($countL>=1){
								@$n+=1;
								if($n==1){
								$db->query("UPDATE MWeb.dbo.Cabal_m_TPoint_resgate_config set DatePremio='".$new_date."' where id='1'");
									echo "UPDATE DE DATA EFETUADA COM SUCESSO<br><br><hr></br>";
								}
								$db->query("UPDATE Netcafebilling.dbo.Point set TPoint=TPoint+'".$tpoint_config->TPoint."' where UserNum='".$row['UserNum']."'");
								
								echo "O Usuário -> [".$row['ID'].'] obteve -> '.$tpoint_config->TPoint. 'T-Point <br>';
								
							}
							
							
							
						}
