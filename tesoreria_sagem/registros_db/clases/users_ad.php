<?php
	class users_ad {

		public function __construct () {}

		public function buscarxid($us,$pass) {
			$sql="SELECT noid FROM tesoreria_global.usuarios WHERE usuario='$us' AND pass='$pass'";
			$result = pg_query($sql);

			if( pg_num_rows($result) <> 0){
				$noid = pg_result($result,0,0);
				return $noid;
			}
			else return 0;
 		}
		
		public function listar ($pdo, $sql) {
            $arreglo = array();

			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objUsuario = new usuario();
				$objUsuario -> setId($fila[0]);
				$objUsuario -> setNoId($fila[6]);
				$objUsuario -> setNombres($fila[1]);
				$objUsuario -> setUsuario($fila[2]);
				$objUsuario -> setPass($fila[3]);
				$objUsuario -> setTipo($fila[4]);
				$objUsuario -> setRegional($fila[5]);
				$objUsuario -> setEmail($fila[7]);
				array_push($arreglo, $objUsuario);
				$objUsuario -> __destruct();
			}

			return $arreglo;
 		}
		
		public function buscarid($id) {
			$arreglo = array();
			$sql="SELECT * FROM tesoreria_global.usuarios WHERE id=$id";
			$resultado = pg_query($sql);

			while ($fila = pg_fetch_row($resultado)) {
				$objUsuario = new usuario();
				$objUsuario -> setId($fila[0]);
				$objUsuario -> setNoId($fila[6]);
				$objUsuario -> setNombres($fila[1]);
				$objUsuario -> setUsuario($fila[2]);
				$objUsuario -> setPass($fila[3]);
				$objUsuario -> setTipo($fila[4]);
				$objUsuario -> setRegional($fila[5]);
				$objUsuario -> setEmail($fila[7]);
				array_push($arreglo, $objUsuario);
			}

			return $objUsuario;
			$objUsuario -> __destruct();
 		}
		
		
 		public function eliminar($pdo, $objAux) {
 			$id=$objAux -> getId();
			echo 'este es el id: '.$id.' ';
 			$result = pg_query("delete from tesoreria_global.usuarios where id = $id;");
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar borrar el registro"'.$errormessage.');"</script>';
			}else{
					echo'<a href="index.php" >';
			}
 		}
		
		public function crear ($objAux) {
			$noid = $objAux -> getNoId();
			$nombres = $objAux -> getNombres();
			$login = $objAux -> getUsuario();
			$password = $objAux -> getPass();
			$tipo = $objAux -> getTipo();
			$tipo = $objAux -> getRegional();
			$tipo = $objAux -> getEmail();
			
			$qry = "insert into tesoreria_global.usuarios (noid,nombres,usuario,pass,tipo,regional,email)
						values('$noid','$nombres','$usuario','$pass',$tipo,$regional,$email)";

            $result = pg_query($qry);
			if (!$result) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar adicionar el registro '.$errormessage.'");</script>';
			}
 		}
		
		public function actualizar ($objAux,$id) {

			$noid = $objAux -> getNoId();
			$nombres = $objAux -> getNombres();
			$usuario = $objAux -> getUsuario();
			$pass = $objAux -> getPass();
			$tipo = $objAux -> gettipo();
			$regional = $objAux -> getRegional();
			$email = $objAux -> getEmail();
			
			$qry = "update tesoreria_global.usuarios set noid='$noid',nombres='$nombres',usuario='$usuario',pass='$pass',tipo='$tipo',regional='$regional',email='$email'
			                             where id = '$id' ";

			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
			}else echo'<script type="text/javascript">alert(" El usuario fue actualizada satisfactoriamente");window.location="index.php"</script>';

 		}
		
		public function actualizarclave ($pass,$id) {

			$qry = "update tesoreria_global.usuarios set pass='$pass' where id = '$id' ";
			//echo $qry;

			if (!pg_query($qry)) {
				$errormessage = pg_last_error();
				echo'<script type="text/javascript">alert("Se presento un error al intentar actualizar el registro"'.$errormessage.');"</script>';
				return false;
			}else return true; // echo'<script type="text/javascript">alert(" El usuario fue actualizada satisfactoriamente");window.location="usu_index.php"</script>';

 		}

		public function __destruct () {}
	}
?>