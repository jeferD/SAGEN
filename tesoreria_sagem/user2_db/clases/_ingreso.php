<!DOCTYPE html>
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
	<?php include('../library/lib.php');?>
	<body>


	    <h1 align = "center" style ="background-color:darkslategray"><font color = "white"><br><b> SISTEMA PQRS</b><br><br></font></h1>
		<div class="page-content">
		<div class="row">

		<?php include('_menu.php');?>


			<div class="col-md-10">
			  	<div class="content-box-large" style="text-align: center;">

			  	<div>
						<h5>FORMULARIO DE INGRESO - PQRS</h5>
				</div>
		<hr>
		<?php

			require('clases/conexion.php');
            require('clases/pqrs_ad.php');
            require('clases/pqrs.php');

		$pqrs = array();

			$id="";
			$fecha_rad="";
			$fecha_envio_ges="";
			$tipo_id="";
			$docto_id="";
			$cod_registro="";
			$asignado="";
			$nombres="";
			$ciudad="";
			$departamento="";
			$especifico="";
			$motivo="";
			$cambio_motivo="";
			$diagnostico="";
			$tipo="";
			$fecha_venc="";
			$ips="";
			$observaciones="";
			$plan="";
			$no_caso="";
			$responsable="";
			$responsable_ges="";
			$fecha_entrega_ges="";
			$observacion="";
			$fecha_envio="";
			$estado="";
			$tiempo_gestion="";

			if(array_key_exists('id', $_POST)){

			 if(empty($_POST['txtid']) || empty($_POST['txtfecha_rad']) || empty($_POST['txtfecha_envio_ges']) || empty($_POST['txttipo_id']) ||
				empty($_POST['txtdocto_id']) || empty($_POST['txtcod_registro']) || empty($_POST['txtasignado']) || empty($_POST['txtnombres']) ||
				empty($_POST['txtciudad']) || empty($_POST['txtdepartamento']) || empty($_POST['txtespecifico']) || empty($_POST['txtmotivo']) ||
				empty($_POST['txtcambio_motivo']) || empty($_POST['txtdiagnostico']) || empty($_POST['txttipo']) || empty($_POST['txtfecha_venc']) ||
				empty($_POST['txtips']) || empty($_POST['txtobservaciones']) || empty($_POST['txtplan']) || empty($_POST['txtno_caso']) ||
				empty($_POST['txtresponsable'])){
					echo'<script type="text/javascript">alert("Ingrese Todos Los Campos Del Formulario");window.location="ingreso.php"</script>';
				}
				else{
					$id = $_POST['id'];
					$fecha_rad = $_POST['fecha_rad'];
					$fecha_envio_ges = $_POST['fecha_envio_ges'];
					$tipo_id = $_POST['tipo_id'];
					$docto_id = $_POST['docto_id'];
					$cod_registro = $_POST['cod_registro'];
					$asignado = $_POST['asignado'];
					$nombres = $_POST['nombres'];
					$ciudad = $_POST['ciudad'];
					$departamento = $_POST['departamento'];
					$especifico = $_POST['especifico'];
					$motivo = $_POST['motivo'];
					$cambio_motivo = $_POST['cambio_motivo'];
					$diagnostico = $_POST['diagnostico'];
					$tipo = $_POST['tipo'];
					$fecha_venc = $_POST['fecha_venc'];
					$ips = $_POST['ips'];
					$observaciones = $_POST['observaciones'];
					$plan = $_POST['plan'];
					$no_caso = $_POST['no_caso'];
					$responsable = $_POST['responsable'];
					$responsable_ges = $_POST['responsable_ges'];
					$fecha_entrega_ges = $_POST['fecha_entrega_ges'];
					$observacion = $_POST['observacion'];
					$fecha_envio = $_POST['fecha_envio'];
					$estado = $_POST['estado'];
					$tiempo_gestion = $_POST['tiempo_gestion'];

					$objPqrss = new pqrs();
					$objPqrss -> setid($id);
					$objPqrss -> setfecha_rad($fecha_rad);
					$objPqrss -> setfecha_envio_ges($fecha_envio_ges);
					$objPqrss -> settipo_id($tipo_id);
					$objPqrss -> setdocto_id($docto_id);
					$objPqrss -> setcod_registro($cod_registro);
					$objPqrss -> setasignado($asignado);
					$objPqrss -> setnombres($nombres);
					$objPqrss -> setciudad($ciudad);
					$objPqrss -> setdepartamento($departamento);
					$objPqrss -> setespecifico($especifico);
					$objPqrss -> setmotivo($motivo);
					$objPqrss -> setcambio_motivo($cambio_motivo);
					$objPqrss -> setdiagnostico($diagnostico);
					$objPqrss -> settipo($tipo);
					$objPqrss -> setfecha_venc($fecha_venc);
					$objPqrss -> setips($ips);
					$objPqrss -> setobservaciones($observaciones);
					$objPqrss -> setplan($plan);
					$objPqrss -> setno_caso($no_caso);
					$objPqrss -> setresponsable($responsable);
					$objPqrss -> setresponsable_ges($responsable_ges);
					$objPqrss -> setfecha_entrega_ges($fecha_entrega_ges);
					$objPqrss -> setobservacion($observacion);
					$objPqrss -> setfecha_envio($fecha_envio);
					$objPqrss -> setestado($estado);
					$objPqrss -> settiempo_gestion($tiempo_gestion);

					$objConexion = new conexion();
					$objConexion -> abrir_conexion();

					$oobjPqrssAD = new pqrs_ad();

					$objPqrssAD -> crear($objConexion -> pdo, $objPqrss);
					$objPqrss -> __destruct();
					echo'<script type="text/javascript">alert(" La pqrs fue registrado satisfactoriamente");window.location="../index.php"</script>';
				}
			}
		?>

		<div class='panel-body'>
			<table border = "0" align = "center" bgcolor="darkslategray">
			<form name = "formularioIngresar" method = "post" action = "ingreso.php">
				<tr>
					<td><label for ="id"><font color = "white">Id:</font></label></td>
					<td><input type="text" name="id" placeholder = "Id De Pqrs" value = "<?php echo $id; ?>"></td>
				</tr>
				<tr>
					<td><label for ="fecha_rad"><font color = "white">FECHA RADICADO:</font></label></td>
					<td><input type="text" name="fecha_rad" placeholder = "fecha de radiacion" value = "<?php echo $fecha_rad; ?>"></td>
				</tr>
				<tr>
					<td><label for ="fecha_envio_ges"><font color = "white">FECHA ENVIO GESTION:</font></label></td>
					<td><input type="text" name="fecha_envio_ges" placeholder = "fecha de envio" value = "<?php echo $fecha_envio_ges; ?>"></td>
				<tr>
					<td><label for ="tipo_id"><font color = "white">TIPO ID:</font></label></td>
					<td><input type="text" name="tipo_id" placeholder = "tipo id" value = "<?php echo $tipo_id; ?>"></td>
				</tr>
				<tr>
					<td><label for ="docto_id"><font color = "white">DOCUMENTO ID:</font></label></td>
					<td><input type="text" name="docto_id" placeholder = "numero id" value = "<?php echo $docto_id; ?>"></td>
				</tr>
				<tr>
					<td><label for ="cod_registro"><font color = "white">CODIGO REGISTRO:</font></label></td>
					<td><input type="text" name="cod_registro" placeholder = "codido registro" value = "<?php echo $cod_registro; ?>"></td>
				</tr>
				<tr>
					<td><label for ="asignado"><font color = "white">ASIGNADO:</font></label></td>
					<td><input type="text" name="asignado" placeholder = "asignado" value = "<?php echo $asignado; ?>"></td>
				</tr>
				<tr>
					<td><label for ="nombres"><font color = "white">NOMBRES:</font></label></td>
					<td><input type="text" name="nombres" placeholder = "nombres completos" value = "<?php echo $nombres; ?>"></td>
				</tr>
				<tr>
					<td><label for ="ciudad"><font color = "white">CIUDAD:</font></label></td>
					<td><input type="text" name="ciudad" placeholder = "ciudad" value = "<?php echo $ciudad; ?>"></td>
				</tr>
				<tr>
					<td><label for ="departamento"><font color = "white">DEPARTAMENTO:</font></label></td>
					<td><input type="text" name="departamento" placeholder = "departamento" value = "<?php echo $departamento; ?>"></td>
				</tr>
				<tr>
					<td><label for ="especifico"><font color = "white">ESPECIFICO:</font></label></td>
					<td><input type="text" name="especifico" placeholder = "especifico" value = "<?php echo $especifico; ?>"></td>
				</tr>
				<tr>
					<td><label for ="motivo"><font color = "white">MOTIVO:</font></label></td>
					<td><input type="text" name="motivo" placeholder = "motivo" value = "<?php echo $motivo; ?>"></td>
				</tr>
				<tr>
					<td><label for ="cambio_motivo"><font color = "white">CAMBIO MOTIVO:</font></label></td>
					<td><input type="text" name="cambio_motivo" placeholder = "cambio motivo" value = "<?php echo $cambio_motivo; ?>"></td>
				</tr>
				<tr>
					<td><label for ="diagnostico"><font color = "white">DIAGNOSTICO:</font></label></td>
					<td><input type="text" name="diagnostico" placeholder = "diagnostico" value = "<?php echo $diagnostico; ?>"></td>
				</tr>
				<tr>
					<td><label for ="tipo"><font color = "white">TIPO:</font></label></td>
					<td><input type="text" name="tipo" placeholder = "tipo" value = "<?php echo $tipo; ?>"></td>
				</tr>
				<tr>
					<td><label for ="fecha_venc"><font color = "white">FECHA VENCIMIENTO:</font></label></td>
					<td><input type="text" name="fecha_venc" placeholder = "fecha de vencimiento" value = "<?php echo $fecha_venc; ?>"></td>
				</tr>
				<tr>
					<td><label for ="ips"><font color = "white">IPS:</font></label></td>
					<td><input type="text" name="ips" placeholder = "ips" value = "<?php echo $ips; ?>"></td>
				</tr>
				<tr>
					<td><label for ="observaciones"><font color = "white">OBSERVACIONES:</font></label></td>
					<td><input type="text" name="observaciones" placeholder = "observaciones" value = "<?php echo $observaciones; ?>"></td>
				</tr>
				<tr>
					<td><label for ="plan"><font color = "white">PLAN:</font></label></td>
					<td><input type="text" name="plan" placeholder = "plan" value = "<?php echo $plan; ?>"></td>
				</tr>
				<tr>
					<td><label for ="no_caso"><font color = "white">NUMERO CASO:</font></label></td>
					<td><input type="text" name="no_caso" placeholder = "numero de caso" value = "<?php echo $no_caso; ?>"></td>
				</tr>
				<tr>
					<td><label for ="responsable"><font color = "white">RESPONSABLE:</font></label></td>
					<td><input type="text" name="responsable" placeholder = "responsable" value = "<?php echo $responsable; ?>"></td>
				</tr>
				<tr>
					<td><label for ="responsable_ges"><font color = "white">RESPONSABLE GESTION:</font></label></td>
					<td><input type="text" name="responsable_ges" placeholder = "responsable rcv" value = "<?php echo $responsable_ges; ?>"></td>
				</tr>
				<tr>
					<td><label for ="fecha_entrega_ges"><font color = "white">FECHA ENTREGA GESTION:</font></label></td>
					<td><input type="text" name="fecha_entrega_ges" placeholder = "fecha entrega rcv" value = "<?php echo $fecha_entrega_ges; ?>"></td>
				</tr>
				<tr>
					<td><label for ="observacion"><font color = "white">OBSERVACION:</font></label></td>
					<td><input type="text" name="observacion" placeholder = "observacion" value = "<?php echo $observacion; ?>"></td>
				</tr>
				<tr>
					<td><label for ="fecha_envio"><font color = "white">FECHA ENVIO:</font></label></td>
					<td><input type="text" name="fecha_envio" placeholder = "Fecha envio rcv" value = "<?php echo $fecha_envio; ?>"></td>
				</tr>
				<tr>
					<td><label for ="estado"><font color = "white">ESTADO:</font></label></td>
					<td><input type="text" name="estado" placeholder = "estado" value = "<?php echo $estado; ?>"></td>
				</tr>
				<tr>
					<td><label for ="tiempo_gestion"><font color = "white">TIEMPO GESTION:</font></label></td>
					<td><input type="text" name="tiempo_gestion" placeholder = "tiempo gestion" value = "<?php echo $tiempo_gestion; ?>"></td>
				</tr>
				<tr>
					<td>
							<input  class = "w3-button w3-teal" type = "submit" value = "INGRESAR PQRS">
						</form>
					</td>
					<td>
						<form name = "formularioRegresar" method = "post" action = "http://localhost/pqrs/registros_db/index.php">
							<input  class = "w3-button w3-teal" type = "submit" value = "REGRESAR">
						</form>
					</td>
				</tr>
			</table>
		</div>
				  </div>
				</div>
		    </div>
			<?php include('_footer.php');?>
	</body>
</html>