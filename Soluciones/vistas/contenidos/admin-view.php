
<!-- para saber si es administrador para no mostrar otras funciones de lavista como eliminar, etc-->
<?php
	if ($_SESSION['tipo_sbm']!= "Administrador") {
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>ADMINISTRADORES</small></h1>
			</div>
			<p class="lead">Sistema web clínica Baca & Mariños</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<?php if ( $_SESSION['privilegio_sbm']== 1 ): ?>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>admin/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ADMINISTRADOR
			  		</a>
			  	</li>
			    <?php endif; ?>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>adminlist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>adminsearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR
			  		</a>
			  	</li>
			</ul>
		</div>
 
		<!-- Panel nuevo administrador -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ADMINISTRADOR</h3>
				</div>
				<div class="panel-body">
					<form action="<?php echo SERVERURL;?>ajax/AdministradorAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
				    	
				<?php if ( $_SESSION['privilegio_sbm']== 1 ): ?>
				    	<fieldset> 
				    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
										  	<label class="control-label">DNI *</label>
										  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="8">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Apellidos *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-reg" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Teléfono</label>
										  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Dirección</label>
										  	<textarea name="direccion-reg" class="form-control" rows="2" maxlength="100"></textarea>
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-key"></i> &nbsp; Datos de la cuenta</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
							    		<div class="form-group label-floating">
										  	<label class="control-label">Nombre de usuario *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="usuario-reg" required="" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Contraseña *</label>
										  	<input class="form-control" type="password" name="password1-reg" required="" maxlength="70">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Repita la contraseña *</label>
										  	<input class="form-control" type="password" name="password2-reg" required="" maxlength="70">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">E-mail</label>
										  	<input class="form-control" type="email" name="email-reg" maxlength="50">
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group">
											<label class="control-label">Genero</label>
											<div class="radio radio-primary">
												<label>
													<input type="radio" name="optionsGenero" id="optionsRadios1" value="Masculino" checked="">
													<i class="zmdi zmdi-male-alt"></i> &nbsp; Masculino
												</label>
											</div>
											<div class="radio radio-primary">
												<label>
													<input type="radio" name="optionsGenero" id="optionsRadios2" value="Femenino">
													<i class="zmdi zmdi-female"></i> &nbsp; Femenino
												</label>
											</div>
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>

				    	<br>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-star"></i> &nbsp; Nivel de privilegios</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
							    		<p class="text-left">
					                        <div class="label label-success">Nivel 1</div> (Control total del sistema)
					                    </p>
					                    <p class="text-left">
					                        <div class="label label-primary">Nivel 2</div> (Tipo Doctor)
					                    </p>
					                    <p class="text-left">
					                        <div class="label label-info">Nivel 3</div> (Solo lectura)
					                    </p>
				    				</div>
				    				<?php if ($_SESSION['privilegio_sbm']==1): ?>
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios1" value="<?php echo $lc->encryption(1); ?>">
												<i class="zmdi zmdi-star"></i> &nbsp; 
											</label>
										</div>
										<?php 
											endif;
											if ($_SESSION['privilegio_sbm']<=2):
										?>
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios2" value="<?php echo $lc->encryption(2); ?>">
												<i class="zmdi zmdi-star"></i> &nbsp; 
											</label>
										</div>
										<?php endif ;?>
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios3" value="<?php echo $lc->encryption(3); ?>" checked=""> 
												<i class="zmdi zmdi-star"></i> &nbsp; 
											</label>
										</div>
				    				</div>
				    			</div>
				    	</fieldset>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
					    <div class="RespuestaAjax"></div>
				    </form>

				<?php  endif; ?>
				</div>
			</div>
		</div>