<title>Emssanar Tesoreria</title>
<?php
require_once('clases/conexion.php');
if(isset($_SESSION['session']) AND  $_SESSION['tipo_usuario']==1)
{
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['time_max'])) {
	    // last request was more than 30 minates ago
	    session_destroy();   // destroy session data in storage
	    session_unset();     // unset $_SESSION variable for the runtime
	    echo '<script type="text/javascript">
				      alert("Tu Sesion termino, realiza de nuevo el Login");
				      window.location="../index.php"
				  </script>';
	}else { //Starting this else one [else1]

		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
			
			ini_set("display_errors", "on");
			
			function conectar_PostgreSQL( $usuario, $pass, $host, $port, $bd )
			{
				$conexion = pg_connect( "user=".$usuario." ".
								   "password=".$pass." ".
								   "host=".$host." ".
								   "port=".$port." ".
								   "dbname=".$bd
								  ) or die( "Error al conectar: ".pg_last_error() );

				return $conexion;
			}
			/*
			function crearRecobroCta($nit,$numero_cuenta_cobro)
			{
				if($nit==NULL or $nit=='') $nit='NULL';
				else 
					$nit="'".$nit."'";
					$numero_cuenta_cobro="'".$numero_cuenta_cobro."'";

				$consulta="SELECT * FROM tesoreria_global.recobros_x_cta($nit,$numero_cuenta_cobro);";

				return $consulta;
			}
			*/
			ini_set('max_execution_time', 0);
			/*
			function ejecutarProcedure( $conexion, $sql )
			{
				// Ejecutar la consulta:
				$rs = pg_query( $conexion, $sql );

				if( $rs )
				{
					// Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
					//if( pg_num_rows($rs) > 0 )	$devolver = pg_fetch_object( $rs, 0 );

					while ($row = pg_fetch_row($rs)) {
					  $devolver=$row[0];}
				}

				return $devolver;
			}
			*/
?>
<!DOCTYPE html>
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml" style ="overflow:scroll">
	<?php include('../library/lib.php');?>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<image src="Emssanar.PNG" width="1380" height="200">		
	</head>
	
	<body>
		<div class="page-content">
		<div class="row">

		<?php include('_menu.php');?>

			<div class="col-md-10">
				<div class="content-box-large">
					<div >
						<form action="recobros_x_cta.php" method="POST" >
						<h5><font color = "#2F62B0" >
							<b>CONSULTA MOVIMIENTO POR NIT Y CUENTA DE COBRO</b>
						</font><br><br></h5>
							<input id="num_nit" type="number" name="nit" required pattern="[0-9]+" placeholder = "Ingrese Nit"><br><br>
							<input id="num_cta" type="number" name="numero_cuenta_cobro" required pattern="[0-9]+" placeholder = "Ingrese Cuenta Cobro"><br><br>
							<input type="submit" name = 'buscar' class="w3-button w3-blue" value="Buscar">
							<!--<input type="submit" name = 'descargar' class="w3-button w3-blue" value="Descargar">-->
						</form>
						<button onclick="get_nit_cta_input()" class="w3-button w3-blue">Descargar</button>
					</div>		
					<br>
				</div>
			</div>
			
			<div class="col-md-12">
			  	<div class="content-box-large" style="text-align: center;">
				
					<div>
							<h5><b><font color ='#2F62B0'> REGISTROS BASE UNOE - CORTE 2021-08-31</font></b></h5>
					</div>
				
<!--sublime-->
					<hr>
					<?php
					/*
					if(array_key_exists('nit', $_POST)&& array_key_exists('numero_cuenta_cobro', $_POST)&&array_key_exists('descargar', $_POST)){

						$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
						$consulta=crearRecobroCta($_POST['nit'],$_POST['numero_cuenta_cobro']);

						$res=ejecutarProcedure( $conexion, $consulta );
						echo $consulta;
						$nit=$_POST['nit'];
						$numero_cuenta_cobro=$_POST['numero_cuenta_cobro'];
						
						//echo $idrad;
						echo'<script type="text/javascript">window.location="Descargas/'.$numero_cuenta_cobro.'.csv"</script>';
						//echo'<script type="text/javascript">"history.back(-1)"</script>';
						echo'<SCRIPT LANGUAGE=javascript>window.history.go(-1)</SCRIPT> ';
					}
					*/
						require('clases/base_unoe_ad.php');
						require('clases/base_unoe.php');
						
						$base_unoe = array();
						

						if(array_key_exists('nit', $_POST)){
						$nit = $_POST['nit'];
						$numero_cuenta_cobro = $_POST['numero_cuenta_cobro'];}
						if(empty($nit)){} else{	
							$objConexion = new conexion();
							$objConexion -> abrir_conexion();
							$objBaseunoeAD = new base_unoe_ad();
							
							$sqlBaseunoe = "select 	id_unoe,(case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional, 
												(case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional_documento,
												auxiliar, a.descripcion as descripcion_auxiliar,nit, p.nombre_ips, numero_radicado,
												numero_cuenta_cobro, fecha, documento,to_char(debito,'999G999G999G999') as debito,
												to_char(credito,'999G999G999G999') as credito,to_char(neto,'999G999G999G999') as neto,nota,
												m.descripcion as tipo_movimiento,numero_pagos,tasa_impuesto_unoe,base_impuesto_unoe,fecha_creacion,fecha_aprobacion,
												tasa_impuesto_real,base_impuesto_real,i.descripcion as tipo_impuesto
											from tesoreria_evento.base_unoe 
											join tesoreria_global.proveedores as p
											using(nit)
											join tesoreria_global.auxiliares as a
											using(auxiliar)
											join tesoreria_global.tipo_movimiento as m
											using(tipo_movimiento)
											join tesoreria_global.tipo_impuesto as i
											using(tipo_impuesto)
											WHERE nit = '$nit' and numero_cuenta_cobro = '$numero_cuenta_cobro';";
							
							$base_unoe = $objBaseunoeAD -> listar($objConexion -> pdo, $sqlBaseunoe);

					?>

					<div class='panel-body'>


						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<!--<th>ID UNOE</th>830010337-0-BEATRIZ.PEREIRACORZO@SANOFI.COM-->
									<th><font size = '2'>C.O</font></th>
									<!--<th><font size = '2'>CENTRO_OPERACION_MOVIMIENTO</font></th>-->
									<!--<th>AUXILIAR</font></th>-->
									<th><font size = '2'>MODALIDAD</font></th>
									<th><font size = '2'>NIT</font></th>
									<th><font size = '2'>NOMBRE</font></th>
									<th><font size = '2'>N°RADICADO</font></th>
									<th><font size = '2'>N°CUENTA</font></th>
									<th><font size = '2'>FECHA</font></th>
									<th><font size = '2'>DOCUMENTO</font></th>
									<th><font size = '2'>DEBITO</font></th>
									<th><font size = '2'>CREDITO</font></th>
									<th><font size = '2'>NETO</font></th>
									<th><font size = '2'>NOTA</font></th>
									<th><font size = '2'>MOVIMIENTO</font></th>
									<th><font size = '2'>N°PAGO</font></th>
									<!-- <th>TASA IMPUESTO UNOE</font></th>-->
									<!-- <th>BASE IMPUESTO UNOE</font></th>-->
									<!-- <th>FECHA CREACION</font></th>-->
									<!-- <th>FECHA APROBAACION</font></th>-->
									<!-- <th>IMPUESTO</font></th>-->
									<!-- <th>TASA IMPUESTO REAL</font></th>-->
									<!-- <th>BASE IMPUESTO REAL</font></th>-->
									<!-- <th>TIPO IMPUESTO</font></th>-->
								</tr>
							</thead>
						
							<tbody>
						
							<?php
								foreach ($base_unoe as $dato) {
									echo "<tr>";
									$objBaseunoe = new base_unoe();
									$objBaseunoe = $dato;
									$ideActual=$objBaseunoe -> getId_UnoE();
									//echo "<td><font size = '2'>".$objBaseunoe -> getId_UnoE()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getCodigo_Regional()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getCodigo_Regional_Documento()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getAuxiliar()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getDescripcion_Auxiliar()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNit()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNombre_Ips()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNumero_Radicado()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNumero_Cuenta_Cobro()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getFecha()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getDocumento()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getDebito()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getCredito()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNeto()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNota()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getTipo_Movimiento()."</font></td>";
									echo "<td><font size = '2'>".$objBaseunoe -> getNumero_Pago()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getTasa_Impuesto_UnoE()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getBase_Impuesto_UnoE()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getFecha_Creacion()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getFecha_Aprobacion()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getTasa_Impuesto_Real()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getBase_Impuesto_Real()."</font></td>";
									//echo "<td><font size = '2'>".$objBaseunoe -> getTipo_Impuesto()."</font></td>";

									echo "</td>";
									$objBaseunoe -> __destruct();
									echo "</tr>";
								}
								$objBaseunoeAD -> __destruct();

							?>
							</tbody>
						</table><br>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php include('_footer.php');?>
	</body>
	<script>
	
		function get_nit_cta_input() {
			var nit = document.getElementById("num_nit");
			var cta = document.getElementById("num_cta");
			if(nit.value !== ''  && cta.value !== ''){
				window.location.href = "descargar_recobro_x_cta.php?id_nit="+nit.value+"&id_numero_cuenta_cobro="+cta.value;
				nit.value="";
				cta.value="";
			}
		}
	
	</script>
</html>

<?php
}
}else
echo'<script type="text/javascript">
      alert("Requiere registro para ver este contenido");
      window.location="../index.php"
	</script>';
?>