///validar email
function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( expr.test(email) ) return true;
       // alert("Error: La dirección de correo " + email + " es incorrecta.");
	else return false;
}
///validar codigo de centro
function EsCodCentro(tel) { 
	//var test = /^[9]\d{8}$/; 
        var test = /^[2][8]\d{6}$/;//28 y otros 6 digitos 
	var telReg = new RegExp(test); 
	return telReg.test(tel); 
}
///validar telefono
function EsTelefonoFijo(tel) { 
	//var test = /^[9]\d{8}$/; 
        var test = /^[9|8]\d{8}$/;//se han añadido números de telefono que empiezan por 8 en valladolid etc 
	var telReg = new RegExp(test); 
	return telReg.test(tel); 
}
//validar edad
function EsEdadValida(ed){
	var test = /^[\s|0|1][0-9]$/;//menos de 19 años
	var telReg = new RegExp(test);
	return telReg.test(ed); 
}
function EsTelefonoMovil(tel) {
	//var test = /^[6]\d{8}$/;
	var test = /^[6|7]\d{8}$/;//se han añadido telefonos móviles que empiezan por 7
	var telReg = new RegExp(test);
	return telReg.test(tel); 
} 

function Validar_NombreApellidos(valor) {
    var reg = /^([a-z ñáéíóúàèìòùç·\'äëïöüâêîôûãõßåæðþý\-\x2Eºª]{2,60})$/i;
    if (reg.test(valor)) return true;
    else return false;
}

function Validar_Centro(valor) {
    var reg = /^([a-z 0-9 ñáéíóúàèìòùç·\'äëïöüâêîôûãõßåæðþý\-\(\)\x2Eºª]{2,60})$/i;
    if (reg.test(valor)) return true;
    else return false;
}
