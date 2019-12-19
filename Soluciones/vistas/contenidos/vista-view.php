<?php

        require_once('conexion.php');
        $dateinicio=$_GET["a"];
        $datefin=$_GET["b"];
        $codigo=$_GET["c"];
        $procentaje=$_GET["d"];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Electrocardiograma</title>
<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
  }
  .boton_personalizado:hover{
    color: #1883ba;
    background-color: #ffffff;
  }
</style>
	</head>
	<body>

        

<script src="code/highcharts.js"></script>
<script src="code/modules/data.js"></script>
<script src="code/highcharts-more.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>

<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>


		<script type="text/javascript">
Highcharts.getJSON(
    'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/range.json',
    function (data) {

        Highcharts.chart('container', {

            chart: {
                type: 'arearange',
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                }
            },

            title: {
                <?php
                $sql="SELECT ClienteNombre,ClienteApellido,ClienteDNI FROM Cliente where CuentaCodigo = '".$codigo."'";
                $result = mysqli_query($conexion,$sql);
                while($registros = mysqli_fetch_array($result))
                {
                $nombre=$registros["ClienteNombre"];
                $apellido=$registros["ClienteApellido"];
                $dni=$registros["ClienteDNI"];
                }
                ?>
                text:'Análisis de Electrocardiograma <br> Nombres: <?php echo $nombre?> <br> Apellidos: <?php echo $apellido ?><br> DNI: <?php echo $dni?>'
            },

            xAxis: {
                type: 'datetime'
            },

            yAxis: {
                title: {

                    text: 'Frecuencia Cardiaca'
                }
            },

            tooltip: {
                crosshairs: true,
                shared: true,
                valueSuffix: ''
            },

            legend: {
                enabled: true
            },

            series: [{
                name: 'Porcentaje de arritmia: <?php echo $procentaje ?>%',
                data: [

                <?php
                $inicio = str_replace("%20"," ",$dateinicio);
                $inicio = urldecode($dateinicio);
                $fin = str_replace("%20"," ",$datefin);
                $fin = urldecode($datefin);
                $sql="SELECT * FROM ecg where fecha between '".$inicio."' and '".$fin."'";
                $result = mysqli_query($conexion,$sql);
                while($registros = mysqli_fetch_array($result))
                {
                echo"[".$registros["lectura"].",".$registros["lectura"]."],";
                }
                    ?>


                ]
            }]


        });
    }
);

		</script>
        <style type="text/css">
            form{
            background-color: white;
            border-radius: 3px;
            color: #999;
            font-size: 0.8em;
            padding: 20px;
            margin: 0 auto;
            width: 300px;
        }

        input, textarea{
            border: 0;
            outline: none;

            width: 280px;
        }

        .field{
            border: solid 1px #ccc;
            padding: 10px;

            
        }

        .field:focus{
            border-color: #18A383;
        }

        .center-content{
            text-align: center;
        }
        </style>
        <div style="">
            <form action="https://clinicabaquita-email.000webhostapp.com" method="post">
             
             <?php 
             
             $sql="SELECT ClienteNombre,ClienteApellido,ClienteTelefono,CuentaEmail FROM cuenta cu inner join cliente cl on cu.CuentaCodigo=cl.CuentaCodigo  where cu.CuentaCodigo = '".$codigo."'";
                $result = mysqli_query($conexion,$sql);
                while($registros = mysqli_fetch_array($result))
                {
                $nombre=$registros["ClienteNombre"];
                $apellido=$registros["ClienteApellido"];
                $telefono=$registros["ClienteTelefono"];
                $correo=$registros["CuentaEmail"];
                }
                ?>
               
            <input type="hidden" value="<?php echo $nombre ?> <?php echo $apellido ?>" name="name"> 
            <input type="hidden" value="<?php echo $telefono ?>" name="tel">      
            <input type="hidden" value="<?php echo $correo ?>" name="corr">      

            <input class="boton_personalizado" type="hidden" name="cod" value="<?php echo $codigo ?>">

            <input class="boton_personalizado"  type="submit" name="" value="Enviar a Correo">
        </form>
            <form action="/Soluciones/analisislist/" method="post">
            <input class="boton_personalizado" type="hidden" name="cod" value="<?php echo $codigo ?>">
                
            <input class="boton_personalizado"  type="submit" name="" value="Finalizar">
            </form>
        </div>
	</body>
</html>
