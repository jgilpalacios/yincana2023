<?php
header('Content-type:text/html;  charset=utf-8');
include ("../includes/configLector.php");
include ("../includes/funciones.php");
include ("config.php");
function tiraNumeros($val)
{
    if(!preg_match('/^([0-9])+$/', $val))
    {
        return false;
    }
    return true;
}
 

//CONFIGURACIÓN PARA COLLADO VILLALBA
/*$CONTADOR=7;
$BASE_DATOS='TORRELODONES';
$URL='http://www.ctifmadridoeste.260mb.net/gymkana/TORRELODONES/comprueba.php';
$GYMKANA="TORRELODONES";*/
//contador=139&clave=332281
//$URL="http://" . substr($_SERVER["HTTP_HOST"] .$_SERVER["REQUEST_URI"], 0, strrpos ( $_SERVER["HTTP_HOST"] .$_SERVER["REQUEST_URI"],  "/" ))."/comprueba.php";
$NSOL=$_GET['contador'];
$CLAVE=$_GET['clave'];
//echo $NSOL."/".$CLAVE;

$resultado=false;
$estado;
if(tiraNumeros($NSOL)&&tiraNumeros($CLAVE)){//echo '<br>llego';
	$cnx = conectar ();
	$sqlMat='SELECT count(*) as n FROM '.$BASE_DATOS.' WHERE  NSOL='.$NSOL.' AND CLAVE='.$CLAVE;
	//echo '<br>llego'.$sqlMat;
	$resMat= mysqli_query($cnx, $sqlMat) or die (mysqli_error($cnx));
	$fila = mysqli_fetch_array($resMat);
	$N=$fila['n'];//echo '<br>llego'.$N;
	if($N>0){
		$sqlMat='SELECT ESTADO, NEQUIPO  FROM '.$BASE_DATOS.' WHERE  NSOL='.$NSOL.' AND CLAVE='.$CLAVE;
		$resMat= mysqli_query($cnx, $sqlMat) or die (mysqli_error($cnx));
		$fila = mysqli_fetch_array($resMat);
		$estado=$fila['ESTADO'];
        $NEQUIPO=$fila['NEQUIPO'];
		$resultado=true;
	}
	mysqli_close($cnx);
	//echo $estado.'<br>llego'.$resultado;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CONSULTA</title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<meta http-equiv="content-language" content="es" />
<link rel="stylesheet" href="../css/miestilo.css">
</head>
<?php
if($resultado){
	if($estado==0){
		echo '<body class="GENERADA">HA GENERADO SU SOLICITUD Y AHORA DEBE:<br/><b>enviar el archivo <u>SOLICITUD'.$NSOL.'.pdf</u> por correo electrónico a</b>: <b><u>ctif.madridoeste@educa.madrid.org</u></b>.</p><p>Otras opciones para completar la inscripción son:<p><ul><li>Imprimir el pdf y enviarlo por fax al CTIF Madrid-Oeste (91 851 71 26)</li><li>Imprimir el pdf y traerlo personalmente al <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40" target="_blank">CTIF Madrid-Oeste</a> (de 8:00 a 15:00 de lunes a viernes).</li></ul><p>Puede consultar el estado de su incripción contactando con el <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40" target="_blank">CTIF Madrid-Oeste</a> o entrando en:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$URL.'?contador='.$NSOL.'&clave='.$CLAVE.'" target="_blank">'.$URL.'?contador='.$NSOL.'&clave='.$CLAVE.'</a><br/>o <b>escaneado el código QR</b> de la solicitud con su dispositivo móvil.</p> <div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2020-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>';
	}else if($estado==1){
		echo '<body class="RECIBIDA">EL CTIF MADRID-OESTE HA <b>RECIBIDO</b> SU SOLICITUD<br/>
			Ahora se estudiará si el equipo cumple los requisitos para ser incluido en la Gymkana.<div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2020-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>';
	}else if($estado==2){
		if($NEQUIPO==0){
			echo '<body class="ADMITIDA">EL CTIF MADRID-OESTE HA <b>ADMITIDO</b> AL EQUIPO EN LA GYMKANA<br/>
			Estamos a la espera de asignarle un número al equipo<br/>
			¡BUENA SUERTE EN LA GYMKANA!<div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2020-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>';
		}else{
			echo '<body class="ADMITIDA">EL CTIF MADRID-OESTE HA <b>ADMITIDO</b> AL EQUIPO EN LA GYMKANA<br/>
			<div align="center"><b><span style="font-size:33px; background-color:#ffff00;border-radius: 10px;border-bottom-left-radius:0px; box-shadow: 7px 7px #158e15;">&nbsp;- El número de equipo asignado es:&nbsp;</span>&nbsp;&nbsp;</b><strong><span style="font-size:66px; background-color:#ffffff; border-radius: 20px;border-bottom-right-radius:0px; box-shadow: 10px 10px #158e15;">&nbsp;'.$NEQUIPO.'&nbsp;</span></strong></div><br/>
			¡BUENA SUERTE EN LA GYMKANA!<div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2020-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>';
		}
	}else if($estado==3){
		echo '<body class="LESPERA">EL CTIF MADRID-OESTE HA RECIBIDO SU SOLICITUD PERO COMO YA SE HA LLEGADO<br>AL TOPE DE LOS EQUIPOS DE SU CENTRO, ESTE EQUIPO <b>ESTÁ EN LA LISTA DE ESPERA</b>.<div style="background-color: #ffccff; border-radius: 10px 10px 10px 10px;	-moz-border-radius: 10px 10px 10px 10px;	-webkit-border-radius: 10px 10px 10px 10px;	border: 0px solid #000000;	  box-shadow: 2px 2px 10px #666;  padding: 10px;">
<span style="color:red; text-shadow: 2px 2px 2px #AAA; font-size:2em">***</span>Los Centros educativos inscritos deberán remitir a la Concejalía de Educación <big><b><a href="Autorización para participar en la Gymkana 2020-mod.pdf" target="_blank">la ficha de autorización</a></b></big> para participar en la actividad, cumplimentada por el padre/madre o tutor de cada uno de los alumnos integrantes del equipo.
<ul>
<li>Por correo electrónico: <big><b>c.educacion@pozuelodealarcon.org</b></big> <a href="https://www.pozuelodealarcon.org/legal/politica-de-privacidad-de-correos-electronicos-corporativos" target="_blank">(Política de privacidad)</a>.</li>

<li>Personalmente: Concejalía de Educación. C/ Hospital, 4. 28223 Pozuelo de Alarcón (De 9:00 a 14:30h)</li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://servicios.pozuelodealarcon.org/portal/action/tramitesinfo?method=enter&id=211" target="_blank">más información</a>.
</div>';
	}else if($estado==4){
		echo '<body class="ANULADA">SU SOLICITUD HA SIDO <b>ANULADA</b> PARA MÁS INFORMACIÓN CONTACTE CON EL <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40"target="_blank">CTIF MADRID-OESTE</a>.';
	}else{//inscripciones movidas a otras gymkanas
		
		$gymkanas=array(   
			1 => 'INSCRIPCIONES_BOMO', 
		    2 => 'INSCRIPCIONES_COVI',
		    3 => 'INSCRIPCIONES_ELES',
			4 => 'INSCRIPCIONES_ROZAS',
		    5 => 'INSCRIPCIONES_POAL',//no se han puesto Majadahonda, Torrelodones y Valdemorillo
		    6 => 'INSCRIPCIONES_SALO',
		);
		$Ngymkanas=array(   
			1 => 'BOADILLA', 
		    2 => 'COLLADOVILLALBA',
		    3 => 'ELESCORIAL',
			4 => 'LASROZAS',
		    5 => 'POZUELO',//no se han puesto Majadahonda, Torrelodones y Valdemorillo
		    6 => 'SANLORENZO',
		);
		//BOADILLA, COLLADOVILLALBA, ELESCORIAL, POZUELO, SANLORENZO
		$gymkDestino=$gymkanas[$estado-50];
		$NgymkDestino=$Ngymkanas[$estado-50];
		$hisGynkDestino="HIS_".$gymkDestino;
		$cnx = conectar ();
		$sqlMat='SELECT HID  FROM '.$hisGynkDestino.' WHERE  NSOL='.$NSOL.' AND CLAVE='.$CLAVE;
		$resMat= mysqli_query($cnx, $sqlMat) or die (mysqli_error($cnx));
		$fila = mysqli_fetch_array($resMat);
		$HID=$fila['HID'];//echo '<br>llego'.$N;
		$sqlMat='SELECT  NSOL, CLAVE  FROM '.$gymkDestino.' WHERE  ID='.$HID;
		$resMat= mysqli_query($cnx, $sqlMat) or die (mysqli_error($cnx));
		$fila = mysqli_fetch_array($resMat);
		$NSOL_DES=$fila['NSOL'];
		$CLAVE_DES=$fila['CLAVE'];
		echo '<body class="DESPLAZADA">COMO YA SE LE CONSULTÓ, SU SOLICITUD HA SIDO <span style="background-color: yellow; color: red;" ><u><B><BIG>DESPLAZADA</BIG></B></u></span> A LA GYMKANA DE <span style="background-color: yellow; color: red;" ><u><B><BIG>'.$NgymkDestino.'</BIG></B></u></span>:';
		echo "<div><iframe src=\"../".$NgymkDestino."/comprueba.php?contador=".$NSOL_DES."&clave=".$CLAVE_DES."\" width=\"100%\" height=\"400px\"></iframe></div>";

		echo 'PARA MÁS INFORMACIÓN CONTACTE CON EL <a href="http://ctif.madridoeste.educa.madrid.org/index.php?option=com_content&view=article&id=5&Itemid=40"target="_blank">CTIF MADRID-OESTE</a>.';
	}
}else{
echo 'NO SE HA GENERADO SU SOLICITUD, PUEDE REALIZAR UNA NUEVA EN ESTE ENLACE:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://goo.gl/dPUmrW" target="_blank">ESTE ENLACE</a>.';
}
?>
<br>
<div><img src="cabecera.svg"  ></div>
<script languaje="javascript">


function limpiar(){ 
    document.body.innerHTML=document.body.innerHTML.split('<div>cortamos por aqui</div>')[0]; 
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

