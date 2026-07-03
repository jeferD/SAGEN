<!DOCTYPE html>
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
	<?php include('../library/lib.php');?>
	<body>


<h1 align = "center" style ="background-color:darkslategray"><font color="white"><br><b> SISTEMA PQRS</b><br><br></font></h1>
<div class="page-content">
	<div class="row">

		<?php include('_menu.php');?>


			<div class="col-md-10">
			  	<div class="content-box-large" style="text-align: center;">

			  	<div>
						<h5>FORMULARIO DE ACTUALIZACION - PQRS</h5>
				</div>
		<hr>
		<?php

			require('clases/conexion.php');
            require('clases/pqrs_ad.php');
            require('clases/pqrs.php');

			$pqrs = array();

			$id="";

			$objConexion = new conexion();
			$objConexion -> abrir_conexion();

			$objPqrsAD = new pqrs_ad();
			if(array_key_exists('id', $_GET)){

				$id = $_GET['id'];
				$objPqrs = new pqrs();
				$objPqrs = $objPqrsAD -> buscarxid($id);

				$fecha_rad=$objPqrs -> getFecha_Rad();
				$fecha_envio_ges=$objPqrs -> getFecha_Envio_Ges();
				$tipo_id=$objPqrs -> getTipo_Id();
				$docto_id=$objPqrs -> getDocto_Id();
				$cod_registro=$objPqrs -> getCod_Registro();
				$asignado=$objPqrs -> getAsignado();
				$nombres=$objPqrs -> getNombres();
				$ciudad=$objPqrs -> getCiudad();
				$departamento=$objPqrs -> getDepartamento();
				$especifico=$objPqrs -> getEspecifico();
				$motivo=$objPqrs -> getMotivo();
				$cambio_motivo=$objPqrs -> getCambio_Motivo();
				$diagnostico=$objPqrs -> getDiagnostico();
				$tipo=$objPqrs -> getTipo();
				$fecha_venc=$objPqrs -> getFecha_Venc();
				$ips=$objPqrs -> getIps();
				$observaciones=$objPqrs -> getObservaciones();
				$plan=$objPqrs -> getPlan();
				$no_caso=$objPqrs -> getNo_Caso();
				$responsable=$objPqrs -> getResponsable();
				$responsable_ges=$objPqrs -> getResponsable_Ges();
				$fecha_entrega_ges=$objPqrs -> getFecha_Entrega_Ges();
				$observacion=$objPqrs -> getObservacion();
				$fecha_envio=$objPqrs -> getFecha_Envio();
				$estado=$objPqrs -> getEstado();
				$tiempo_gestion=$objPqrs -> getTiempo_Gestion();
				$observ_pqrs=$objPqrs -> getobserv_pqrs();


				$objPqrs -> __destruct();
				pg_close();

		?>

		<div class='panel-body'>

			<form name = "formularioIngresar" method = "post" action = "#">
			<table class="table table-striped" style="text-align: left;">
				<tbody>
					<tr>
						<td width='10%'><label>FECHA RADICADO </label></td><td width='20%'><input type="text" name="fecha_rad" class="form-control" disabled value=<?php echo "'".$fecha_rad."'"; ?>></td>
						<td width='10%'><label >FECHA ENVIO GESTION </label></td><td width='20%'><input type="text" name="fecha_envio_ges" class="form-control" disabled value=<?php echo "'".$fecha_envio_ges."'"; ?>></td>
					</tr>
					<tr>
						<td><label>TIPO ID </label></td><td><input type="text" name="tipo_id" class="form-control" disabled value=<?php echo "'".$tipo_id."'"; ?>></td>
						<td><label>DOCUMENTO ID</label></td><td><input type="text" name="docto_id" class="form-control" disabled value=<?php echo "'".$docto_id."'"; ?>></td>
					</tr>
					<tr>
						<td><label>CODIGO REGISTRO</label></td><td><input type="text" name="cod_registro" class="form-control" disabled value=<?php echo "'".$cod_registro."'"; ?>></td>
						<td><label>ASIGNADO</label></td><td><input type="text" name="asignado" class="form-control" disabled value=<?php echo "'".$asignado."'"; ?>></td>
					</tr>

					<tr>
						<td><label>CIUDAD</label></td><td><input type="text" name="ciudad" class="form-control" disabled value=<?php echo "'".$ciudad."'"; ?>></td>
						<td><label>DEPARTAMENTO</label></td><td><input type="text" name="departamento" class="form-control" disabled value=<?php echo "'".$departamento."'"; ?>></td>
					</tr>

					<tr>
						<td><label>NOMBRES</label></td><td><input type="text" name="nombres" class="form-control" disabled value=<?php echo "'".$nombres."'"; ?>></td>
						<td><label>ESPECIFICO</label></td><td><input type="text" name="especifico" class="form-control" disabled value=<?php echo "'".$especifico."'"; ?>></td>

					</tr>
					<tr>
						<td><label>MOTIVO</label></td><td><input type="text" name="motivo" class="form-control" disabled value=<?php echo "'".$motivo."'"; ?>></td>
						<td><label>CAMBIO MOTIVO</label></td><td><input type="text" name="cambio_motivo" class="form-control" disabled value=<?php echo "'".$cambio_motivo."'"; ?>></td>
					</tr>
					<tr>
						<td><label>DIAGNOSTICO</label></td><td><input type="text" name="diagnostico" class="form-control" disabled value=<?php echo "'".$diagnostico."'"; ?>></td>
						<td><label>TIPO</label></td><td><input type="text" name="tipo" class="form-control" disabled value=<?php echo "'".$tipo."'"; ?>></td>
					</tr>
					<tr>
						<td><label>FECHA VENCIMIENTO</label></td><td><input type="text" name="fecha_venc" class="form-control" disabled value=<?php echo "'".$fecha_venc."'"; ?>></td>
						<td><label>IPS</label></td><td><input type="text" name="ips" class="form-control" disabled value=<?php echo "'".$ips."'"; ?>></td>
					</tr>
					<tr>
						<td><label>OBSERVACIONES</label></td><td><input type="text" name="observaciones" class="form-control" disabled value=<?php echo "'".$observaciones."'" ?>></td>
						<td><label>PLAN</label></td><td><input type="text" name="plan" class="form-control" disabled value=<?php echo "'".$plan."'"; ?>></td>
					</tr>
					<tr>
						<td><label>NUMERO CASO</label></td><td><input type="text" name="no_caso" class="form-control" disabled value=<?php echo "'".$no_caso."'" ?>></td>
						<td><label>RESPONSABLE</label></td><td><input type="text" name="responsable" class="form-control" disabled value=<?php echo "'".$responsable."'"; ?>></td>
					</tr>
				</table>


			<hr>
			<div>
				<h6>Campos Adicionales RCV</h6>
			</div>
			<br>
			<table class="table table-striped" style="text-align: left;">
				<tbody>
					<tr>
						<td><label for ="responsable_ges"><font>RESPONSABLE GESTION:</font></label></td>
						<td><input type="text" name="responsable_ges" class="form-control" disabled value=<?php echo "'".$responsable_ges."'"; ?>></td>

						<td><label for ="observacion"><font>OBSERVACION:</font></label></td>
						<td><input type="text" name="observacion" class="form-control" disabled value=<?php echo "'".$observacion."'"; ?>></td>
					</tr>

					<tr>
						<td><label for ="fecha_envio"><font>FECHA ENVIO:</font></label></td>
						<td><input type="text" name="fecha_envio" class="form-control" disabled value=<?php echo $fecha_envio ?>></td>
						<td><label for ="estado"><font>ESTADO:</font></label></td>
						<td><input type="text" name="estado" class="form-control" disabled value=<?php echo "'".$estado."'"; ?>></td>
					</tr>

					<tr>

						<td><label for ="observacion"><font>OBSERVACION_PQRS: </font></label></td>
						<td><input type="text" name="observ_pqrs" class="form-control" disabled value=<?php echo "'".$observ_pqrs."'"; ?>></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

				</tbody>
				</form>
			</table>
			<hr>
			<div class="form-group" >
				<div class="col-sm-offset-2 col-sm-8">
					<form name = "formularioRegresar" method = "post" action = "index.php">
						<input  class = "btn btn-primary signup" type = "submit" value = "REGRESAR">
					</form>

				</div>
			</div>
		</div>

		<?php } ?>
				  </div>
				</div>
		    </div>
			<?php include('_footer.php');?>
	</body>
</html>