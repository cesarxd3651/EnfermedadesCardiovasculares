<?php

include'Conexion-view.php';
$codigo="";

if (isset($_POST["cod"])) {
	# code...
$codigo=$_POST["cod"];

}elseif ( isset($_GET["cod"])) {
	# code...

$codigo=$_GET["cod"];

}


?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Analisis <small>de Pacientes</small></h1>
			</div>


							<?php

				$result = $mysqli->query("SELECT ClienteNombre,ClienteApellido  from cliente where CuentaCodigo ='".$codigo."' ");
				while ($row = mysqli_fetch_array($result)){
							?>
			<p class="lead">Lista de analisis del paciente: <?php echo $row["ClienteNombre"];?> <?php echo $row["ClienteApellido"];}?> </p>
		</div>
		<?php 
			require_once "./controladores/administradorControlador.php";
			$insAdmin= new  administradorControlador();

		?>
		<!-- Panel listado de administradores -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ANALISIS</h3>
				</div>
		 <!-- mostrar inicio-->
				<div class="panel-body">
					<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">FECHA DE ANALISIS</th>
							<th class="text-center">VER ANALISIS</th>

						</tr>
				</thead>
				 <tbody>



							<?php

				$result = $mysqli->query("SELECT CuentaCodigo,inicio,fin,porcentaje_cuestionario  from paciente where CuentaCodigo ='".$codigo."' ");
				while ($row = mysqli_fetch_array($result)){
							?>
						<tr>
										<form method="GET" action='<?php echo SERVERURL;?>vistas/contenidos/vista-view.php'> 
										<td><?php echo $row["inicio"];?></td>
										<td>
										<input type="hidden" name="a" value='<?php echo $row["inicio"];?>' >
										<input type="hidden" name="b" value='<?php echo $row["fin"];?>' >
										<input type="hidden" name="c" value='<?php echo $row["CuentaCodigo"];?>' >
										<input type="hidden" name="d" value='<?php echo $row["porcentaje_cuestionario"];?>' >
										<input type="submit" value="Ver" class="btn btn-primary btn-raised btn-xs">
										</form>
									<?php } ?>
										</td>
								</tr>		
				</div>
			</div>
		</div>