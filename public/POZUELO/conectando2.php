<?php
header('Content-type:text/html;  charset=utf-8');
include ("../includes/config.php");
include ("../includes/funciones.php");
include ("config.php");
//chequea la existencia de comillas dobles o simples para evitar la inyección SQL y 
// y longitud del texto para evitar la entrada de datos no validos
function Valida($texto){

	if (strpos ( $texto , '"' )!== false) {//echo "La cadena '$findme' fue encontrada 
        	return false;
	}else if (strpos ( $texto , "'" )!== false) {//echo "La cadena '$findme' fue encontrada 
        	return false;
	}else if (strlen ( $texto )<650){//demasiado corta-SE DEBEN PONER EN FUNCIÓN DE LA CLAVE RSA UTILIZADA ESTOS SON PARA 4096
		return false;
	}else if (strlen ( $texto )>1395){//demasiado LARGA
		return false;
	}else return true;
}
/// Realizamos limpieza de las solicitudes viejas
/// y controlamos las solicitudes vivas
function LimpiaYcontrola(){
	$TIEMPO= time()-3600;//las que ya llevan una hora
	$cnx = conectar ();
	$sqlMat='DELETE FROM `solicitudes` WHERE fecha < '.$TIEMPO;
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
	$sqlMat='SELECT count(*) as valor FROM `solicitudes`';
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
	$fila = mysqli_fetch_array($resMat);
	$nSol=$fila['valor'];
	mysqli_close($cnx);
	return $nSol;	
}
 

/*CONFIGURACIÓN PARA MAJADAHONDA
$CONTADOR=4;
$BASE_DATOS='INSCRIPCIONES_MAJA';
$URL='http://www.ctifmadridoeste.260mb.net/gymkana/MAJADAHONDA/comprueba.php';
$GYMKANA="MAJADAHONDA";*/


$nVisita=$_POST['nVisita'];
$CLAVE=$_POST['CLAVE'];
$mensajeCRP=$_POST['mensajeCRP'];


$resultados='';//controlar los valores
if(Valida($mensajeCRP)){
	$cnx = conectar ();
	$sqlMat='SELECT valor FROM `contadores` WHERE  id='.$CONTADOR;
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
	$fila = mysqli_fetch_array($resMat);
	$nVisita=$fila['valor'];//aumentamos el numero de visita
	$nVisita+=1;
	$sqlMat='UPDATE `contadores` SET valor='.$nVisita.'  WHERE  id='.$CONTADOR;//al acceder al sitio aumentamos en BD
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
        $CLAVE=rand ( 1 , 999999 );
	$TIEMPO= time();
	$sqlMat='INSERT INTO `solicitudes` (numero, CLAVE, fecha) VALUES ('.$nVisita.', '.$CLAVE.', '.$TIEMPO.')';
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error()); 
	mysqli_close($cnx);
	//hacemos limpieza una de cada 10 veces;
	$azar=rand ( 1 , 10 );
	$solVivas;
	if($azar=1){//limpiamos 
		$solVivas=LimpiaYcontrola();
		//echo 'solicitudes vivas:'.$solVivas.'<br/>';
		//$resultados.='solicitudes vivas:'.$solVivas.'<br/>';
	}else{//simplemente las contamos
		$cnx = conectar ();
		$sqlMat='SELECT count(*) as valor FROM `solicitudes`';
		$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
		$fila = mysqli_fetch_array($resMat);
		$solVivas=$fila['valor'];
		mysqli_close($cnx);
	}
	//if()
	$cnx = conectar ();
	$sqlMat='INSERT INTO '.$BASE_DATOS.' (NSOL, CLAVE, VALOR, SOLICITADA ) VALUES ('.$nVisita.', '.$CLAVE.', \''.$mensajeCRP.'\', '.$TIEMPO.')'; 
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
	mysqli_close($cnx);
//echo $nVisita.'<br/>Clave: '.$CLAVE.'<br/>Instante: '.$TIEMPO;
$resultados.='SE HA GENERADO SU SOLICITUD PARA PARTICIPAR EN LA GYMKANA STEM DE '.$GYMKANA.'<br/>Los datos de su solicitud son:<br/> -Nº SOLICITUD:<b> '.$nVisita.'</b><br/> -Clave solicitud:<b> '.$CLAVE.'</b><br/>Instante: '.$TIEMPO.'<p>Para <b>completar su inscripción</b> deberá <b>enviar el archivo <u>SOLICITUD'.$nVisita.'.pdf</u> por correo electrónico a: <u>ctif.madridoeste@educa.madrid.org</u></b>.</p><p>Otras opciones para completar la inscripción son:<p><ul><li>Imprimir el pdf y enviarlo por fax al CTIF Madrid-Oeste (91 851 71 26)</li><li>Imprimir el pdf y traerlo personalmente al <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40" target="_blank">CTIF Madrid-Oeste</a> (de 8:00 a 15:00 de lunes a viernes).</li></ul><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si hubiera perdido el archivo SOLICITUD'.$nVisita.'.pdf, puede volver a generarlo pulsando de nuevo el botón <b><i>Genera PDF</i></b> (siempre que no haya modificado los datos del formulario).</p><p>Puede consultar el estado de su incripción contactando con el <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40" target="_blank">CTIF Madrid-Oeste</a> o entrando en:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$URL.'?contador='.$nVisita.'&clave='.$CLAVE.'" target="_blank">'.$URL.'?contador='.$nVisita.'&clave='.$CLAVE.'</a><br/>o <b>escaneando con su dispositivo móvil el código QR</b> siguiente o el de la solicitud.</p><div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2019-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div><br><br>';
}else{
	$resultados="Ha fallado el proceso, vuelva a intentalo";
	$nVisita='xxx';
	$CLAVE='###';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biblioteca</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="../js/jspdf.debug.js"></script>
<script type="text/javascript">
</script>
</head>
<body>
<?php echo $resultados; ?>
<span id="qr"></span>

<script languaje="javascript">
function ponQR(){
	jQuery('#qr').html('');
	jQuery('#qr').qrcode('<?php echo $URL."?contador=".$nVisita."&clave=".$CLAVE;?>');
}
//ponQR();

function tomaQR(){
	var c=$('#qr').children('canvas');
	c=document.getElementById('qr').firstChild.toDataURL();
	return [c,'<?php echo $URL."?contador=".$nVisita."&clave=".$CLAVE; ?>',<?php echo $nVisita.", ".$CLAVE; ?> ]; 
}
var resultadoBD;//=tomaQR();


function limpiar(){ 
    document.body.innerHTML=document.body.innerHTML.split('<div>cortamos por aqui</div>')[0];
    ponQR();resultadoBD=tomaQR();window.top.window.A(resultadoBD); 
}
setTimeout(limpiar, 50);

</script>
<br/>
<br/>
<div>cortamos por aqui</div>
<br/>
<br/>

</body>
</html>



