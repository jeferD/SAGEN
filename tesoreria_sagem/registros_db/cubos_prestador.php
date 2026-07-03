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
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<image src="Emssanar.PNG" width="1380" height="200">
		
	</head>
	
	<body>
		
		<div class="page-content">
		<div class="row">

		<?php include('_menu.php');?>
		
		<?php
			require('clases/cubos_ad.php');
			require('clases/cubos.php');
			require('clases/indicador.php');
			
			$cubos = array();
			$indicador = array();
			
			
			if(isset($_POST['txtBusqueda'])){
			$busqueda = $_POST['txtBusqueda'];
			}
			
			$objConexion = new conexion();
			$objConexion -> abrir_conexion();
			
			$objCubosAD = new cubos_ad();		

			$sqlCubos = "SELECT  	niteps,nitips,to_char(vrfacturaeps,'999G999G999G999') as vrfacturaeps,
									to_char(vrglosaaceptadaeps,'999G999G999G999') as vrglosaaceptadaeps,
									to_char(vrpagototaleps,'999G999G999G999') as vrpagototaleps,to_char(vrsaldoeps,'999G999G999G999') as vrsaldoeps,
									to_char(vrfacturaips,'999G999G999G999') as vrfacturaips,to_char(vrglosaaceptadaips,'999G999G999G999') as vrglosaaceptadaips,
									to_char(vrpagototalips,'999G999G999G999') as vrpagototalips,to_char(vrsaldoips,'999G999G999G999') as vrsaldoips,
									nomeps,nomips,to_char(diferencia,'999G999G999G999') as diferencia,coincidencia
						FROM tesoreria_sac.cubos;";
			$cubos = $objCubosAD -> listar($objConexion -> pdo, $sqlCubos);
				

			$sqlIndicador = "select * from tesoreria_sac.indicador;";
			$indicador = $objCubosAD -> listarindicador($objConexion -> pdo, $sqlIndicador);
				
		?>
			
			<div class="col-md-10">
				<div class="content-box">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example1">
						<thead>
							<tr>
								<th><font size = '2'>FECHA CORTE</font></th>
								<th><font size = '2'>NIT EPS</font></th>
								<th><font size = '2'>NOMBRE EPS</font></th>
								<th><font size = '2'>VALOR SALDO EPS</font></th>
								<th><font size = '2'>VALOR SALDO IPS</font></th>
								<th><font size = '2'>DIFERENCIA</font></th>
								<th><font size = '2'>NIVEL DE COINCIDENCIA</font></th>
							</tr>
						</thead>
					
						<?php
							foreach ($indicador as $dato) {
								echo "<tr>";
								$objIndicador = new indicador();
								$objIndicador = $dato;
								//$ideActual=$objIndicador -> getId();
								echo "<td><font size = '2'>".$objIndicador -> getFecha_corte()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getNiteps()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getNomeps()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getVrsaldoeps()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getVrsaldoips()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getDiferencia()."</font></td>";
								echo "<td><font size = '2'>".$objIndicador -> getNivel()."</font></td>";

								echo "</td>";
								$objIndicador -> __destruct();
								echo "</tr>";
							}
							$objCubosAD -> __destruct();
						?>
					</table>			
				</div>
			</div> 
		
			<div class="col-md-12">
			  	<div class="content-box-large" style="text-align: center;">

					<div>
							<h5><font color = "#2F62B0"><b>CUBOS DE INFORMACION CORTE - CORTE 2020-12-31</b></font></h5>
					</div>
				
<!--sublime-->

					<div class='panel-body'>


						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<th><font size = '2'>NIT EPS</font></th>
									<th><font size = '2'>NOMBRE EPS</font></th>
									<th><font size = '2'>NIT IPS</font></th>
									<th><font size = '2'>NOMBRE IPS</font></th>
									<th><font size = '2'>VALOR FACTURA EPS</font></th>
									<th><font size = '2'>VALOR GLOSA ACEPTADA EPS</font></th>
									<th><font size = '2'>VALOR PAGO TOTAL EPS</font></th>
									<th><font size = '2'>VALOR SALDO EPS</font></th>
									<th><font size = '2'>VALOR FACTURA IPS</font></th>
									<th><font size = '2'>VALOR GLOSA ACEPTADA IPS</font></th>
									<th><font size = '2'>VALOR PAGO TOTAL IPS</font></th>
									<th><font size = '2'>VALOR SALDO IPS</font></th>
									<th><font size = '2'>DIFERENCIA</font></th>
									<th><font size = '2'>NIVEL DE COINCIDENCIA</font></th>

								</tr>
							</thead>
						
							<tbody>
						
							<?php
								foreach ($cubos as $dato) {
									echo "<tr>";
									$objCubos = new cubos();
									$objCubos = $dato;
									//$ideActual=$objCubos -> getId();
									echo "<td><font size = '1.9'>".$objCubos -> getNiteps()."</font></td>";
									echo "<td><font size = '1'>".$objCubos -> getNomeps()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getNitips()."</font></td>";
									echo "<td><font size = '1'>".$objCubos -> getNomips()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrfacturaeps()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrglosaaceptadaepst()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrpagototaleps()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrsaldoeps()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrfacturaips()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrglosaaceptadaips()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrpagototalips()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getVrsaldoips()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getDiferencia()."</font></td>";
									echo "<td><font size = '1.9'>".$objCubos -> getCoincidencia()."%"."</font></td>";

									echo "</td>";
									$objCubos -> __destruct();
									echo "</tr>";
								}
								$objCubosAD -> __destruct();

							?>
							</tbody>
						</table><br>
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