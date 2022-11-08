<?php 
header('Content-type:text/html;  charset=utf-8');
require '../../cifrado/aes.class.php';     // AES PHP implementation
require '../../cifrado/aesctr.class.php';  // AES Counter Mode implementation
include ("../../cifrado/primos.php");//PARA INCLUIR EL NUMERO PRIMO PARA ALGORITMO DE DIFFIE HELLMAN

include ("../../includes/configLector.php");
include ("../../includes/funciones.php");
//COMPRUEBA QUE SE PASA UN TIRAS DE NUMEROS
function tiraNumeros($val)
{
    if(!preg_match('/^([0-9])+$/', $val))
    {
        return false;
    }
    return true;
}
function tiraLetras($val)
{
    if(!preg_match('/^([A-Z])+$/', $val))
    {
        return false;
    }
    return true;
}
session_start();
/**
 * Debe recibir el numero primo, la base y la potencia de la base al exponente del cliente (cliente) y genera la clave compartida (k), 
 * para que el cliente pueda a su vez obtener por su cuenta la clave compartida le pasa la potencia de la base al exponente propio del
 * servidor (servidor), situa dichos parámetros en la sesión establecida para que lo usen las distintas paginas llamadas.
 **/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Ayuntamiento</title>
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
<meta http-equiv="content-language" content="es" />
<?php
$base=$_SESSION['base'];
$primo=$_SESSION['primo'];
$kServidor=$_SESSION['kServidor'];
$cliente=$_POST['cliente'];
$k="1234567807484088458390405458498908540585848538538584908534480808855858";
//$k=bcpowmod($cliente,$kServidor,$primo);
//$key=AesCtr::encryptFijo($k, $k ,256);//usamos realmente como clave encriptado aes de la clave
$key="1234567807484088458390405458498908540585848538538584908534480808855858";

//obtenemos para comprobar el MD5
$MD5KprivEncr=$_POST['MD5KprivEncr'];
$BDATOS=$_POST['BDATOS'];
$MD5priv=$MD5array[$BDATOS];//ahora usamos claves distintas para cada ayuntamiento
$MD5Kpriv=AesCtr::decrypt($MD5KprivEncr, $key ,256);

//tenemos en cuenta la ofuscación que se ha producido con la sal y con el numero aleatorio
$auxAray=explode( "#".$sal."#" , $MD5Kpriv);
$MD5Kpriv=$auxAray[0];
/*$auxAray=explode( "#".$sal."#" , $ClaveAdministrador);
$ClaveAdministrador=$auxAray[0];*/


	$BDATOS=$_POST['BDATOS'];
