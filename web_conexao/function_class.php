<?php 
  function decodificar($MegaHonra) {
  $sexoChar_array = array('<img src="images/utilitares/male.png" width="18" height="18" title="Male"/>',
                          '<img src="images/utilitares/female.png" width="18" height="18" title="Female"/>',
						  '<img src="images/utilitares/male.png" width="18" height="18" title="Male"/>',
						  '<img src="images/utilitares/female.png" width="18" height="18" title="Female"/>',
						  '<img src="images/utilitares/male.png" width="18" height="18" title="Male"/>',
						  '<img src="images/utilitares/female.png" width="18" height="18" title="Female"/>');

  $sexoChar_array1 = array('Masculino',
                          'Feminino',
						  'Masculino',
						  'Feminino', 
						  'Masculino',
						  'Feminino');
						  
  $auraChar_array = array('<img src="images/nation_0.png" width="25" height="25" title="Neutro"/>',
                          '<img src="images/aura_1.gif" width="25" height="25" title="Aura Terra"/>',
						  '<img src="images/aura_2.gif" width="25" height="25" title="Aura Água"/>',
						  '<img src="images/aura_3.gif" width="25" height="25" title="Aura Vento"/>',
						  '<img src="images/aura_4.gif" width="25" height="25" title="Aura Fogo"/>',
						  '<img src="images/aura_5.gif" width="25" height="25" title="Aura Gelo"/>',
						  '<img src="images/aura_6.gif" width="25" height="25" title="Aura Trovão"/>');

   $auraChar_array1 = array('Aura:neutro',
                          'Aura Terra',
						  'Aura Água',
						  'Aura Vento',
						  'Aura Fogo',
						  'Aura Gelo',
						  'Aura Trovão');
						  
  $classeChar_arrayIS = array(
                            4=>'<img src="images/classe/0_4.png">',
                            5=>'<img src="images/classe/0_5.png">',
                            6=>'<img src="images/classe/0_6.png">',
                            9=>'<img src="images/classe/0_1.png">',
                            10=>'<img src="images/classe/0_2.png">',
                            11=>'<img src="images/classe/0_3.png">',
                            12=>'<img src="images/classe/0_4.png">',
                            13=>'<img src="images/classe/0_5.png">',
                            14=>'<img src="images/classe/0_6.png">',
                            );
	  
	  $classeChar_array = array(
                            4=>'<img src="images/classe/0_4.png">',
                            5=>'<img src="images/classe/0_5.png">',
                            6=>'<img src="images/classe/0_6.png">',
                            9=>'<img src="images/classe/0_1.png">',
                            10=>'<img src="images/classe/0_2.png">',
                            11=>'<img src="images/classe/0_3.png">',
                            12=>'<img src="images/classe/0_4.png">',
                            13=>'<img src="images/classe/0_5.png">',
                            14=>'<img src="images/classe/0_6.png">',
                            );
	  
	  $classeChar_Sigla = array(
                            4=>'aa',
                            5=>'ga',
                            6=>'ea',
                            9=>'gu',
                            10=>'du',
                            11=>'ma',
                            12=>'aa',
                            13=>'ga',
                            14=>'ea',
                            );  
	
	
	$classeChar_name = array(4=>'Arqueiro Arcano',
                            5=>'Guardião Arcano',
					        6=>'Espadachim Arcano',
					        9=>'Guerreiro',
					        10=>'Duelista',
					        11=>'Mago',
					        12=>'Arqueiro Arcano',
					        13=>'Guardião Arcano',
					        14=>'Espadachim Arcano');						
					   
  $style['Aura'] = round(($MegaHonra % hexdec(4000000)) / hexdec(200000))/2;
  $style['NomeAura'] = $auraChar_array[$style['Aura']];
  $style['NomeAura_is_name'] = $auraChar_array1[$style['Aura']];
  $style['Sexo'] = $sexoChar_array[round($MegaHonra / hexdec(4000000))];
  $style['Sexo_is_name'] = $sexoChar_array1[round($MegaHonra / hexdec(4000000))];		
  $style['Classe_Rank'] = round((((($MegaHonra % hexdec(4000000)) % hexdec(20000)) % hexdec(2000)) % hexdec(100)) / 8 );
  $style['Classe'] = (((($MegaHonra % hexdec(4000000)) % hexdec(20000)) % hexdec(2000)) % hexdec(100)) -  (($style['Classe_Rank'] -1) * 8) ;
  $style['Classe_Nome'] = $classeChar_array[$style['Classe']] ;
	   $style['Classe_is_image'] = $classeChar_arrayIS[$style['Classe']] ;
  $style['Classe_Sigla'] = $classeChar_Sigla[$style['Classe']] ;
  $style['Classe_is_name'] = $classeChar_name[$style['Classe']] ;
  return $style;  
} 

