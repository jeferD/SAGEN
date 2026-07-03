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
			function crearRecobroFact($nit,$factura)
			{
				if($nit==NULL or $nit=='') $nit='NULL';
				else 
					$nit="'".$nit."'";
					$factura="'".$factura."'";

				$consulta="SELECT * FROM tesoreria_global.trazabilidad_factura($nit,$factura);";

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
						<form action="recobros_x_fact.php" method="POST" >
						<h5><font color = "#2F62B0" >
							<b>CONSULTA MOVIMIENTO POR NIT Y FACTURA</b>
						</font><br><br></h5>
							<input id="num_nit" type="number" name="nit" required pattern="[0-9]+" placeholder = "Ingrese Nit"><br><br>
							<input id="num_factura" type="number" name="factura" required pattern="[0-9]+" placeholder = "Ingrese Factura"><br><br>
							<input type="submit" name = 'buscar' class="w3-button w3-blue" value="Buscar">
							<!--<input type="submit" name = 'descargar' class="w3-button w3-blue" value="Descargar">-->
						</form>
						<button onclick="get_nit_factura_input()" class="w3-button w3-blue">Descargar</button>
					</div>		
					<br>
				</div>
			</div>
			
			<div class="col-md-12">
			  	<div class="content-box-large" style="text-align: center;">
				
					<div>
							<h5><b><font color ='#2F62B0'> REGISTROS TRAZABILIDAD - CORTE 2021-08-31</font></b></h5>
					</div>
				
<!--sublime-->
					<hr>
					<?php
					/*
					if(array_key_exists('nit', $_POST)&& array_key_exists('factura', $_POST)&&array_key_exists('descargar', $_POST)){

						$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
						$consulta=crearRecobroFact($_POST['nit'],$_POST['factura']);
						
						$res=ejecutarProcedure( $conexion, $consulta );
						//echo $consulta;
						$nit=$_POST['nit'];
						$factura=$_POST['factura'];
						
						//echo $idrad;
						echo'<script type="text/javascript">window.location="Descargas/'.$nit.'_'.$factura.'.csv"</script>';
						//echo'<script type="text/javascript">"history.back(-1)"</script>';
						echo'<SCRIPT LANGUAGE=javascript>window.history.go(-1)</SCRIPT> ';
					}
					*/
						require('clases/factura_ad.php');
						require('clases/factura.php');
						
						$factura = array();
						

						if(array_key_exists('nit', $_POST)){
						$nit = $_POST['nit'];
						$factura = $_POST['factura'];}
						if(empty($nit)){} else{	
							$objConexion = new conexion();
							$objConexion -> abrir_conexion();
							$objFacturaAD = new factura_ad();
							
							$sqlBaseunoe = "select t.*, 
											(case when existe_conciliacion is null then 'NO' else existe_conciliacion end) as existe_conciliacion,
											(case when fecha_conciliacion is null then null else fecha_conciliacion end) as fecha_conciliacion,
											(case when documento_conciliacion is null then '' else documento_conciliacion end) as documento_conciliacion,
											(case when valor_glosa_favor_eps is null then 0 else valor_glosa_favor_eps end) as valor_glosa_favor_eps,
											(case when valor_glosa_favor_ips is null then 0 else valor_glosa_favor_ips end) as valor_glosa_favor_ips,
											(case when valor_impuesto_real is null then 0 else valor_impuesto_real end) as valor_impuesto_real,
											(case when valor_impuesto_contable is null then 0 else valor_impuesto_contable end) as valor_impuesto_contable,
											(case when fecha_pago is null then null else fecha_pago end) as fecha_pago,
											(case when documento_pago is null then '' else documento_pago end) as documento_pago,
											(case when valor_pagado is null then 0 else valor_pagado end) as valor_pagado,
											(case when valor_pago_total is null then 0 else valor_pago_total end) as valor_pago_total,
											(valor_facturado - (case when valor_glosa_favor_eps is null then 0 else valor_glosa_favor_eps end) - (case when valor_impuesto_real is null then 0 else valor_impuesto_real end) - (case when valor_pago_total is null then 0 else valor_pago_total end)) as valor_saldo
											from (
												select numero_contrato, (case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional, modalidad, auxiliar,
													   (case when auxiliar is null then '' else a.descripcion end) as descripcion_auxiliar, nit, 
													   (case when p.nombre_ips is null then '' else p.nombre_ips end) as nombre_ips,numero_radicado, numero_cuenta_cobro, idfactura, idinterno_lazos, 
													   rips, prefijo, consecutivo, fecha_egreso, fecha_expedicion, fecha_radicacion, 
													   fecha_causacion, documento_causacion, valor_facturado, fecha_glosa_inicial, 
													   documento_glosa_inicial, valor_glosado
												from tesoreria_evento.radicacion 
												left join tesoreria_global.auxiliares as a
												using (auxiliar)
												left join tesoreria_global.proveedores as p
												using (nit)
												where  nit = '$nit' and rips like '%$factura%'
													) as t
											left join (
													select idinterno_lazos, 'SI':: varchar as existe_conciliacion, fecha_conciliacion, documento_conciliacion, valor_glosa_favor_eps, valor_glosa_favor_ips
													from tesoreria_evento.auditoria
													where idinterno_lazos in (
																				select distinct idinterno_lazos
																				from tesoreria_evento.radicacion
																				where  nit = '$nit' and rips like '%$factura%'
																				)
													)a
											using (idinterno_lazos)
											left join (
													select idinterno_lazos, sum(valor_impuesto_real) as valor_impuesto_real, sum(valor_impuesto_contable) as valor_impuesto_contable
													from (
														select *
														from tesoreria_evento.impuestos
														where idinterno_lazos in (
																					select distinct idinterno_lazos
																					from tesoreria_evento.radicacion
																					where  nit = '$nit' and rips like '%$factura%'
																					)
														)imp
													group by idinterno_lazos
													)i
											using (idinterno_lazos)
											left join ( 
													select idinterno_lazos, fecha_pago, documento_pago, valor_pagado,pt.valor_pago_total
													from (
														select *
														from tesoreria_evento.pagos
														where idinterno_lazos in (
																					select distinct idinterno_lazos
																					from tesoreria_evento.radicacion
																					where  nit = '$nit' and rips like '%$factura%'
																					)
															)p
													join (
														select idinterno_lazos,sum(valor_pagado) as valor_pago_total
														from (
															select idinterno_lazos, fecha_pago, documento_pago, valor_pagado
															from tesoreria_evento.pagos
															where idinterno_lazos in (
																						select distinct idinterno_lazos
																						from tesoreria_evento.radicacion
																						where  nit = '$nit' and rips like '%$factura%'
																						)
																		)p
														group by idinterno_lazos
															)pt
													using(idinterno_lazos)
														)p
											using (idinterno_lazos);";
							
							$factura = $objFacturaAD -> listar($objConexion -> pdo, $sqlBaseunoe);

					?>

					<div class='panel-body'>


						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<!--<th><font size = '1.3'>N° CONTRATO</font></th>-->
									<th><font size = '1.3'>C.O</font></th>
									<!--<th><font size = '1.3'>MODADLIDAD</font></th>-->
									<!--<th><font size = '1.3'>AUXILIAR</font></th>-->
									<!--<th><font size = '1.3'>DESCRIPCION AUXILIAR</font></th>-->
									<th><font size = '1.3'>NIT</font></th>
									<th><font size = '1.3'>NOMBRE</font></th>
									<th><font size = '1.3'>NUMERO RADICADO</font></th>
									<th><font size = '1.3'>NUMERO CUENTA COBRO</font></th>
									<!--<th><font size = '1.3'>IDFACTURA</font></th>-->
									<!--<th><font size = '1.3'>ID INTERNO LAZOS</font></th>-->
									<th><font size = '1.3'>RIPS</font></th>
									<!--<th><font size = '1.3'>PREFIJO</font></th>-->
									<!--<th><font size = '1.3'>CONSECUTIVO</font></th>-->
									<!--<th><font size = '1.3'>FECHA EGRESO</font></th>-->
									<!--<th><font size = '1.3'>FECHA EXPEDICION</font></th>-->
									<th><font size = '1.3'>FECHA RADICACION</font></th>
									<!--<th><font size = '1.3'>FECHA CAUSACION</font></th>-->
									<!--<th><font size = '1.3'>DOCUMENTO CAUSACION</font></th>-->
									<th><font size = '1.3'>VALOR FACTURADO</font></th>
									<!--<th><font size = '1.3'>FECHA GLOSA INICIAL</font></th>-->
									<!--<th><font size = '1.3'>DOCTO GLOSA INCIAL</font></th>-->
									<th><font size = '1.3'>VALOR GLOSADO</font></th>
									<th><font size = '1.3'>EXISTE CONCILIACION</font></th>
									<!--<th><font size = '1.3'>FECHA CONCILIACION</font></th>-->
									<!--<th><font size = '1.3'>DOCUMENTO CONCILIACION</font></th>-->
									<th><font size = '1.3'>VALOR GLOSA FAVOR EPS</font></th>
									<th><font size = '1.3'>VALOR GLOSA FAVOR IPS</font></th>
									<th><font size = '1.3'>VALOR IMPUESTO REAL</font></th>
									<!--<th><font size = '1.3'>VALOR IMPUESTO CONTABLE</font></th>-->
									<th><font size = '1.3'>FECHA PAGO</font></th>
									<th><font size = '1.3'>DOCUMENTO PAGO</font></th>
									<th><font size = '1.3'>VALOR PAGODO</font></th>
									<th><font size = '1.3'>VALOR PAGO TOTAL</font></th>
									<th><font size = '1.3'>VALOR SALDO</font></th>

								</tr>
							</thead>
						
							<tbody>
						
							<?php
								foreach ($factura as $dato) {
									echo "<tr>";
									$objFactura = new factura();
									$objFactura = $dato;
									//echo "<td><font size = '1.3'>".$objFactura -> getNumero_Contrato()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getCodigo_Regional()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getModalidad()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getAuxiliar()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getDescripcion_Auxiliar()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getNit()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getNombre_Ips()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getNumero_Radicado()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getNumero_Cuenta_Cobro()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getIdfactura()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getIdinterno_Lazos()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getRips()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getPrefijo()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getConsecutivo()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getFecha_Egreso()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getFecha_Expedicion()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getFecha_Radicacion()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getFecha_Causacion()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getDocumento_Causacion()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Facturado()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getFecha_Glosa_Inicial()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getDocumento_Glosa_Inicial()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Glosado()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getExiste_conciliacion()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getFecha_Conciliacion()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getDocumento_Conciliacion()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Glosa_Favor_Eps()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Glosa_Favor_Ips()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Impuesto_Real()."</font></td>";
									//echo "<td><font size = '1.3'>".$objFactura -> getValor_Impuesto_Contable()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getFecha_Pago()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getDocumento_Pago()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Pagado()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Pagado_Total()."</font></td>";
									echo "<td><font size = '1.3'>".$objFactura -> getValor_Saldo()."</font></td>";

									echo "</td>";
									$objFactura -> __destruct();
									echo "</tr>";
								}
								$objFacturaAD -> __destruct();

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
	
		function get_nit_factura_input() {
			var nit = document.getElementById("num_nit");
			var factura = document.getElementById("num_factura");
			if(nit.value !== ''  && factura.value !== ''){
				window.location.href = "descargar_recobro_x_factura.php?id_nit="+nit.value+"&id_factura="+factura.value;
				nit.value="";
				factura.value="";
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