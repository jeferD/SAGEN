<title>Emssanar Tesoreria</title>
<?php
	
	require('registros_db/clases/conexion.php');
	require('registros_db/clases/users_ad.php');
	$objConexion = new conexion();
	$objConexion->cerrar();

	if(isset($_POST['login'])) {

		$user = addslashes(trim($_POST['login']));
		$pass = addslashes(trim($_POST['password']));

		$log = $objConexion->logueo($user, $pass);
	}
?>


<html>
	<head>
	
		<image src="Emssanar1.PNG" width="1380" height="200">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	</head>



	<body class="login-bg">

		<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/styles.css" rel="stylesheet">
	    <script src="js/jquery-1.9.js"></script>
	    <script src="bootstrap/js/bootstrap.min.js"></script>
	    <script src="js/custom.js"></script>
	    <script src="js/maincode.js"></script>
  	
	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
					<br /><br />
			        <div class="box">
			            <div class="content-wrap">
			                <h6 style="font-family:'Open Sans Condensed'; color:#2F62B0; font-size: 250%; font-weight: bold;">INICIAR SESION</h6>
			                
			                <form name = "InicioSesion" method = "post" action = "index.php">
			                <input class="form-control" name="login" type="text" required placeholder="USUARIO" onkeypress="if (event.keyCode == 13) submitform_login()">
			                <input class="form-control" name="password" type="password" placeholder="PASSWORD" required onkeypress="if (event.keyCode == 13) submitform_login()">
			                <div class="action">
			                    <input type='submit' class="w3-button w3-blue" value='INGRESAR'/>
			                </div>

			                </form>   
			                <br /><br />
			                <div align='right'><a href='recuperarcon.php'>Recuperar clave</a></div>           
			            </div>
			        </div>
					<style>
						.custom-link {
							text-decoration: none;
							color: #000;
							font-size: 18px;
						}
						.custom-link:hover {
							color: #00508A; 
						}
						.custom-link:active {
							color: #FF5733; 
						}
					</style>
					<div style="display: flex; justify-content: center; align-items: center; height: 30vh;">
						<a href="https://servicios.emssanareps.co/" class="custom-link">Regresar al inicio</a>
					</div>
			    </div>
			</div>
		</div>
	</div>  
	
	
  </body>
</html>