        <!--<body onload="/*alert(Tipos);*/PonTipos();/*setInterval(Candidatos, 1000)*/">-->
CENTRO:<br>
          <p>Tipo
            <select name="tipoC" id="tipoC" onclick="desactivaTemp();"
              onchange="Candidatos()">
            </select>
            Nombre: <input name="nombre_centro2" id="nombre_centro2" onclick="if(!temporizador)temporizador=setInterval(Candidatos, 500)"
              onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();Candidatos()"
              maxlength="50" size="40"> CÓDIGO: <input name="cod_centro" id="cod_centro"
              maxlength="8" size="8"><a href="http://gestiona.madrid.org/wpad_pub/run/j/MostrarConsultaGeneral.icm?tipoCurso=ADM&amp;sinboton=S"
              target="_BLANK" title="Buscador de Centros Comunidad de Madrdid"><img
                src="../img/find.png" align="middle"></a> Localidad: <input name="loc_centro"
              id="loc_centro" onchange="NUM_SOL=0; this.value=this.value.toUpperCase().trim();"
              maxlength="30" size="30"><input id="nombre_centro" name="nombre_centro" type="hidden" value=""></p>
    <p><br>
    </p>
    <span id="centros"></span>