function maps($number){
		$maps	=  
			array(1  => ' Tundra Infame',
                  2  => ' Deserto Lamentao',
				  3  => ' Floresta Desespero',
				  4  => 'Porto Lux',
				  5  => ' Forte Ruina',
				  6  => ' Elo Perdido',
				  7  => ' Regiao dos Lagos',
				  8  => ' Santurio Profano',
				  9  => ' Floresta Mutante',
				  10 => ' Pontus Ferrum',
				  11 => ' Forte Infernus',
				  12 => ' Vestigio Arcano',
				  13 => 'Dragona dos Mortos',
				  14 => 'Tropa de Soldados',
				  15 => 'Tierra Gloriosa',
				  16 => 'Tierra Gloriosa[Espera]',
				  17 => ' Ilha Desperta',
				  18 => ' T2 Desperto',
				  19 => 'Prisao',
				  20 => 'Arena Da Defesa',
				  21 => 'Senellinia',
				  22 => ' Dragona 3ss',
				  23 => ' Templo Esquecido 1SS',
				  24 => ' Cidade Vulcanica',
				  25 => ' Patren',
				  26 => ' Lago do Crepusculo',
				  27 => 'Calabouo',
				  28 => 'Calabouo',
				  29 => 'Calabouo',
				  30 => ' Central de Teleporte',
				  31 => 'Calabouo',
				  32 => 'Calabouo',
				  33 => 'Calabouo',
				  34 => ' Templo 2 ss',
				  35 => ' Ilha perdida',
				  36 => ' Siena 1 ss',
				  37 => ' Siena 2 ss',
				  38 => 'Calabouo',
				  39 => 'Calabouo',
				  40 => 'Calabouo',
				  41 => 'Calabouo',
				  42 => 'Calabouo',
				  43 => 'Calabouo',
				  44 => 'Calabouo',
				  45 => 'Calabouo',
				  46 => 'Calabouo',
				  47 => ' Castelo 1',
				  48 => 'Calabouo',
				  49 => 'Calabouo',
				  50 => 'Calabouo',
				  51 => ' Castelo 2',
				  52 => 'Calabouo',
				  53 => 'Calabouo'
			);
			return $maps[$number];
	}
	function protecao($value){
		return htmlspecialchars($value);
		
	}
// Anti-Inject Etapa 2 //
	
	function anti_injection($sql)	
	{	
		$sql 	=	preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", '', $sql);
	    $sql 	=	trim($sql);
	    $sql 	=	strip_tags($sql);
	    $sql 	=	addslashes($sql);
	    $sql 	=	htmlspecialchars($sql);
		$sql    =   filter_var($sql);
	    return $sql;
	}

	$badwords = array(";","'", "+", "--","/","|",":", "=", "%", "(", ")","DROP", "INSERT", "insert", "SELECT", "FROM", "from", "UPDATE", "DELETE", "drop", "select", "update", "delete", "WHERE", "where", "-1", "-2", "-3","-4", "-5", "-6", "-7", "-8", "-9",);
	
