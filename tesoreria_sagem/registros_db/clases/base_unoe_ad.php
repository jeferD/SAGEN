<?php
	class base_unoe_ad {

		public function __construct () {}

		public function listar ($pdo, $sql) {
            $arreglo = array();
			//echo $sql;
			$resultado = pg_query($sql);
			ini_set('memory_limit', '-1');
			while ($fila = pg_fetch_row($resultado)) {
				$objBaseunoe = new base_unoe();
				$objBaseunoe -> setId_UnoE($fila[0]);
				$objBaseunoe -> setCodigo_Regional($fila[1]);
				$objBaseunoe -> setCodigo_Regional_Documento($fila[2]);
				$objBaseunoe -> setAuxiliar($fila[3]);
				$objBaseunoe -> setDescripcion_Auxiliar($fila[4]);
				$objBaseunoe -> setNit($fila[5]);
				$objBaseunoe -> setNombre_Ips($fila[6]);
				$objBaseunoe -> setNumero_Radicado($fila[7]);
				$objBaseunoe -> setNumero_Cuenta_Cobro($fila[8]);
				$objBaseunoe -> setFecha($fila[9]);
				$objBaseunoe -> setDocumento($fila[10]);
				$objBaseunoe -> setDebito($fila[11]);
				$objBaseunoe -> setCredito($fila[12]);
				$objBaseunoe -> setNeto($fila[13]);
				$objBaseunoe -> setNota($fila[14]);
				$objBaseunoe -> setTipo_Movimiento($fila[15]);
				$objBaseunoe -> setNumero_Pago($fila[16]);
				$objBaseunoe -> setTasa_Impuesto_UnoE($fila[17]);
				$objBaseunoe -> setBase_Impuesto_UnoE($fila[18]);
				$objBaseunoe -> setFecha_Creacion($fila[19]);
				$objBaseunoe -> setFecha_Aprobacion($fila[20]);
				$objBaseunoe -> setTasa_Impuesto_Real($fila[21]);
				$objBaseunoe -> setBase_Impuesto_Real($fila[22]);
				$objBaseunoe -> setTipo_Impuesto($fila[23]);
				array_push($arreglo, $objBaseunoe);
				$objBaseunoe -> __destruct();
			}

			return $arreglo;
 		}

 		public function buscarxid($id) {
			$arreglo = array();
			$sql="SELECT * FROM tesoreria_evento.base_unoe WHERE numero_radicado = $id";
			//echo $sql;
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objBaseunoe = new base_unoe();
				$objBaseunoe -> setId_UnoE($fila[0]);
				$objBaseunoe -> setCodigo_Regional($fila[1]);
				$objBaseunoe -> setCodigo_Regional_Documento($fila[2]);
				$objBaseunoe -> setAuxiliar($fila[3]);
				$objBaseunoe -> setDescripcion_Auxiliar($fila[4]);
				$objBaseunoe -> setNit($fila[5]);
				$objBaseunoe -> setNombre_Ips($fila[6]);
				$objBaseunoe -> setNumero_Radicado($fila[7]);
				$objBaseunoe -> setNumero_Cuenta_Cobro($fila[8]);
				$objBaseunoe -> setFecha($fila[9]);
				$objBaseunoe -> setDocumento($fila[10]);
				$objBaseunoe -> setDebito($fila[11]);
				$objBaseunoe -> setCredito($fila[12]);
				$objBaseunoe -> setNeto($fila[13]);
				$objBaseunoe -> setNota($fila[14]);
				$objBaseunoe -> setTipo_Movimiento($fila[15]);
				$objBaseunoe -> setNumero_Pago($fila[16]);
				$objBaseunoe -> setTasa_Impuesto_UnoE($fila[17]);
				$objBaseunoe -> setBase_Impuesto_UnoE($fila[18]);
				$objBaseunoe -> setFecha_Creacion($fila[19]);
				$objBaseunoe -> setFecha_Aprobacion($fila[20]);
				$objBaseunoe -> setTasa_Impuesto_Real($fila[21]);
				$objBaseunoe -> setBase_Impuesto_Real($fila[22]);
				$objBaseunoe -> setTipo_Impuesto($fila[23]);
				array_push($arreglo, $objBaseunoe);

			}

			return $objBaseunoe;
			$objBaseunoe -> __destruct();
 		}

 		public function eliminar($pdo, $objAux) {
 			$id=$objAux -> getId_UnoE();
 			$result = pg_query("delete from tesoreria_evento.base_unoe where id = $id ");
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar borrar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function crear ($objAux) {

			$codigo_regional = $objAux -> getCodigo_Regional();
			$codigo_regional_documento = $objAux -> getCodigo_Regional_Documento();
			$auxiliar = $objAux -> getAuxiliar();
			//$descripcion_auxiliar = $objAux -> getDescripcion_Auxiliar();
			$nit = $objAux -> getNit();
			//$nombre_ips = $objAux -> getNombre_Ips();
			$numero_radicado = $objAux -> getNumero_Radicado();
			$numero_cuenta_cobro = $objAux -> setNumero_Cuenta_Cobro();
			$fecha = $objAux -> getFecha();
			$documento = $objAux -> getDocumento();
			$debito = $objAux -> getDebito();
			$credito = $objAux -> getCredito();
			$neto = $objAux -> getNeto();
			$nota = $objAux -> getNota();
			$tipo_movimiento = $objAux -> getTipo_Movimiento();
			$numero_pagos = $objAux -> getNumero_Pago();
			$tasa_impuesto_unoe = $objAux -> getTasa_Impuesto_UnoE();
			$base_impuesto_unoe = $objAux -> getBase_Impuesto_UnoE();
			$fecha_creacion = $objAux -> getFecha_Creacion();
			$fecha_aprobacion = $objAux -> getFecha_Aprobacion();
			$tasa_impuesto_real = $objAux -> getTasa_Impuesto_Real();
			$base_impuesto_real = $objAux -> getBase_Impuesto_Real();
			$tipo_impuesto = $objAux -> getTipo_Impuesto();

			$qry = "insert into tesoreria_evento.base_unoe ( codigo_regional, codigo_regional_documento, auxiliar, 
											nit, numero_radicado, numero_cuenta_cobro, fecha, documento, 
											debito, credito, neto, nota, tipo_movimiento, numero_pagos, tasa_impuesto_unoe, 
											base_impuesto_unoe, fecha_creacion, fecha_aprobacion, tasa_impuesto_real, 
											base_impuesto_real, tipo_impuesto)
						values('$codigo_regional','$codigo_regional_documento','$auxiliar','$nit','$numero_radicado','$numero_cuenta_cobro','$fecha','$documento','$debito','$credito','$neto','$nota','$tipo_movimiento','$numero_pagos','$tasa_impuesto_unoe','$base_impuesto_unoe','$fecha_creacion','$fecha_aprobacion','$tasa_impuesto_real','$base_impuesto_real','$tipo_impuesto')";

            $result = pg_query($qry);
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar adicionar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function actualizar ($objAux,$id) {

			$codigo_regional = $objAux -> getCodigo_Regional();
			$codigo_regional_documento = $objAux -> getCodigo_Regional_Documento();
			$auxiliar = $objAux -> getAuxiliar();
			$nit = $objAux -> getNit();
			$numero_radicado = $objAux -> getNumero_Radicado();
			$numero_cuenta_cobro = $objAux -> setNumero_Cuenta_Cobro();
			$fecha = $objAux -> getFecha();
			$documento = $objAux -> getDocumento();
			$debito = $objAux -> getDebito();
			$credito = $objAux -> getCredito();
			$neto = $objAux -> getNeto();
			$nota = $objAux -> getNota();
			$tipo_movimiento = $objAux -> getTipo_Movimiento();
			$numero_pagos = $objAux -> getNumero_Pago();
			$tasa_impuesto_unoe = $objAux -> getTasa_Impuesto_UnoE();
			$base_impuesto_unoe = $objAux -> getBase_Impuesto_UnoE();
			$fecha_creacion = $objAux -> getFecha_Creacion();
			$fecha_aprobacion = $objAux -> getFecha_Aprobacion();
			$tasa_impuesto_real = $objAux -> getTasa_Impuesto_Real();
			$base_impuesto_real = $objAux -> getBase_Impuesto_Real();
			$tipo_impuesto = $objAux -> getTipo_Impuesto();			

			$qry = "update  tesoreria_evento.base_unoe set codigo_regional='$codigo_regional',codigo_regional_documento='$codigo_regional_documento',auxiliar='$auxiliar',nit='$nit',numero_radicado='$numero_radicado',numero_cuenta_cobro='$numero_cuenta_cobro',fecha='$fecha',
							documento='$documento',debito='$debito',credito='$credito',neto='$neto',nota='$nota',tipo_movimiento='$tipo_movimiento',numero_pagos='$numero_pagos',tasa_impuesto_unoe='$tasa_impuesto_unoe',base_impuesto_unoe='$base_impuesto_unoe',fecha_creacion='$fecha_creacion',
							fecha_aprobacion='$fecha_aprobacion',tasa_impuesto_real='$tasa_impuesto_real',base_impuesto_real='$base_impuesto_real',tipo_impuesto='$tipo_impuesto'
							where id_unoe = $id";


			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" La pqrs fue actualizada satisfactoriamente");window.location="index.php"</script>';

 		}
		
		public function __destruct () {}
	}
?>