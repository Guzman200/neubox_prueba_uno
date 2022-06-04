<?php


$resultado = "No se encontro ninguna instrucción";

if ($fp = fopen($_FILES['archivo']['tmp_name'], "r")) {

    $numeroRondas = 0;
    $rondas = [];

    $numeroLinea = 1;
    while (!feof($fp)) { // recorremos todas las líneas del archivo

        $linea = fgets($fp);

        if (!empty($linea)) {

            $linea = trim($linea);

            if ($numeroLinea == 1) { // rondas
                $numeroRondas = $linea;
            } else {
                $rondas[] = explode(' ', $linea);
            }
        }

        $numeroLinea++;
    }

    if ($numeroRondas == count($rondas)) {

        $ganador = 0;
        $ventaja = 0;
        $esPrimerRonda = true;

        foreach ($rondas as $ronda) {

            $marcadorJugadorUno = $ronda[0];
            $marcadorJugadorDos = $ronda[1];

            /** Considerando que no hay empates */
            $ganadorTemporal = ($marcadorJugadorUno > $marcadorJugadorDos) ? 1 : 2;
            $ventajaTemporal = ($marcadorJugadorUno > $marcadorJugadorDos) ? $marcadorJugadorUno - $marcadorJugadorDos : $marcadorJugadorDos - $marcadorJugadorUno;

            if ($esPrimerRonda) {

                $ganador = $ganadorTemporal;
                $ventaja = $ventajaTemporal;

                $esPrimerRonda = false;
            } else {

                if ($ventajaTemporal > $ventaja) {
                    $ventaja = $ventajaTemporal;
                    $ganador = $ganadorTemporal;
                }
            }
        }

        $file = fopen("archivo.txt", "w");
        fwrite($file, "$ganador $ventaja");
        fclose($file);

        echo json_encode(['resultado' => "$ganador $ventaja"]);
        return true;
    }

    $file = fopen("archivo.txt", "w");
    fwrite($file, "El número de rondas no es igual al proporcionado");
    fclose($file);
    echo json_encode(['resultado' => 'El número de rondas no es igual al proporcionado']);
    return true;
} else {
    echo json_encode(['resultado' => 'Archivo no adjuntado']);
    return false;
}
