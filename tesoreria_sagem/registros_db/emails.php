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
	function crearEmails()
	{
		$consulta="select * from tesoreria_global.exporta_emails()";

		return $consulta;
}
	
	ini_set('max_execution_time', 0);

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
			  	<div class="content-box-large" style="text-align: center;">
				
					<div>
							<h5><b><font color ='#2F62B0'> CORREOS ELECTRONICOS PRESTADORES </font></b></h5>
					</div>

					<hr>
					<?php
						require('clases/emails_ad.php');
						require('clases/emails.php');
						
						$busqueda = 0;
						$emails = array();

						//if(empty($busqueda)){} else{	
							$objConexion = new conexion();
							$objConexion -> abrir_conexion();
							$objEmailsAD = new emails_ad();
						
						if(array_key_exists('id', $_POST)){
							$busqueda = $_POST['id'];}
						
						if(array_key_exists('idEliminacion', $_POST)){
							$objEmails = new emails();
							$objEmails -> setId($_GET['idEliminacion']);
							$objEmailsAD -> eliminar($objConexion -> pdo, $objEmails);
						}
						$sqlEmails = "select * from tesoreria_global.emails where activo = TRUE;";
						
						$emails = $objEmailsAD -> listar($objConexion -> pdo, $sqlEmails);

					?>

					<div class='panel-body'>


						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<!--<th><font size = '2'>ID</font></th>-->
									<th><font size = '2'>NIT</font></th>
									<th><font size = '2'>NOMBRE</font></th>
									<th><font size = '2'>EMAIL</font></th>
									<th><font size = '2'>ACCION</font></th>

								</tr>
							</thead>
						
							<tbody>
						
							<?php
								foreach ($emails as $dato) {
									echo "<tr>";
									$objEmails = new emails();
									$objEmails = $dato;
									$ideActual=$objEmails -> getId();
									//echo "<td><font size = '2'>".$objEmails -> getId()."</font></td>";
									echo "<td><font size = '2'>".$objEmails -> getNit()."</font></td>";
									echo "<td><font size = '2'>".$objEmails -> getNomips()."</font></td>";
									echo "<td><font size = '2'>".$objEmails -> getEmail()."</font></td>";

									echo "<td>
									<table>
										<tr>
											<td width='40%'  style='text-align: center;'>
												<a href='actualizar.php?id=$ideActual'>
													<img src='../images/notes_edit.png' title='Actualizar'>
												</a>
											</td>
											
											<td width='40%'  style='text-align: center;'>
												<a href='eliminar.php?id=$ideActual'>
													<img src=../images/delete.png title='Eliminar'>
												</a>
											</td>
										</tr>
									</table>";
							?>
							<?php
									echo "</td>";
									$objEmails -> __destruct();
									echo "</tr>";
								}
								$objEmailsAD -> __destruct();
							?>
							</tbody>
						</table><br>
						<!--sublime-->
								<hr>
								<?php
								if(array_key_exists('emails', $_POST)){

								$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
								$consulta= crearEmails();
								echo $consulta;
								$res=ejecutarProcedure( $conexion, $consulta );
								echo $consulta;
								//$nit=$_POST['txtnit'];

								echo'<script type="text/javascript">window.location="Descargas/email.csv"</script>';
								//echo'<script type="text/javascript">"history.back(-1)"</script>';
								echo'<SCRIPT LANGUAGE=javascript>window.history.go(-1)</SCRIPT> ';
								
								/*
								<div class="content-box-short">
									<form name = "form_Num_Procesos" method = "post" action = http://192.168.12.58/tesoreria/registros_db/emails.php>						
											<input class = "w3-button w3-blue" name = "emails" type = "submit" value = "DESCARGAR" title="DESCARGA ARCHIVO DE EMAILS">
									</form><br>
								</div>
								*/
								}
								?>
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