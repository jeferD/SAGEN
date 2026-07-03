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
	
	function crearRecobroFact($nit,$factura)
			{
				if($nit==NULL or $nit=='') $nit='NULL';
				else 
					$nit="'".$nit."'";
					$factura="'".$factura."'";

				$consulta="SELECT * FROM tesoreria_global.trazabilidad_factura($nit,$factura);";

				return $consulta;
			}
	
	ini_set('max_execution_time', 0);
			
	function ejecutarProcedure( $conexion, $consulta )
	{
		// Ejecutar la consulta:
		$rs = pg_query( $conexion, $consulta );

		if( $rs )
		{
			// Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
			//if( pg_num_rows($rs) > 0 )	$devolver = pg_fetch_object( $rs, 0 );

			while ($row = pg_fetch_row($rs)) {
			  $devolver=$row[0];}
		}

		return $devolver;
	}

$data='';
$nombres_columnas='';
			
$nit= $_GET['id_nit'];	
$factura = $_GET['id_factura'];

$conexion = conectar_PostgreSQL( "postgres", "123456", "192.168.125.18", "5432", "sagem" );
$consulta=crearRecobroFact($nit,$factura);	
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

$fieldname = date("Y-m-d")."_PAGOS_NIT_".$nit."_NUMERO_FACTURA_".$factura;

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$fieldname.'.csv"');
echo $data; 
exit();

?>	
				