var getImageFromUrl = function(url, callback) { alert(url)
    var img = new Image();	
    img.onError = function() {
        alert('Cannot load image: "'+url+'"');
    };
    img.onload = function() {
	
        callback(img);
    };
    img.src = url;
}

function validaCampos(){
	lee();
	var errores='';
	var nErrores=0;
	if(tipo=="no elegido") errores+='('+(++nErrores)+') Debe elegir si es equipo de primaria o secundaria.\n';
	if(!Validar_Centro(nombre_centro)) errores+='('+(++nErrores)+') Nombre centro erróneo.\n';
	if(!Validar_Centro(texto_centro)) errores+='('+(++nErrores)+') Nombre centro erróneo.\n';
	if(!EsCodCentro(cod_centro)) errores+='('+(++nErrores)+') Código de centro erróneo.\n';
	if(!Validar_NombreApellidos(loc_centro)) errores+='('+(++nErrores)+') Localidad del centro errónea.\n';
	if(!Validar_NombreApellidos(Ap11)) errores+='('+(++nErrores)+') Primer apellido del participante 1 erróneo.\n';
	if(!Validar_NombreApellidos(Nombre1)) errores+='('+(++nErrores)+') Nombre del participante 1 erróneo.\n';
	if(!Validar_NombreApellidos(Ap21)) errores+='('+(++nErrores)+') Primer apellido del participante 2 erróneo.\n';
	if(!Validar_NombreApellidos(Nombre2)) errores+='('+(++nErrores)+') Nombre del participante 2 erróneo.\n';
	if(!Validar_NombreApellidos(Ap31)) errores+='('+(++nErrores)+') Primer apellido del participante 3 erróneo.\n';
	if(!Validar_NombreApellidos(Nombre3)) errores+='('+(++nErrores)+') Nombre del participante 3 erróneo.\n';
	if(!Validar_NombreApellidos(Ap41)) errores+='('+(++nErrores)+') Primer apellido del participante 4 erróneo.\n';
	if(!Validar_NombreApellidos(Nombre4)) errores+='('+(++nErrores)+') Nombre del participante 4 erróneo.\n';
	if(!Validar_NombreApellidos(ApP1)) errores+='('+(++nErrores)+') Primer apellido de la persona de contácto erróneo.\n';
	if(!Validar_NombreApellidos(NomP)) errores+='('+(++nErrores)+') Nombre de la persona de contacto erróneo.\n';
	if(!EsTelefonoFijo(TelP1)&&!EsTelefonoMovil(TelP1) ) errores+='('+(++nErrores)+') Primer teléfono de la persona de contacto erróneo.\n';
	if(!validarEmail( EmailP )) errores+='('+(++nErrores)+') Formato de correo electrónico erróneo.\n';
	if(!EsEdadValida( Edad1 )) errores+='('+(++nErrores)+') Edad del participante 1 errónea.\n';
	if(!EsEdadValida( Edad2 )) errores+='('+(++nErrores)+') Edad del participante 2 errónea.\n';
	if(!EsEdadValida( Edad3 )) errores+='('+(++nErrores)+') Edad del participante 3 errónea.\n';
	if(!EsEdadValida( Edad4 )) errores+='('+(++nErrores)+') Edad del participante 4 errónea.\n';
	if(Ap12){
		if(!Validar_NombreApellidos(Ap12)) errores+='('+(++nErrores)+') Segundo apellido del participante 1 erróneo.\n';
	}
	if(Ap22){
		if(!Validar_NombreApellidos(Ap22)) errores+='('+(++nErrores)+') Segundo apellido del participante 2 erróneo.\n';
	}
	if(Ap32){
		if(!Validar_NombreApellidos(Ap32)) errores+='('+(++nErrores)+') Segundo apellido del participante 3 erróneo.\n';
	}
	if(Ap42){
		if(!Validar_NombreApellidos(Ap42)) errores+='('+(++nErrores)+') Segundo apellido del participante 4 erróneo.\n';
	}
	if(ApP2){
		if(!Validar_NombreApellidos(ApP2)) errores+='('+(++nErrores)+') Segundo apellido de la persona de contácto erróneo.\n';
	}
	if(TelP2){
		if(!EsTelefonoFijo(TelP2)&&!EsTelefonoMovil(TelP2) ) errores+='('+(++nErrores)+') Segundo teléfono de la persona de contacto erróneo.\n';
	}
	if(nErrores>0){
		alert(errores);
		return false;
	}else return true;
}

