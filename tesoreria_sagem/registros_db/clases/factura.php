<?php
	class factura {
		private $numero_contrato;
		private $codigo_regional;
		private $modalidad;
		private $auxiliar;
		private $descripcion_auxiliar;
		private $nit;
		private $nombre_ips;
		private $numero_radicado;
		private $numero_cuenta_cobro;
		private $idfactura;
		private $idinterno_lazos;
		private $rips;
		private $prefijo;
		private $consecutivo;
		private $fecha_egreso;
		private $fecha_expedicion;
		private $fecha_radicacion;
		private $fecha_causacion;
		private $documento_causacion;
		private $valor_facturado;
		private $fecha_glosa_inicial;
		private $documento_glosa_inicial;
		private $valor_glosado;
		private $existe_conciliacion;
		private $fecha_conciliacion;
		private $documento_conciliacion;
		private $valor_glosa_favor_eps;
		private $valor_glosa_favor_ips;
		private $valor_impuesto_real;
		private $valor_impuesto_contable;
		private $fecha_pago;
		private $documento_pago;
		private $valor_pagado;
		private $valor_pagado_total;
		private $valor_saldo;
		
		public function __construct () {
			$this ->  numero_contrato = "";
			$this ->  codigo_regional = "";
			$this ->  modalidad = "";
			$this ->  auxiliar = "";
			$this ->  descripcion_auxiliar ="";
			$this ->  nit = "";
			$this ->  nombre_ips = "";
			$this ->  numero_radicado = "";
			$this ->  numero_cuenta_cobro = "";
			$this ->  idfactura = "";
			$this ->  idinterno_lazos = "";
			$this ->  rips = "";
			$this ->  prefijo = "";
			$this ->  consecutivo = "";
			$this ->  fecha_egreso = "";
			$this ->  fecha_expedicion = "";
			$this ->  fecha_radicacion = "";
			$this ->  fecha_causacion = "";
			$this ->  documento_causacion = "";
			$this ->  valor_facturado = "";
			$this ->  fecha_glosa_inicial = "";
			$this ->  documento_glosa_inicial = "";
			$this ->  valor_glosado = "";
			$this ->  existe_conciliacion = "";
			$this ->  fecha_conciliacion = "";
			$this ->  documento_conciliacion = "";
			$this ->  valor_glosa_favor_eps = "";
			$this ->  valor_glosa_favor_ips = "";
			$this ->  valor_impuesto_real = "";
			$this ->  valor_impuesto_contable = "";
			$this ->  fecha_pago = "";
			$this ->  documento_pago = "";
			$this ->  valor_pagado = "";
			$this ->  valor_pagado_total = "";
			$this ->  valor_saldo = "";
		}
		
		public function setNumero_Contrato($aux) {
			$this -> numero_contrato = $aux;
		}

		public function getNumero_Contrato() {
			return $this -> numero_contrato;
		}

		public function setCodigo_Regional($aux) {
			$this -> codigo_regional = $aux;
		}

		public function getCodigo_Regional() {
			return $this -> codigo_regional;
		}
		
		public function setModalidad($aux) {
			$this -> modalidad = $aux;
		}

		public function getModalidad() {
			return $this -> modalidad;
		}
		
		public function setAuxiliar($aux) {
			$this -> auxiliar = $aux;
		}

		public function getAuxiliar() {
			return $this -> auxiliar;
		}
		
		public function setDescripcion_Auxiliar($aux) {
			$this -> descripcion_auxiliar = $aux;
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
			$this -> numero_radicado = $aux;
		}

		public function getNumero_Radicado() {
			return $this -> numero_radicado;
		}

		public function setNumero_Cuenta_Cobro($aux) {
			$this -> numero_cuenta_cobro = $aux;
		}

		public function getNumero_Cuenta_Cobro() {
			return $this -> numero_cuenta_cobro;
		}
		
		public function setIdfactura($aux) {
			$this -> idfactura = $aux;
		}

		public function getIdfactura() {
			return $this -> idfactura;
		}
		
		public function setIdinterno_Lazos($aux) {
			$this -> idinterno_lazos = $aux;
		}

		public function getIdinterno_Lazos() {
			return $this -> idinterno_lazos;
		}
		
		public function setRips($aux) {
			$this -> rips = $aux;
		}

		public function getRips() {
			return $this -> rips;
		}
		
		public function setPrefijo($aux) {
			$this -> prefijo = $aux;
		}

		public function getPrefijo() {
			return $this -> prefijo;
		}
		
		public function setConsecutivo($aux) {
			$this -> consecutivo = $aux;
		}

		public function getConsecutivo() {
			return $this -> consecutivo;
		}

		public function setFecha_Egreso($aux) {
			$this -> fecha_egreso = $aux;
		}
		
		public function getFecha_Egreso() {
			return $this -> fecha_egreso;
		}
		
		public function setFecha_Expedicion($aux) {
			$this -> fecha_expedicion = $aux;
		}

		public function getFecha_Expedicion() {
			return $this -> fecha_expedicion;
		}
		
		public function setFecha_Radicacion($aux) {
			$this -> fecha_radicacion = $aux;
		}

		public function getFecha_Radicacion() {
			return $this -> fecha_radicacion;
		}
		
		public function setFecha_Causacion($aux) {
			$this -> fecha_causacion = $aux;
		}

		public function getFecha_Causacion() {
			return $this -> fecha_causacion;
		}
		
		public function setDocumento_Causacion($aux) {
			$this -> documento_causacion = $aux;
		}

		public function getDocumento_Causacion() {
			return $this -> documento_causacion;
		}
		
		public function setValor_Facturado($aux) {
			$this -> valor_facturado = $aux;
		}

		public function getValor_Facturado() {
			return $this -> valor_facturado;
		}
		
		public function setFecha_Glosa_Inicial($aux) {
			$this -> fecha_glosa_inicial = $aux;
		}

		public function getFecha_Glosa_Inicial() {
			return $this -> fecha_glosa_inicial;
		}
		
		public function setDocumento_Glosa_Inicial($aux) {
			$this -> documento_glosa_inicial = $aux;
		}

		public function getDocumento_Glosa_Inicial() {
			return $this -> documento_glosa_inicial;
		}
		
		public function setValor_Glosado($aux) {
			$this -> valor_glosado = $aux;
		}

		public function getValor_Glosado() {
			return $this -> valor_glosado;
		}	

		public function setExiste_conciliacion($aux) {
			$this -> existe_conciliacion = $aux;
		}

		public function getExiste_conciliacion() {
			return $this -> existe_conciliacion;
		}	

		public function setFecha_Conciliacion($aux) {
			$this -> fecha_conciliacion = $aux;
		}

		public function getFecha_Conciliacion() {
			return $this -> fecha_conciliacion;
		}
		
		public function setDocumento_Conciliacion($aux) {
			$this -> documento_conciliacion = $aux;
		}

		public function getDocumento_Conciliacion() {
			return $this -> documento_conciliacion;
		}

		public function setValor_Glosa_Favor_Eps($aux) {
			$this -> valor_glosa_favor_eps = $aux;
		}

		public function getValor_Glosa_Favor_Eps() {
			return $this -> valor_glosa_favor_eps;
		}

		public function setValor_Glosa_Favor_Ips($aux) {
			$this -> valor_glosa_favor_ips = $aux;
		}

		public function getValor_Glosa_Favor_Ips() {
			return $this -> valor_glosa_favor_ips;
		}
		
		public function setValor_Impuesto_Real($aux) {
			$this -> valor_impuesto_real = $aux;
		}

		public function getValor_Impuesto_Real() {
			return $this -> valor_impuesto_real;
		}
		
		public function setValor_Impuesto_Contable($aux) {
			$this -> valor_impuesto_contable = $aux;
		}

		public function getValor_Impuesto_Contable() {
			return $this -> valor_impuesto_contable;
		}
		
		public function setFecha_Pago($aux) {
			$this -> fecha_pago = $aux;
		}

		public function getFecha_Pago() {
			return $this -> fecha_pago;
		}
		
		public function setDocumento_Pago($aux) {
			$this -> documento_pago = $aux;
		}

		public function getDocumento_Pago() {
			return $this -> documento_pago;
		}
		
		public function setValor_Pagado($aux) {
			$this -> valor_pagado = $aux;
		}

		public function getValor_Pagado() {
			return $this -> valor_pagado;
		}

		public function setValor_Pagado_Total($aux) {
			$this -> valor_pagado_total = $aux;
		}

		public function getValor_Pagado_Total() {
			return $this -> valor_pagado_total;
		}
		
		public function setValor_Saldo($aux) {
			$this -> valor_saldo = $aux;
		}

		public function getValor_Saldo() {
			return $this -> valor_saldo;
		}

		public function __destruct () {}
	}
?>