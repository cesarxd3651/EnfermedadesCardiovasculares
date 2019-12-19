<?php
	if ($_SESSION['tipo_sbm']!= "Administrador") {
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Usuarios <small>PACIENTES</small></h1>
			</div>
			<p class="lead">Buscar Paciente</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">

				<?php if ( $_SESSION['privilegio_sbm']<= 2 ): ?>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>paciente/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO PACIENTE
			  		</a>
			  	</li>
			  <?php endif;?> 
			  	<li>
			  		<a href="<?php echo SERVERURL;?>pacientelist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PACIENTES
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>pacientesearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR PACIENTES
			  		</a>
			  	</li>
			</ul>
		</div>
		<!-- para comprobar, si busqueda viene vacio, solo muestra el primer formulario de quien estas buscando, y si vieene definido, mostrar eliminar busqueda y tabla -->
		<?php if (!isset($_SESSION['busqueda_paciente']) && empty($_SESSION['busqueda_paciente'])): 
			# code...
		?>
		<div class="container-fluid">
			<form class="well FormularioAjax" action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
				<div class="row">
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<div class="form-group label-floating">
							<span class="control-label">¿A quién estas buscando?</span>
							<input class="form-control" type="text" name="busqueda_inicial_paciente" required="">
						</div>
					</div>
					<div class="col-xs-12">
						<p class="text-center">
							<button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
						</p>
					</div>
				</div>
				<div class="RespuestaAjax"></div>
			</form>
		</div>
<?php else: ?>
		<div class="container-fluid">
			<form class="well FormularioAjax" action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
				<p class="lead text-center">Su última búsqueda  fue <strong>"<?php echo $_SESSION['busqueda_paciente'] ?></strong>"</p>
				<div class="row">
					<input type="hidden" name="eliminar_busqueda_paciente" value="destruir">
					<div class="col-xs-12">
						<p class="text-center">
							<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
						</p>
					</div>
				</div>
				<div class="RespuestaAjax"></div>
			</form>
		</div>

		<!-- Panel listado de busqueda de clientes -->
		<div class="container-fluid">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR PACIENTE</h3>
				</div>
				<div class="panel-body">
					<?php

						require_once "./controladores/pacienteControlador.php";
						$insPaciente = new pacienteControlador();
					// exlpode para poder divir en partes un valor, en este caso lo q viene en el url
						$pagina = explode("/", $_GET['views']);
						echo $insPaciente->paginador_paciente_controlador($pagina[1],10, $_SESSION['privilegio_sbm'],$_SESSION['busqueda_paciente']);
					 ?>
				</div>
			</div>
		</div>
		<?php endif; ?>