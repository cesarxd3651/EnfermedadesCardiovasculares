<?php
	if ($_SESSION['tipo_sbm']!= "Administrador") {
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Control de Citas <small>CITAS REGISTRADAS</small></h1>
			</div>
			<p class="lead">Listado citas registradas</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL;?>cita/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA CITA
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>citalist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CITAS REGISTRAS
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>citasearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR CITA
			  		</a>
			  	</li>
			</ul>
		</div>
		<?php
			require_once "./controladores/citaControlador.php";
			$insCita = new citaControlador();
		 ?>
		<!-- Panel listado de clientes -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CITAS</h3>
				</div>
				<div class="panel-body">
					<?php
					// exlpode para poder divir en partes un valor, en este caso lo q viene en el url
						$pagina = explode("/",$_GET['views']);
						echo $insCita->paginador_cita_controlador($pagina[1],10,$_SESSION['privilegio_sbm'],$_SESSION['codigo_cuenta_sbm'],"");
					 ?>
				</div>
			</div>
		</div>