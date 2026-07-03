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
	function crearCartera($nit,$ctacobro,$idrad,$docto,$fini,$ffin)
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

		$consulta="SELECT * FROM tesoreria_global.tesoreria_cartera('".$nit."',".$ctacobro.",".$idrad.",".$docto.",".$fini.",".$ffin.");";

		return $consulta;
}*/
	
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
							<h5><b><font color = "#2F62B0"> REPORTE DE CARTERA A PROVEEDORES POR LISTA DE RADICADOS</font></h5>
					</div>
<!--sublime-->
					<hr>
					<?php 
					/*
					if(array_key_exists('txtnit', $_POST)&& array_key_exists('cartera', $_POST)){

							$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
							$consulta=crearCartera($_POST['txtnit'],$_POST['txtctacobro'],$_POST['txtidrad'],$_POST['txtdocto'],$_POST['fini'],$_POST['ffin']);

							$res=ejecutarProcedure( $conexion, $consulta );
							//echo $consulta;
							$nit=$_POST['txtnit'];
							
							$file=date("Y-m-d")."_Cartera_".$nit;
							
							echo'<script type="text/javascript">window.location="Descargas/'.$file.'.csv"</script>';
							//echo'<script type="text/javascript">"history.back(-1)"</script>';
							echo'<SCRIPT LANGUAGE=javascript>window.history.go(-1)</SCRIPT> ';
class="content-box-short"
						}
						*/
					?>
					
					<div class="content-box-short">
						<!-- <form name = "form_Num_Procesos" method = "post" action = https://servicios.emssanar.org.co/tesoreria_sagem/registros_db/descargar_cartera_x_rad.php>-->
						<form name = "form_Num_Procesos" method = "post" action = "descargar_cartera_lista_radicados.php">
							<table class="w3-table-all w3-card-4">
								<tr>								
									<td>
										<input type="text" style="width : 900px; heigth : 900px" rows = "4"  name = "txtidrad" onKeyPress="return validar(event)" placeholder = "Ingrese la lista de radicados, separar por el simbolo de la coma ','" required>
									</td>
								</tr>
							</table>			
							<br>
							<input class = "w3-button w3-blue" name = "cartera" type = "submit" value = "DESCARGAR" title="DESCARGA ARCHIVO DE CARTERA POR FACTURA DESDE EL ANIO 2016">
						</form><br>
					</div>
				</div>
			</div>
		</div>
		<?php include('_footer.php');?>
	</body>
</html>

	<script type="text/javascript">
		function validar(e) {
			tecla = (document.all) ? e.keyCode : e.which;
			if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
			if (tecla==44) return true; //Coma ( En este caso para diferenciar los decimales )
			if (tecla==48) return true;
			if (tecla==49) return true;
			if (tecla==50) return true;
			if (tecla==51) return true;
			if (tecla==52) return true;
			if (tecla==53) return true;
			if (tecla==54) return true;
			if (tecla==55) return true;
			if (tecla==56) return true;
			patron = /1/; //ver nota
			te = String.fromCharCode(tecla);
			return patron.test(te);
		}
		
		function get_lista_radicados() {
			  var rad = document.getElementById("id");
			  if(rad.value !== ''){
				window.location.href = "descargar_cartera_x_rad.php?txtidrad="+rad.value;
				rad.value="";
			  }
		}
		
	</script>

<?php
}
}else
echo'<script type="text/javascript">
      alert("Requiere registro para ver este contenido");
      window.location="../index.php"
	</script>';
?>