// Anti-Inject Etapa 4 //
	
    function protect($var) {  
    $banlist = array("insert", "select", "update", "delete", ";", "'", "+", "--", "/", "|", ":", "=", "%", "(", ")", "distinct", "having", "truncate", "replace","handler", "like", " as ", "or ", "procedure", "limit", "order by", "group by", "asc", "union", "desc", "'", "union all");  
    if(eregi("[a-zA-Z0-9]+", $var)){  
        $texto = trim(str_replace($banlist,'', strtolower($var)));  
    }  
  return $texto;  
 
 } 
 //Anti-Injection Etapa 5 ;;
  if(!function_exists("antiSQL")) {
function antiSQL($campo, $adicionaBarras = false) {
// remove palavras que contenham sintaxe sql
$campo = preg_replace("/(from|alter table|select|insert|delete|update|were|drop table|-1|-2|-3|-4|-5|-6|-7|-8|-9|show tables|#|\*|--|\\\\)/i","Anti Sql-Injection - bjus Mãe !",$campo);
$campo = trim($campo);//limpa espaços vazio
$campo = strip_tags($campo);//tira tags html e php
if($adicionaBarras || !get_magic_quotes_gpc())
$campo = addslashes($campo);
return $campo;
} }
 
 
 function soNumero($str){
        return preg_replace("/[^0-9]/", "", $str);
    }
	function validaEmail($email){
		$conta = "^[a-zA-Z0-9\._-]+@";
		$domino = "outlook|outlook.com|live|live.com|hotmail|hotmail.com|gmail|gmail.com|yahoo|yahoo.com|leonardojbc|leonardojbc.com+.";
		//$domino = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$";
		
		$pattern = $conta.$domino.$extensao;
		
		if(preg_match("/$pattern/i", $email)){
			return true;
		}else{
			return false;
		}
	}  
function tempoItem($tempo){
		switch($tempo) {
			case 1: echo "1 Hora"; break;
			case 2: echo "2 Horas"; break;
			case 3: echo "3 Horas"; break;
			case 4: echo "4 Horas"; break;
			case 5: echo "5 Horas"; break;
			case 6: echo "6 Horas"; break;
			case 7: echo "10 Horas"; break;
			case 8: echo "12 Horas"; break;
			case 9: echo "1 Dia"; break;
			case 10: echo "3 Dias"; break;
			case 11: echo "5 Dias"; break;
			case 12: echo "7 Dias"; break;
			case 13: echo "10 Dias"; break;
			case 14: echo "14 Dias"; break;
			case 15: echo "15 Dias"; break;
			case 16: echo "20 Dias"; break;
			case 17: echo "30 Dias"; break;
			case 18: echo "45 Dias"; break;
			case 19: echo "60 Dias"; break;
			case 20: echo "90 Dias"; break;
			case 21: echo "100 Dias"; break;
			case 22: echo "120 Dias"; break;
			case 23: echo "180 Dias"; break;
			case 24: echo "270 Dias"; break;
			case 25: echo "1 Ano"; break;
			case 26: echo "3 Minutos"; break;
			case 27: echo "30 Minutos"; break;
			case 31: echo "Permanente"; break;
		}
	}
	
	function month($month){
		switch($month) {
			case 1 : echo 'Janeiro'; break;
			case 2 : echo 'Fevereiro'; break;
			case 3 : echo 'Março'; break;
			case 4 : echo 'Abril'; break;
			case 5 : echo 'maio'; break;
			case 6 : echo 'Junho'; break;
			case 7 : echo 'Julho'; break;
			case 8 : echo 'Agosto'; break;
			case 9 : echo 'Setembro'; break;
			case 10 : echo 'Outubro'; break;
			case 11 : echo 'Novembro'; break;
			case 12 : echo 'Dezembro'; break;
		}
	}
    function limitarTexto($texto, $limite, $quebrar = true){
  //corta as tags do texto para evitar corte errado
  $contador = strlen(strip_tags($texto));
  if($contador <= $limite):
    //se o número do texto form menor ou igual o limite então retorna ele mesmo
    $newtext = $texto;
  else:
    if($quebrar == true): //se for maior e $quebrar for true
      //corta o texto no limite indicado e retira o ultimo espaço branco
      $newtext = trim(mb_substr($texto, 0, $limite))."...";
    else:
      //localiza ultimo espaço antes de $limite
      $ultimo_espaço = strrpos(mb_substr($texto, 0, $limite)," ");
      //corta o $texto até a posição lozalizada
      $newtext = trim(mb_substr($texto, 0, $ultimo_espaço))."...";
    endif;
  endif;
  return $newtext;
}
	
	/*------------functions -----------*/

	
	function Deslogado(){
		
		if(!isset($_SESSION["my_login"])){
			
				echo '<script>console.log( swal("Informamos!", "Houve um problema, sua sessão no painel expirou, favor conecte-se novamente.", "warning") );</script>';
			echo '<meta HTTP-EQUIV=\'Refresh\' CONTENT=\'2;URL=../\'>';
			exit();
		}
	}

    function AdminCP(){
		//Adicione aqui sua ID de Administrador.
		if(!in_array($_SESSION['my_login'], array('wennyel','xxxxxxxxxxxxxs'))){
			
				echo '<script>console.log( swal("Blindado!", "Você não tem permissão para acessa essa função.", "error") );</script>';
			echo '<meta HTTP-EQUIV=\'Refresh\' CONTENT=\'2;URL=../\'>';
			exit();
		}
	}
