
<?php
    include('libreria.php');
    $datos = leerdata();
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Impresion de ZPL</title>
</head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="zebra/BrowserPrint-1.0.4.min.js"></script>
<script src="zebra/impresionZebra.js"></script>
<script src="js/zpl.js"></script>
<body>
    <div class='container-fluid my-5  text-center'>
        <div class='row'>
            <div class='col-md-6'>
                <div class="card border-secondary mb-3" >
                    <div class="card-header">Subir archivo - upload file CSV</div>
                        <div class="card-body">
                            <form method='post' action='control.php?opc=subir'  enctype="multipart/form-data">
                                <fieldset>             
                                    <fieldset class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="archivo" required name='archivo'>
                                            <label class="custom-file-label" for="archivo">Seleccionar documento...</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary">Subir - upload  </button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            <div class='col-md-6'>
                <div class="card border-secondary mb-3" >
                    <div class="card-header">Imprimir - to print</div>
                        <div class="card-body">
                            <fieldset>
                                <form>
                                    <div class="form-group">
                                    <input type="email" class="form-control" id="numero"  name="numero" aria-describedby="emailHelp" placeholder="numero - number">
                                    </div>
                                    <button type="button" class="btn btn-warning" id='btn-zpl'>Imprimir ZPL en el listado</button>
                                </form>
                            </fieldset>
                        </div>
                    </div>
            </div>
            <div class='col-md-12'>
                <div class="jumbotron">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">REFERENCIA</th>
                            <th scope="col">CODIGO 1</th>
                            <th scope="col">CODIGO 2</th>
                            <th scope="col">DESCRIPCION</th>
                            <th scope="col">REF</th>
                            <th scope="col">DESCONTADO</th>
                            <th scope="col">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count($datos) > 0){
                                $num = 0;
                                foreach($datos as $d){
                                    $descuento = (isset($d[5])) ? $d[5] : '' ;
                                    $porcentaje = (isset($d[6])) ? $d[6] : '' ;
                                ?>
                                <tr>
                                    <th><?php echo $num ?></th>
                                    <th scope="row"><?php echo $d[0] ?></th>
                                    <td><?php  echo $d[1] ?></td>
                                    <td><?php  echo $d[2] ?></td>
                                    <td><?php  echo $d[3]  ?></td>
                                    <td><?php  echo $d[4]  ?></td>
                                    <td><?php  echo $descuento  ?></td>
                                    <td><?php  echo $porcentaje  ?></td>
                                </tr>
                                <?php
                            $num++;
                                }
                            }else{
                                ?>
                            <tr>
                                <th scope="row" span='5'>Debe subir un archivo CSV llamado listado</th>
                            </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>