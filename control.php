<?php
    $separador = ';';
    $opc = $_GET['opc'];
    switch ($opc) {
        case 'print':
            /* ejemplo de caja
            ^XA
                ^CFA,70
                ^FO160,120^FD CAJA 01 ^FS 
            ^XZ
            */
            $v = $_POST;
            $archivo = 'listado.csv';
            $datos = []; 
            if (($h = fopen("{$archivo}", "r")) !== FALSE) 
            {
                while (($data = fgetcsv($h, 1000, $separador)) !== FALSE) 
                {
                    $datos[] = $data;		
                }
                fclose($h);
            }

            $d = array();
            $i = 0;           
            if (is_numeric($v['numero']))
            {
                $temp = $datos[$v['numero']];
                $datos = []; 
                $datos[] = $temp;
            }
            foreach($datos as $p)
            {
                if (!empty($p[4])) 
                {
                    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ ';
                    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr ';
                    $fecha  = date('d/m/Y');
                    $p[3] = trim($p[3]);
                    $p[3] = utf8_decode($p[3]);
                    $p[3] = strtr($p[3], utf8_decode($originales), $modificadas);
                    $p[3] = strtoupper($p[3]);
                    $p[3]  = utf8_encode($p[3]);

                    $porcentaje = (isset($p[6])) ? $p[6].'%' : '' ;
                    $descuento = (isset($p[5])) ? $p[4]: '' ;

                    $precio = (isset($p[5])) ? $p[5]: $p[4] ;
                    $precio = (is_numeric($precio)) ? number_format((float)$precio, 2, '.', ''): '';

                    $descuento = (!empty($descuento)) ? number_format($descuento, 2, '.', '') : $descuento ;
                    /* Subrayado de descuento */
                    $linea = (!empty($descuento)) ? 130 : 0 ;

                    $des1 = "";
                    $des2 = "";
                    $des3 = "";
                    if (strlen($p[3]) > 30) {
                        $des1 = substr($p[3], 0, 30);
                        $des2 = substr($p[3], 30, 30);
                        $des3 = substr($p[3], 60, 30);
                    } else {
                        $des1 = $p[3];
                    }
                    $mar = 210;
                    $zpl = "
                    ^XA
                        ^CF0,40
                        ^FO".$mar.",20^FD".$p[0]."^FS
                        ^CF0,20
                        ^FO500,20^FD".$fecha."^FS
                        ^CF0,30
                        ^FO240,80^FDREF:^FS
                        ^CFA,30
                        ^FO350,50^FD ".$descuento." ^FS
                        ^FO360,60^GB".$linea.",1,2^FS                    
                        ^CFA,30
                        ^FO480,50^FD ".$porcentaje." ^FS
                        ^CFA,50
                        ^FO270,80^FD ".$precio." ^FS
                        ^CFA,20
                        ^FO".$mar.",150^FD".$des1."^FS
                        ^FO".$mar.",170^FD".$des2."^FS
                        ^FO".$mar.",190^FD".$des3."^FS
                        ^BY2,2,25
                        ^FO230,210^BC^FD".$p[1]."^FS
                        ^CF0,20
                        ^FO500,120^FD".$p[2]."^FS
                    ^XZ";
                    $d[] = $zpl;
                    $i++;
                }
            }
            header('Content-type: application/json');
            echo json_encode($d);
        break;
        
        case 'subir':
            date_default_timezone_set('America/Caracas');
            $nombre = date('Y_m_d_his');            
            $dir_subidaHistorico = 'historico';
            $fichero_subido = $dir_subidaHistorico .'/'.$nombre.'.csv';
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], 'mostrarData.csv')) {
                copy('mostrarData.csv', $fichero_subido);
            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }
            header("Location: index.php");
        break;
    }
?>