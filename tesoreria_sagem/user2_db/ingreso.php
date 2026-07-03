<!DOCTYPE html>
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
	<?php include('../library/lib.php');?>
	<body>


<h1 align = "center" style ="background-color:darkslategray"><font><br><b> SISTEMA PQRS</b><br><br></font></h1>
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
			$observ_pqrs="";

			if(array_key_exists('id', $_POST)){

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
				$observ_pqrs= $_POST['observ_pqrs'];

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
				$objPqrss -> setobserv_pqrs($observ_pqrs);

				$objConexion = new conexion();
				$objConexion -> abrir_conexion();

				$objPqrssAD = new pqrs_ad();

				$objPqrssAD -> crear($objPqrss);
				$objPqrss -> __destruct();
				echo'<script type="text/javascript">alert(" La pqrs fue registrado satisfactoriamente");window.location="index.php"</script>';
				pg_close();

			}
		?>

		<div class='panel-body'>

			<form name = "formularioIngresar" method = "post" action = "ingreso.php">
			<input type="hidden" class="form-control" name="id" placeholder = "Id De Pqrs" value = "999">

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">FECHA RADICADO </label>
					<div class="col-sm-3">
						<input type="date" name="fecha_rad" class="form-control" required>
					</div>
					<label class="col-md-2 control-label" for="text-field">FECHA ENVIO GESTION </label>
					<div class="col-sm-3">
						<input type="date" name="fecha_envio_ges" class="form-control" required>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">TIPO ID </label>
					<div class="col-sm-3">
						<select required class="form-control" name="tipo_id">
							<option value="">Seleccione...
						  	<option value="CC">CC
						  	<option value="RC">RC
						  	<option value="TI">TI
						  	<option value="CE">CE
						</select>
					</div>
					<label class="col-md-2 control-label" for="text-field">DOCUMENTO ID</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="docto_id" required="" pattern="[0-9]*">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">CODIGO REGISTRO</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="cod_registro" required="">
					</div>
						<label class="col-md-2 control-label" for="text-field">ASIGNADO</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="asignado" pattern='[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*'>
					</div>

				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">CIUDAD</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="ciudad" required pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*">
					</div>
						<label class="col-md-2 control-label" for="text-field">DEPARTAMENTO</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="departamento" required pattern='[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*'>
					</div>

				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">NOMBRES</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="nombres" required pattern="[a-zA-ZÑÁÉÍÓÚáéíóú ][a-zA-Zñáéíóú ]*">
					</div>
					<label class="col-md-2 control-label" for="text-field">ESPECIFICO</label>
					<div class="col-sm-3">
						<select required class="form-control" name="especifico">
							<option value="">Seleccione...
							<option value="AFILIACION">AFILIACION
							<option value="ATENCION">ATENCION
							<option value="AUTORIZACION">AUTORIZACION
							<option value="CITAS">CITAS
							<option value="MEDICAMENTOS">MEDICAMENTOS
							<option value="REFERENCIA O CONTRARREFERENCIA">REFERENCIA O CONTRARREFERENCIA
						</select>
					</div>

				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">MOTIVO</label>
					<div class="col-sm-3">
						<select required class="form-control" name="motivo">
							<option value="">Seleccione...
							<option value="RESTRICCION EN EL ACCESO A LOS SERVICIOS DE SALUD">RESTRICCION EN EL ACCESO A LOS SERVICIOS DE SALUD
							<option value="INSATISFACCION DEL USUARIO CON EL PROCESO ADMINISTRATIVO">INSATISFACCION DEL USUARIO CON EL PROCESO ADMINISTRATIVO
							<option value="DEFICIENCIA EN LA EFECTIVIDAD DE LA ATENCION EN SALUD">DEFICIENCIA EN LA EFECTIVIDAD DE LA ATENCION EN SALUD
							<option value="NO RECONOCIMIENTO DE LAS PRESTACIONES ECONOMICAS">NO RECONOCIMIENTO DE LAS PRESTACIONES ECONOMICAS
						</select>
					</div>
					<label class="col-md-2 control-label" for="text-field">CAMBIO MOTIVO</label>
					<div class="col-sm-3">
						<select class="form-control" name="cambio_motivo">
							<option value="SI">SI
							<option value="NO">NO
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">DIAGNOSTICO</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="diagnostico" required pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*">
					</div>
					<label class="col-md-2 control-label" for="text-field">TIPO</label>
					<div class="col-sm-3">
						<select required class="form-control" name="tipo">
							<option value="">Seleccione...
							<option value="ATENCION INMEDIATA">ATENCION INMEDIATA
							<option value="NURC">NURC
							<option value="NORMAL(5 DIAS)">NORMAL(5 DIAS)
						</select>
					</div>

				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">FECHA VENCIMIENTO</label>
					<div class="col-sm-3">
						<input type="date" name="fecha_venc" class="form-control" required>
					</div>
					<label class="col-md-2 control-label" for="text-field">IPS</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="ips" required pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">OBSERVACIONES</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="observaciones" required pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*">
					</div>
					<label class="col-md-2 control-label" for="text-field">PLAN</label>
					<div class="col-sm-3">
						<select required class="form-control" name="plan">
							<option value="">Seleccione...
							<option value="SUBSIDIADO">SUBSIDIADO
							<option value="CONTRIBUTIVO">CONTRIBUTIVO
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">NUMERO CASO</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="no_caso" required maxlength="10" pattern="[0-9]*">
					</div>
					<label class="col-md-2 control-label" for="text-field">RESPONSABLE</label>
					<div class="col-sm-3">
						<select required class="form-control" name="responsable">
							<option value="">Seleccione...
							<option value="MAURICIO">MAURICIO
							<option value="ADRIANA">ADRIANA
							<option value="AYDE LILIANA">AYDE LILIANA
							<option value="ERIKA SALAS">ERIKA SALAS
						</select>
					</div>
				</div>
			</div>



			<hr>
			<div>
				<h6>Campos Adicionales RCV</h6>
			</div>
			<br>
			<table class="table table-striped" style="text-align: left;">
				<tbody>
					<tr>
						<td><label for ="responsable_ges"><font>RESPONSABLE GESTION:</font></label></td>
						<td>
						<select class="form-control" name="responsable_ges">
							<option value="">Seleccione...
							<option value="SILVIA BASTIDAS">SILVIA BASTIDAS
							<option value="VANESSA MORENO">VANESSA MORENO
							<option value="LADY SF">LADY SF
							<option value="VERONICA LOBRIDO">ERONICA LOBRIDO
							<option value="VIVIAN V.">VIVIAN V.
							<option value="YURI M.">YURI M.
							<option value="JESSICA A.">JESSICA A.
							<option value="MILENA A.">MILENA A.
						</select>

						</td>
						<td><label for ="observacion"><font>OBSERVACION:</font></label></td>
						<td><input  type="text" class="form-control" placeholder="" name="observacion" pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*"></td>
					</tr>

					<tr>
						<td><label for ="fecha_envio"><font>FECHA ENVIO:</font></label></td>
						<td><input type="date" name="fecha_envio" class="form-control"></td>
						<td><label for ="estado"><font>ESTADO:</font></label></td>
						<td><input  type="text" class="form-control" placeholder="" name="estado" pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*"></td>
					</tr>

					<tr>

						<td><label for ="observacion"><font>OBSERVACION_PQRS: </font></label></td>
						<td><input  type="text" class="form-control" placeholder="" name="observ_pqrs" pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]*"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
						<input type="hidden" name="fecha_entrega_ges" value = "1990-01-01">
						<input type="hidden" name="tiempo_gestion" value = "000000">
				</tbody>
			</table>
			<hr>
			<br>
			<div class="form-group" >
				<div class="col-sm-offset-2 col-sm-8">
				  <input  class="btn btn-primary signup" type = "submit" value = "INGRESAR PQRS">
					</form>
				</div>
			</div>


		</div>
				  </div>
				</div>
		    </div>
			<?php include('_footer.php');?>
	</body>
</html>