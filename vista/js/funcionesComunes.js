// JavaScript Document
function calendario(v1,v2)
{
Calendar.setup(
    {
      inputField  : v1,         // ID of the input field
      ifFormat    : "%d/%m/%Y",      // the date format
      button      : v2        // ID of the button
    }
  );
}

function popup(url,w,h)
{
	ventanaHija = window.open(url, 'ventanaHija','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width='+w+',height='+h+',left = 120,top = 180');
}

function estiloSobre(id)//estilo para las filas de las tablas. A�ade color al pasar sobre las filas
{
	document.getElementById(id).style.background="#FFFF99";	
}

function estiloDeja(id,color)//estilo para las filas de las tablas. devuelve el color original al pasar sobre las filas
{
    document.getElementById(id).style.background=color;	
}

function estiloSeleccion(id,color,idLista,checkVerificar)
{
	//alert(pos+' '+idLista+' '+color+' '+id);
	//color='#FFFF99';
	var checkBox=document.getElementById(checkVerificar).checked;
	
	if(checkBox==true)		
		document.getElementById(id).style.background='#FFFF99';	
	else	
		document.getElementById(id).style.background=color;	
}

function limpiarCampos(campo,tipoDato)// Ernesto Rivas
{
	/*Funcion que permite limpiar los campos del formulario, donde el programador 
	debe enviar por parametro 2 arreglo, el primero tiene que tener los id de los campos y otro arreglo con los 
	tipo de campo*/
	var long=campo.length;
	
	for (var i=0;i<long;i++)
	{
		
		if(tipoDato[i]=='sel')
		{
			document.getElementById(campo[i]).value='0';
		}
		else
			document.getElementById(campo[i]).value='';
	}
	document.getElementById(campo[0]).focus();
}


function soloMayuscula(cadena,id)// FUNCION ENCARGADA DE COLOCAR LAS LETRAS PRESIONADAS EN MAYUSCULAS
{
	//alert(id);
	var txt=document.getElementById(id).value.toUpperCase(cadena);
	document.getElementById(id).value=txt;
}


function soloMayuscula2(valor)// FUNCION ENCARGADA DE COLOCAR LAS LETRAS PRESIONADAS EN MAYUSCULAS
{
	alert(valor);
	/*alert(id);
	var txt=document.getElementById(id).value.toUpperCase(cadena);
	document.getElementById(id).value=txt;
	var code;*/
	
	
	var text=valor.toUpperCase();
	return text;
}

function soloNumeroLetra(evt) {
	var nav4=window.Event?true:false;
	var key=nav4?evt.which:evt.keyCode;
	//alert(key);
	return(key<=13 || key==127 || (key>=48 && key<=57) || (key==109) || (key>=97 && key<=122) || (key>=65 && key<=92) || key==13);	
}


function soloCodigo(evt) {
	var nav4=window.Event?true:false;
	var key=nav4?evt.which:evt.keyCode;
	
	return(key<=13 || key==127 || (key>=48 && key<=57) || (key==109));
	
}

function formatofecha(valor)
{
	//para cambiar el formato de la fecha aaaa-mm-dd por dd/mm/aaaa 
	if(valor!=null && valor!="") // es necesario porq sino el valor.split da error si las fechas son nulas o vacias
	{
		var fechaArray= valor.split('-');
		var anio=fechaArray[0];
		var mes=fechaArray[1];
		var dia =fechaArray[2];
		var fecha=dia+'/'+mes+'/'+anio;
		return fecha;
	}
	else
		return null;
	//alert(dia+'/'+mes+'/'+anio);
	//fecha.replace('/','-');
	////////////////////////////////////////////////////////////////
	//alert(fecha);
}

//funcion que se encarga de no permitir registrar campos vacios
function campoVacio(q) {  
         for ( i = 0; i < q.length; i++ ) {  
                 if ( q.charAt(i) != " " ) {  
                        return true;  
                 }  
         }  
       return false;  
 }
 function validarcorreo(id)
 {
 	//alert(document.getElementById(id).value);
	var email=document.getElementById(id).value;
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
     {

     	alert("Error: La dirección de correo " + email + " es incorrecta.");
		document.getElementById(id).value="";
		//document.getElementById(id).focus(); 
		document.getElementById(id).focus();


     } 


 }

  
 
function verifacarSession(session)
{
	//var estadoSession='"'+seccio+'"';
	
	if(session=='' || session==null)
	{
		alert(session);
		alert('Se vencio la session. Por favor, vuelva a logearse...');
		//location.replace('http://10.5.12.145/siceudo/loginBD.php');
			
	}
	//alert(document.getElementById('estadoSessionloging').value);
	//alert(estado);
	
}
function pulsar(e) {
	tecla=(document.all) ? e.keyCode : e.which;
	if(tecla==13) return false;
}