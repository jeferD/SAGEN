<?php
	class pqrs {
		private $id;
		private $fecha_rad;
		private $fecha_envio_ges;
		private $tipo_id;
		private $docto_id;
		private $cod_registro;
		private $asignado;
		private $nombres;
		private $ciudad;
		private $departamento;
		private $especifico;
		private $motivo;
		private $cambio_motivo;
		private $diagnostico;
		private $tipo;
		private $fecha_venc;
		private $ips;
		private $observaciones;
		private $plan;
		private $no_caso ;
		private $responsable ;
		private $responsable_ges;
		private $fecha_entrega_ges;
		private $observacion;
		private $fecha_envio;
		private $estado;
		private $tiempo_gestion;
		private $observ_pqrs;


		public function __construct () {
			$this -> id = "";
			$this -> fecha_rad = "";
			$this -> fecha_envio_ges = "";
			$this -> tipo_id = "";
			$this -> docto_id = "";
			$this -> cod_registro = "";
			$this -> asignado = "";
			$this -> nombres = "";
			$this -> ciudad = "";
			$this -> departamento = "";
			$this -> especifico = "";
			$this -> motivo = "";
			$this -> cambio_motivo = "";
			$this -> diagnostico = "";
			$this -> tipo = "";
			$this -> fecha_venc = "";
			$this -> ips = "";
			$this -> observaciones = "";
			$this -> plan = "";
			$this -> no_caso  = "";
			$this -> responsable  = "";
			$this -> responsable_ges = "";
			$this -> fecha_entrega_ges = "";
			$this -> observacion = "";
			$this -> fecha_envio = "";
			$this -> estado = "";
			$this -> tiempo_gestion = "";
			$this -> observ_pqrs = "";
		}

		public function setId($aux) {
			$this -> id  = $aux;
		}

		public function getId() {
			return $this -> id;
		}

		public function setFecha_Rad($aux) {
			$this -> fecha_rad  = $aux;
		}

		public function getFecha_Rad() {
			return $this -> fecha_rad  ;
		}

		public function setFecha_Envio_Ges($aux) {
			$this -> fecha_envio_ges  = $aux;
		}

		public function getFecha_Envio_Ges() {
			return $this -> fecha_envio_ges;
		}

		public function setTipo_Id($aux) {
			$this -> tipo_id = $aux;
		}

		public function getTipo_Id() {
			return $this -> tipo_id;
		}

		public function setDocto_Id($aux) {
			$this -> docto_id = $aux;
		}

		public function getDocto_Id() {
			return $this -> docto_id;
		}

		public function setCod_Registro($aux) {
			$this -> cod_registro  = $aux;
		}

		public function getCod_Registro() {
			return $this -> cod_registro ;
		}

		public function setAsignado($aux) {
			$this -> asignado  = $aux;
		}

		public function getAsignado() {
			return $this -> asignado ;
		}

		public function setNombres($aux) {
			$this -> nombres = $aux;
		}

		public function getNombres() {
			return $this -> nombres;
		}

		public function setCiudad($aux) {
			$this -> ciudad  = $aux;
		}

		public function getCiudad() {
			return $this -> ciudad ;
		}

		public function setDepartamento($aux) {
			$this -> departamento  = $aux;
		}

		public function getDepartamento() {
			return $this -> departamento ;
		}

		public function setEspecifico($aux) {
			$this -> especifico  = $aux;
		}

		public function getEspecifico() {
			return $this -> especifico ;
		}

		public function setMotivo($aux) {
			$this -> motivo  = $aux;
		}

		public function getMotivo() {
			return $this -> motivo ;
		}

		public function setCambio_Motivo($aux) {
			$this -> cambio_motivo  = $aux;
		}

		public function getCambio_Motivo() {
			return $this -> cambio_motivo ;
		}

		public function setDiagnostico($aux) {
			$this -> diagnostico  = $aux;
		}

		public function getDiagnostico() {
			return $this -> diagnostico ;
		}

		public function setTipo($aux) {
			$this -> tipo  = $aux;
		}

		public function getTipo() {
			return $this -> tipo ;
		}

		public function setFecha_Venc($aux) {
			$this -> fecha_venc  = $aux;
		}

		public function getFecha_Venc() {
			return $this -> fecha_venc ;
		}

		public function setIps($aux) {
			$this -> ips  = $aux;
		}

		public function getIps() {
			return $this -> ips ;
		}

		public function setObservaciones($aux) {
			$this -> observaciones  = $aux;
		}

		public function getObservaciones() {
			return $this -> observaciones ;
		}

		public function setPlan($aux) {
			$this -> plan  = $aux;
		}

		public function getPlan() {
			return $this -> plan ;
		}

		public function setNo_Caso($aux) {
			$this -> no_caso  = $aux;
		}

		public function getNo_Caso() {
			return $this -> no_caso ;
		}

		public function setResponsable($aux) {
			$this -> responsable  = $aux;
		}

		public function getResponsable() {
			return $this -> responsable ;
		}

		public function setResponsable_Ges($aux) {
			$this -> responsable_ges  = $aux;
		}

		public function getResponsable_Ges() {
			return $this -> responsable_ges ;
		}

		public function setFecha_Entrega_Ges($aux) {
			$this -> fecha_entrega_ges  = $aux;
		}

		public function getFecha_Entrega_Ges() {
			return $this -> fecha_entrega_ges ;
		}

		public function setObservacion($aux) {
			$this -> observacion  = $aux;
		}

		public function getObservacion() {
			return $this -> observacion ;
		}

		public function setFecha_Envio($aux) {
			$this -> fecha_envio  = $aux;
		}

		public function getFecha_Envio() {
			return $this -> fecha_envio ;
		}

		public function setEstado($aux) {
			$this -> estado   = $aux;
		}

		public function getEstado() {
			return $this -> estado  ;
		}

		public function setTiempo_Gestion($aux) {
			$this -> tiempo_gestion  = $aux;
		}

		public function getTiempo_Gestion() {
			return $this -> tiempo_gestion ;
		}

		public function setobserv_pqrs($aux) {
					$this -> observ_pqrs  = $aux;
				}

		public function getobserv_pqrs() {
					return $this -> observ_pqrs ;
		}



		public function __destruct () {}
	}
?>