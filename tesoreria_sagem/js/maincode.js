/**
 Este es el script maincode que se carga en todas las paginas
**/

// funcion que envia los datos del logeo para verificar si son validos
function submitform_login()
{
    document.forms["logform"].submit();
}

//Funcion para subir foto al sistema
function ver(image)
{
	document.getElementById('image').innerHTML = "<img src='"+image+"'>"
}

function buttonModRes(id_res)
{
    location.href="admin_mod_resident.php?idRes="+id_res;
}

// Funcion que envia los datos del acudiente a la base de datos
function submitform_acudiente()
{
    document.forms["acuform"].submit();
}

// funcion que modifica la info del residente en la BD
function submitform_edit_res()
{
    document.forms["modresform"].submit();
}

// funcion para ingresar un nuevo profesioan en la BD
function submitform_new_pro()
{
    document.forms["proform"].submit();
}


//funcion para ingresar un nuevo residente en la BD
function submitform_new_res()
{
    document.forms["resform"].submit();
}

//funcion para ingresar una nueva nota de evolucion en la BD
function submitform_new_note_evo()
{
	document.forms["note_evo_form"].submit();

}

//funcion para hacer submit a un formulario de busqueda
function submitform_breporte()
{
	document.forms["breporte"].submit();

}

//funcion para ingresar un nuevo anexo en la BD y carpeta de archivos
function submitform_new_anexo()
{
	document.forms["note_anexo_form"].submit();

}

// funcion que finaliza sesion y destruye las variable SESSION
function finalizar(){
		window.location="../admin/principal_admin.php";
}

// esta funcion muestra una ventana para confirmar si desea cerrar sesion
function confirmCerrar() {
	var answer=0;
	answer=confirm("Estas seguro de cerrar sesion");
	if (answer==true)
	  {
		location.href="../login.php";
	  }
}

function confirm_delete_pqrs(idepqrs){
	var answer=0;
	answer=confirm("Esta seguro de ELIMINAR este  EMAIL?");
	if (answer==true)
	  {
		location.href="emails.php?idEliminacion="+idepqrs+"";
	  }
}

function confirm_delete_emails(ide){
	var answer=0;
	answer=confirm("Esta seguro de ELIMINAR este  EMAIL?");
	if (answer==true)
	  {
		location.href="emails.php?idEliminacion="+ide+"";
	  }
}

