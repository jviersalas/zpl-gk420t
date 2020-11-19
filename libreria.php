<?php
function leerdata()
{
    $separador = ',';
    $archivo = 'mostrarData.csv';
    $datos = []; 
    if (file_exists($archivo)) {
        if (($h = fopen("{$archivo}", "r")) !== FALSE) 
        {
            while (($data = fgetcsv($h, 1000, $separador)) !== FALSE) 
            {
                $datos[] = $data;		
            }
            fclose($h);
        }
    }
    return $datos;
}