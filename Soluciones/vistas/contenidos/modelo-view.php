<?php
include '../../core/configApp.php';

    $inicio=$_GET["ini"];
    $fin=$_GET["fn"];
    $codigo=$_GET["cod"];
    $procentaje=$_GET["por"];

     
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Etiquetas <meta> obligatorias para Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Enlazando el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            
    <title>¡Hola Mundo!</title>
  </head>
  <style type="text/css">
    .cargando {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('img/cargando.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
  </style>
  <body onload="redireccionar()"> 
    <div class="cargando"></div>
    <div>
    <h2 class="" style=" padding-top: 120px;padding-left: 400px">Analizando BPM del Corazón</h2>
    </div>
    <div>
    <h4 class="" style=" padding-top: 10px;padding-left: 462px">Por favor espere 1 minuto ... </h4>
    </div>



    <!-- Opcional: enlazando el JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  </body>
</html>


<script language="JavaScript">
  function redireccionar() {

    setTimeout("window.location='vista-view.php?a=<?php echo $inicio ?>&b=<?php echo $fin ?>&c=<?php echo $codigo ?>&d=<?php echo $procentaje ?>'", 60000);

  }
  </script>

