<?php
if ($_SESSION['tipo_sbm']!= "Administrador" || $_SESSION['privilegio_sbm']>2) {
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>DiAGNOSTICO</small></h1>
			</div>
			<p class="lead"></p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL;?>diagnostico" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO DIAGNOSTICO
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>diagnosticolist" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE DIAGNOSTICOS
			  		</a>
			  	</li>
			</ul>
		</div>

		<!-- panel datos de la empresa -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL DIAGNOSTICO</h3>
				</div>
				<div class="panel-body">
					<form>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp; DIAGNOSTICOS MAS RECIENTES</legend>
				    		<fieldset>
				    		<legend><i class="zmdi zmdi-star"></i> &nbsp; Seleccionar Diagnostico</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
							    		<p class="text-left">
					                        Diagnostico 1
					                    </p>
					                    <p class="text-left">
					                       Diagnostico 2
					                    </p>
					                    <p class="text-left">
					                        Diagnotisco 3
					                    </p>
					                    <p class="text-left">
					                        Diagnotisco .....
					                    </p>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios1" value="1">
											</label>
										</div>
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios2" value="2">
												
											</label>
										</div>
										<div class="radio radio-primary">
											<label>
												<input type="radio" name="optionsPrivilegio" id="optionsRadios3" value="3" checked="">
												
											</label>
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	
					    </fieldset>
					   
				    </form>

				</div>
			</div>
			<a class="text-center" href="<?php echo SERVERURL;?>email/"  style="margin-top: 20px;">
			<button  type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-mail-send"></i> Enviar diagnostico por correo electrónico</button>
			</a>
		</div>