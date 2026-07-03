<?php
	class cubos_ad {

		public function __construct () {}

		public function listar ($pdo, $sql) {
            $arreglo = array();
			//echo $sql;
			$resultado = pg_query($sql);
			ini_set('memory_limit', '-1');
			while ($fila = pg_fetch_row($resultado)) {
				$objCubos = new cubos();
				$objCubos -> setNiteps($fila[0]);
				$objCubos -> setNitips($fila[1]);
				$objCubos -> setVrfacturaeps($fila[2]);
				$objCubos -> setVrglosaaceptadaeps($fila[3]);
				$objCubos -> setVrpagototaleps($fila[4]);
				$objCubos -> setVrsaldoeps($fila[5]);
				$objCubos -> setVrfacturaips($fila[6]);
				$objCubos -> setVrglosaaceptadaips($fila[7]);
				$objCubos -> setVrpagototalips($fila[8]);
				$objCubos -> setVrsaldoips($fila[9]);
				$objCubos -> setNomeps($fila[10]);
				$objCubos -> setNomips($fila[11]);
				$objCubos -> setDiferencia($fila[12]);
				$objCubos -> setCoincidencia($fila[13]);
				array_push($arreglo, $objCubos);
				$objCubos -> __destruct();
			}

			return $arreglo;
 		}

 		public function buscarxid($id) {
			$arreglo = array();
			$sql="SELECT * FROM tesoreria_sac.cubos WHERE nitips = $id";
			//echo $sql;
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objCubos = new cubos();
				$objCubos -> setNiteps($fila[0]);
				$objCubos -> setNitips($fila[1]);
				$objCubos -> setVrfacturaeps($fila[2]);
				$objCubos -> setVrglosaaceptadaeps($fila[3]);
				$objCubos -> setVrpagototaleps($fila[4]);
				$objCubos -> setVrsaldoeps($fila[5]);
				$objCubos -> setVrfacturaips($fila[6]);
				$objCubos -> setVrglosaaceptadaips($fila[7]);
				$objCubos -> setVrpagototalips($fila[8]);
				$objCubos -> setVrsaldoips($fila[9]);
				$objCubos -> setNomeps($fila[10]);
				$objCubos -> setNomips($fila[11]);
				$objCubos -> setDiferencia($fila[12]);
				$objCubos -> setCoincidencia($fila[13]);
				array_push($arreglo, $objCubos);

			}

			return $objCubos;
			$objCubos -> __destruct();
 		}

 		public function eliminar($pdo, $objAux) {
 			$id=$objAux -> getId();
 			$result = pg_query("delete from tesoreria_sac.cubos where id = $id ");
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar borrar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function crear ($objAux) {

			$niteps = $objAux -> getNitips();
			$nitips = $objAux -> getNiteps();
			$vrfacturaeps = $objAux -> getVrfacturaeps();
			$vrglosaaceptadaeps = $objAux -> getVrglosaaceptadaepst();
			$vrpagototaleps = $objAux -> getVrpagototaleps();
			$vrsaldoeps = $objAux -> getVrsaldoeps();
			$vrfacturaips = $objAux -> getVrfacturaips();
			$vrglosaaceptadaips = $objAux -> getVrglosaaceptadaips();
			$vrpagototalips = $objAux -> getVrpagototalips();
			$vrsaldoips = $objAux -> getVrsaldoips();
			$nomeps = $objAux -> getNomeps();
			$nomips = $objAux -> getNomips();
			$diferencia = $objAux -> getDiferencia();
			$coincidencia = $objAux -> getCoincidencia();
			
			$qry = "insert into tesoreria_sac.cubos (niteps,nitips,vrfacturaeps,vrglosaaceptadaeps,vrpagototaleps,vrsaldoeps,vrfacturaips,vrglosaaceptadaips,vrpagototalips,vrsaldoips,nomeps,nomips,diferencia,coincidencia)
						values('$niteps','$nitips','$vrfacturaeps','$vrglosaaceptadaeps','$vrpagototaleps','$vrsaldoeps','$vrfacturaips','$vrglosaaceptadaips','$vrpagototalips','$vrsaldoips','$nomeps','$nomips','$diferencia','$coincidencia')";

            $result = pg_query($qry);
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar adicionar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function actualizar ($objAux,$id) {

			$niteps = $objAux -> getNitips();
			$nitips = $objAux -> getNiteps();
			$vrfacturaeps = $objAux -> getVrfacturaeps();
			$vrglosaaceptadaeps = $objAux -> getVrglosaaceptadaepst();
			$vrpagototaleps = $objAux -> getVrpagototaleps();
			$vrsaldoeps = $objAux -> getVrsaldoeps();
			$vrfacturaips = $objAux -> getVrfacturaips();
			$vrglosaaceptadaips = $objAux -> getVrglosaaceptadaips();
			$vrpagototalips = $objAux -> getVrpagototalips();
			$vrsaldoips = $objAux -> getVrsaldoips();
			$nomeps = $objAux -> getNomeps();
			$nomips = $objAux -> getNomips();
			$diferencia = $objAux -> getDiferencia();
			$coincidencia = $objAux -> getCoincidencia();
			

			$qry = "update tesoreria_sac.cubos set niteps='$niteps',nitips='$nitips',vrfacturaeps='$vrfacturaeps',vrglosaaceptadaeps='$vrglosaaceptadaeps',vrpagototaleps='$vrpagototaleps',vrsaldoeps='$vrsaldoeps',vrfacturaips='$vrfacturaips',
			vrglosaaceptadaips='$vrglosaaceptadaips',vrpagototalips='$vrpagototalips',vrsaldoips='$vrsaldoips',nomeps='$nomeps',nomips='$nomips',diferencia='$diferencia',coincidencia='$coincidencia' where id = $id";


			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" La pqrs fue actualizada satisfactoriamente");window.location="index.php"</script>';

 		}
		
		public function listarindicador ($pdo, $sql) {
            $arreglo = array();
			//echo $sql;
			$resultado = pg_query($sql);
			ini_set('memory_limit', '-1');
			while ($fila = pg_fetch_row($resultado)) {
				$objIndicador = new indicador();
				$objIndicador -> setFecha_corte($fila[0]);
				$objIndicador -> setNiteps($fila[1]);
				$objIndicador -> setNomeps($fila[2]);
				$objIndicador -> setVrsaldoeps($fila[3]);
				$objIndicador -> setVrsaldoips($fila[4]);
				$objIndicador -> setdiferencia($fila[5]);
				$objIndicador -> setNivel($fila[6]);
				array_push($arreglo, $objIndicador);
				$objIndicador -> __destruct();
			}

			return $arreglo;
 		}


		public function __destruct () {}
	}
?>