//funcion para la ventan del acudiente que estaba en admin_viw_resident
function winacu(idRes)
{
	var win = "admin_view_acu.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

function winacu2(idRes)
{
	var win = "user_view_acu.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=850,height=400,left=60,top=60');
}

function winnote(idNot)
{
	var ruta = "user_view_note.php?idNot="+idNot+"";
	window.open(ruta,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=450,left=60,top=40');
}

function winscon(idScon)
{
	var ruta = "user_view_scon.php?idScon="+idScon+"";
	window.open(ruta,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=450,left=60,top=40');
}

function wintotnote(idRes)
{
	var ruta = "user_wintotnote.php?idRes="+idRes+"";
	window.open(ruta,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=450,left=60,top=40');
}

function winorder(idOrd)
{
	var ruta = "user_view_order.php?idOrd="+idOrd+"";
	window.open(ruta,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=400,left=60,top=40');
}

function winepic(idEpi)
{
	var ruta = "user_view_epi.php?idEpi="+idEpi+"";
	window.open(ruta,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=550,left=60,top=40');
}

// funcion que abre una ventana emergente con la info a imprimir
function winPrintRes(idRes)
{
	var win = "admin_print_res.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintAcu(idRes)
{
	var win = "admin_print_acu.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintPro(idPer)
{
	var win = "admin_print_pro.php?idPer="+idPer+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la lista Residentes Activos
function winPrintLra()
{
	var win = "admin_print_lra.php";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la lista Residentes Inactivos
function winPrintLri()
{
	var win = "admin_print_lri.php";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la lista Profesionales
function winPrintLisPro()
{
	var win = "admin_print_list_pro.php";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la lista Residentes Activos de las cuentas USER
function winPrintLraUser()
{
	var win = "user_print_lra.php";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con el reporte de medicamentos x residente x periodo
function winPrintRep(fI,fF)
{

	var win = "user_print_rep.php?fIni="+fI+"&fFin="+fF+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');

}

//funcion que abre una ventana emergente con la lista Residentes Inactivos de las cuentas USER
function winPrintLriUser()
{
	var win = "user_print_lri.php";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintNote(idNot)
{
	var win = "user_print_note.php?idNot="+idNot+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=450,left=60,top=40');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintPit(idRes,idPrf)
{
	var win = "user_print_pit.php?idRes="+idRes+"&idPrf="+idPrf+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintValin(idRes)
{
	var win = "user_print_valin.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintEsoc(idRes)
{
	var win = "user_print_esoc.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintOrder(idOrd)
{
	var win = "user_print_order.php?idOrd="+idOrd+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=450,left=60,top=60');
}

function winPrintEpic(idEpi)
{
	var win = "user_print_epi.php?idEpi="+idEpi+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=450,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintNrp(idRes)
{
	var win = "user_print_nrp.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintEnr(idRes)
{
	var win = "user_print_enr.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintEnf(idRes)
{
	var win = "user_print_enf.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintTsr(idRes)
{
	var win = "user_print_tsr.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

//funcion que abre una ventana emergente con la info a imprimir
function winPrintTsf(idRes)
{
	var win = "user_print_tsf.php?idRes="+idRes+"";
	window.open(win,'','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=400,left=60,top=60');
}

 //funcion para cerrar la ventan del acudiente que estaba en admin_viw_resident
function cerrarVentana(){
       //la referencia de la ventana es el objeto window del popup. Lo utilizo para acceder al método close
       window.close();
}

// funcion de prueba para cambriar el current en el menu
$(document).ready(function(){
	  $( 'ul.nav li' ).on( 'click', function() {
            $( this ).parent().find( 'li.current' ).removeClass( 'cuerrent' );
            $( this ).addClass( 'cuerrent' );
      });

    /* var cambio = false;
    $('.nav li').click(function() {
    	$("li").removeClass("current");
    	$(this).addClass("current");
        cambio = true;
    });

    if(!cambio){
        $('.nav li:first').addClass("current");
    } */
});

// Funcion para Imprimir



function impresion(){
	//window.print()
	//window.close();

	window.print();
    setTimeout(function () { window.close(); }, 100);


}



//FUNCION AJAX PARA LLAMAR LOS DATOS DEL SEGUNDO COMBO
function getMunicipios(id_combo1){ //variable que espera la funcion
	var xmlhttp;

	if (window.XMLHttpRequest){// codigo for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// codigo for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

  //funcion que se llama cada vez que cambia la propiedad readyState
	xmlhttp.onreadystatechange=function(){
	    //readyState 4: peticion finalizada y respuesta lista
	    //status 200: OK
	    if (xmlhttp.readyState===4 && xmlhttp.status===200){
	      //Pasar la respuesta html a div_combo2
			document.getElementById("div_combo2").innerHTML=xmlhttp.responseText;
		}
	};

  /* open(metodo, url, asincronico)
   * metodo: post o get
   * url: localizacion del archivo en el servidor
   * asincronico: comunicacion asincronica true o false.
  */
	xmlhttp.open("POST","../control/getMun.php",true);

  //establece el header para la respuesta
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

  //enviamos las variables al archivo get_combo2.php
	xmlhttp.send("id_combo1=" + id_combo1);
	//alert("el id es: " + id_combo1); // aqui si llega el valor del ide del departamento, pero no lo pasa al getMun.php
}

function getMunicipios2(id_combo1){ //variable que espera la funcion
	var xmlhttp;

	if (window.XMLHttpRequest){// codigo for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// codigo for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

  //funcion que se llama cada vez que cambia la propiedad readyState
	xmlhttp.onreadystatechange=function(){
	    //readyState 4: peticion finalizada y respuesta lista
	    //status 200: OK
	    if (xmlhttp.readyState===4 && xmlhttp.status===200){
	      //Pasar la respuesta html a div_combo2
			document.getElementById("div_oricombo2").innerHTML=xmlhttp.responseText;
		}
	};

  /* open(metodo, url, asincronico)
   * metodo: post o get
   * url: localizacion del archivo en el servidor
   * asincronico: comunicacion asincronica true o false.
  */
	xmlhttp.open("POST","../control/getMun2.php",true);

  //establece el header para la respuesta
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

  //enviamos las variables al archivo get_combo2.php
	xmlhttp.send("id_combo1=" + id_combo1);
	//alert("el id es: " + id_combo1); // aqui si llega el valor del ide del departamento, pero no lo pasa al getMun.php
}

