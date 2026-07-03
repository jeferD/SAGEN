<title>Emssanar Tesoreria</title>
<?php
require_once('clases/conexion.php');
if(isset($_SESSION['session']))
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
<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml"   style ="overflow:scroll">
	<?php include('../library/lib.php');?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	
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
					<?php
						$objConexion = new conexion();
					?>
						<div class='panel-body'>
							<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							<script type="text/javascript">
								Highcharts.chart('container', {
								chart: {
									type: 'column'
								},
								title: {
									text: 'CARTERA REPORTADA EN CIRCULAR 030 PERIODO DICIEMBRE 2020'
								},
								subtitle: {
										text: 'Comparativo grafico entre cartera reportada entre EPS vs IPS.'
									},
								xAxis: {
									type: 'category'
								},
								yAxis: {
									title: {
										text: 'valor cartera reportada'
									}

								},
								legend: {
									enabled: false
								},
								plotOptions: {
									series: {
										borderWidth: 0,
										dataLabels: {
											enabled: true,
											format: '{point.y:f}'
										}
									}
								},

								tooltip: {
									headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
									pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> del total saldo reportado<br/>'
								},

								series: [
									{
										name: "Valor saldo",
										colorByPoint: true,
										data: [


										<?php
											$sql = "select entidad,cast(replace(saldo, ',', '') as numeric) as saldo from tesoreria_sac.grafica_indicador where fecha_corte = '2020-12-31' order by 1";  
											$result = pg_query($sql);

											while ($fila = pg_fetch_row($result)) {
												echo "
													{name: '".$fila[0]."',
														y: ".$fila[1].",
														drilldown: null
													},";
											}
										?>


										   
										]
									}
								]
							});
							</script>
						</div>
					</div>
				
				
					<!--<div class="row">-->
					<?php
						require('clases/cubos_ad.php');
						require('clases/indicador.php');
						
						$cubos = array();
						$indicador = array();
						
						
						if(isset($_POST['txtBusqueda'])){
						$busqueda = $_POST['txtBusqueda'];
						}
						
						$objConexion -> abrir_conexion();
						
						$objCubosAD = new cubos_ad();		

						$sqlIndicador = "select * from tesoreria_sac.indicador;";
						$indicador = $objCubosAD -> listarindicador($objConexion -> pdo, $sqlIndicador);	
					?>
						<div class="col-md-12" align : 'center'>
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
					<!--</div>-->
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