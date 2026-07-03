<!DOCTYPE html>
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
	<?php include('../library/lib.php');?>
	<body>
	
	    <div class="page-content">
		<div class="row">

		<?php include('_menu.php');?>


			<div class="col-md-10">
			  	<div class="content-box-large" style="text-align: center;">

			  	<div>
						<h5>Reportes</h5>
				</div>
		<hr>
		<?php
        ini_set("display_errors", "on");
            require('clases/conexion.php');
            require('clases/pqrs_ad.php');
            require('clases/pqrs.php');

			$pqrs = array();

			if(isset($_POST['txtBusqueda'])){
			$busqueda = $_POST['txtBusqueda'];
			}

			$objConexion = new conexion();
			$objConexion -> abrir_conexion();


            $objPqrsAD = new pqrs_ad();



			$sqlPqrs = "select * from gestion_pqrs;";
			$pqrs = $objPqrsAD -> listar($objConexion -> pdo, $sqlPqrs);

		?>

		<div class='panel-body'>


			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th>ID</th>
						<th>Fecha Radicaci&oacute;n</font></th>
						<th>Fecha envio de gesti&oacute;n</font></th>
						<th>Tipo id</font></th>
						<th>Documento id</font></th>
						<th>Codigo de registro</font></th>
						<th>Asignado</font></th>
						<th>Nombres completos</font></th>
						<!-- <th>Ciudad</font></th> -->
						<!-- <th>Cepartamento</font></th> -->
						<!-- <th>Especifico</font></th> -->
						<!-- <th>Motivo</font></th> -->
						<!-- <th>Cambio de motivo</font></th> -->
						<!-- <th>Diagnostico</font></th> -->
						<th>Tipo</font></th>
						<!-- <th>Fecha de vencimiento</font></th> -->
						<th>IPS</font></th>
						<!-- <th>Observaciones</font></th> -->
						<!-- <th>Regimen</font></th> -->
						<th>Nro Caso</font></th>
						<th>Responsable</font></th>
						<!-- <th>Responsable de gesti&oacute;n</font></th> -->
						<!-- <th>Fecha de entrega gesti&oacute;n</font></th> -->
						<th>Observaci&oacute;n</font></th>
						<!-- <th>Fecha de envio</font></th> -->
						<th>Estado</font></th>
						<!-- <th>Tiempo de gesti&oacute;n</font></th> -->
						<!-- <th>Observaci&oacute;n_PQRS</font></th> -->
						<th>Acciones</font></th>

			</tr>
			</thead>
			<tbody>
			<?php
				foreach ($pqrs as $dato) {
					echo "<tr>";
					$objPqrs = new pqrs();
					$objPqrs = $dato;
					$ideActual=$objPqrs -> getId();
					echo "<td>".$objPqrs -> getId()."</td>";
					echo "<td>".$objPqrs -> getFecha_Rad()."</td>";
					echo "<td>".$objPqrs -> getFecha_Envio_Ges()."</td>";
					echo "<td>".$objPqrs -> getTipo_Id()."</td>";
					echo "<td>".$objPqrs -> getDocto_Id()."</td>";
					echo "<td>".$objPqrs -> getCod_Registro()."</td>";
					echo "<td>".strtolower($objPqrs -> getAsignado())."</td>";
					echo "<td>".$objPqrs -> getNombres()."</td>";
					//echo "<td>".$objPqrs -> getCiudad()."</td>";
					//echo "<td>".$objPqrs -> getDepartamento()."</td>";
					//echo "<td>".strtolower($objPqrs -> getEspecifico())."</td>";
					//echo "<td>".strtolower($objPqrs -> getMotivo())."</td>";
					//echo "<td>".$objPqrs -> getCambio_Motivo()."</td>";
					//echo "<td>".strtolower($objPqrs -> getDiagnostico())."</td>";
					echo "<td>".strtolower($objPqrs -> getTipo())."</td>";
					//echo "<td>".$objPqrs -> getFecha_Venc()."</td>";
					echo "<td>".$objPqrs -> getIps()."</td>";
					//echo "<td>".$objPqrs -> getObservaciones()."</td>";
					//echo "<td>".$objPqrs -> getPlan()."</td>";
					echo "<td>".$objPqrs -> getNo_Caso()."</td>";
					echo "<td>".$objPqrs -> getResponsable()."</td>";
					//echo "<td>".$objPqrs -> getResponsable_Ges()."</td>";
					//echo "<td>".$objPqrs -> getFecha_Entrega_Ges()."</td>";
					echo "<td>".$objPqrs -> getObservacion()."</td>";
					//echo "<td>".$objPqrs -> getFecha_Envio()."</td>";
					echo "<td>".$objPqrs -> getEstado()."</td>";
					//echo "<td>".strtolower($objPqrs -> getTiempo_Gestion())."</td>";
					//echo "<td>".$objPqrs -> getobserv_pqrs()."</td>";

					//

					echo "<td>


			<table>
				<tr>
					<td width='40%' style='text-align: center;'>
						<a href='visualizar.php?id=$ideActual'>
							<img src=../images/prescription.png title='Ver detalle'>
						</a>
					</td>
					<td width='40%'  style='text-align: center;'>
						<a href='actualizar.php?id=$ideActual'>
							<img src='../images/notes_edit.png' title='Modificar PQRS'>
						</a>
					</td>
				</tr>
			</table>";
		?>

			<?php
					echo "</td>";
					$objPqrs -> __destruct();
					echo "</tr>";
				}
				$objPqrsAD -> __destruct();

			?>
		 </tbody>
	</table>

	<br>


		</div>
				  </div>
				</div>
		    </div>
			<?php include('_footer.php');?>
	</body>
</html>