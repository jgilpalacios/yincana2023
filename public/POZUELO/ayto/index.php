	<?php 
	header('Content-type:text/html;  charset=utf-8');
	require '../../cifrado/aes.class.php';     // AES PHP implementation
	require '../../cifrado/aesctr.class.php';  // AES Counter Mode implementation
	include ("../../cifrado/primos.php");//PARA INCLUIR EL NUMERO PRIMO PARA ALGORITMO DE DIFFIE HELLMAN
    include ("../config.php");//configuracion de la localidad
    include ("../../includes/configLector.php");
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
	<link rel="shortcut icon" href="../ayuntamiento.svg" type="image/x-icon" />
	<meta http-equiv="content-language" content="es" />
	<link rel="stylesheet" href="../../css/miestilo.css">
	<script languaje="javascript" src="../../mathjs/math.min.js"></script>
	<script languaje="javascript" src="../../cifrado/aes.js">/* AES JavaScript implementation */</script>
	<script languaje="javascript" src="../../cifrado/aes-ctr.js">/* AES Counter Mode implementation */</script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>-->
	<script type="text/javascript" src="../../js/md5.js"></script>
	<!--<script type="text/javascript" src="../mijs/encriptador.js"></script>-->
	<script src="../../mijs/encriptador.js"></script>
	<script src="../../js/jsencrypt.min.js"></script>
	<!--<script src="tablaA.js" async></script>-->
	<script type="text/javascript">
	<?php

	$primo=GetPrimo($MisPrimos);
	$n=floor ((strlen($primo)-1)/2);
	$base='';$aux='';
	for($i=0;$i<$n;$i++){
		$aux2='00'.mt_rand (0,99);
		$aux.=substr($aux2, strlen($aux2)-2, 2);
	}
	$base=$aux;
	$aux='';
	for($i=0;$i<$n;$i++){
		$aux2='00'.mt_rand (1,99);
		$aux.=substr($aux2, strlen($aux2)-2, 2);
	}
	$kServidor=$aux;
	// Almacenamos la parte del servidor en la sesión

	$_SESSION['primo']=$primo;
	$_SESSION['base']=$base;
	$_SESSION['kServidor']=$kServidor;

	$servidor="1234567807484088458390405458498908540585848538538584908534480808855858";
	//$servidor=bcpowmod($base,$kServidor,$primo);
	//mandamos su parte al cliente
	echo "var primo='".$primo."';\n";//pasamos el primo
	echo "var base='".$base."';\n";//pasamos la base
	echo "var servidor='".$servidor."';\n";//pasamos la parte del servidor
	/// y el genera la clave y la parte que debe enviarnos
	echo "var sal='".$sal."';\n";
	?>
	var kCliente;
	var cliente;
	var k;
	var key;
	


	/**
	 * Funcion para potenciar modulo tope que se necesita para algoritmo de diffie Hellman
	 * utiliza las librerias para operar con números grandes de 
	 * mathJS enlazadas en http://cdnjs.cloudflare.com/ajax/libs/mathjs/1.0.1/math.min.js
	 */

	function ModPow(b,e,tope){
		math.config({ number: 'BigNumber',   precision: 256 });
		var resultado=math.bignumber('1');
		var auxe=e;
		var auxb=math.mod(b,tope);
		while (math.compare(auxe,0)>0){
			if(math.compare(math.mod(auxe,2),0)>0) resultado=math.mod(math.multiply(auxb,resultado),tope);
			auxb=math.mod(math.multiply(auxb,auxb),tope);
			auxe=math.floor(math.divide(auxe,2));
		}
		return resultado;
	}

	function IniciaCliente(){
		var n = Math.floor((primo.length-1)/2);
		kCliente='';
		for (var i=0;i<n;i++){
			var aux='00'+Math.floor(Math.random()*100);
			kCliente+=aux.substring(aux.length-2);
		}//alert(kCliente+'ll'+math);
		cliente=math.format(ModPow(math.bignumber(base),math.bignumber(kCliente),math.bignumber(primo)), {notation: 'fixed'});
	};
	/**
	 * Funcion que genera el texto cifrado a partir del resumen que pasa GeneraMensaje utilizando
	 * la clave pasada en kk
	 */
	function Codificalo(texto,clave){
		var enkr=Aes.Ctr.encrypt(texto, clave ,256);
		//var enkr=Aes.Ctr.encryptFijo(texto, clave,256);
		return enkr;
	};
	/**
	 * Función que genera la clave Diffie Hellman,luego realmente usamos su codificación AES como clave
	 */
	function GeneraK(){
		/* calculamos la clave compartida en el cliente*/
		//k=math.format(ModPow(math.bignumber(servidor),math.bignumber(kCliente),math.bignumber(primo)), {notation: 'fixed'});
		key='1234567807484088458390405458498908540585848538538584908534480808855858';
		//key=Aes.Ctr.encryptFijo(k, k ,256);//finalmente codificamos aes el numero clave y usamos esa codificacion como clave
	}

	/**
     * Prepara la conexion enrcriptando AES el resumen de la clave privada y la clave de administrador.
	 * Para ofuscar más el envío se usa la sal y tambien se genera un número aleatorio de 20 cifras
	 * que se añade a las claves y sal.
     */
	function LanzaConexion(){//alert('entro');
	//////////////////////
		clavePriv=document.getElementById('cPrivada').value;///se añade para fijar la clave privada con el contenido del text area 
	//////////////////////////
		var aux=calcMD5(document.getElementById('cPrivada').value);//alert(aux);
   		var auxNum=Math.floor(100000*Math.random())+''+Math.floor(100000*Math.random());
		var aux2=Codificalo(aux+'#'+sal+'#'+auxNum,key);//alert(aux2);
		document.getElementById('MD5KprivEncr').value=aux2;
		///<--parte clave privada---parte clave administrador----->
		/*auxNum=Math.floor(100000*Math.random())+''+Math.floor(100000*Math.random());
		aux=document.getElementById('CAdmin').value+'#'+sal+'#'+auxNum;
		document.getElementById('ClaveAdmin').value=Codificalo(aux,key);
		//document.getElementById('resumenClave').innerHTML=aux;*/
		//document.getElementById('resumenClavEncr').innerHTML=aux2;
	}





	var totalOperaciones={};
	function registraOperacion(op){
		var objeto=op.split(',');//alert(objeto);
		if(objeto[2]<0){
			delete totalOperaciones[objeto[0]+objeto[1]];
		}
		else totalOperaciones[objeto[0]+objeto[1]]=objeto;
		//alert(op+'registrado'+objeto+';'+JSON.stringify(totalOperaciones));
	}

	function generaNeQuipos(id,neq){
		var CodHTML='<td>';
		 CodHTML+='<input type="text" name="pin'+id+'" id="pin'+id+'" maxlength="3" size="3" onchange=";registraOperacion(\'NEQUIPO,'+id+', \'+this.value+\'\')" value="'+neq+'">';
		return CodHTML+'</td>';
	}

	function generaOperaciones(id,estado){
		var CodHTML='<td>';
		switch (+estado){
			case 0:CodHTML='<td class="GENERADA">';break;
			case 1:CodHTML='<td class="RECIBIDA">';break; 
			case 2:CodHTML='<td class="ADMITIDA">';break;
			case 3:CodHTML='<td class="LESPERA">';break; 
			case 4:CodHTML='<td class="ANULADA">';break;  
		}"['+id+', -1]"
		CodHTML+='<select onchange="registraOperacion(this.value);"><option value="ESTADO,'+id+', -1"></option><option value="ESTADO,'+id+', 0">GENERADA</option><option value="ESTADO,'+id+',1">RECIBIDA</option><option value="ESTADO,'+id+',2">ADMITIDA</option><option value="ESTADO,'+id+', 3">L. ESPERA</option><option value="ESTADO,'+id+', 4">ANULADA</option></select>';
		return CodHTML+'</td>';
	}

	function cargaOperaciones(){
		document.getElementById('instante').value=Math.floor(new Date().getTime()/1000);
		var texto="";var n=0;var aux='';
		for(var i in totalOperaciones){//alert(i);
			aux=totalOperaciones[i][0]+'a'+totalOperaciones[i][1]+'a'+totalOperaciones[i][2];
			if(n++==0){ texto+=aux;			
			}else texto+='b'+aux;
		}
		//texto+=' ]';
		document.getElementById('operaciones').value=texto;//alert(texto);
		//document.getElementById('operaciones').value=JSON.stringify(totalOperaciones);
		totalOperaciones={};
	}
	var avance=0;
	var cucu;
	var miArrayDeObjetos;//se guardan los datos cargados que convierte en CSV la función arrayObjToCsv(ar)
	/*function MuestraProgreso(){ //alert(avance);
		document.getElementById('miBarra').value=window.top.window.avance;
		document.getElementById('miAvance').innerHTML=avance+'%';//alert(avance);
		if (avance<100) setTimeout('MuestraProgreso()', 20);
	}
	var guardaMuestra;
	var array;
	function B(arr){
		array=arr;
	    	setTimeout('MuestraProgreso()', 100);
		setTimeout('A()', 110);
	}*/

	function move() {
	  var elem = document.getElementById("miBarra");
	  var width = 1;
	  var id = setInterval(frame, 10);
	  function frame() {
	    if (width >= 100) {
	      clearInterval(id);
	    } else {
	      width++;
	      elem.style.width = width + '%';
	    }
	  }
	}
	function gestBarra(){ alert('--');
		document.getElementById('miBarra').value=avance;
		document.getElementById('miAvance').innerHTML=avance+'%';
		//renderizado=true;
	}

	function iniciaBarra(){
		avance=0;
		document.getElementById('miBarra').value=avance;
		document.getElementById('miAvance').innerHTML=avance+'%';
	}

	var elIn=0;
	var msgAcum='';
	var msgDisp='';
	var ArrayTemp=[];
	var completado=false;
	function A(array, hecho){ //alert(hecho + msgAcum);
		//completado=false;
		if(hecho){
			alert('no se hace nada');
		}else{
		document.getElementById('reiframe').style.visibility='hidden';
		completado=false;
		msgDisp=array;
		var msg='';
		//avance=0;
		//move();
		//cucu=setInterval(gestBarra, 100);
		var datos;
		var aux;
		miArrayDeObjetos=ArrayTemp;
		var tablaIn='<table style="text-align: center; width: 100% ;" border="1" cellpadding="1" cellspacing="1"><tbody>';
		
		tablaIn+='<th>ACCIÓN</th><th>ID</th><th class="ordenable" onclick="OrdLocal(\'NEQUIPO\')">NºEQUIPO</th><th class="ordenable" onclick="OrdLocal(\'NSOL\')" >NSOL</th><th>CLAVE</th><th class="ordenable" onclick="OrdLocal(\'TIPO\')">TIPO</th><th class="ordenable" onclick="OrdLocal(\'CODCENTRO\')">CENTRO</th><th>ALUMNOS</th><th class="ordenable" onclick="OrdLocal(\'RESPONSABLE\')">RESPONSABLE</th><th class="ordenable" onclick="OrdLocal(\'SOLICITADA\')">SOLICITADA</th><th class="ordenable" onclick="OrdLocal(\'RECIBIDA\')">RECIBIDA</th><th class="ordenable" onclick="OrdLocal(\'ESTADO\')">ESTADO</th>';
		tabla=msgAcum;
		var elFin=elIn+3;	
		if (array.length<elFin){  
			elFin=array.length;
			completado=true;
		}
		for(var i=elIn; i<elFin; i++){

			miArrayDeObjetos[i]={};
			tabla+='<tr>';
			for (var j in array[i]){
				if(j==='VALOR') {
					aux=DesencrMensaje(array[i][j]); 
					msg+=aux+',';
					datos=aux.split(',')
					miArrayDeObjetos[i]['TIPO']=datos[0];
					miArrayDeObjetos[i]['CENTRO']=datos[1];
					miArrayDeObjetos[i]['LOCALIDAD']=datos[2];
					miArrayDeObjetos[i]['CODCENTRO']=datos[3];
					miArrayDeObjetos[i]['ALUMNO1']=datos[4]+' '+datos[5]+', '+datos[6];miArrayDeObjetos[i]['EDAD1']=datos[7];
					miArrayDeObjetos[i]['ALUMNO2']=datos[8]+' '+datos[9]+', '+datos[10];miArrayDeObjetos[i]['EDAD2']=datos[11];
					miArrayDeObjetos[i]['ALUMNO3']=datos[12]+' '+datos[13]+', '+datos[14];miArrayDeObjetos[i]['EDAD3']=datos[15];
					miArrayDeObjetos[i]['ALUMNO4']=datos[16]+' '+datos[17]+', '+datos[18];miArrayDeObjetos[i]['EDAD4']=datos[19];
					miArrayDeObjetos[i]['RESPONSABLE']=datos[20]+' '+datos[21]+', '+datos[22];
					miArrayDeObjetos[i]['TFNOs']=datos[23]+' / '+datos[24];
					miArrayDeObjetos[i]['CORREOe']=datos[25];
					if(datos[0]=='primaria') {tabla+='<td class="primaria">P</td>';}
					else{tabla+='<td class="secundaria">S</td>';};
					tabla+='<td>'+datos[3]+'<br/> '+datos[1]+'<br/>('+datos[2]+')</td>';
					tabla+='<td><table><tr><td>'+datos[4]+' '+datos[5]+', '+datos[6]+' ('+datos[7]+')</td></tr>';
					tabla+='<tr><td>'+datos[8]+' '+datos[9]+', '+datos[10]+' ('+datos[11]+')</td></tr>';
					tabla+='<tr><td>'+datos[12]+' '+datos[13]+', '+datos[14]+' ('+datos[15]+')</td></tr>';
					tabla+='<tr><td>'+datos[16]+' '+datos[17]+', '+datos[18]+' ('+datos[19]+')</td></tr></table></td>';
					tabla+='<td><table><tr><td>'+datos[20]+' '+datos[21]+', '+datos[22]+'</td></tr>';
					tabla+='<tr><td>'+datos[23]+' / '+datos[24]+'</td></tr>';
					tabla+='<tr><td>'+datos[25]+'</td></tr></table></td>';
				}
				else {
					miArrayDeObjetos[i][j]=array[i][j];
					msg+=array[i][j]+',';
					if(j=='SOLICITADA'){ tabla+='<td>'+Afecha(array[i][j])+'</td>';}
					else if(j=='RECIBIDA'){
						 if((+array[i][j])>1000) {tabla+='<td>'+Afecha(array[i][j])+'</td>';}
						else tabla+='<td>'+array[i][j]+'</td>';
					}else if(j=='ID'){
						tabla+=generaOperaciones(array[i][j],array[i]['ESTADO'])+'<td>'+array[i][j]+'</td>';
					}else if(j=='NEQUIPO'){
						tabla+=generaNeQuipos(array[i]['ID'],array[i][j]);
					}else {tabla+='<td>'+array[i][j]+'</td>';}
					
				}
				
			}
			tabla+='</tr>';
			msg+=array[i][j]+'<br/>';//alert(Math.floor((i+1)*100/array.length));
			avance=Math.floor((i+1)*100/array.length);
			
			
			//document.getElementById('decrip').innerHTML=tabla+'</tbody></table>';
			
			//alert(avance);
			//while (document.getElementById('miBarra').value!=avance){};
		}
		elIn=elFin;
		msgAcum=tabla;

		tablaIn+=tabla+'</tbody></table>';
		
		document.getElementById('miAvance').innerHTML=avance+'%';
		document.getElementById('miBarra').value=avance;
		//document.getElementById('decrip').innerHTML=tablaIn;//+msg;//msg+tabla;
		if(completado){
			document.getElementById('miAvance').innerHTML=avance+'%; '+elFin+' equipos.';
			document.getElementById('decrip').innerHTML=tablaIn;//+msg;//msg+tabla;
			elIn=0;
			msgAcum='';
			//var msgDisp='';
			ArrayTemp=[];
			Alocal();

		}else{
			document.getElementById('kkkk').dblclick();	
			document.getElementById('kkk').click();//alert('cc')
			//document.getElementById('kkkk').dblclick();
		}
		//A(msgDisp,completado);
	}
		//clearInterval(cucu);
	}
	

	function OrdLocal(criterio){ //alert('se emtra');
		//alert (criterio);
		//alert(miArrayDeObjetos[0]['ID']);
		miArrayDeObjetos.sort(function(a, b) {  return  a[criterio] > b[criterio] ? 1 : -1; }); //alert('se etra');
		//alert(miArrayDeObjetos[0]['ID']);
		Alocal();
	}
	function Alocal(){ //alert('se entra'+miArrayDeObjetos); alert(miArrayDeObjetos[0]['ID']);
	var msg='';
		//array=JSON.parse(Aes.Ctr.decrypt(array,key,256));
		//alert(array.length);
		//var datos;
		//var aux;
		//miArrayDeObjetos=[];
		var tabla='<table style="text-align: center; width: 100% ;" border="1" cellpadding="1" cellspacing="1"><tbody>';
		tabla+='<th>ID</th><th class="ordenable" onclick="OrdLocal(\'NEQUIPO\')">NºEQUIPO</th><th class="ordenable" onclick="OrdLocal(\'NSOL\')" >NSOL</th><th>CLAVE</th><th class="ordenable" onclick="OrdLocal(\'TIPO\')">TIPO</th><th class="ordenable" onclick="OrdLocal(\'CODCENTRO\')">CENTRO</th><th>ALUMNOS</th><th class="ordenable" onclick="OrdLocal(\'RESPONSABLE\')">RESPONSABLE</th><th class="ordenable" onclick="OrdLocal(\'SOLICITADA\')">SOLICITADA</th><th class="ordenable" onclick="OrdLocal(\'RECIBIDA\')">RECIBIDA</th><th class="ordenable" onclick="OrdLocal(\'ESTADO\')">ESTADO</th>';
		for(var i=0; i<miArrayDeObjetos.length; i++){
			//miArrayDeObjetos[i]={};
			tabla+='<tr>';
			tabla+='<td>'+miArrayDeObjetos[i]['ID']+'</td>';
			if(miArrayDeObjetos[i]['NEQUIPO']>0){
				tabla+='<td><h1 style="color:#882222">'+miArrayDeObjetos[i]['NEQUIPO']+'</h></td>';
			}else tabla+='<td> </td>';
			tabla+='<td>'+miArrayDeObjetos[i]['NSOL']+'</td>';
			tabla+='<td>'+miArrayDeObjetos[i]['CLAVE']+'</td>';
			if(miArrayDeObjetos[i]['TIPO']=='primaria') {tabla+='<td class="primaria">P</td>';}
			else{tabla+='<td class="secundaria">S</td>';};
			tabla+='<td>'+miArrayDeObjetos[i]['CODCENTRO']+'<br/> '+miArrayDeObjetos[i]['CENTRO']+'<br/>('+miArrayDeObjetos[i]['LOCALIDAD']+')</td>';
			tabla+='<td><table><tr><td>'+miArrayDeObjetos[i]['ALUMNO1']+' ('+miArrayDeObjetos[i]['EDAD1']+')</td></tr>';
			tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO2']+' ('+miArrayDeObjetos[i]['EDAD2']+')</td></tr>';
			tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO3']+' ('+miArrayDeObjetos[i]['EDAD3']+')</td></tr>';
			tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO4']+' ('+miArrayDeObjetos[i]['EDAD4']+')</td></tr></table></td>';
			
			tabla+='<td><table><tr><td>'+miArrayDeObjetos[i]['RESPONSABLE']+'</td></tr>';
			tabla+='<tr><td>'+miArrayDeObjetos[i]['TFNOs']+'</td></tr>';
			tabla+='<tr><td>'+miArrayDeObjetos[i]['CORREOe']+'</td></tr></table></td>';
			tabla+='<td>'+Afecha(miArrayDeObjetos[i]['SOLICITADA'])+'</td>';
			if((+miArrayDeObjetos[i]['RECIBIDA'])>1000) {tabla+='<td>'+Afecha(miArrayDeObjetos[i]['RECIBIDA'])+'</td>';}
			else tabla+='<td>'+miArrayDeObjetos[i]['RECIBIDA']+'</td>';
			switch(miArrayDeObjetos[i]['ESTADO']){
				case 2:
					tabla+='<td class="ADMITIDA">ADMITIDO<br>(<b>'+miArrayDeObjetos[i]['ESTADO']+'</b>)</td>';
				break;
				case 3:
					tabla+='<td class="LESPERA">LISTA DE<br>ESPERA<br>(<b>'+miArrayDeObjetos[i]['ESTADO']+'</b>)</td>';
				break;
			}
			//tabla+='<td>'+miArrayDeObjetos[i]['ESTADO']+'</td>';
			for (var j in miArrayDeObjetos[i]){
				/*if(miArrayDeObjetos[i]['TIPO']=='primaria') {tabla+='<td class="primaria">P</td>';}
				else{tabla+='<td class="secundaria">S</td>';};*/
				//tabla+='<td>'+miArrayDeObjetos[i]['CODCENTRO']+'<br/> '+miArrayDeObjetos[i]['CENTRO']+'<br/>('+miArrayDeObjetos[i]['LOCALIDAD']+')</td>';
				/*tabla+='<td><table><tr><td>'+miArrayDeObjetos[i]['ALUMNO1']+' ('+miArrayDeObjetos[i]['EDAD1']+')</td></tr>';
				tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO2']+' ('+miArrayDeObjetos[i]['EDAD2']+')</td></tr>';
				tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO3']+' ('+miArrayDeObjetos[i]['EDAD3']+')</td></tr>';
				tabla+='<tr><td>'+miArrayDeObjetos[i]['ALUMNO4']+' ('+miArrayDeObjetos[i]['EDAD4']+')</td></tr></table></td>';*/
				/*tabla+='<td><table><tr><td>'+miArrayDeObjetos[i]['RESPONSABLE']+'</td></tr>';
				tabla+='<tr><td>'+miArrayDeObjetos[i]['TFNOs']+'</td></tr>';
				tabla+='<tr><td>'+miArrayDeObjetos[i]['CORREOe']+'</td></tr></table></td>';*/
				msg+=miArrayDeObjetos[i][j]+',';
				/*if(j=='SOLICITADA'){ tabla+='<td>'+Afecha(miArrayDeObjetos[i][j])+'</td>';}
				else if(j=='RECIBIDA'){
					 if((+miArrayDeObjetos[i][j])>1000) {tabla+='<td>'+Afecha(miArrayDeObjetos[i][j])+'</td>';}
					else tabla+='<td>'+miArrayDeObjetos[i][j]+'</td>';
				}else if(j=='ID'){
					//tabla+=generaOperaciones(miArrayDeObjetos[i][j],miArrayDeObjetos[i]['ESTADO'])+'<td>'+miArrayDeObjetos[i][j]+'</td>';
				}else if(j=='NEQUIPO'){
					//tabla+=generaNeQuipos(miArrayDeObjetos[i]['ID'],miArrayDeObjetos[i][j]);
				}else {tabla+='<td>'+miArrayDeObjetos[i][j]+'</td>';}*/			
			}
			tabla+='</tr>';
			msg+='<br/>';
		}
		tabla+='</tbody></table>';
		document.getElementById('decrip').innerHTML=tabla;//+msg;//msg+tabla;

	}

	function arrayObjToCsv(ar) {
		//comprobamos compatibilidad
		if(window.Blob && (window.URL || window.webkitURL)){
			var contenido = "",
				d = new Date(),
				blob,
				reader,
				save,
				clicEvent;
			//creamos contenido del archivo
			for (var i = 0; i < ar.length; i++) {
				//construimos cabecera del csv
				if (i == 0)
					contenido += Object.keys(ar[i]).join(";") + "\n";
				//resto del contenido
				contenido += Object.keys(ar[i]).map(function(key){
								return ar[i][key];
							}).join(";") + "\n";
			}
			//creamos el blob
			blob =  new Blob(["\ufeff", contenido], {type: 'text/csv'});
			//creamos el reader
			var reader = new FileReader();
			reader.onload = function (event) {
				//escuchamos su evento load y creamos un enlace en dom
				save = document.createElement('a');
				save.href = event.target.result;
				save.target = '_blank';
				//aquí le damos nombre al archivo
				save.download = "log_"+ d.getDate() + "_" + (d.getMonth()+1) + "_" + d.getFullYear() +".csv";
				try {
					//creamos un evento click
					clicEvent = new MouseEvent('click', {
						'view': window,
						'bubbles': true,
						'cancelable': true
					});
				} catch (e) {
					//si llega aquí es que probablemente implemente la forma antigua de crear un enlace
					clicEvent = document.createEvent("MouseEvent");
					clicEvent.initEvent('click', true, true);
				}
				//disparamos el evento
				save.dispatchEvent(clicEvent);
				//liberamos el objeto window.URL
				(window.URL || window.webkitURL).revokeObjectURL(save.href);
			}
			//leemos como url
			reader.readAsDataURL(blob);
		}else {
			//el navegador no admite esta opción
			alert("Su navegador no permite esta acción");
		}
	};

	function Afecha(timestamp){
	    var date = new Date(timestamp*1000);
	    var mes=date.getMonth()+1; //getMonth devuelve el mes empezando por 0
	    var dia=date.getDate(); //getDate devuelve el dia del mes
	    var anyo=date.getFullYear();
	    var hora=date.getHours();
	    var minutos= date.getMinutes();
	    return ('00'+dia).substring(('00'+dia).length-2)+'/'+('00'+mes).substring(('00'+mes).length-2)+'/'+anyo+' '+('00'+hora).substring(('00'+hora).length-2)+':'+('00'+minutos).substring(('00'+minutos).length-2) ;
	}
	function Atimestamp(dia, mes){
		if(dia==''||mes==''){
			return '';
		}else{
			return new Date(2019,mes,dia).getTime()/1000;
			//return new Date(2018,mes,dia).getTime()/1000;
		}
	}

	//para poder ajustar los datos de la BD con valores interpretables
	var arraySalida=[];
	function AjustaSalida(){
		arraySalida=[];
		for(var i=0; i<miArrayDeObjetos.length; i++){
			arraySalida[i]={};//alert ('entro');
			for(var j in miArrayDeObjetos[i]){
				if (j=='SOLICITADA'){
					arraySalida[i]['SOLICITADA']=Afecha(miArrayDeObjetos[i]['SOLICITADA']);
				}else if (j=='RECIBIDA'){
					if(+miArrayDeObjetos[i]['RECIBIDA']>1000){
						arraySalida[i]['RECIBIDA']=Afecha(miArrayDeObjetos[i]['RECIBIDA']);
					}else{
						arraySalida[i]['RECIBIDA']=' ';
					}
				}else{
					arraySalida[i][j]=miArrayDeObjetos[i][j];
				}
			}
		}
	}

	///para leer la clava de archivos del equipo
