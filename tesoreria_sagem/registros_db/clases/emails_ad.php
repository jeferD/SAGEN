<?php
	class emails_ad {

		public function __construct () {}

		public function listar ($pdo, $sql) {
            $arreglo = array();
			//echo $sql;
			$resultado = pg_query($sql);
			ini_set('memory_limit', '-1');
			while ($fila = pg_fetch_row($resultado)) {
				$objEmails = new emails();
				$objEmails -> setId($fila[0]);
				$objEmails -> setNit($fila[1]);
				$objEmails -> setNomips($fila[2]);
				$objEmails -> setEmail($fila[3]);
				$objEmails -> setActivo($fila[4]);
				array_push($arreglo, $objEmails);
				$objEmails -> __destruct();
			}

			return $arreglo;
 		}

 		public function buscarxid($id) {
			$arreglo = array();
			$sql="select * from tesoreria_global.emails WHERE id = $id";
			//echo $sql;
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objEmails = new emails();
				$objEmails -> setId($fila[0]);
				$objEmails -> setNit($fila[1]);
				$objEmails -> setNomips($fila[2]);
				$objEmails -> setEmail($fila[3]);
				$objEmails -> setActivo($fila[4]);
				array_push($arreglo, $objEmails);

			}

			return $objEmails;
			$objEmails -> __destruct();
 		}

 		public function eliminar ($objAux,$id) {

			$id = $objAux -> getId();
			$nit = $objAux -> getNit();
			$nomips = $objAux -> getNomips();
			$email = $objAux -> getEmail();
			$activo = false;
			
			$qry1 = "update tesoreria_global.emails set activo='false' where id = $id";

			if (!pg_query($qry1)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" El EMAiL fue Eliminado satisfactoriamente");window.location="emails.php"</script>';

 		}

		public function crear ($objAux) {

			$id = $objAux -> getId();
			$nit = $objAux -> getNit();
			$nomips = $objAux -> getNomips();
			$email = $objAux -> getEmail();
			$activo = true;

			$qry = "insert into tesoreria_global.emails (nit,nombre,email)
						values('$nit','$nomips','$email')";
			
			//echo $qry;
            $result = pg_query($qry);
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar adicionar el registro"'.$errormessage.');"</script>';
			}
 		}

		public function actualizar ($objAux,$id) {

			$id = $objAux -> getId();
			$nit = $objAux -> getNit();
			$nomips = $objAux -> getNomips();
			$email = $objAux -> getEmail();
			
			$qry = "update tesoreria_global.emails set email='$email' where id = $id";

			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" El EMaIl fue actualizado satisfactoriamente");window.location="emails.php"</script>';

 		}
		
		public function __destruct () {}
	}
?>