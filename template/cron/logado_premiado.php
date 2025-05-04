<?php
     require('../../web_conexao/init.php');

if(htmlentities(anti_injection(!array_key_exists("token", $_GET)))){
	
	echo "fatal error!";
	exit();
	
}
if(htmlentities(anti_injection(antiSQL($_GET['token'])))!="f2scsaOs214"){
	
	echo "fatal error!";
	exit();
}
	


    //Verificar o config do logado premiado//
    $init = $db->query("select * from MWeb.dbo.cabal_m_logado_premiado_config where idConfig = 1 ")->fetchObject();
 

    //Verifica a quantidade de players online//
    $online = $db->query("select count(*) from server01.dbo.cabal_character_table where Login = 1")->fetchColumn();


    //Comparações de data//
    $date_atual 	=	strtotime(date('Y-m-d H:i:s.B'));
    $vencidoEm	    =	strtotime($init->RegDate);



    if($init->limite_players>$online){
	    echo 'Desculpe! não existe um favor x de jogadores online no servidor.';
		exit();
	}elseif($vencidoEm > $date_atual){
		echo 'Desculpe! Ainda não é hora para sortear um jogador.'.$init->RegDate;
		exit();
	}else{
		
		//sorteia um personagem//
		$personagem = $db->query("select top 1 * from server01.dbo.cabal_character_table where Login = 1 order by newid() ")->fetchObject();
		
		//Pegar usernum referente ao personagem//
		$usernum = $db->query("select * from account.dbo.cabal_auth_table where '".$personagem->CharacterIdx."'/8=UserNum")->fetchObject();
		
		//sorteia um item//
		$item = $db->query("select top 1 * from MWeb.dbo.cabal_m_logado_premiado order by newid() ")->fetchObject();
		
		//Atualizar Data//
	///FALTA CORRIGIR ESSA QUERY//
		$hours = 1;
		$new_date				=	date('Y-m-d H:i:s.B', strtotime('+'.$hours.' hour'));
		$db->query("USE[MWeb]exec cabal_m_logado_premiado_refresh_config '".$new_date."'");
		
		
			if($item->tipo==1) { $Idx = $item->ItemIdx; }
			if($item->tipo==2) { $Idx = $item->ItemIdx + 4096; }
			if($item->tipo==3) { $Idx = $item->ItemIdx + 524288; }
			if($item->tipo==4) { $Idx = $item->ItemIdx + 4096 + 524288; }
			
				
		
		
		$db->query("USE[MWeb]exec cabal_insert_logado_premiado_log '".$usernum->UserNum."','".$personagem->Name."','".$item->ItemIdx."','".$item->ItemOption."','".$item->Duracao."','".$item->ItemName."' ");
		
		$db->query("exec server01.dbo.cabal_sp_mail_send_GM '".$personagem->CharacterIdx."','Logado Premiado','Olá, ".$personagem->Name.", você acaba de receber ".$item->ItemName.", no logado premiado.','".$Idx."','".$item->ItemOption."','".$item->Duracao."'");
		echo $personagem->Name.'Obteve'. $item->ItemName.$Idx;
		
		
	}



?>