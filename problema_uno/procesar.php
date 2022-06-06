<?php


$resultado = "No se encontro ninguna instrucción";

if ($fp = fopen($_FILES['archivo']['tmp_name'], "r")) {

    $instruccionUno = "";
    $instruccionDos = "";
    $mensaje = "";
    $numeroLinea = 1;
    $longitudes = "";

    $lista = [];
    $instrucciones = "";


    while (!feof($fp)) { // recorremos todas las líneas del archivo

        $linea = fgets($fp);

        if (!empty($linea)) {

            $linea = trim($linea);

            if ($numeroLinea == 1) { // tamaños
                $longitudes = $linea;
            } else if ($numeroLinea == 2) { // instrucción uno
                $instruccionUno = $linea;
            } else if ($numeroLinea == 3) { // instrucción dos
                $instruccionDos = $linea;
            } else if ($numeroLinea == 4) { // mensaje
                $mensaje = $linea;
            }
        }

        $numeroLinea++;
    }


    $longitudesArray = explode(" ", $longitudes);

    $longitudInstruccionUno = $longitudesArray[0];
    $longitudInstruccionDos = $longitudesArray[1];
    $longitudMensaje        = $longitudesArray[2];

    $mensajeLimpio = preg_replace("/(.)\\1+/", "$1", $mensaje); // Quitamos las letras duplicadas

    $file = fopen("archivo.txt", "w");

    if (!(strlen($instruccionUno) == $longitudInstruccionUno)) {

        fwrite($file, 'La primer instrucción no tiene la longitud proporcionada');
        fclose($file);

        echo json_encode(['resultado' => 'La primer instrucción no tiene la longitud proporcionada']);
        return false;
    }

    if (! (strlen($instruccionUno) >= 2 && strlen($instruccionUno) <= 50)  ) {

        fwrite($file, 'La primer instrucción debe tener una longitud de entre 2 y 50');
        fclose($file);

        echo json_encode(['resultado' => 'La primer instrucción debe tener una longitud de entre 2 y 50']);
        return false;
    }

    if( preg_match("/(.)\\1+/", strtoupper($instruccionUno)) ){
        fwrite($file, 'La primera instrucción tiene letras iguales seguidas');
        fclose($file);
        echo json_encode(['resultado' => 'La primera instrucción tiene letras iguales seguidas']);
        return false;
    }

    if (!(strlen($instruccionDos) == $longitudInstruccionDos)) {

        fwrite($file, 'La segunda instrucción no tiene la longitud proporcionada');
        fclose($file);
        echo json_encode(['resultado' => 'La segunda instrucción no tiene la longitud proporcionada']);
        return false;
    }

    if (! (strlen($instruccionDos) >= 2 && strlen($instruccionDos) <= 50)  ) {

        fwrite($file, 'La segunda instrucción debe tener una longitud de entre 2 y 50');
        fclose($file);

        echo json_encode(['resultado' => 'La segunda instrucción debe tener una longitud de entre 2 y 50']);
        return false;
    }

    if( preg_match("/(.)\\1+/", strtoupper($instruccionDos)) ){
        fwrite($file, 'La segunda instrucción tiene letras iguales seguidas');
        fclose($file);
        echo json_encode(['resultado' => 'La segunda instrucción tiene letras iguales seguidas']);
        return false;
    }

    if (!(strlen($mensaje) == $longitudMensaje)) {

        fwrite($file, 'El mensaje no tiene la longitud proporcionada');
        fclose($file);
        echo json_encode(['resultado' => 'El mensaje no tiene la longitud proporcionada']);
        return false;
    }

    if (! (strlen($mensaje) >= 3 && strlen($mensaje) <= 5000 )   ) {

        fwrite($file, 'El mensaje debe de tener una longitud de entre 3 a 5000');
        fclose($file);
        echo json_encode(['resultado' => 'El mensaje debe de tener una longitud de entre 3 a 5000']);
        return false;
    }

    if(!preg_match("/^[a-zA-Z0-9]+$/", $mensaje)){
        fwrite($file, 'El mensaje contiene caracteres no aceptados');
        fclose($file);
        echo json_encode(['resultado' => 'El mensaje contiene caracteres no aceptados']);
        return true;
    }

    $resultado = "";

    if (strpos($mensajeLimpio, $instruccionUno)) {
        $resultado .= "SI\n";
    } else {
        $resultado .= "NO\n";
    }

    if (strpos($mensajeLimpio, $instruccionDos)) {
        $resultado .= "SI\n";
    } else {
        $resultado .= "NO\n";
    }

    fwrite($file, $resultado);
    fclose($file);

    echo json_encode(['resultado' => $resultado, 'mensaje' => $mensajeLimpio]);
    return true;
} else {
    echo json_encode(['resultado' => 'Archivo no adjuntado']);
    return false;
}
