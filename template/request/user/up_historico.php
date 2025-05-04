<?php
require("../../../web_conexao/init.php");

try{
$result_conta = $db->query("select * from account.dbo.cabal_auth_table where ID='".$_SESSION['my_login']."'")->fetchObject();
$contar_personagem = $db->query("select distinct count(*) from server01.dbo.cabal_character_table where CharacterIdx/8='".$result_conta->UserNum."'")->fetchColumn();
}catch(PDOException $e){
	
echo $e;	
}
?>


<table width="491" style="margin-top:60px;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="137" height="47" align="center" valign="middle">Package</td>
    <td width="130" align="center" valign="middle">Form of payment</td>
    <td width="77" align="center" valign="middle">Date</td>
    <td width="96" align="center" valign="middle">Transaction Cod</td>
    <td width="51" align="center" valign="middle">Status</td>
  </tr>
  
  <?
  $search		=	$db->query("SELECT * FROM MWeb.dbo.ConfPgmt_historico where IdxUser='".$result_conta->UserNum."'");
  $result = $search->fetchAll();
 
 foreach($result as $rows){
					
						$pacote = $db->query("SELECT * FROM MWeb.dbo.ConfPgmt_Pacotes where Idx='".$rows['IdxPacote']."'")->fetchObject();
  ?>
  
  <tr>
    <td height="23" align="center" valign="middle">Doei $ <?=number_format($pacote->Valor) . '.00'?> e vou receber <?=number_format($pacote->Cash + $pacote->Bonus)?>
  Gold</td>
    <td align="center" valign="middle">
	<?
	switch($rows['FormaDePgmt']){
		case 1 : echo "MercadoPago (Boleto)"; break;
		 case 2 : echo "MercadoPago (Cartão de Crédito)"; break;
		  case 3 : echo "PayPal (Boleto)"; break;
		   case 4 : echo "PayPal (Cartão de Crédito)"; break;
		
	}
	?>
	</td>
    <td align="center" valign="middle"><?=date('d-m-Y', strtotime($rows['Data']))?></td>
    <td align="center" valign="middle" onclick="swal('Código de transação','<?=$rows['Codigo']?>','info')">ver</td>
    <td align="center" valign="middle">
	<?
	switch($rows['Confirmado']){
		case 0 : echo "<font style='color:#ffaf43;'>Pendant</font>"; break;
		case 1 : echo  "<font style='color:#7BAC3B;'>Aprovado</font>"; break;
		
	}
	
	?>
	</td>
  </tr>
  
					<? } ?>
  
  
  </table>
