<html>
	<head>
		<title>.:: ACTUALIZAR PQRS ::.</title>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	
	<body bgcolor = "floralwhite">
	
		<?php		
			
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

			
			require('conexion.php');
            require('pqrs_ad.php');
            require('pqrs.php');
        
			$pqrs = array();
			
			
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
			}
			
			$objConexion = new conexion();
			$objConexion -> abrir_conexion();
        
            $objPqrsAD = new pqrs_ad();
			
			if(array_key_exists('txtid', $_POST)){
			
			$id = $_POST['txtid'];
			$fecha_rad = $_POST['txtfecha_rad'];
			$fecha_envio_ges = $_POST['txtfecha_envio_ges'];
			$tipo_id = $_POST['txttipo_id'];
			$docto_id = $_POST['txtdocto_id'];
			$cod_registro = $_POST['txtcod_registro'];
			$asignado = $_POST['txtasignado'];
			$nombres = $_POST['txtnombres'];
			$ciudad = $_POST['txtciudad'];
			$departamento = $_POST['txtdepartamento'];
			$especifico = $_POST['txtespecifico'];
			$motivo = $_POST['txtmotivo'];
			$cambio_motivo = $_POST['txtcambio_motivo'];
			$diagnostico = $_POST['txtdiagnostico'];
			$tipo = $_POST['txttipo'];
			$fecha_venc = $_POST['txtfecha_venc'];
			$ips = $_POST['txtips'];
			$observaciones = $_POST['txtobservaciones'];
			$plan = $_POST['txtplan'];
			$no_caso = $_POST['txtno_caso'];
			$responsable = $_POST['txtresponsable'];
			$responsable_ges = $_POST['txtresponsable_ges'];
			$fecha_entrega_ges = $_POST['txtfecha_entrega_ges'];
			$observacion = $_POST['txtobservacion'];
			$fecha_envio = $_POST['txtfecha_envio'];
			$estado = $_POST['txtestado'];
			$tiempo_gestion = $_POST['txttiempo_gestion'];
			
			//echo "el id es ".$id;
			
			if(empty($_POST['txtid']) || empty($_POST['txtfecha_rad']) || empty($_POST['txtfecha_envio_ges']) || empty($_POST['txttipo_id']) || 
				empty($_POST['txtdocto_id']) || empty($_POST['txtcod_registro']) || empty($_POST['txtasignado']) || empty($_POST['txtnombres']) || 
				empty($_POST['txtciudad']) || empty($_POST['txtdepartamento']) || empty($_POST['txtespecifico']) || empty($_POST['txtmotivo']) || 
				empty($_POST['txtcambio_motivo']) || empty($_POST['txtdiagnostico']) || empty($_POST['txttipo']) || empty($_POST['txtfecha_venc']) || 
				empty($_POST['txtips']) || empty($_POST['txtobservaciones']) || empty($_POST['txtplan']) || empty($_POST['txtno_caso']) || 
				empty($_POST['txtresponsable'])){
					echo'<script type="text/javascript">alert("Debe Llenar Todos Los Campos Del Formulario");window.location="actualizar.php"</script>';
				}else{
					$objPqrs = new pqrs();
					$objPqrs -> setid($id);
					$objPqrs -> setfecha_rad($fecha_rad);
					$objPqrs -> setfecha_envio_ges($fecha_envio_ges);
					$objPqrs -> settipo_id($tipo_id);
					$objPqrs -> setdocto_id($docto_id);
					$objPqrs -> setcod_registro($cod_registro);
					$objPqrs -> setasignado($asignado);
					$objPqrs -> setnombres($nombres);
					$objPqrs -> setciudad($ciudad);
					$objPqrs -> setdepartamento($departamento);
					$objPqrs -> setespecifico($especifico);
					$objPqrs -> setmotivo($motivo);
					$objPqrs -> setcambio_motivo($cambio_motivo);
					$objPqrs -> setdiagnostico($diagnostico);
					$objPqrs -> settipo($tipo);
					$objPqrs -> setfecha_venc($fecha_venc);
					$objPqrs -> setips($ips);
					$objPqrs -> setobservaciones($observaciones);
					$objPqrs -> setplan($plan);
					$objPqrs -> setno_caso($no_caso);
					$objPqrs -> setresponsable($responsable);
					$objPqrs -> setresponsable_ges($responsable_ges);
					$objPqrs -> setfecha_entrega_ges($fecha_entrega_ges);
					$objPqrs -> setobservacion($observacion);
					$objPqrs -> setfecha_envio($fecha_envio);
					$objPqrs -> setestado($estado);
					$objPqrs -> settiempo_gestion($tiempo_gestion);
						
					$objPqrsAD -> actualizar($objConexion -> pdo, $objPqrs);
					$objPqrsAD -> __destruct();
					
					echo'<script type="text/javascript">alert(" El registro Pqrs fue Actualizado satisfactoriamente");window.location="eliminar.php"</script>';
				}
			}			
		?>
		<h1 align = "center" style ="background-color:darkslategray"><font color = "white"><br><b> FORMULARIO PARA ACTUALIZAR DATOS DE PQRS<br><br></font></h1>
		<br>
			<table border = "1" align = "center">
				<form name = "formularioActualizacion" method = "post" action = "actualizar.php">
					<td colspan = "2" align = "center"><b>ACTUALIZAR DATOS DE PQRS</b></td>
					<tr>
						<td><input type = "text" name = "txtidasesor" placeholder = "ID" value = "<?php echo $id; ?>"></td>
						<td><input type = "text" name = "txtnoidasesor" placeholder = "FECHA RADICADO"value = "<?php echo $fecha_rad; ?>"></td>
					</tr>	
					<tr>
						<td><input type = "text" name = "txtnomasesor" placeholder = "FECHA ENVIO GESTION"value = "<?php echo $fecha_envio_ges; ?>"></td>
						<td><input type = "text" name = "txtapellasesor" placeholder = "TIPO ID" value = "<?php echo $tipo_id; ?>"></td>
					</tr>	
					<tr>	
						<td><input type = "text" name = "txtcomasesor" placeholder = "DOCUMENTO ID"value = "<?php echo $docto_id; ?>"></td>
						<td><input type = "text" name = "txtloginasesor" placeholder = "CODIGO REGISTRO" value = "<?php echo $cod_registro; ?>"></td>
					</tr>	
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "ASIGNADO"value = "<?php echo $asignado; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "NOMBRES" value = "<?php echo $nombres; ?>"></td>
					</tr>	
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "CIUDAD"value = "<?php echo $ciudad; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "DEPARTAMENTO" value = "<?php echo $departamento; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "ESPECIFICO"value = "<?php echo $especifico; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "MOTIVO" value = "<?php echo $motivo; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "CAMBIO MOTIVO"value = "<?php echo $cambio_motivo; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "DIAGNOSTICO" value = "<?php echo $diagnostico; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "TIPO"value = "<?php echo $tipo; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "FECHA VENCIMIENTO" value = "<?php echo $fecha_venc; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "IPS"value = "<?php echo $ips; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "OBSERVACIONES" value = "<?php echo $observaciones; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "PLAN"value = "<?php echo $plan; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "NUMERO CASO" value = "<?php echo $no_caso; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "RESPONSABLE"value = "<?php echo $responsable; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "RESPONSABLE GESTION" value = "<?php echo $responsable_ges; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "FECHA ENTREGA GESTION"value = "<?php echo $fecha_entrega_ges; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "OBSERVACION" value = "<?php echo $observacion; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "FECHA ENVIO"value = "<?php echo $fecha_envio; ?>"></td>
						<td><input type = "text" name = "txtsucursal" placeholder = "ESTADO" value = "<?php echo $estado; ?>"></td>
					</tr>
					<tr>
						<td><input type = "text" name = "txtpassasesor" placeholder = "TIEMPO GESTION"value = "<?php echo $tiempo_gestion; ?>"></td>
					</tr>	
					<tr>
						<td align = "center"><input  class = "w3-button w3-teal" type = "submit" value = "Actualizar">
						</form></td>
						<form name = "formularioRegresar" method = "post" action = "http://localhost/pqrs/registros_db/index.php">
						<td align = "center"><input  class = "w3-button w3-teal" type = "submit" value = "Regresar">
						</form></td>
					</tr>
			</table>
	</body>
</html>