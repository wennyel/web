<?
$encrypt   =  md5('www.cabalicore.com.br');
	     $validat_url = $_SERVER['SERVER_NAME'];

echo $encrypt.'<br>';
echo $validat_url;
?>