function msgErro(){
	
echo '<script>console.log( swal("Informamos!", "preencha todos os campos do registro.", "info") );</script>';	
}

function checkout_token(){
	   
		 $encrypt   =  md5(url_token);
	     $validat_url = md5($_SERVER['SERVER_NAME']);
		 if($validat_url != $encrypt){
		    
			  echo '<div class=\'ferrorbig\'> Não foi possivel acessar está página pois o token de acesso é inválido, verifique com o administrador.</div><meta HTTP-EQUIV=\'Refresh\' CONTENT=\'3;URL=../\'>';
			 exit();
			 
		 }
}
function Serial($tipo = '', $qtdigitos = 6, $qtdbaterias = 1, $separador = '') {
    $qtdtotal = $qtdbaterias * $qtdigitos;
    $letrasnumeros = array_merge(range(0,9), range('A', 'Z')); // Cria um array de letras e numeros de forma simplificada

    for($i=0; $i < $qtdtotal; $i++){

        if ($tipo == 'numeros') { $digito = rand(0, 9); } 
        else if($tipo == 'letras') { $digito = chr(rand(65, 90)); }   //65 é o codigo ascii para 'A' e 90 para 'Z'
        else { $digito = $letrasnumeros[rand(0, count($letrasnumeros) - 1)]; }

        $serial .= (!($i % $qtdigitos) && $i ? $separador : '').$digito;
    }
  return $serial;
}

function AntSQL($str) {
 /*** Função para retornar uma string/Array protegidos contra SQL/Blind/XSS Injection*/
        if( !is_array( $str ) ) {                      
                $str = preg_replace( '/(from|select|insert|delete|where|drop|union|order|update|database)/i', '', $str );
                $str = preg_replace( '/(&lt;|<)?script(\/?(&gt;|>(.*))?)/i', '', $str );
                $tbl = get_html_translation_table( HTML_ENTITIES );
                $tbl = array_flip( $tbl );
                $str = addslashes( $str );
                $str = strip_tags( $str );
                return strtr( $str, $tbl );
        } else {
                return array_filter( $str, "AntSQL" );
        }
}
		 
/* begin Eliemar Flexpoint */
function aiRemove($sql)
{
	while(
        preg_match("/(from|select|update|insert|shutdown|delete|where|drop table|show tables|'|#|\*|--|\\\\)/i", $sql)
		||
		preg_match("/(FROM|SELECT|UPDATE|INSERT|SHUTDOWN|DELETE|WHERE|DROP TABLE|SHOW TABLES|#|\*|--|\\\\)/i", $sql)
    ){
        $sql = preg_replace("/(from|select|update|insert|shutdown|delete|where|drop table|show tables|'|#|\*|--|\\\\)/i","",$sql);
		$sql = preg_replace("/(FROM|SELECT|UPDATE|INSERT|SHUTDOWN|DELETE|WHERE|DROP TABLE|SHOW TABLES|#|\*|--|\\\\)/i","",$sql);
	}
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
}

function aiClearVar($var){
	if(is_array($var)){
		foreach($var as $k => $v){
			if(is_array($v))
				$var[$k] = aiClearVar($v);
			else
				$var[$k] = aiRemove($v);
		}
	}else{
		$var = aiRemove($var);
	}
	return $var;
}

$_REQUEST = aiClearVar($_REQUEST);
$_POST = aiClearVar($_POST);
$_GET = aiClearVar($_GET);
$_COOKIE = aiClearVar($_COOKIE);
$_SESSION = aiClearVar($_SESSION);
//print_r($_GET);exit;
/* end Eliemar Flexpoint*/
?>

