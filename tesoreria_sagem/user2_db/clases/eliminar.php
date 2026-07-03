<html>
	<head>
		<title>.:: ELIMINAR PQRS ::.</title>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	<body bgcolor = "floralwhite">
		<?php
        
            require('conexion.php');
            require('pqrs_ad.php');
            require('pqrs.php');
        
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
		
			$objConexion = new conexion();
			$objConexion -> abrir_conexion();
			
			$objPqrsAD = new pqrs_ad();
			
			if(array_key_exists('txtBusqueda', $_POST)){
				echo'<script type="text/javascript">alert("Buscando Pqrs");window.location="eliminar.php"</script>';
				$busqueda = $_POST['txtBusqueda'];
			}
			echo getId();
			if(array_key_exists('idEliminacion', $_POST)){
				$objPqrs = new pqrs();
				$objPqrs -> setId($_POST['idEliminacion']);
				$objPqrsAD -> eliminar($objConexion -> pdo, $objPqrs);
				$objPqrsAD -> __destruct();
			}
			
			$sqlPqrs = "select * from gestion_pqrs";
			$pqrs = $objPqrsAD -> listar($objConexion -> pdo, $sqlPqrs);
		?>
		<h1 align = "center" style ="background-color:darkslategray"><font color = "white"><br><b> LISTA DE PQRS<br><br></font></h1>
		<form name = "formularioBusqueda" method = "post" action = "eliminar.php">
			<input type = "text" name = "txtBusqueda">
			<input type = "submit" class = "w3-button w3-teal" value = "Buscar">
		</form>
		</form>
		<form name = "formularioRegreso" method = "post" action = "http://localhost/pqrs/registos_db/index.php">
			<input type = "submit" class = "w3-button w3-teal" value = "Regresar">
		</form>
		<table border = "1" class = "w3-table-all w3-hoverable">
			<tr>
				<th bgcolor= "darkslategray"><font color = "white">ID</font></th>
				<th bgcolor= "darkslategray"><font color = "white">FECHA RADICADO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">FECHA ENVIO GESTION</font></th>
				<th bgcolor= "darkslategray"><font color = "white">TIPO ID</font></th>
				<th bgcolor= "darkslategray"><font color = "white">DOCUMENTO ID</font></th>
				<th bgcolor= "darkslategray"><font color = "white">CODIGO REGISTRO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">ASIGNADO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">NOMBRES</font></th>
				<th bgcolor= "darkslategray"><font color = "white">CIUDAD</font></th>
				<th bgcolor= "darkslategray"><font color = "white">DEPARTAMENTO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">ESPECIFICO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">MOTIVO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">CAMBIO MOTIVO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">DIAGNOSTICO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">TIPO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">FECHA VENCIMIENTO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">IPS</font></th>
				<th bgcolor= "darkslategray"><font color = "white">OBSERVACIONES</font></th>
				<th bgcolor= "darkslategray"><font color = "white">PLAN</font></th>
				<th bgcolor= "darkslategray"><font color = "white">NUMERO CASO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">RESPONSABLE</font></th>
				<th bgcolor= "darkslategray"><font color = "white">RESPONSABLE GESTION</font></th>
				<th bgcolor= "darkslategray"><font color = "white">FECHA ENTREGA GESTION</font></th>
				<th bgcolor= "darkslategray"><font color = "white">OBSERVACION</font></th>
				<th bgcolor= "darkslategray"><font color = "white">FECHA ENVIO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">ESTADO</font></th>
				<th bgcolor= "darkslategray"><font color = "white">TIEMPO GESTION</font></th>
			</tr>
			<?php
			if (empty($busqueda)) {
				foreach ($pqrs as $dato) {
					echo "<tr>";
					$objPqrs = new pqrs();
					$objPqrs = $dato;
					echo "<td>".$objPqrs -> getId()."</td>";
					echo "<td>".$objPqrs -> getFecha_Rad()."</td>";
					echo "<td>".$objPqrs -> getFecha_Envio_Ges()."</td>";
					echo "<td>".$objPqrs -> getTipo_Id()."</td>";
					echo "<td>".$objPqrs -> getDocto_Id()."</td>";
					echo "<td>".$objPqrs -> getCod_Registro()."</td>";
					echo "<td>".$objPqrs -> getAsignado()."</td>";
					echo "<td>".$objPqrs -> getNombres()."</td>";
					echo "<td>".$objPqrs -> getCiudad()."</td>";
					echo "<td>".$objPqrs -> getDepartamento()."</td>";
					echo "<td>".$objPqrs -> getEspecifico()."</td>";
					echo "<td>".$objPqrs -> getMotivo()."</td>";
					echo "<td>".$objPqrs -> getCambio_Motivo()."</td>";
					echo "<td>".$objPqrs -> getDiagnostico()."</td>";
					echo "<td>".$objPqrs -> getTipo()."</td>";
					echo "<td>".$objPqrs -> getFecha_Venc()."</td>";
					echo "<td>".$objPqrs -> getIps()."</td>";
					echo "<td>".$objPqrs -> getObservaciones()."</td>";
					echo "<td>".$objPqrs -> getPlan()."</td>";
					echo "<td>".$objPqrs -> getNo_Caso()."</td>";
					echo "<td>".$objPqrs -> getResponsable()."</td>";
					echo "<td>".$objPqrs -> getResponsable_Ges()."</td>";
					echo "<td>".$objPqrs -> getFecha_Entrega_Ges()."</td>";
					echo "<td>".$objPqrs -> getObservacion()."</td>";
					echo "<td>".$objPqrs -> getFecha_Envio()."</td>";
					echo "<td>".$objPqrs -> getEstado()."</td>";
					echo "<td>".$objPqrs -> getTiempo_Gestion()."</td>";
					echo "<td>";
			?>
			<form name = "formularioEliminacion" method = "post" action = "eliminar.php">
				<input type = "hidden" name = "idEliminacion" value = "<?php echo $objPqrs -> getIdAsesor(); ?>">
				<input type = "submit"  class = "w3-button w3-teal" value = "Eliminar">
			</form>
			<form name = "formularioActualizar" method = "post" action = "actualizar.php">
				<input type = "hidden" name = "id" value = "<?php echo $objPqrs -> getId();?>">
				<input type = "hidden" name = "fecha_rad" value = "<?php echo $objPqrs -> getFecha_Rad(); ?>">
				<input type = "hidden" name = "fecha_envio_ges" value = "<?php echo $objPqrs -> getFecha_Envio_Ges(); ?>">
				<input type = "hidden" name = "tipo_id" value = "<?php echo $objPqrs -> getTipo_Id(); ?>">
				<input type = "hidden" name = "docto_id" value = "<?php echo $objPqrs -> getDocto_Id(); ?>">
				<input type = "hidden" name = "cod_registro" value = "<?php echo $objPqrs -> getCod_Registro(); ?>">
				<input type = "hidden" name = "asignado" value = "<?php echo $objPqrs -> getAsignado(); ?>">
				<input type = "hidden" name = "nombres" value = "<?php echo $objPqrs -> getNombres(); ?>">
				<input type = "hidden" name = "ciudad" value = "<?php echo $objPqrs -> getCiudad(); ?>">
				<input type = "hidden" name = "departamento" value = "<?php echo $objPqrs -> getDepartamento(); ?>">
				<input type = "hidden" name = "especifico" value = "<?php echo $objPqrs -> getEspecifico(); ?>">
				<input type = "hidden" name = "motivo" value = "<?php echo $objPqrs -> getMotivo(); ?>">
				<input type = "hidden" name = "cambio_motivo" value = "<?php echo $objPqrs -> getCambio_Motivo(); ?>">
				<input type = "hidden" name = "diagnostico" value = "<?php echo $objPqrs -> getDiagnostico(); ?>">
				<input type = "hidden" name = "tipo" value = "<?php echo $objPqrs -> getTipo(); ?>">
				<input type = "hidden" name = "fecha_venc" value = "<?php echo $objPqrs -> getFecha_Venc(); ?>">
				<input type = "hidden" name = "ips" value = "<?php echo $objPqrs -> getIps(); ?>">
				<input type = "hidden" name = "observaciones" value = "<?php echo $objPqrs -> getObservaciones(); ?>">
				<input type = "hidden" name = "plan" value = "<?php echo $objPqrs -> getPlan(); ?>">
				<input type = "hidden" name = "no_caso" value = "<?php echo $objPqrs -> getNo_Caso(); ?>">
				<input type = "hidden" name = "responsable" value = "<?php echo $objPqrs -> getResponsable(); ?>">
				<input type = "hidden" name = "responsable_ges" value = "<?php echo $objPqrs -> getResponsable_Ges(); ?>">
				<input type = "hidden" name = "fecha_entrega_ges" value = "<?php echo $objPqrs -> getFecha_Entrega_Ges(); ?>">
				<input type = "hidden" name = "observacion" value = "<?php echo $objPqrs -> getObservacion(); ?>">
				<input type = "hidden" name = "fecha_envio" value = "<?php echo $objPqrs -> getFecha_Envio(); ?>">
				<input type = "hidden" name = "estado" value = "<?php echo $objPqrs -> getEstado(); ?>">
				<input type = "hidden" name = "tiempo_gestion" value = "<?php echo $objPqrs -> getTiempo_Gestion(); ?>">
				<input type = "submit"  class = "w3-button w3-teal" value = "Actualizar">
			</form>
			<?php
				echo "</td>";
					$objPqrs -> __destruct();
					echo "</tr>";
				}
			} else {
				$encontrado = false;
				foreach($pqrs as $dato){
					$objPqrs = new pqrs();
					$objPqrs = $dato;
					if (!(strpos($objPqrs -> getId(), $busqueda) === false)) {
							$encontrado = true;
							echo "<tr>";
							echo "<td>".$objPqrs -> getId()."</td>";
							echo "<td>".$objPqrs -> getFecha_Rad()."</td>";
							echo "<td>".$objPqrs -> getFecha_Envio_Ges()."</td>";
							echo "<td>".$objPqrs -> getTipo_Id()."</td>";
							echo "<td>".$objPqrs -> getDocto_Id()."</td>";
							echo "<td>".$objPqrs -> getCod_Registro()."</td>";
							echo "<td>".$objPqrs -> getAsignado()."</td>";
							echo "<td>".$objPqrs -> getNombres()."</td>";
							echo "<td>".$objPqrs -> getCiudad()."</td>";
							echo "<td>".$objPqrs -> getDepartamento()."</td>";
							echo "<td>".$objPqrs -> getEspecifico()."</td>";
							echo "<td>".$objPqrs -> getMotivo()."</td>";
							echo "<td>".$objPqrs -> getCambio_Motivo()."</td>";
							echo "<td>".$objPqrs -> getDiagnostico()."</td>";
							echo "<td>".$objPqrs -> getTipo()."</td>";
							echo "<td>".$objPqrs -> getFecha_Venc()."</td>";
							echo "<td>".$objPqrs -> getIps()."</td>";
							echo "<td>".$objPqrs -> getObservaciones()."</td>";
							echo "<td>".$objPqrs -> getPlan()."</td>";
							echo "<td>".$objPqrs -> getNo_Caso()."</td>";
							echo "<td>".$objPqrs -> getResponsable()."</td>";
							echo "<td>".$objPqrs -> getResponsable_Ges()."</td>";
							echo "<td>".$objPqrs -> getFecha_Entrega_Ges()."</td>";
							echo "<td>".$objPqrs -> getObservacion()."</td>";
							echo "<td>".$objPqrs -> getFecha_Envio()."</td>";
							echo "<td>".$objPqrs -> getEstado()."</td>";
							echo "<td>".$objPqrs -> getTiempo_Gestion()."</td>";
							echo "</tr>";
						}
						$objPqrs -> __destruct();
				}
				if (!$encontrado) {
					echo "<tr>";
					echo "<td colspan = '9'>No se ha encontrado el dato</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
	</body>
</html>