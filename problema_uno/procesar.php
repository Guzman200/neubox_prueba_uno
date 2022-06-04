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

    $mensajeLimpio = preg_replace("/(.)\\1+/", "$1", $mensaje); // Quitamos las letras duplicadas

    $file = fopen("archivo.txt", "w");

    if (!(strlen($instruccionUno) == $longitudInstruccionUno)) {

        fwrite($file, 'La primer instrucción no tiene la longitud proporcionada');
        fclose($file);

        echo json_encode(['resultado' => 'La primer instrucción no tiene la longitud proporcionada']);
        return false;
    }

    if (!(strlen($instruccionDos) == $longitudInstruccionDos)) {

        fwrite($file, 'La segunda instrucción no tiene la longitud proporcionada');
        fclose($file);
        echo json_encode(['resultado' => 'La segunda instrucción no tiene la longitud proporcionada']);
        return false;
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

    echo json_encode(['resultado' => $resultado]);
    return true;
} else {
    echo json_encode(['resultado' => 'Archivo no adjuntado']);
    return false;
}
