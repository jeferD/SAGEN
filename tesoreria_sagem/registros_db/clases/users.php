<?php
	class users {
		private $id;
		private $nombres;
		private $usuario;
		private $pass;
		private $tipo;
		private $regional;
		private $noid;
		private $email;

		public function __construct () {
			$this -> id = "";
			$this -> nombres = "";
			$this -> usuario = "";
			$this -> pass = "";
			$this -> tipo = "";
			$this -> regional = "";
			$this -> noid = "";
			$this -> email = "";
		}

		public function setId($aux) {
			$this -> id  = $aux;
		}

		public function getId() {
			return $this -> id;
		}

		public function setNombres($aux) {
			$this -> nombres  = $aux;
		}

		public function getNombres() {
			return $this -> nombres;
		}

		public function setUsuario($aux) {
			$this -> usuario  = $aux;
		}

		public function getUsuario() {
			return $this -> usuario;
		}

		public function setPass($aux) {
			$this -> pass  = $aux;
		}

		public function getPass() {
			return $this -> pass;
		}

		public function setTipo($aux) {
			$this -> tipo  = $aux;
		}

		public function getTipo() {
			return $this -> tipo;
		}

		public function setRegional($aux) {
			$this -> regional  = $aux;
		}

		public function getRegional() {
			return $this -> regional;
		}
		
		public function setNoid($aux) {
			$this -> noid  = $aux;
		}

		public function getNoid() {
			return $this -> noid;
		}
		
		public function setEmail($aux) {
			$this -> email  = $aux;
		}

		public function getEmail() {
			return $this -> email;
		}

		public function __destruct () {}
	}
?>