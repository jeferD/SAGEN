<?php
	class factura_ad {

		public function __construct () {}

		public function listar ($pdo, $sql) {
            $arreglo = array();
			//echo $sql;
			$resultado = pg_query($sql);
			ini_set('memory_limit', '-1');
			while ($fila = pg_fetch_row($resultado)) {
				$objFactura = new factura();
				$objFactura -> setNumero_Contrato($fila[0]);
				$objFactura -> setCodigo_Regional($fila[1]);
				$objFactura -> setModalidad($fila[2]);
				$objFactura -> setAuxiliar($fila[3]);
				$objFactura -> setDescripcion_Auxiliar($fila[4]);
				$objFactura -> setNit($fila[5]);
				$objFactura -> setNombre_Ips($fila[6]);
				$objFactura -> setNumero_Radicado($fila[7]);
				$objFactura -> setNumero_Cuenta_Cobro($fila[8]);
				$objFactura -> setIdfactura($fila[9]);
				$objFactura -> setIdinterno_Lazos($fila[10]);
				$objFactura -> setRips($fila[11]);
				$objFactura -> setPrefijo($fila[12]);
				$objFactura -> setConsecutivo($fila[13]);
				$objFactura -> setFecha_Egreso($fila[14]);
				$objFactura -> setFecha_Expedicion($fila[15]);
				$objFactura -> setFecha_Radicacion($fila[16]);
				$objFactura -> setFecha_Causacion($fila[17]);
				$objFactura -> setDocumento_Causacion($fila[18]);
				$objFactura -> setValor_Facturado($fila[19]);
				$objFactura -> setFecha_Glosa_Inicial($fila[20]);
				$objFactura -> setDocumento_Glosa_Inicial($fila[21]);
				$objFactura -> setValor_Glosado($fila[22]);
				$objFactura -> setExiste_Conciliacion($fila[23]);
				$objFactura -> setFecha_Conciliacion($fila[24]);
				$objFactura -> setDocumento_Conciliacion($fila[25]);
				$objFactura -> setValor_Glosa_Favor_Eps($fila[26]);
				$objFactura -> setValor_Glosa_Favor_Ips($fila[27]);
				$objFactura -> setValor_Impuesto_Real($fila[28]);
				$objFactura -> setValor_Impuesto_Contable($fila[29]);
				$objFactura -> setFecha_Pago($fila[30]);
				$objFactura -> setDocumento_Pago($fila[31]);
				$objFactura -> setValor_Pagado($fila[32]);
				$objFactura -> setValor_Pagado_Total($fila[33]);
				$objFactura -> setValor_Saldo($fila[34]);
				array_push($arreglo, $objFactura);
				$objFactura -> __destruct();
			}

			return $arreglo;
 		}

 		public function buscarxid($id) {
			$arreglo = array();
			$sql="SELECT * FROM factura WHERE idrad = $id";
			//echo $sql;
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objFactura = new factura();
				$objFactura -> setNumero_Contrato($fila[0]);
				$objFactura -> setCodigo_Regional($fila[1]);
				$objFactura -> setModalidad($fila[2]);
				$objFactura -> setAuxiliar($fila[3]);
				$objFactura -> setDescripcion_Auxiliar($fila[4]);
				$objFactura -> setNit($fila[5]);
				$objFactura -> setNombre_Ips($fila[6]);
				$objFactura -> setNumero_Radicado($fila[7]);
				$objFactura -> setNumero_Cuenta_Cobro($fila[8]);
				$objFactura -> setIdfactura($fila[9]);
				$objFactura -> setIdinterno_Lazos($fila[10]);
				$objFactura -> setRips($fila[11]);
				$objFactura -> setPrefijo($fila[12]);
				$objFactura -> setConsecutivo($fila[13]);
				$objFactura -> setFecha_Egreso($fila[14]);
				$objFactura -> setFecha_Expedicion($fila[15]);
				$objFactura -> setFecha_Radicacion($fila[16]);
				$objFactura -> setFecha_Causacion($fila[17]);
				$objFactura -> setDocumento_Causacion($fila[18]);
				$objFactura -> setValor_Facturado($fila[19]);
				$objFactura -> setFecha_Glosa_Inicial($fila[20]);
				$objFactura -> setDocumento_Glosa_Inicial($fila[21]);
				$objFactura -> setValor_Glosado($fila[22]);
				$objFactura -> setExiste_Conciliacion($fila[23]);
				$objFactura -> setFecha_Conciliacion($fila[24]);
				$objFactura -> setDocumento_Conciliacion($fila[25]);
				$objFactura -> setValor_Glosa_Favor_Eps($fila[26]);
				$objFactura -> setValor_Glosa_Favor_Ips($fila[27]);
				$objFactura -> setValor_Impuesto_Real($fila[28]);
				$objFactura -> setValor_Impuesto_Contable($fila[29]);
				$objFactura -> setFecha_Pago($fila[30]);
				$objFactura -> setDocumento_Pago($fila[31]);
				$objFactura -> setValor_Pagado($fila[32]);
				$objFactura -> setValor_Pagado_Total($fila[33]);
				$objFactura -> setValor_Saldo($fila[34]);
				array_push($arreglo, $objFactura);

			}

			return $objFactura;
			$objFactura -> __destruct();
 		}

 		public function eliminar($pdo, $objAux) {
 			$id=$objAux -> getId();
 			$result = pg_query("delete from factura where id = $id ");
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar borrar el registro"'.$errormessage.');"</script>';
			}
 		}
		
		public function __destruct () {}
	}
?>