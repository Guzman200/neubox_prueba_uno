<?php

    // Define headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=archivo.txt");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");

    readfile('archivo.txt');
    
