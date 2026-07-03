<?php
	class indicador {
		private $fecha_corte;
		private $niteps;
		private $nomeps;
		private $vrsaldoeps;
		private $vrsaldoips;
		private $diferencia;
		private $nivel;
		
		
		public function __construct () {
			$this -> fecha_corte = "";
			$this -> niteps = "";
			$this -> nomeps = "";
			$this -> vrsaldoeps = "";
			$this -> vrsaldoips = "";
			$this -> diferencia = "";
			$this -> nivel = "";
		}

		public function setFecha_corte($aux) {
			$this -> fecha_corte  = $aux;
		}

		public function getFecha_corte() {
			return $this -> fecha_corte;
		}

		public function setNiteps($aux) {
			$this -> niteps  = $aux;
		}

		public function getNiteps() {
			return $this -> niteps  ;
		}
		
		public function setNomeps($aux) {
			$this -> nomeps  = $aux;
		}

		public function getNomeps() {
			return $this -> nomeps  ;
		}

		public function setVrsaldoeps($aux) {
			$this -> vrsaldoeps  = $aux;
		}

		public function getVrsaldoeps() {
			return $this -> vrsaldoeps;
		}

		public function setVrsaldoips($aux) {
			$this -> vrsaldoips = $aux;
		}

		public function getVrsaldoips() {
			return $this -> vrsaldoips;
		}

		public function setdiferencia($aux) {
			$this -> diferencia = $aux;
		}

		public function getDiferencia() {
			return $this -> diferencia;
		}

		public function setNivel($aux) {
			$this -> nivel  = $aux;
		}

		public function getNivel() {
			return $this -> nivel ;
		}

		public function __destruct () {}
	}
?>