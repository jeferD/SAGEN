<?php
	class users_ad {

		public function __construct () {}

		public function buscarxid($us,$pass) {
			$sql="SELECT tipo FROM usuarios WHERE usuario='$us' AND pass='$pass'";
			$result = pg_query($sql);

			if( pg_num_rows($result) <> 0){
				$tipo = pg_result($result,0,0);
				return $tipo;
			}
			else return 0;
 		}

		public function __destruct () {}
	}
?>