

<?php 
if ($_SESSION['tipo_sbm']!= "Administrador" || $_SESSION['privilegio_sbm']>2) {
		echo $lc->forzar_cierre_sesion_controlador();
	}

include'Conexion-view.php';

$codigo=$_POST["cod"];
$cuest1=$_POST["cues1"];

 	$cuest2=$_POST["cues2"];

 	$cuest3=$_POST["cues3"];

 	$cuest4=$_POST["cues4"];

 	$cuest5=$_POST["cues5"];

 	$cuest6=$_POST["cues6"];

 	$cuest7=$_POST["cues7"];

 	$cuest8=$_POST["cues8"];

 	$cuest9=$_POST["cues9"];


 	$prom=$cuest1+$cuest2+$cuest3+$cuest4+$cuest5+$cuest6+$cuest7+$cuest8+$cuest9;
 	

$ini = new DateTime();
$inicio= $ini->format('Y-m-d H:i:s');
echo $inicio;

$fin = new DateTime();
$fin->modify('+60 second');
$finalidad= $fin->format('Y-m-d H:i:s');
echo $finalidad;
echo "<br>";


$result=$mysqli->query("INSERT INTO paciente(CuentaCodigo,inicio,fin,porcentaje_cuestionario) VALUES ('$codigo','$inicio','$finalidad','$prom')");

$resultado  = $mysqli->query($result);

echo "<script> window.location='vistas/contenidos/modelo-view.php?ini=$inicio&fn=$finalidad&cod=$codigo&por=$prom'; </script>";

?>