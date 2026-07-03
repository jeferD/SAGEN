<?php
	class cubos {
		private $niteps;
		private $nitips;
		private $vrfacturaeps;
		private $vrglosaaceptadaeps;
		private $vrpagototaleps;
		private $vrsaldoeps;
		private $vrfacturaips;
		private $vrglosaaceptadaips;
		private $vrpagototalips;
		private $vrsaldoips;
		private $nomeps;
		private $nomips;
		private $diferencia;
		private $coincidencia;

		
		public function __nitipsnstruct () {
			$this -> niteps = "";
			$this -> nitips = "";
			$this -> vrfacturaeps = "";
			$this -> vrglosaaceptadaeps = "";
			$this -> vrpagototaleps = "";
			$this -> vrsaldoeps = "";
			$this -> vrfacturaips = "";
			$this -> vrglosaaceptadaips = "";
			$this -> vrpagototalips = "";
			$this -> vrsaldoips = "";
			$this -> nomeps = "";
			$this -> nomips = "";
			$this -> diferencia = "";
			$this -> coincidencia = "";			
		}

		public function setNiteps($aux) {
			$this -> niteps  = $aux;
		}
		
		public function getNiteps() {
			return $this -> niteps  ;
		}
		
		public function setNitips($aux) {
			$this -> nitips  = $aux;
		}

		public function getNitips() {
			return $this -> nitips  ;
		}

		public function setVrfacturaeps($aux) {
			$this -> vrfacturaeps  = $aux;
		}

		public function getVrfacturaeps() {
			return $this -> vrfacturaeps;
		}

		public function setVrglosaaceptadaeps($aux) {
			$this -> vrglosaaceptadaeps = $aux;
		}

		public function getVrglosaaceptadaepst() {
			return $this -> vrglosaaceptadaeps;
		}

		public function setVrpagototaleps($aux) {
			$this -> vrpagototaleps = $aux;
		}

		public function getVrpagototaleps() {
			return $this -> vrpagototaleps;
		}

		public function setVrsaldoeps($aux) {
			$this -> vrsaldoeps  = $aux;
		}

		public function getVrsaldoeps() {
			return $this -> vrsaldoeps ;
		}

		public function setVrfacturaips($aux) {
			$this -> vrfacturaips  = $aux;
		}

		public function getVrfacturaips() {
			return $this -> vrfacturaips ;
		}

		public function setVrglosaaceptadaips($aux) {
			$this -> vrglosaaceptadaips = $aux;
		}

		public function getVrglosaaceptadaips() {
			return $this -> vrglosaaceptadaips;
		}

		public function setVrpagototalips($aux) {
			$this -> vrpagototalips  = $aux;
		}

		public function getVrpagototalips() {
			return $this -> vrpagototalips ;
		}

		public function setVrsaldoips($aux) {
			$this -> vrsaldoips  = $aux;
		}

		public function getVrsaldoips() {
			return $this -> vrsaldoips ;
		}

		public function setNomeps($aux) {
			$this -> nomeps  = $aux;
		}

		public function getNomeps() {
			return $this -> nomeps ;
		}

		public function setNomips($aux) {
			$this -> nomips  = $aux;
		}

		public function getNomips() {
			return $this -> nomips ;
		}

		public function setDiferencia($aux) {
			$this -> diferencia  = $aux;
		}

		public function getDiferencia() {
			return $this -> diferencia ;
		}

		public function setCoincidencia($aux) {
			$this -> coincidencia  = $aux;
		}

		public function getCoincidencia() {
			return $this -> coincidencia ;
		}

		public function __destruct () {}
	}
?>