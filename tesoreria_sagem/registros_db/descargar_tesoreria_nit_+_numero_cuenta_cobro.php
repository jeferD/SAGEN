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

function crearPagos($nit,$cta)
	{

		$consulta="SELECT * FROM tesoreria_global.exportar_pagos_nit_y_cuenta_cobro('".$nit."','".$cta."');";

		return $consulta;
	}

function ejecutarProcedure( $conexion, $consulta )
	{
		// Ejecutar la consulta:
		$rs = pg_query( $conexion, $consulta );

		if( $rs )
		{
			// Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
			
			if( pg_num_rows($rs) > 0 ){	
				while ($row = pg_fetch_row($rs)) {
					$devolver=$row[0];
					}
				}
				else echo "No se encontraron registros";
		}
		return $devolver;
	}
	
$nit= $_POST['txtnit'];
$cta= $_POST['txtcta'];
$data='';
$nombres_columnas='';
$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );	
$consulta=crearPagos($_POST['txtnit'],$_POST['txtcta']);	
$res=ejecutarProcedure( $conexion, $consulta );
$res2 = pg_query($res);

$k = pg_num_fields($res2);
  for ($j = 0; $j < $k; $j++) {
	  $fieldname = pg_field_name($res2, $j);
	  $nombres_columnas .= $fieldname.",";
  }
  
$data.=$nombres_columnas."\n";

if( pg_num_rows($res2) > 0 ){	
	while($row = pg_fetch_row($res2)) {
	  for($i = 0; $i<$k;$i++){
		  $data.=$row[$i].",";
	  }
	  $data.="\n";
	}
} 
if($cta == NULL OR $cta== ''){
	$fieldname = date("Y-m-d")."_PAGOS_NIT_".$nit;
}
else 
	$fieldname = date("Y-m-d")."_PAGOS_NIT_".$nit."_NUMERO_CUENTA_COBRO_".$cta;


header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$fieldname.'.csv"');
echo $data; 
exit();

?>