function ajustaLong(longitud,cadena,caracter){
	var car=caracter||' ';
	var resultado='';
	cadena+='';
	if(cadena.length>longitud){
		resultado=cadena.substring(0, longitud)
	}else if(cadena.length<longitud){
		for(var i=0;i<longitud-cadena.length;i++)resultado+=car;
		resultado+=cadena
	}else resultado=cadena;
	return resultado;
}
let texto_centro;
var tipo;
var nombre_centro;
var loc_centro;
var cod_centro;
var Ap11;
var Ap12;
var Nombre1;
var Edad1;
var Ap21;
var Ap22;
var Nombre2;
var Edad2;
var Ap31;
var Ap32;
var Nombre3;
var Edad3;
var Ap41;
var Ap42;
var Nombre4;
var Edad4;
var ApP1;
var ApP2;
var NomP;
var TelP1;
var TelP2;
var EmailP;

function lee(){
	tipo="no elegido";
	if(document.getElementById('primaria').checked) tipo='primaria';
	if(document.getElementById('secundaria').checked) tipo='secundaria';
	nombre_centro=document.getElementById('nombre_centro').value;
	if(document.getElementById('nombre_centro2'))texto_centro=document.getElementById('nombre_centro2').value;
	loc_centro=document.getElementById('loc_centro').value;
	cod_centro=document.getElementById('cod_centro').value;
	Ap11=document.getElementById('Ap11').value;
	Ap12=document.getElementById('Ap12').value;
	Nombre1=document.getElementById('Nombre1').value;//alert(Ap11+Ap12+Nombre1);
	Edad1=ajustaLong(2, document.getElementById('Edad1').value||'0');
	Ap21=document.getElementById('Ap21').value;
	Ap22=document.getElementById('Ap22').value;
	Nombre2=document.getElementById('Nombre2').value;
	Edad2=ajustaLong(2, document.getElementById('Edad2').value||'0');
	Ap31=document.getElementById('Ap31').value;
	Ap32=document.getElementById('Ap32').value;
	Nombre3=document.getElementById('Nombre3').value;
	Edad3=ajustaLong(2, document.getElementById('Edad3').value||'0');
	Ap41=document.getElementById('Ap41').value;
	Ap42=document.getElementById('Ap42').value;
	Nombre4=document.getElementById('Nombre4').value;
	Edad4=ajustaLong(2, document.getElementById('Edad4').value||'0');
	ApP1=document.getElementById('ApP1').value;
	ApP2=document.getElementById('ApP2').value;
	NomP=document.getElementById('NomP').value;
	TelP1=document.getElementById('TelP1').value;
	TelP2=document.getElementById('TelP2').value;
	EmailP=document.getElementById('EmailP').value;
}

