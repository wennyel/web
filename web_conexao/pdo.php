<?php
    class Database
    {
        protected static $db;
        
        protected   $db_host        =   DB_HOST;
        protected   $db_usuario     =   DB_USER;
        protected   $db_senha       =   DB_PASS;

        private function __construct()
        {
            try
            {
				self::$db = new PDO("odbc:Driver={SQL Server};Server=".$this->db_host."; Uid=$this->db_usuario;Pwd=$this->db_senha;");          
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                die("Connection Error: " . $e->getMessage());
            }
        }
		
        public static function conexao()
        {
            if (!self::$db)
            {
                new Database();
            }
            return self::$db;
        }
		
    }


     //CONEXAO 2


class connection
    {
        protected static $pdo;
        
        protected   $db_host        =   DB_HOST;
        protected   $db_usuario     =   DB_USER;
        protected   $db_senha       =   DB_PASS;

        private function __construct()
        {
            try
            {
				self::$pdo = new PDO("odbc:Driver={SQL Server};Server=".$this->db_host."; Uid=$this->db_usuario;Pwd=$this->db_senha;");          
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                die("Connection Error: " . $e->getMessage());
            }
        }
		
        public static function conn()
        {
            if (!self::$pdo)
            {
                new connection();
            }
            return self::$pdo;
        }
		
    }




?>