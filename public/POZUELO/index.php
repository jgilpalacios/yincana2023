<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>INSCRIPCIÓN</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<meta http-equiv="content-language" content="es" />
<link rel="stylesheet" href="../css/miestilo.css">
<style type="text/css">
    table th {
      text-align: left;
    }
</style>

<script src="../js/jsencrypt.min.js"></script>
<script type="text/javascript" src="../js/jspdf.debug.js"></script>


<script type="text/javascript" src="../mijs/generadorAdultos.js"></script>
<script type="text/javascript" src="../mijs/validar.js"></script>
<script type="text/javascript" src="../mijs/encriptador.js"></script>
<script type="text/javascript" src="../mijs/centros.js"></script>

<script type="text/javascript">
//var LOCALIDAD='TORRELODONES';
var NUM_SOL=0;
var DatosSolicitud;
function A(elementoIframe){
	DatosSolicitud=elementoIframe;
	NUM_SOL=DatosSolicitud[2];
	getImageFromUrl('LogoGymk18.jpg', generaPDF);
}
function LimpiaParticipantes(){
	for (var i=1;i<5;i++){
		document.getElementById('Ap'+i+'1').value='';
		document.getElementById('Ap'+i+'2').value='';
		document.getElementById('Nombre'+i).value='';
	}
	NUM_SOL=0;
}

</script>

<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body class="exe-single-page">

<div align="center"><img src="cabecera.svg" ></div>
<hr/>
TIPO DE EQUIPO<br/>
 <form action="#" target="_blank"> 
 <input type="radio" name="tipo" id="primaria" value="primaria" onchange="NUM_SOL=0;"> Equipo de Ed. <b>Primaria</b> de Centro (4 alumnos de Ed. Primaria del mismo Centro Educativo)<br>
  <input type="radio" name="tipo" id="secundaria" value="secundaria" onchange="NUM_SOL=0;"> Equipo de Ed. <b>Secundaria</b> de Centro (4 alumnos de Ed. Secundaria del mismo Centro Educativo )<br/>
   <!--<input type="radio" name="tipo" id="adultos" value="adultos" onchange="NUM_SOL=0;"> Equipo de Ed. para <b>Adultos</b> de Centro (4 alumnos de Ed. para Adultos del mismo Centro Educativo )<br/>-->
<hr>
<?php  include "../mijs/centros.php"; ?>
<hr>
<!--Nombre del Centro: <input name="nombre_centro" id="nombre_centro" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="50" size="50">
CÓDIGO: <input name="cod_centro" id="cod_centro" maxlength="8" size="8"><a href="http://gestiona.madrid.org/wpad_pub/run/j/MostrarConsultaGeneral.icm?tipoCurso=ADM&sinboton=S" target="_BLANK" title="Buscador de Centros Comunidad de Madrdid"><img src="../img/find.png" align="middle"></a>  
Localidad: <input name="loc_centro" id="loc_centro" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="30" size="30"><hr/>-->
DATOS DE LOS COMPONENTES DEL EQUIPO<hr/>
 <table style="width:100%">
  <tr>
    <th><br/></th>
    <th>Apellido1</th>
    <th>Apellido2</th>
    <th>Nombre</th>
    <th>Edad</th>
  </tr>
  <tr>
    <td>1</td>
    <td><input name="Ap11" id="Ap11" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Ap12" id="Ap12" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Nombre1" id="Nombre1" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Edad1" id="Edad1" maxlength="2" size="2"></td>
  </tr>
  <tr>
    <td>2</td>
    <td><input name="Ap21" id="Ap21" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Ap22" id="Ap22" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Nombre2" id="Nombre2" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Edad2" id="Edad2" maxlength="2" size="2"></td>
  </tr>
  <tr>
    <td>3</td>
    <td><input name="Ap31" id="Ap31" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Ap32" id="Ap32" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Nombre3" id="Nombre3" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Edad3" id="Edad3" maxlength="2" size="2"></td>
   </tr>
  <tr>
    <td>4</td>
    <td><input name="Ap41" id="Ap41" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Ap42" id="Ap42" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Nombre4" id="Nombre4" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></td>
    <td><input name="Edad4" id="Edad4" maxlength="2" size="2"></td>
  </tr>
</table>
<p>PERSONA DE CONTACTO: <p/>
<p>Primer apellido: <input name="ApP1" id="ApP1" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"> Segundo apellido: <input name="ApP2" id="ApP2" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"> Nombre: <input name="NomP" id="NomP" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();" maxlength="20" size="20"></p>  
<p>Telefonos de contacto: <input name="TelP1" id="TelP1" maxlength="9" size="9"> / <input name="TelP2" id="TelP2" maxlength="9"  size="9"> Correo e.: <input name="EmailP" id="EmailP" onchange="NUM_SOL=0;this.value=this.value.toLowerCase().trim();"maxlength="50"  size="50"></p><hr/>
<input name="Genera PDF" value="Genera PDF" type="button" onclick="if((+NUM_SOL)===0){if(validaCampos()){ compacta();document.getElementById('grabador').submit();}}else{getImageFromUrl('LogoGymk18.jpg', generaPDF);};"><input name="Limpia los participantes" value="Limpia los participantes." type="button" onclick="LimpiaParticipantes();"><input type="reset" value="Limpia los campos." onclick="NUM_SOL=0;"><br><br>
<!--<div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2019-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>-->
<!--<span id="qr">--></span><br>
</form>
<form id="grabador" action="conectando2.php" target="CargaBD" method="POST">
	<input type="hidden" id="nVisita" name="nVisita" value="0">
	<input type="hidden" id="CLAVE" name="CLAVE" value="0">
	<input type="hidden" id="mensajeCRP" name="mensajeCRP" value="0">
</form>

<iframe name="CargaBD" id="CargaBD" src="info.html"  width="100%" height="500px"></iframe>
 
    <!--<textarea id="input" name="input" type="text" rows=4 cols=70>This is a test!</textarea><br/>
    <input id="pruebame" type="button" value="encripta" onclick="document.getElementById('output').value=EncrMensaje(document.getElementById('input').value)" /><br/>
    <input id="desencripta" type="button" value="desencripta" onclick="document.getElementById('output2').value=DesencrMensaje(document.getElementById('output').value)" /><br/>
    <textarea id="output" name="output" type="text" rows=4 cols=70>This is a test!</textarea><br/>
    <textarea id="output2" name="output2" type="text" rows=4 cols=70>This is a test!</textarea><br/>-->
 <div style="visibility: hidden;"><textarea id="pubkey" rows="15" cols="65"><?php  include "clave_pub.pem"; ?></textarea></div>


<script languaje="javascript">
function limpiar(){
    //alert("Hello");
    //alert(document.body.innerHTML); 
    document.body.innerHTML=document.body.innerHTML.split('<div>cortamos por aqui</div>')[0];
    clavePub=document.getElementById('pubkey').value;//alert(clavePub);
    PonTipos();
    clearInterval(myVar);//document.getElementById('cabecera').innerHTML=LOCALIDAD;
}
var myVar=setInterval(limpiar, 500);
//var myVar=setInterval(function(){ alert("Hello");alert(document.body.innerHTML); clearInterval(myVar);}, 3000);
</script>
<br/>
<br/>
<div>cortamos por aqui</div>
<br/>
<br/>

</body>
</html>
