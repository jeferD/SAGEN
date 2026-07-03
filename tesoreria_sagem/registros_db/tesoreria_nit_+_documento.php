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

?>
<?php
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
	function crearPagos($nit,$ctacobro,$idrad,$docto,$fini,$ffin)
	{
		if($ctacobro==NULL or $ctacobro=='') $ctacobro='NULL';
		else $ctacobro="'".$ctacobro."'";

		if($idrad==NULL or $idrad=='') $idrad='NULL';
		else $idrad="'".$idrad."'";

		if($docto==NULL or $docto=='') $docto='NULL';
		else $docto="'".$docto."'";

		if($fini==NULL or $fini=='') $fini='NULL';
		else $fini="'".$fini."'";

		if($ffin==NULL or $ffin=='') $ffin='NULL';
		else $ffin="'".$ffin."'";

		$consulta="SELECT * FROM tesoreria_global.tesoreria_pagos('".$nit."',".$ctacobro.",".$idrad.",".$docto.",".$fini.",".$ffin.");";

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
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
	<?php include('../library/lib.php');?>
	<head>
		<image src="Emssanar.PNG" width="1380" height="200">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	
	<body>
		<div class="page-content">
		<div class="row">

		<?php include('_menu.php');?>


			<div class="col-md-9">
			  	<div class="content-box-large" style="text-align: center;">

					<div>
							<h5><b><font color = "#2F62B0"> REPORTE DE PAGOS A PROVEEDORES POR NIT Y NUMERO DE DOCUMENTO DE PAGO</font></h5>
					</div>			
<!--sublime-->
					<hr>
					<?php
					/*
						if(array_key_exists('txtnit', $_POST)&& array_key_exists('pagos', $_POST)){

							$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
							$consulta=crearPagos($_POST['txtnit'],$_POST['txtctacobro'],$_POST['txtidrad'],$_POST['txtdocto'],$_POST['fini'],$_POST['ffin']);

							$res=ejecutarProcedure( $conexion, $consulta );
							//echo $consulta;
							$nit=$_POST['txtnit'];
							
							$file=date("Y-m-d")."_Pagos_".$nit;
							
							echo'<script type="text/javascript">window.location="Descargas/'.$file.'.csv"</script>';
							//echo'<script type="text/javascript">"history.back(-1)"</script>';
							echo'<SCRIPT LANGUAGE=javascript>window.history.go(-1)</SCRIPT> ';

						}
					*/
					?>
					
					<div class="content-box-short">

					
						<form name = "form_Num_Procesos" method = "post" action = "descargar_tesoreria_nit_+_documento.php">
							<table  class="w3-table-all w3-card-4">


									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">NIT*</font></th>
										<td width=40%><input type="number" name = "txtnit" required pattern="[0-9]+" placeholder = "NIT Prestador"></td>
									</tr>
									<!--
									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">Cuenta de Cobro</font></th>
										<td><input type = "text" name = "txtctacobro" placeholder = "Cuenta de Cobro" maxlength="20" pattern="[0-9]+" ></td>
									</tr>
									
									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">Radicado</font></th>
										<td><input type = "text" name = "txtidrad" placeholder = "Radicado" maxlength="10" pattern="[0-9]+" ></td>
									</tr>
									-->
									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">Documento Pago</font></th>
										<td><input type = "text" name = "txtdocto" required placeholder = "Documento Pago" maxlength="12" ></td>
									</tr>
									<!--
									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">Fecha Radicacion inicial</font></th>
										<td><input type = "date" name = "txtfini" ></td></tr>
									<tr>
										<th bgcolor= "white"><font color = "#2F62B0">Fecha Radicacion Final</font></th>
										<td><input type = "date" name = "txtffin"></td>
									</tr>
									-->
							</table><br>
							
								<input class = "w3-button w3-blue" name = "pagos" type = "submit" value = "DESCARGAR" title="DESCARGA ARCHIVO DE CARTERA POR FACTURA DESDE EL ANIO 2016">
						</form><br>
					</div>
				</div>
			</div>
		</div>
		<?php include('_footer.php');?>
	</body>
</html>

<?php
}
}else
echo'<script type="text/javascript">
      alert("Requiere registro para ver este contenido");
      window.location="../index.php"
	</script>';
?>