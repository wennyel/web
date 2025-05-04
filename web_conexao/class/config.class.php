<?php
	class ConexaoMssql{
		protected	$server			=	DB_HOST;
		protected	$user			=	DB_USER;
		protected	$password		=	DB_PASS;

		public function connect(){
			$connect	=	mssql_connect($this->server, $this->user, $this->password);
			if(!$connect){
				echo "Atenção!, Houve um problema com nosso servidor e o site está fora do ar, por favor, volte mais tarde.";
				exit();
			}
		}
		public function close(){
			mssql_close();
		}
	}
?>