<?php
session_start();
	class conexion {
		public $pdo;
		
			public function __construct () {
				$host = "192.168.125.18";
				$port = "5432";
				$usuario = "postgres";
				$pass = "123456";
				$bd = "sagem";

				$this->pdo = pg_connect( "host=".$host." ".
									"port=".$port." ".
								   "user=".$usuario." ".
								   "password=".$pass." ".
								   "dbname=".$bd
								  ) or die( "Error al conectar: ".pg_last_error() );
			}

			public function __destruct () {
				pg_close($this->pdo);
			} 
		
			public function logueo($us, $pass){

				$sql="SELECT * FROM tesoreria_global.usuarios WHERE usuario='$us' AND pass='$pass' limit 1";
				$result = pg_query($sql);

				if( pg_num_rows($result) == 0)
				{
					echo'<script type="text/javascript">
						alert("Usuario o Password Incorrecta");
						window.location="#"
						</script>';
				}
				else
				{
					session_start();

					$reg = pg_fetch_row($result);
					$_SESSION['session'] = $reg[0];
					$_SESSION['noid'] = $reg[6];
					$_SESSION['tipo_usuario'] = $reg[4];
					$_SESSION['name_user'] = $reg[1];
					$_SESSION['empid'] = $reg[3];

					$_SESSION['time_max'] = 1200;//tiempo maximo de la sesion, en segundos
					$_SESSION['LAST_ACTIVITY'] = time(); //se inicia a contar el tiempo para luego hacer el timeout de la sesion

					if($reg[4]==1){
						header("location:registros_db/index.php");
					}elseif($reg[4]==2){
						header("location:registros_db/index.php");
					}
				}
					//redireccionando a la pagina en la pagina que le corresponde al usuario
			}
		
			public function recuperar($noid){

				$sql="SELECT pass,email FROM tesoreria_global.usuarios WHERE noid='$noid'";
				$result = pg_query($sql);

				if( pg_num_rows($result) == 0)
				{
					echo'<script type="text/javascript">
						alert("Usuario no encontrado");
						window.location="index.php"
						</script>';
				}
				else
				{
					$reg = pg_fetch_row($result);
					$pass = $reg[0];
					$email = $reg[1];
					$name = "Prestador";
					$asunto = "Mesa de ayuda - Aplicativo Tesoreria Emssanar"; 
					$cuerpo = ' 
								<html> 
								<head> 
								   <title>Correo de recuperacion - Sistema de Tesoreria Emssanar</title> 
								</head> 
								<body> 
								<h1>Saludos!</h1> 
								<p> 
								<b>Has solicitado la recuperacion de clave</b>. tu clave es: '.$pass.'
								</p> 
								</body> 
								</html>'; 
					$headers = "From: bryanacosta@emssanar.org.co";

					  echo'<script type="text/javascript">
						alert("Clave enviada al correo '.$email.'");
						window.location="index.php"
						</script>';
	            
					//$mail = new PHPMailer(true);

			// Send mail using Gmail
				/*if($send_using_gmail){
					echo "<h1>si es gmail</h1>";
				    $mail->IsSMTP(); // telling the class to use SMTP
				    $mail->SMTPAuth = true; // enable SMTP authentication
				    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
				    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
				    $mail->Port = 465; // set the SMTP port for the GMAIL server
				    $mail->Username = "bryanacosta@emssanar.org.co"; // GMAIL username
				    $mail->Password = "ESS10B@A"; // GMAIL password
				}
				
				$email_from="bryanacosta@emssanar.org.co";
				$name_from = "Tesoreria";
				
				$mail->AddAddress($email, $name);
				$mail->SetFrom($email_from, $name_from);
				$mail->Subject = $asunto;
				$mail->Body = $cuerpo;

				try{
				    $mail->Send();
				    echo'<script type="text/javascript">
	                alert("Clave enviada al correo '.$email.'");
	                window.location="index.php"
	                </script>';
				} catch(Exception $e){
				    // Something went bad
				    echo "Fail :(".$e;
				}*/
				
					//mail($email,$asunto,$cuerpo,$headers);
/*
					echo'<script type="text/javascript">
						alert("Clave enviada al correo '.$email.'");
						window.location="index.php"
						</script>';
*/						
				}

					//redireccionando a la pagina en la pagina que le corresponde al usuario

			}	
		
			public function cerrar(){
				session_destroy();
				//header("Location:../index.php");
			}
			
			public function abrir_conexion(){
				$host = "192.168.125.18";
				$port = "5432";
				$usuario = "postgres";
				$pass = "123456";
				$bd = "sagem";
				
			$pdo = pg_connect( "user=".$usuario." ".
								"port=".$port." ".
							   "password=".$pass." ".
							   "host=".$host." ".
							   "dbname=".$bd
							  ) or die( "Error al conectar: ".pg_last_error() );

			return $pdo;
			}
		}		
?>