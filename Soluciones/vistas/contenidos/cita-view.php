
<?php 
if ($_SESSION['tipo_sbm']!= "Administrador" || $_SESSION['privilegio_sbm']>2) {
		echo $lc->forzar_cierre_sesion_controlador();
	}

require_once "Conexion-view.php";

?>
<head>
    <script src="<?php echo SERVERURL; ?>vistas/js/jquery.js"></script> 
     <script src="<?php echo SERVERURL; ?>vistas/js/bootstrap-datetimepicker.min.js"></script>
</head>
<style style="text/css">
  	.hoverTable{
		width:100%; 
		border-collapse:collapse; 
	}
	.hoverTable td{ 
		padding:7px;  1px solid;
	}
	/* Define the default color for all the table rows */
	
	/* Define the hover highlight color for the table row */
    .hoverTable tr:hover {
          background-color: #ffff99;
    }
</style>


	


<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Control de Citas <small>Clínica Baca&Mariños</small></h1>
			</div>
			<p class="lead">Control de citas de pacientes de la Clínica Baca&Mariños</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="company.html" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA CITA
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL;?>citalist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CITAS REGISTRADAS
			  		</a>
			  	</li>
			</ul>
		</div>
		
		<!-- panel datos de la paciente -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DE LA CITA</h3>
				</div>
				<div class="panel-body">
					<form action="<?php echo SERVERURL;?>ajax/citaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos del paciente</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6" style="height:130px;">
								    	<div class="form-group label-floating">
										  	<span class="control-label"><b>Seleccionar paciente</b></span>
										  	<button type="button" data-backdrop="false" data-toggle="modal" data-backdrop="false" data-target="#exampleModal" class="form-control btn btn-info btn-success"  name="btn_buscar"> <i class="zmdi zmdi-accounts"></i> Seleccionar</button>
										</div>
				    				</div>
				    				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 						 				<div class="modal-dialog" role="document">
    										<div class="modal-content">
      											<div class="modal-header">
        										<h3 class="modal-title" id="exampleModalLabel"> <b>Pacientes registrados</b></h3>
        										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          										<span aria-hidden="true">&times;</span>
       											</button>
      											</div>
      										<div class="modal-body">
       										
         										 <table class=" hoverTable" id="tblGrid">
         										 	
	           										<?php include 'tabla-paciente.php'?>
          												</table>
      										</div>

      										<div class="modal-footer">
									        <button id="cerrar" type="button" class="btn btn-warning btn-info btn-raised btn-sm" data-dismiss="modal"><i class="zmdi zmdi-close-circle"></i> Cerrar</button>		
									      </div>

									    </div>

									  </div>

								</div>
				    				<div class="col-xs-12 col-sm-6" style="height:130px;">
								    	<div class="form-group label-floating">
										  	<span class="control-label"><b>Fecha y Hora</b></span>
										  	<div class='input-group date' id='datetimepicker9'>
                							<input required="" type='text' name="fecha" class="form-control" />
                							<span class="input-group-addon">
                    						<span class="glyphicon glyphicon-calendar">
                    						</span>
                						</span>
            							</div>
										</div>
										<script type="text/javascript">
        								$(function () {
            								$('#datetimepicker9').datetimepicker({
                							
            									});

        										});

    									</script>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label"><b>Nombre Paciente</b></span>
										  	<input id="nombre" disabled pattern="[0-9+]{1,15}" class="form-control" type="text" name="nombre-paciente" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label"><b>Apellido Paciente</b></span>
										  	<input id="apellido" disabled class="form-control" type="text" name="apellido-reg" maxlength="50">
										</div>
				    				</div>
								</div>
										  	<input id="codigopaciente"  class="form-control" type="hidden" name="codigopaciente" maxlength="50">

				    	</fieldset>
				    	<br>



				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos del Doctor</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6" style="height:130px;">
								    	<div class="form-group label-floating">
										  	<span class="control-label"><b>Seleccionar Doctor</b></span>
										  	<button type="button" data-backdrop="false" data-toggle="modal" data-backdrop="false" data-target="#ModalDoctor" class="form-control btn btn-info btn-success"  name="btn_buscar"> <i class="zmdi zmdi-accounts"></i> Seleccionar</button>
										</div>
				    				</div>
				    				<div class="modal fade" id="ModalDoctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 						 				<div class="modal-dialog" role="document">
    										<div class="modal-content">
      											<div class="modal-header">
        										<h3 class="modal-title" id="exampleModalLabel"> <b>Doctores Disponibles</b></h3>
        										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          										<span aria-hidden="true">&times;</span>
       											</button>
      											</div>
      										<div class="modal-body">
       										
         										 <table class=" hoverTable" id="tblGrid">
         										 	
	           										<?php include 'tabla-doctor.php'?>

          										</table>
      										</div>

      										<div class="modal-footer">
									        <button id="cerrardoc" type="button" class="btn btn-warning btn-info btn-raised btn-sm" data-dismiss="modal"><i class="zmdi zmdi-close-circle"></i> Cerrar</button>		
									      </div>

									    </div>

									  </div>

								</div>
				    				
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label"><b>Nombre de Doctor</b></span>
										  	<input id="nombredoctor" disabled pattern="[0-9+]{1,15}" class="form-control" type="text" name="nombre-doctor" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label"><b>Apellido de Doctor</b></span>
										  	<input id="apellidodoctor" disabled class="form-control" type="text" name="apellido-doctor" maxlength="50">
										</div>
				    				</div>
								</div>
										  	<input id="codigodoctor"  readonly="" class="form-control" type="hidden" name="codigodoctor" maxlength="50">

				    	</fieldset>
				    	<br>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Otros datos de la cita</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
							    		<div class="form-group label-floating">
										  	<span class="control-label"><b>Asunto</b></span>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="asunto-cita" required="" maxlength="500">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
							    		<div class="form-group label-floating">
										  	<span class="control-label"><b>Estado cita</b></span>
										  	<input class="form-control" disabled 	type="text" name="moneda-reg" value="Pendiente" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
							    		<div class="form-group label-floating">
										  	<span class="control-label"><b>Lugar de Cita</b></span>
										  	<input  class="form-control" type="text" name="lugar-cita" required="" maxlength="40">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
					    <div class="RespuestaAjax"></div>
				    </form>
				</div>
			</div>
		</div>
	<script type="text/javascript">
   function EnviarDatos(datos){
    d=datos.split('||');
    $('#nombre').val(d[0]);
    $('#apellido').val(d[1]);
    $('#codigopaciente').val(d[3]);
    $('#cerrar').click();
    
   }
	</script>	


	<script type="text/javascript">
	$(document).ready(function(){
    $('#cerrar').click();
    })
	</script>
	<script type="text/javascript">

   function EnviarDatosDoctor(datos){
    d=datos.split('||');
    $('#nombredoctor').val(d[0]);
    $('#apellidodoctor').val(d[1]);
    $('#codigodoctor').val(d[2]);
    $('#cerrardoc').click();
    
   }
	</script>	


	<script type="text/javascript">
	$(document).ready(function(){
    $('#cerrardoc').click();
    })
	</script>


   