<?php
if ($_SESSION['tipo_sbm']!= "Administrador" || $_SESSION['privilegio_sbm']>2) {
		echo $lc->forzar_cierre_sesion_controlador();
	}
include'Conexion-view.php';

$codigo=$_POST["cod"];

$result = $mysqli->query("SELECT * from cliente where CuentaCodigo ='".$codigo."'");
while ($row = mysqli_fetch_array($result)){


?>

<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Usuarios <small>PACIENTES</small></h1>
			</div>
			<p class="lead">Formulario de Paciente</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL;?>paciente" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; ANALIZAR PACIENTE
			  		</a>
			  	</li>
			</ul>
			<i class="lead">DNI :</i><h4><?php echo $row["ClienteDNI"];  ?></h4>
			<i class="lead">Nombres :</i><h4><?php echo $row["ClienteNombre"];  ?></h4>
			<i class="lead">Apellidos :</i><h4><?php echo $row["ClienteApellido"]; ?></h4>

			<!--  
			<form action="<?php echo SERVERURL;?>insertpaciente/" method="POST">
				<input type="hidden" name="cod" value="<?php echo $row["CuentaCodigo"]; ?>" >
				
				<input type="submit"  value="Iniciar Analisis"  class="btn btn-success ">
			</form>
			-->
			<form action="<?php echo SERVERURL;?>cuestionario/" method="POST">
				<input type="hidden" name="cod" value="<?php echo $row["CuentaCodigo"]; ?>" >
				
				<input type="submit"  value="Iniciar Pre-Analisis"  class="btn btn-success ">
			</form>


		</div>
		<?php
	}
		?>