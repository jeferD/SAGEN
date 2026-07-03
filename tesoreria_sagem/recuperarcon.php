<?php
	
	require('registros_db/clases/conexion.php');
	require('registros_db/clases/users_ad.php');
	$objConexion = new conexion();
	$objConexion->cerrar();

	if(isset($_POST['ide'])) {

		$noid = addslashes(trim($_POST['ide']));

		$log = $objConexion->recuperar($noid);
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
			                <h6 style="font-family:'Open Sans Condensed'; color:#2F62B0; font-size: 250%; font-weight: bold;">Digite su numero de identificacion</h6>
			                
			                <form name = "InicioSesion" method = "post" action = "recuperarcon.php">
								<input class="form-control" name="ide" type="text" required placeholder="Identificate!" onkeypress="if (event.keyCode == 13) submitform_login()">

								<div class="action">
									<input type='submit' class="w3-button w3-blue" value='Enviar'/>
								</div>

			                </form>   
       						<br/><br />
			                <div align='right'><a href='index.php'>Volver...</a></div>
			            </div>
			            
			        </div>

			        <!--div class="already">
			            <p>Recuperar contrase�a </p>
			            <a href="#">Dar clic aqui</a>
			        </div-->
			    </div>
			</div>
		</div>
	</div>

    
  </body>


</html>