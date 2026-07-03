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
				<div class="col-md-10">
					<div class="content-box-large" style="text-align: center;">
						<div>
								<h5><font color = "#2F62B0" ><b>.::BIENVENIDO::.</b></font></h5>
						</div>
					<hr>
					<?php
					ini_set("display_errors", "on");
						
						require('clases/users_ad.php');
						require('clases/users.php');

					?>
						<div class='panel-body'>
							<br>
							<h6>Te damos la bienvenida a este aplicativo web, el cual tiene multiples funciones implementado por el area de Tesoreria Emssanar, con el fin de poner a su disposicion una herramienta
							agil que responde a las solicitudes o reportes realizados por las diferentes areas que requieren informacion sobre pagos, cartera, conciliaciones, circular 030 y demas 
							temas relacionados con nuestra area y sus procesos.</h6>
							<br>
							
							<img src="Inicio.png">
							
						</div>
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
      alert("Debe iniciar sesion para ver este contenido");
      window.location="../index.php"
	</script>';
?>