function ponEvento(){
	document.getElementById('file-input')
  .addEventListener('change', leerArchivo, false);
 }
function leerArchivo(e) {
  var archivo = e.target.files[0];
  if (!archivo) {
    return;
  }
  var lector = new FileReader();
  lector.onload = function(e) {
    var contenido = e.target.result;
    mostrarContenido(contenido);
  };
  lector.readAsText(archivo);
}

function mostrarContenido(contenido) {
  //var elemento = document.getElementById('contenido-archivo');
  var elemento = document.getElementById('cPrivada');
  var n=contenido.length-1;
  elemento.innerHTML = contenido.substring(0,n);
}

///para mostrar el resultado de no haber puesto la clave privada correcta.
function B(){
	document.getElementById('reiframe').style.visibility='visible';
}

	</script>
	</head>
	<body>
		<div style="display: inline;" align="center">
			<img src="../ayuntamiento.svg" align="middle" height="140">
			<textarea id="cPrivada" name="input" type="text" rows=2 cols=70>Aquí se pone la clave privada</textarea> 
			<input type="file" id="file-input" />
			ESTADO DE SOLICITUD:<select onchange="document.getElementById('ESTADO').value=this.value;">
				<option value="23">ADMITIDA y L.ESP.</option>
				<option value="2">ADMITIDA</option>
		  		<option value="3">L. ESPERA</option>				
			</select>	
		</div>
		<div  align="center"><input id="acceder" type="button" value="acceder" onclick="document.getElementById('reiframe').style.visibility='hidden';document.getElementById('decrip').innerHTML='';iniciaBarra();LanzaConexion();cargaOperaciones();document.getElementById('genk').submit();" />
