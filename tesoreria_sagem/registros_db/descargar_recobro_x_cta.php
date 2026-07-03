<?php
require_once('clases/conexion.php');
ini_set('max_execution_time', 0);

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


$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );

$nit = $_GET['id_nit'];
$numero_cuenta_cobro = $_GET['id_numero_cuenta_cobro'];

$qry = pg_query("select (case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional, 
						(case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional_documento,
						auxiliar, 
						a.descripcion as descripcion_auxiliar,
						nit, 
						p.nombre_ips, 
						numero_radicado,
						numero_cuenta_cobro, 
						fecha, 
						documento,
						to_char(debito,'999G999G999G999') as debito,
						to_char(credito,'999G999G999G999') as credito,
						to_char(neto,'999G999G999G999') as neto,
						nota,
						m.descripcion as tipo_movimiento,
						numero_pagos,
						tasa_impuesto_unoe,
						base_impuesto_unoe,
						fecha_creacion,
						fecha_aprobacion,
						tasa_impuesto_real,
						base_impuesto_real,
						i.descripcion as tipo_impuesto
					from tesoreria_evento.base_unoe 
					join tesoreria_global.proveedores as p
					using(nit)
					join tesoreria_global.auxiliares as a
					using(auxiliar)
					join tesoreria_global.tipo_movimiento as m
					using(tipo_movimiento)
					join tesoreria_global.tipo_impuesto as i
					using(tipo_impuesto)
					WHERE nit = '$nit' and numero_cuenta_cobro = '$numero_cuenta_cobro';");

$data = "codigo_regional,codigo_regional_documento,auxiliar,descripcion_auxiliar,nit,nombre_ips,numero_radicado,numero_cuenta_cobro,fecha,documento,debito,credito,neto,nota,tipo_movimiento,numero_pagos,tasa_impuesto_unoe,base_impuesto_unoe,fecha_creacion,fecha_aprobacion,tasa_impuesto_real,base_impuesto_real,tipo_impuesto\n";
while($row = pg_fetch_row($qry)) {
  $data .= $row[0].",".$row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5].",".$row[6].",".$row[7].",".$row[8].",".$row[9].",".$row[10].",".$row[11].",".$row[12].",".$row[13].",".$row[14].",".$row[15].",".$row[16].",".$row[17].",".$row[18].",".$row[19].",".$row[20].",".$row[21].",".$row[22]."\n";
}

$fieldname = date("Y-m-d")."_NIT_".$nit."_NUMERO_CUENTA_COBRO_".$numero_cuenta_cobro;

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$fieldname.'.csv"');
echo $data; 
exit();

?>	
				