<?php
	class pqrs_ad {

		public function __construct () {}

		public function listar ($pdo, $sql) {
            $arreglo = array();

			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objPrqs = new pqrs();
				$objPrqs -> setId($fila[0]);
				$objPrqs -> setFecha_Rad($fila[1]);
				$objPrqs -> setFecha_Envio_Ges($fila[2]);
				$objPrqs -> setTipo_Id($fila[3]);
				$objPrqs -> setDocto_Id($fila[4]);
				$objPrqs -> setCod_Registro($fila[5]);
				$objPrqs -> setAsignado($fila[6]);
				$objPrqs -> setNombres($fila[7]);
				$objPrqs -> setCiudad($fila[8]);
				$objPrqs -> setDepartamento($fila[9]);
				$objPrqs -> setEspecifico($fila[10]);
				$objPrqs -> setMotivo($fila[11]);
				$objPrqs -> setCambio_Motivo($fila[12]);
				$objPrqs -> setDiagnostico($fila[13]);
				$objPrqs -> setTipo($fila[14]);
				$objPrqs -> setFecha_Venc($fila[15]);
				$objPrqs -> setIps($fila[16]);
				$objPrqs -> setObservaciones($fila[17]);
				$objPrqs -> setPlan($fila[18]);
				$objPrqs -> setNo_Caso($fila[19]);
				$objPrqs -> setResponsable($fila[20]);
				$objPrqs -> setResponsable_Ges($fila[21]);
				$objPrqs -> setFecha_Entrega_Ges($fila[22]);
				$objPrqs -> setObservacion($fila[23]);
				$objPrqs -> setFecha_Envio($fila[24]);
				$objPrqs -> setEstado($fila[25]);
				$objPrqs -> setTiempo_Gestion($fila[26]);
				$objPrqs -> setobserv_pqrs($fila[27]);
				array_push($arreglo, $objPrqs);
				$objPrqs -> __destruct();
			}

			return $arreglo;
 		}

 		public function buscarxid($id) {
			$arreglo = array();
			$sql="SELECT * FROM gestion_pqrs WHERE id=$id";
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objPrqs = new pqrs();
				$objPrqs -> setId($fila[0]);
				$objPrqs -> setFecha_Rad($fila[1]);
				$objPrqs -> setFecha_Envio_Ges($fila[2]);
				$objPrqs -> setTipo_Id($fila[3]);
				$objPrqs -> setDocto_Id($fila[4]);
				$objPrqs -> setCod_Registro($fila[5]);
				$objPrqs -> setAsignado($fila[6]);
				$objPrqs -> setNombres($fila[7]);
				$objPrqs -> setCiudad($fila[8]);
				$objPrqs -> setDepartamento($fila[9]);
				$objPrqs -> setEspecifico($fila[10]);
				$objPrqs -> setMotivo($fila[11]);
				$objPrqs -> setCambio_Motivo($fila[12]);
				$objPrqs -> setDiagnostico($fila[13]);
				$objPrqs -> setTipo($fila[14]);
				$objPrqs -> setFecha_Venc($fila[15]);
				$objPrqs -> setIps($fila[16]);
				$objPrqs -> setObservaciones($fila[17]);
				$objPrqs -> setPlan($fila[18]);
				$objPrqs -> setNo_Caso($fila[19]);
				$objPrqs -> setResponsable($fila[20]);
				$objPrqs -> setResponsable_Ges($fila[21]);
				$objPrqs -> setFecha_Entrega_Ges($fila[22]);
				$objPrqs -> setObservacion($fila[23]);
				$objPrqs -> setFecha_Envio($fila[24]);
				$objPrqs -> setEstado($fila[25]);
				$objPrqs -> setTiempo_Gestion($fila[26]);
				$objPrqs -> setobserv_pqrs($fila[27]);
				array_push($arreglo, $objPrqs);

			}

			return $objPrqs;
			$objPrqs -> __destruct();
 		}

 		public function eliminar($pdo, $objAux) {
 			$id=$objAux -> getId();
 			$result = pg_query("delete from gestion_pqrs where id = $id ");
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar borrar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function actualizar ($objAux,$id) {


			$responsable_ges = $objAux -> getResponsable_Ges();
			$fecha_entrega_ges = $objAux -> getFecha_Entrega_Ges();
			$observacion = $objAux -> getObservacion();
			$fecha_envio = $objAux -> getFecha_Envio();
			$estado = $objAux -> getEstado();
			$tiempo_gestion = $objAux -> getTiempo_Gestion();
			$observ_pqrs= $objAux -> getobserv_pqrs();

			$qry = "update  gestion_pqrs set responsable_ges='$responsable_ges',fecha_entrega_ges='$fecha_entrega_ges',observacion='$observacion',
			fecha_envio='$fecha_envio',estado='$estado',tiempo_gestion='$tiempo_gestion',observ_pqrs='$observ_pqrs' where id = $id";


			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" La pqrs fue actualizada satisfactoriamente");window.location="actualizar.php?id='.$id.'"</script>';
			//echo $qry;
 		}


		public function __destruct () {}
	}
?>