var generaPDF = function (imgData){//alert('se invoca');

	var doc = new jsPDF(); 
	doc.addImage(imgData, 'JPEG', 0, 0, 200, 297, 'monkey'); 
	doc.setFontSize(20);doc.setFontType("bold");
	doc.text(120, 20, 'FICHA DE INSCRIPCIÓN');

	doc.setFillColor(200,200,255);
	doc.rect(130, 30, 60, 20, 'FD');
	doc.setFontSize(12);
	doc.text(140, 40, 'Equipo nº: ');//+ajustaLong(6,DatosSolicitud[2]||NUM_SOL,'0'));
	doc.setFontSize(10);
  	doc.text(135, 45, '(a rellenar por la organización)');

	doc.setFontSize(12);doc.setFontType("normal");
	doc.text(10, 60, 'TIPO DE EQUIPO');
	doc.line(9, 62, 201, 62);
	doc.setFillColor(255,255,255);
	doc.rect(10, 63, 5, 5, 'FD');
	
	doc.text(18, 67, 'Equipo de Ed. Primaria de Centro');
		doc.setFontSize(10);doc.text(83, 67,'(4 alumnos de Ed. Primaria del mismo Centro Educativo)');
		doc.setFontSize(12); 
	
	doc.text(28, 75, 'Nombre del Centro: ');
	doc.text(28, 83, 'Localidad:');
	doc.text(155, 83, 'Cod. Centro:');

	if (document.getElementById('primaria').checked)
	{
		doc.setFontType("bold");doc.text(48, 83, loc_centro);
		doc.text(179, 83, cod_centro);
		doc.text(68, 75, nombre_centro);
        	doc.text(11, 67, 'X');doc.setFontType("normal");
	}
	doc.line(9, 62, 9, 91);
	doc.line(201, 62, 201, 91);
	doc.line(16, 62, 16, 91);
	doc.line(9, 91, 201, 91);
	
	//doc.line(9, 62, 201, 62);
	doc.setFillColor(255,255,255);
	doc.rect(10, 92, 5, 5, 'FD');
	
	doc.text(18, 96, 'Equipo de Ed. Secundaria de Centro');
		doc.setFontSize(10);doc.text(88, 96,'(4 alumnos de Ed. Secundaria del mismo Centro Educativo)');
		doc.setFontSize(12); 
	
	doc.text(28, 104, 'Nombre del Centro: ');
	doc.text(28, 112, 'Localidad:');
	doc.text(155, 112, 'Cod. Centro:');

	if (document.getElementById('secundaria').checked)
	{
		doc.setFontType("bold");doc.text(48, 112, loc_centro);
		doc.text(179, 112, cod_centro);
		doc.text(11, 96, 'X');
		doc.text(68, 104, nombre_centro);doc.setFontType("normal");
	}
	doc.line(9, 91, 9, 120);
	doc.line(201, 91, 201, 120);
	doc.line(16, 91, 16, 120);
	doc.line(9, 120, 201, 120);

        doc.text(10, 130, 'DATOS DE LOS COMPONENTES DEL EQUIPO');
	doc.line(9, 131, 201, 131);
	doc.text(50, 138, 'Apellidos y Nombre');doc.text(189, 138, 'Edad');
	doc.line(9, 141, 201, 141);
	doc.text(10, 148, '1');doc.setFontType("bold"); doc.text(15, 148, Ap11+' '+Ap12+', '+Nombre1);doc.text(193, 148, Edad1);doc.setFontType("normal");
	doc.line(9, 151, 201, 151);
	doc.text(10, 158, '2');doc.setFontType("bold"); doc.text(15, 158, Ap21+' '+Ap22+', '+Nombre2);doc.text(193, 158, Edad2);doc.setFontType("normal");
	doc.line(9, 161, 201, 161);
	doc.text(10, 168, '3');doc.setFontType("bold"); doc.text(15, 168, Ap31+' '+Ap32+', '+Nombre3);doc.text(193, 168, Edad3);doc.setFontType("normal");
	doc.line(9, 171, 201, 171);
	doc.text(10, 178, '4');doc.setFontType("bold"); doc.text(15, 178, Ap41+' '+Ap42+', '+Nombre4);doc.text(193, 178, Edad4);doc.setFontType("normal");
	doc.line(9, 181, 201, 181); 
	doc.line(14, 141, 14, 181);
	doc.line(187, 131, 187, 181);
	doc.text(10, 191, 'Persona de contacto: ');doc.setFontType("bold"); doc.text(51, 191, ApP1+' '+ApP2+', '+NomP);doc.setFontType("normal");
	doc.text(10, 200, 'Teléf. de contacto: ');doc.setFontType("bold"); doc.text(46, 200, TelP1+' / '+TelP2);doc.setFontType("normal");
	doc.text(95, 200, 'Correo-e.:');doc.setFontType("bold"); doc.text(115, 200, EmailP);doc.setFontType("normal");
	doc.line(9, 202, 201, 202);
	doc.line(9, 131, 9, 202);
	doc.line(201, 131, 201, 202);

	doc.text(10, 207, 'CÓMO ENTREGAR ESTA INSCRIPCIÓN');
	doc.text(10, 212, 'Personalmente:');
	doc.setFontType("bold");
	doc.text(41, 212, 'CTIF “Madrid-Oeste” C/ Gabriel García Márquez, 10 Collado Villalba (de 8:00 a');
	doc.text(41, 216, '15:00 de lunes a viernes).');
	doc.setFontType("normal");
	doc.text(10, 221, 'Por Fax:');
	doc.setFontType("bold");doc.text(27, 221, '91 851 71 26');doc.setFontType("normal");
	doc.text(56, 221, 'Por correo electrónico:');
	doc.setFontType("bold");doc.text(100, 221, 'ctif.madridoeste@educa.madrid.org');

	doc.setFontSize(10);doc.text(13, 226, 'INSCRIPCIÓN DE LOS EQUIPOS DESDE LAS 10:00 DEL 1 DE ABRIL HASTA LAS 20:00 DEL 25 DE ABRIL');doc.setFontSize(8);doc.setFontType("normal");
	doc.text(10, 230, 'Los datos proporcionados en esta ficha se utilizarán solamente para la Yincana STEM 2022. Al finalizar la misma, las fichas serán destruidas y');
	doc.text(10, 233, 'NO SE ALMACENARÁN LOS DATOS.');
	doc.text(10, 236, 'Los datos y apellidos de los participantes ganadores y el nombre de los centros escolares ganadores podrán ser publicados en los portales de la');
	doc.text(10, 239, 'Comunidad de Madrid y de los Ayuntamientos a través de los que se ha realizado la Convocatoria de participación en la Yincana STEM de la');
	doc.text(10, 242, 'Comunidad de Madrid.');
	doc.text(10, 246, 'La participación en la Yincana implica la autorización expresa a la organización para la toma y difusión de fotos o vídeos de los participantes con');
	doc.text(10, 249, 'carácter exclusivamente informativo o promocional sobre el evento.');
	doc.text(20, 252, 'Puede consultar el estado de la solicitud escaneando el codigo QR o visitando:');//alert('se llega1');
	doc.setFontType("bold");doc.text(25, 255, DatosSolicitud[1]);doc.setFontType("normal");

	if(DatosSolicitud[0]) doc.addImage(DatosSolicitud[0], 'JPEG', 85, 260, 30, 30);
	//alert('se llega');
	
	doc.output('save', 'SOLICITUD'+NUM_SOL+'.pdf');
	
}