<progress id="miBarra" max="100" value="0" ></progress><span id="miAvance">0%</span><input id="aCSV" type="button" value="aCSV" onclick="AjustaSalida();arrayObjToCsv(arraySalida);" /></div>
		<!-- ESTO QUE SIGUE ES PARA QUE SE MUESTRE EL AVANCE DE LA BARRA DE PROGRESO -->
		<input id="kkk" type="button" value="kkk" onclick="if(!completado) A(msgDisp,completado)" style="visibility:hidden"/>
		<input id="kkkk" type="button" value="kkkk" style="visibility:hidden" />
		<form id="genk" action="paso2.php" target="resk" method="POST">
			<input type="hidden" id="cliente" name="cliente" value="0">
		 	<input type="hidden" id="MD5KprivEncr" name="MD5KprivEncr" value="0">
			<input type="hidden" id="BDATOS" name="BDATOS" value="<?php echo $BASE_DATOS ?>"><!--Aqui el ayuntamiento-->
			<input type="hidden" id="ESTADO" name="ESTADO" value="23"><!--Aqui el solo las admitidas estado 2-->
			<input type="hidden" id="FECHAINI" name="FECHAINI" value="">
			<input type="hidden" id="FECHAFIN" name="FECHAFIN" value="">
			<input type="hidden" id="ORDRECV" name="ORDRECV" value="false">
			<input type="hidden" id="operaciones" name="operaciones" value="">
			<input type="hidden" id="instante" name="instante" value="">
		</form><br>
		<!--<span id="keyCliente">aqui ira la clave</span><br/>
		<span id="resumenClave">aqui ira el resumen clave</span><br/>
		<span id="resumenClavEncr">aqui ira el resumen clave encriptado</span><br/>-->
		<div id="decrip"></div>
		<div id="reiframe" style="visibility: visible;">
		<!--<div id="reiframe" style="visibility: hidden;">-->
			<iframe name="resk" id="resk" src="../../infoAyto.html"  width="100%" height="500px"></iframe>
		</div>


	<script languaje="javascript">
	function limpiar(){ 
	    document.body.innerHTML=document.body.innerHTML.split('<span>cortamos por aqui</span>')[0];
	    //onload="IniciaCliente();GeneraK();document.getElementById('cliente').value=cliente;document.getElementById('keyCliente').innerHTML='clave='+key;"
	    ponEvento();
	    IniciaCliente();GeneraK();document.getElementById('cliente').value=cliente;//document.getElementById('keyCliente').innerHTML='clave='+key;
	}
	setTimeout(limpiar, 40);

	//var myVar=setInterval(function(){ alert("Hello");alert(document.body.innerHTML); clearInterval(myVar);}, 3000);
	</script>
	<br/>
	<br/>
	<span>cortamos por aqui</span>
	<br/>
	<br/>


	</body>
	</html>
