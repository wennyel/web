<?php


/*

require('../../web_conexao/init.php');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$char = $db->query("select * from Account.dbo.cabal_charge_auth where ServiceKind=25 and cashVIP=1");
$VIP = $char->fetchAll();
foreach($VIP as $row){
	
	
		
		$db->query("USE[cabalcash]exec up_AddMyCashItemByItem '".$row['UserNum']."',0,0,5469,0,17");
		
	
	echo 'UserNum: => '.$row['UserNum'].'<br>';



}
*/

?>