<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="col-md-2">
  	<div class="sidebar content-box" style="display: block;">
    	<ul class="nav">
        	<!-- Main menu -->
            
			<button onclick="myFunction('inicio')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-home"></i> <b> Inicio</b></a></button>
				<div id="inicio" class="w3-container w3-hide">
					<li>
						<a href='index.php' class="glyphicon glyphicon-eye-close"> Inicio</a>
					</li>
				</div>
			
			<button onclick="myFunction('recobros')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-tower"></i> <b> Recobros</b></a></button>
				<div id="recobros" class="w3-container w3-hide">
					<li>
						<a href='recobros_nit_+_numero_cuenta_cobro.php' class="glyphicon glyphicon-search"> Nit_+_Cuenta_Cobro</a>
					</li>
					<li>
						<a href='recobros_nit_+_numero_factura.php' class="glyphicon glyphicon-search"> Nit_+_Factura</a>
					</li>
					<li>
						<a href='recobros_nit_+_numero_radicado.php' class="glyphicon glyphicon-search"> Numero_De_Radicado</a>
					</li>
				</div>
					
			<button onclick="myFunction('cartera')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-lock"></i> <b> Cartera</b></a></button>
				<div id="cartera" class="w3-container w3-hide">
					<li>
						<a href='cartera_nit_+_periodo.php' class="glyphicon glyphicon-search"> Nit_+_Periodo</a>
					</li>
					<li>
						<a href='cartera_nit_+_numero_cuenta_cobro.php' class="glyphicon glyphicon-search"> Nit_+_Cuenta_Cobro</a>
					</li>
					<li>
						<a href='cartera_lista_radicados.php' class="glyphicon glyphicon-search"> Lista_Radicados</a>
					</li>
				</div>
			
			
			<button onclick="myFunction('tesoreria')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-usd"></i> <b> Tesoreria</b></a></button>
				<div id="tesoreria" class="w3-container w3-hide">
					<li>
						<a href='tesoreria_nit_+_periodo.php' class="glyphicon glyphicon-search"> Nit_+_Periodo</a>
					</li>
					<li>
						<a href='tesoreria_nit_+_numero_cuenta_cobro.php' class="glyphicon glyphicon-search"> Nit_+_Cuenta_Cobro</a>
					</li>
					<li>
						<a href='tesoreria_nit_+_documento.php' class="glyphicon glyphicon-search"> Nit_+_Documento</a>
					</li>
					<li>
						<a href='tesoreria_lista_radicados.php' class="glyphicon glyphicon-search"> Lista_Radicados</a>
					</li>
				</div>	
			
			<button onclick="myFunction('impuestos')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-list-alt"></i> <b> Impuestos </b></a></button>
				<div id="impuestos" class="w3-container w3-hide">
					<li>
						<a href='impuestos_nit_+_periodo.php' class="glyphicon glyphicon-search"> Nit_+_Periodo</a>
					</li>
					<li>
						<a href='impuestos_nit_+_numero_cuenta_cobro.php' class="glyphicon glyphicon-search"> Nit_+_Cuenta_Cobro</a>
					</li>
					<li>
						<a href='impuestos_nit_+_documento.php' class="glyphicon glyphicon-search"> Nit_+_Documento</a>
					</li>
					<li>
						<a href='impuestos_lista_radicados.php' class="glyphicon glyphicon-search"> Lista_Radicados</a>
					</li>
				</div>
				
			<button onclick="myFunction('circular030')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-indent-right"></i> <b> Circular 030</b></a></button>
				<div id="circular030" class="w3-container w3-hide">
					<li>
						<a href='circular030_fepa.php' class="glyphicon glyphicon-stats"> Fepa</a>
					</li>
					<li>
						<a href='circular030_cruce.php' class="glyphicon glyphicon-random"> Cruce</a>
					</li>
				</div>
			
			
			<button onclick="myFunction('cubos')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-stats"></i> <b> Cubos</b></a></button>
				<div id="cubos" class="w3-container w3-hide">
					<li>
						<a href='cubos_gerencial.php' class="glyphicon glyphicon-th-list"> Resumen Gerencial</a>
					</li>
					<li>
						<a href='cubos_prestador.php' class="glyphicon glyphicon-list-alt"> Resumen Prestador</a>
					</li>
				</div>         
			
			<button onclick="myFunction('emails')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-check"></i> <b> Emails</b></a></button>
				<div id="emails" class="w3-container w3-hide">
					<li>
						<a href='emails.php' class="glyphicon glyphicon-list-alt"> Listar</a>
					</li>
					<li>
						<a href='ingreso.php' class="glyphicon glyphicon-plus-sign"> Crear</a>
					</li>
				</div>
			
			
			<button onclick="myFunction('cerrar_cesion')" class="w3-button w3-block w3-left-align">
			<i class="glyphicon glyphicon-off"></i><b> Cerrar Sesion</b></a></button>
				<div id="cerrar_cesion" class="w3-container w3-hide">
					<li>
						<a href='../index.php' class="glyphicon glyphicon-log-out"></i> Salir</a>
					</li>
				</div>

			<script>
			function myFunction(id) {
			  var x = document.getElementById(id);
			  if (x.className.indexOf("w3-show") == -1) {
				x.className += " w3-show";
			  } else {
				x.className = x.className.replace(" w3-show", "");
			  }
			}
			</script>
			
		</ul>
	</div>
</div>