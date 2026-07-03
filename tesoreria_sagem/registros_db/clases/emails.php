<?php
	class emails {
		private $id;
		private $nit;
		private $nomips;
		private $email;
		private $activo;
		
		public function __construct () {
			$this -> id = "";
			$this -> nit = "";
			$this -> nomips = "";
			$this -> email = "";
			$this -> activo = "";			
		}

		public function setId($aux) {
			$this -> id  = $aux;
		}

		public function getId() {
			return $this -> id;
		}

		public function setNit($aux) {
			$this -> nit = $aux;
		}

		public function getNit() {
			return $this -> nit;
		}

		public function setNomips($aux) {
			$this -> nomips = $aux;
		}

		public function getNomips() {
			return $this -> nomips;
		}

		public function setEmail($aux) {
			$this -> email  = $aux;
		}

		public function getEmail() {
			return $this -> email ;
		}

		public function setActivo($aux) {
			$this -> activo  = $aux;
		}

		public function getActivo() {
			return $this -> activo ;
		}
		
		public function __destruct () {}
	}
?>