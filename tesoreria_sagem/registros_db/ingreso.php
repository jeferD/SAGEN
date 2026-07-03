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
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<image src="Emssanar.PNG" width="1380" height="200">		
	</head>

<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml" style ="overflow:scroll">
	<?php include('../library/lib.php');?>
	<body>

<div class="page-content">
	<div class="row">

		<?php include('_menu.php');?>


			<div class="col-md-10">
			  	<div class="content-box-large" style="text-align: center;">

			  	<div>
						<h5><font color = "#2F62B0"><b> FORMULARIO DE INGRESO - EMAIL PROVEEDORES </b></font></h5>
				</div>
		<hr>
		<?php

            require('clases/emails_ad.php');
            require('clases/emails.php');

		$emails = array();

			$id="";
			$nit="";
			$nomips="";
			$email="";
			$activo="";
			

			if(array_key_exists('id', $_POST)){

				$id = '';
				$nit = $_POST['nit'];
				$nomips = $_POST['nomips'];
				$email = $_POST['email'];
				$activo = false;
				
				$objEmails = new emails();
				$objEmails -> setId($id);
				$objEmails -> setNit($nit);
				$objEmails -> setNomips($nomips);
				$objEmails -> setEmail($email);
				$objEmails -> setActivo($activo);
				
				$objConexion = new conexion();
				$objConexion -> abrir_conexion();

				$objEmailsAD = new emails_ad();

				$objEmailsAD -> crear($objEmails);
				$objEmails -> __destruct();
				echo'<script type="text/javascript">alert(" El EMAIL fue registrado satisfactoriamente");window.location="emails.php"</script>';
				pg_close();

			}
		?>

		<div class='panel-body'>

			<form name = "formularioIngresar" method = "post" action = "ingreso.php">
			<input type="hidden" class="form-control" name="id" placeholder = "Id De emails" value = "999">

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">NIT </label>
					<div class="col-sm-3">
						<input type="text" name="nit" class="form-control" required>
					</div>
					<label class="col-md-2 control-label" for="text-field">NOMBRE </label>
					<div class="col-sm-3">
						<input type="text" name="nomips" class="form-control" required>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<label class="col-md-2 control-label" for="text-field">EMAIL</label>
					<div class="col-sm-3">
						<input  type="text" class="form-control" placeholder="" name="email" required>
					</div>
				</div>
			</div>
			
			<br>
			<div class="form-group" >
				<div class="col-sm-offset-2 col-sm-8">
				  <input  class="btn btn-primary signup" type = "submit" value = "REGISTRAR">
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

<?php
}
}else
echo'<script type="text/javascript">
      alert("Requiere registro para ver este contenido");
      window.location="../index.php"
	</script>';
?>