<?php
	class base_unoe {
		private $id_unoe;
		private $codigo_regional;
		private $codigo_regional_documento;
		private $auxiliar;
		private $descripcion_auxiliar;
		private $nit;
		private $nombre_ips;
		private $numero_radicado;
		private $numero_cuenta_cobro;
		private $fecha;
		private $documento;
		private $debito;
		private $credito;
		private $neto;
		private $nota;
		private $tipo_movimiento;
		private $numero_pagos;
		private $tasa_impuesto_unoe;
		private $base_impuesto_unoe;
		private $fecha_creacion;
		private $fecha_aprobacion;
		private $tasa_impuesto_real;
		private $base_impuesto_real;
		private $tipo_impuesto;
		
		public function __construct () {
			$this -> id_unoe = "";
			$this -> codigo_regional = "";
			$this -> codigo_regional_documento = "";
			$this -> descripcion_auxiliar = "";
			$this -> descripcion = "";
			$this -> nit = "";
			$this -> nombre_ips = "";
			$this -> numero_radicado = "";
			$this -> numero_cuenta_cobro = "";
			$this -> fecha = "";
			$this -> documento = "";
			$this -> debito = "";
			$this -> credito = "";
			$this -> neto = "";
			$this -> nota = "";
			$this -> tipo_movimiento = "";
			$this -> numero_pagos = "";
			$this -> tasa_impuesto_unoe = "";
			$this -> base_impuesto_unoe = "";
			$this -> fecha_creacion = "";
			$this -> fecha_aprobacion = "";
			$this -> tasa_impuesto_real = "";
			$this -> base_impuesto_real = "";
			$this -> tipo_impuesto = "";
		}

		public function setId_UnoE($aux) {
			$this -> id_unoe  = $aux;
		}

		public function getId_UnoE() {
			return $this -> id_unoe;
		}

		public function setCodigo_Regional($aux) {
			$this -> codigo_regional  = $aux;
		}

		public function getCodigo_Regional() {
			return $this -> codigo_regional  ;
		}
		
		public function setCodigo_Regional_Documento($aux) {
			$this -> codigo_regional_documento  = $aux;
		}

		public function getCodigo_Regional_Documento() {
			return $this -> codigo_regional_documento  ;
		}

		public function setAuxiliar($aux) {
			$this -> auxiliar  = $aux;
		}

		public function getAuxiliar() {
			return $this -> auxiliar;
		}
		
		public function setDescripcion_Auxiliar($aux) {
			$this -> descripcion_auxiliar  = $aux;
		}

		public function getDescripcion_Auxiliar() {
			return $this -> descripcion_auxiliar;
		}

		public function setNit($aux) {
			$this -> nit = $aux;
		}

		public function getNit() {
			return $this -> nit;
		}
		
		public function setNombre_Ips($aux) {
			$this -> nombre_ips = $aux;
		}

		public function getNombre_Ips() {
			return $this -> nombre_ips;
		}

		public function setNumero_Radicado($aux) {
			$this -> numero_radicado  = $aux;
		}

		public function getNumero_Radicado() {
			return $this -> numero_radicado ;
		}

		public function setNumero_Cuenta_Cobro($aux) {
			$this -> numero_cuenta_cobro  = $aux;
		}

		public function getNumero_Cuenta_Cobro() {
			return $this -> numero_cuenta_cobro ;
		}

		public function setFecha($aux) {
			$this -> fecha = $aux;
		}

		public function getFecha() {
			return $this -> fecha;
		}

		public function setDocumento($aux) {
			$this -> documento  = $aux;
		}

		public function getDocumento() {
			return $this -> documento ;
		}

		public function setDebito($aux) {
			$this -> debito  = $aux;
		}

		public function getDebito() {
			return $this -> debito ;
		}

		public function setCredito($aux) {
			$this -> credito  = $aux;
		}

		public function getCredito() {
			return $this -> credito ;
		}

		public function setNeto($aux) {
			$this -> neto  = $aux;
		}

		public function getNeto() {
			return $this -> neto ;
		}

		public function setNota($aux) {
			$this -> nota  = $aux;
		}

		public function getNota() {
			return $this -> nota ;
		}

		public function setTipo_Movimiento($aux) {
			$this -> tipo_movimiento  = $aux;
		}

		public function getTipo_Movimiento() {
			return $this -> tipo_movimiento ;
		}

		public function setNumero_Pago($aux) {
			$this -> numero_pagos  = $aux;
		}

		public function getNumero_Pago() {
			return $this -> numero_pagos ;
		}
		
		public function setTasa_Impuesto_UnoE($aux) {
			$this -> tasa_impuesto_unoe  = $aux;
		}

		public function getTasa_Impuesto_UnoE() {
			return $this -> tasa_impuesto_unoe ;
		}

		public function setBase_Impuesto_UnoE($aux) {
			$this -> base_impuesto_unoe  = $aux;
		}

		public function getBase_Impuesto_UnoE() {
			return $this -> base_impuesto_unoe ;
		}

		public function setFecha_Creacion($aux) {
			$this -> fecha_creacion  = $aux;
		}

		public function getFecha_Creacion() {
			return $this -> fecha_creacion ;
		}

		public function setFecha_Aprobacion($aux) {
			$this -> fecha_aprobacion  = $aux;
		}

		public function getFecha_Aprobacion() {
			return $this -> fecha_aprobacion ;
		}

		public function setTasa_Impuesto_Real($aux) {
			$this -> tasa_impuesto_real  = $aux;
		}

		public function getTasa_Impuesto_Real() {
			return $this -> tasa_impuesto_real ;
		}
		
		public function setBase_Impuesto_Real($aux) {
			$this -> base_impuesto_real  = $aux;
		}

		public function getBase_Impuesto_Real() {
			return $this -> base_impuesto_real ;
		}
		
		public function setTipo_Impuesto($aux) {
			$this -> tipo_impuesto  = $aux;
		}

		public function getTipo_Impuesto() {
			return $this -> tipo_impuesto ;
		}

		public function __destruct () {}
	}
?>