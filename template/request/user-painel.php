<?php
	require("../../web_conexao/init.php");
	
	if(isset($_SESSION["my_login"])){
		try{
$getLogin = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:id");
$getLogin->bindParam(':id', $_SESSION["my_login"], PDO::PARAM_STR);
$getLogin->execute(); 
$rows = $getLogin->fetchObject();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-Fx34p", "warning") );</script>'; exit(); }

try{
$getCount = $db->prepare("select count(*) from  Account.dbo.cabal_auth_table where ID=:idC");
$getCount->bindParam(':idC', $_SESSION["my_login"], PDO::PARAM_STR);
$getCount->execute(); 
$count = $getCount->fetchColumn();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-Du74S1", "warning") );</script>'; exit(); }

if($count>=1 AND !in_array($_SESSION['my_login'], $AdminCP)){
			
try{ // Pega informações da tabela cabal_auth_table
$getObject = $db->prepare("SELECT * FROM Account.dbo.cabal_auth_table WHERE ID=:id");
$getObject->bindParam(':id', $_SESSION["my_login"], PDO::PARAM_STR);
$getObject->execute(); 
$rowObject = $getObject->fetchObject();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-kNe32l", "warning") );</script>'; exit(); }
	
try{ // verificar a tabela Cash Account
$getCash = $db->prepare("SELECT * FROM CabalCash.dbo.CashAccount WHERE UserNum=:UserNum");
$getCash->bindParam(':UserNum', $rows->UserNum, PDO::PARAM_INT);
$getCash->execute(); 
$Crow = $getCash->fetchObject();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-fI14wS", "warning") );</script>'; exit(); }

try{ // verificar a tabela cabal_charge_auth
$vipCHarge = $db->prepare("SELECT * FROM Account.dbo.cabal_charge_auth WHERE UserNum=:UserNum");
$vipCHarge->bindParam(':UserNum', $rowObject->UserNum, PDO::PARAM_INT);
$vipCHarge->execute(); 
$rows_vip = $vipCHarge->fetchObject();
}catch(PDOException  $er ){ echo '<script>console.log( swal("Warning", "Houve um problema técnico no sistema, favor atualize a página e tente novamente. Nº Protocolo m-V23pWx", "warning") );</script>'; exit(); }

			if(in_array($_SESSION['my_login'], $AdminCP)){
				echo '<script>console.log( swal("Painel Administrativo!", "Olá, '.$rowObject->Nome.' navegue pelo seu painel de usuário.", "info") );</script>';
			}else{
			echo '<script>console.log( swal("Bem vindo!", "Olá, '.$rowObject->Nome.' navegue pelo seu painel de usuário.", "info") );</script>';

			}
?>
<style>
	a {
		cursor: pointer;
	}
</style>
<div class="content-title c-title">

	<span class="title">Ferramentas:</span>
</div><!-- content-title -->
<div class="cbPs">
	<img src="images/utilitares/homem.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a onclick="new Ajax.Updater('container', 'template/request/profile.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">MEU PERFIL</a>
	</div>
	<div class="cbPs-autor">
		<p>informações de minha conta</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/calculator.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/distribuir-pontos"
			onclick="new Ajax.Updater('container', 'template/request/user/distribuir-pontos.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">DISTRIBUIR
			PONTOS</a>
	</div>
	<div class="cbPs-autor">
		<p>distribua como quiser!</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/lock.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/forSenha"
			onclick="new Ajax.Updater('container', 'template/request/user/forSenha.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">ALTERAR
			MINHA SENHA</a>
	</div>
	<div class="cbPs-autor">
		<p>faça a mudança de senha!</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/eraser_46865.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/limpa-pk"
			onclick="new Ajax.Updater('container', 'template/request/user/limpa-pk.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">LIMPAR
			PUNIÇÃO</a>
	</div>
	<div class="cbPs-autor">
		<p>limpe agora sua penalidade!</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/delchar.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/get_delchar"
			onclick="new Ajax.Updater('container', 'template/request/user/get_delchar.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">EXCLUIR
			CHAR</a>
	</div>
	<div class="cbPs-autor">
		<p>delete aquele char sem uso!</p>
	</div>
</div>
<?php
	if($rows_vip->ServiceKind>=1){
	?>
<div class="cbPs">
	<img src="images/icons/vip.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/get_resgate_dungeon"
			onclick="new Ajax.Updater('container', 'template/request/user/get_resgate_dungeon.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">RESGATAR
			DGS</a>
	</div>
	<div class="cbPs-autor">
		<p>Com VIP resgate dgs diáriamente!</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/Lendarios.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/get_bau_lendario"
			onclick="new Ajax.Updater('container', 'template/request/user/get_bau_lendario.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">BAÚ
			LENDÁRIO</a>
	</div>
	<div class="cbPs-autor">
		<p>abra seu baú e obtenha items raros.</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/fantasyVIP.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a href="#!user/get_resgate_fantasias_vip"
			onclick="new Ajax.Updater('container', 'template/request/user/get_resgate_fantasias_vip.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">RECEBA
			FANTASIAS</a>
	</div>
	<div class="cbPs-autor">
		<p>escolha suas fantasias de 30 dias.</p>
	</div>
</div>
<!-- NOVA FERRAMENTA: Transferência de Personagem -->
<div class="cbPs">
    <img src="images/icons/transferir.png" alt="cbPs-ava">
    <div class="cbPs-title">
        <a onclick="document.getElementById('btTransf').style.display = 
                   (document.getElementById('btTransf').style.display == 'none') ? 'block' : 'none'">
            TRANSFERÊNCIA DE PERSONAGEM
        </a>
    </div>
    <div class="cbPs-autor"><p>envie ou receba personagens entre contas</p></div>
</div>

<div id="btTransf" style="display: none; margin-top: -10px; margin-left: 10px;">
    <div class="cbPs">
        <div class="cbPs-title">
            <a onclick="new Ajax.Updater('container', 'template/request/user/up_moverChar.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">
                <li style="margin-left:20px;"><span class="user-1">➤ Enviar Personagem</span></li>
            </a>
        </div>
    </div>
    <div class="cbPs">
        <div class="cbPs-title">
            <a onclick="new Ajax.Updater('container', 'template/request/user/up_moverCharFrom.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">
                <li style="margin-left:20px;"><span class="user-1">➤ Receber Personagem</span></li>
            </a>
        </div>
    </div>
</div>
<? } ?>

<div style="height:15px;"></div>
<button name="register" style="cursor:pointer; float:right; font-size:11px;" class="btn  btn-success" type="button"
	onClick="new Ajax.Updater('AjaxDel', 'template/request/Validar.php?sair=sair', {method: 'get', asynchronous:true, evalScripts:true}); carregando('AjaxDel'); mover('AjaxDel');">Deslogar</button>
<div style="height:25px;"></div>


<div id="AjaxDel" name="AjaxDel">
</div>
<?php
	}elseif(in_array($_SESSION['my_login'], $AdminCP)){ //painel adm
	echo '<script>console.log( swal("Painel Administrativo!", "Olá, navegue pelo seu painel de administração e desfrute das facilidades.", "info") );</script>';
?>

<div class="content-title c-title">

	<span class="title">Ferramentas:</span>
</div><!-- content-title -->
<div class="cbPs">
	<img src="images/utilitares/homem.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/profile.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">MEU
			PERFIL</a>
	</div>
	<div class="cbPs-autor">
		<p>informações de minha conta</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/feed.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_insert_notice.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">NOTICIAS</a>
	</div>
	<div class="cbPs-autor">
		<p>gerencie as noticias do site.</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/pesquisar.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_search_players.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">PESQUISAR</a>
	</div>
	<div class="cbPs-autor">
		<p>pesquisar contas,chars e endereço de ip</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/youtube.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_m_Youtube.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">YOUTUBE
			VIDEOS</a>
	</div>
	<div class="cbPs-autor">
		<p>adicione videos referente ao servidor.</p>
	</div>
</div>


<div class="cbPs">
	<img src="images/icons/logadopremiado.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/insert_logado_premiado.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">LOGADO
			PREMIADO</a>
	</div>
	<div class="cbPs-autor">
		<p>adicione e deletar items.</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/moeda.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_moeda_insert.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">MOEDA
			DO JOGO</a>
	</div>
	<div class="cbPs-autor">
		<p>adicione ticket,tpoint e cash a uma conta.</p>
	</div>
</div>


<div class="cbPs">
	<img src="images/icons/banned.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_banned_users.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">BLOQUEAR
			CONTA</a>
	</div>
	<div class="cbPs-autor">
		<p>Bloqueio de usuário por duração.</p>
	</div>
</div>

<div class="cbPs">
	<img src="images/icons/getDownload.png" alt="cbPs-ava">
	<div class="cbPs-title">
		<a
			onclick="new Ajax.Updater('container', 'template/request/p/get_url_download.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');">GERENCIAR
			DOWNLOAD</a>
	</div>
	<div class="cbPs-autor">
		<p>adicionar ou atualizar url de download.</p>
	</div>
</div>


<div style="height:15px;"></div>
<button name="register" style="cursor:pointer; float:right; font-size:11px;" class="btn  btn-success" type="button"
	onClick="new Ajax.Updater('AjaxDel', 'template/request/Validar.php?sair=sair', {method: 'get', asynchronous:true, evalScripts:true}); carregando('AjaxDel'); mover('AjaxDel');">Deslogar</button>
<div style="height:25px;"></div>


<div id="AjaxDel" name="AjaxDel">
</div>
<?php
		}else{
		?>
<div class="content-box" align="center" style="min-height: 356px;">
	<div class="categoria">
		Minha conta
	</div>
	<img src="template/img/barUser.png" width="200" height="1" alt="" />
	<div class="minha-conta" align="center">
		Houve um erro ao tentar acessar as informações da sua conta, por favor logue novamente mais tarde!
		<a href="#"
			onClick="new Ajax.Updater('logout', 'template/request/Validar.php?sair=sair', {method: 'get', asynchronous:true, evalScripts:true}); carregando('logout');">Deslogar</a>
	</div>
</div>
<?
		}
	}else{
		//<button type="button" id="login" onclick="new Ajax.Updater('loginboxF', 'template/request/Validar.php', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.logar)}); carregando('#loginboxF');" name="submit">Login</button>
?>
<div class="login-title">
	<span>ou <a onclick='new modal("#reg_modal"); return false'>Cadastre-se</a></span>
	Entrar
</div>
<p><input type="text" name="username" placeholder="Digite seu login"></p>
<p><input type="password" name="password" placeholder="Digite sua senha"></p>
<div class="license">
	<input id="check" type="checkbox" name="check" value="check">
	<label for="check">Mantenha-me conectado</label>
</div>
<button type="button" class="login-button" id="login"
	onclick="new Ajax.Updater('loginboxF', 'template/request/Validar.php', {method: 'post', asynchronous:true, evalScripts:true, parameters:Form.serialize(document.logar)}); carregando('#loginboxF');"
	name="submit">Login</button> <a href="#!recover_password"
	onclick="new Ajax.Updater('container', 'template/request/recover_password.php', {method: 'get', asynchronous:true, evalScripts:true}); carregando('#container');"
	class="lost-pass">Perdeu sua senha ?</a>

<div id="loginboxF" name="loginboxF"></div>


<?php
	}
?>