$SQLsentencias='';
if ($MD5Kpriv==$MD5priv){
	$operaciones=$_POST['operaciones'];
	$instante=$_POST['instante'];
	if(!($operaciones==""||$operaciones=="{}")){
		//$objeto=json_decode($operaciones);
		$objeto=explode("b", $operaciones);
		$nop=count($objeto);
		$parteSQL="UPDATE ".$BDATOS." SET ";//ESTADO=";//value, column2=value2,...WHERE some_column=some_value";
		$parteSQLhis="INSERT INTO HIS_".$BDATOS." (HID, NEQUIPO, NSOL, CLAVE, VALOR, SOLICITADA, RECIBIDA, ESTADO) SELECT * FROM ".$BDATOS." WHERE ID = ";//.$caso[1].");";
		$updateSQL='';
		$cnx = conectar ();
		for ($i = 0; $i < $nop; $i++){
			$caso=explode("a", $objeto[$i]);
      			$updateSQL=$parteSQL.$caso[0]."=".trim ($caso[2]).", RECIBIDA=".$instante." WHERE ID=".$caso[1].";";
			$insertSQL=$parteSQLhis.$caso[1].";";
			$sqlMat=$updateSQL;
			$SQLsentencias.=$insertSQL.'<br/>'.$sqlMat.'<br/>';
			if(tiraNumeros(trim ($caso[2])) && tiraNumeros($caso[1]) && tiraNumeros($instante) && tiraLetras($caso[0])){
				$resMat= mysqli_query($cnx, $insertSQL) or die (mysql_error());//insertamos en historico
				$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());//editamos en vigente
			}else{
				$SQLsentencias.="¡NO SE HA EJECUTADO FALLA EL FORMATO DE ALGUN DATO!<br/>";
			}
  		}
		
		mysqli_close($cnx);
	}

	$ESTADO=$_POST['ESTADO'];
	$FECHAINI=$_POST['FECHAINI'];
	$FECHAFIN=$_POST['FECHAFIN'];
	$ORDRECV=$_POST['ORDRECV'];
	$msel="WHERE 1";
	if($ESTADO<>""){
		//if($ESTADO=="12") $msel.=" AND (ESTADO=1 OR ESTADO=2 OR ESTADO=3)";
		if($ESTADO=="23") $msel.=" AND (ESTADO=2 OR ESTADO=2 OR ESTADO=3)";
		else $msel.=" AND ESTADO=".$ESTADO;
	}
	if($FECHAINI<>""){
		$msel.=" AND SOLICITADA>".$FECHAINI;
	}
	if($FECHAFIN<>""){
		$msel.=" AND SOLICITADA<".$FECHAFIN;
	}
	$morder="";
	if($ORDRECV<>"false"){
		$morder.=" ORDER BY RECIBIDA ASC";
	}else $morder.=" ORDER BY ID ASC";
	$cnx = conectar ();
	$sqlMat='SELECT * FROM `'.$BDATOS.'` '.$msel.$morder;
	$SQLsentencias.=$sqlMat.'<br/>';
	if((tiraNumeros($ESTADO)||$ESTADO=="") && (tiraNumeros($FECHAINI)||$FECHAINI=="") && (tiraNumeros($FECHAFIN)||$FECHAFIN=="")){
		$resMat= mysqli_query($cnx, $sqlMat) or die (mysql_error());
	}else{
		$SQLsentencias.="¡NO SE HA EJECUTADO FALLA EL FORMATO DE ALGUN DATO!<br/>";
	}
	//$fila = mysqli_fetch_array($resMat);
	$resultado='[';
	while($fila = mysqli_fetch_array($resMat)) {
		$resultado.='{ID: '.$fila['ID'].', NEQUIPO: '.$fila['NEQUIPO'].', NSOL: '.$fila['NSOL'].', CLAVE:'.$fila['CLAVE'].', VALOR:"'.$fila['VALOR'].'", SOLICITADA:'.$fila['SOLICITADA'].', RECIBIDA:'.$fila['RECIBIDA'].', ESTADO:'.$fila['ESTADO'].'},';
	}
	$resultado.=']';
	mysqli_close($cnx);

$_SESSION['key']=$key;
//$servidor=bcpowmod($base,$kServidor,$primo);
$servidor="1234567807484088458390405458498908540585848538538584908534480808855858";

//$key=5;
//mandamos su parte al cliente
echo /*"</head><body>primo=".$primo."<br/>base=".$base."<br/>kServidor=".$kServidor."<br/>kServidor=".$kServidor."<br/>cliente=".$cliente."<br/>k=".$k."<br/>Clave servidor:".$key."<br/>MD5KprivEncr:".$MD5KprivEncr."<br/>MD5Kpriv:".$MD5Kpriv."<br/><br/>".*/$resultado."<br/>".$SQLsentencias;//.ESTADO".$ESTADO."--".$msel.$morder."ORD".$ORDRECV."SQL ".$sqlMat;
?>
<script languaje="javascript">
function limpiar(){
    //alert("Hello");
    //alert(document.body.innerHTML); 
    document.body.innerHTML=document.body.innerHTML.split('<div>cortamos por aqui</div>')[0];
    //window.top.window.B(<?php echo $resultado; ?>);
    //window.top.window.cucu=setInterval(window.top.window.gestBarra, 100);
    //window.top.window.move();
    window.top.window.A(<?php echo $resultado; ?>);
    clearInterval(myVar);
}
myVar=setInterval(limpiar, 50);
//var myVar=setInterval(function(){ alert("Hello");alert(document.body.innerHTML); clearInterval(myVar);}, 3000);
</script>
<br/>
<br/>
<div>cortamos por aqui</div>
<br/>
<br/>

<?php
}else{
echo "</head><body onload='window.top.window.B();'>No es la clave privada correcta<br/>";

}
?>


</body>
</html>
