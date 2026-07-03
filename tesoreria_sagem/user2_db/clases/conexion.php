<?php
	class conexion {
		public $pdo;
		
		public function __construct () {}

		
		public function abrir_conexion(){
			$host = "localhost";
			$usuario = "postgres";
			$pass = "admin";
			$bd = "pqrs";
			
		$pdo = pg_connect( "user=".$usuario." ".
				  		   "password=".$pass." ".
						   "host=".$host." ".
						   "dbname=".$bd
						  ) or die( "Error al conectar: ".pg_last_error() );

		return $pdo;
	}
		
		
		
		
		/*
		public function abrir_conexion () {

			$host = "localhost";
			$usuario = "postgres";
			$password = "admin";
			$db = "pqrs";
			
			try {
				$this -> pdo = new PDO("mysql:host=$host;dbname=$db;", $usuario, $password);
			} catch (Exception $e) {
				die ("No se ha podido establecer la conexion".$e -> getMessage());
			}
		}*/
		
		public function __destruct () {} 
	}
?>