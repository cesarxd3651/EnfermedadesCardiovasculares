
<?php 

require_once "Conexion-view.php";

?>
<head>
    <script src="<?php echo SERVERURL; ?>vistas/js/jquery.js"></script> 
     <script src="<?php echo SERVERURL; ?>vistas/js/bootstrap-datetimepicker.min.js"></script>
     <script src="<?php echo SERVERURL; ?>vistas/css/tabla.css"></script>

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">


    </style>
</head>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>Citas</small></h1>
			</div>
			<p class="lead">Administración de Citas</p>
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
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CITAS
			  		</a>
			  	</li>
			</ul>
		</div>



</head>
<body>





		<!-- panel datos de la empresa -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DE CITA</h3>
				</div>
				<div class="panel-body">
					<form>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-5">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres</label>
										  	<input id="nombre" readonly="" pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-5">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Apellidos</label>
										  	<input id="apellido" readonly="" pattern="[0-9-]{1,30}" class="form-control" type="text" required="" maxlength="30">
										</div>

										  	<input id="codigo"  type="text" hidden="">
										
				    				
				    				<div class="col-xs-12 col-sm-1">
								    	<div class="form-group label-floating">
										  	<span class="control-label"><b>Seleccionar paciente</b></span>
										  	<button type="button" data-backdrop="false" data-toggle="modal" data-backdrop="false" data-target="#exampleModal" class="form-control btn btn-info btn-success"  name="btn_buscar"> <i class="zmdi zmdi-accounts"></i> Seleccionar</button>
										</div>
				    				</div>
				    			</div>
				    		</div>

								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 						 				<div class="modal-dialog" role="document">
    										<div class="modal-content">
      											<div class="modal-header">
        										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          										<span aria-hidden="true">&times;</span>
       											</button>
      											</div>
      										<div class="modal-body">
         									<form >
		  										<h5 class="text-center">Seleccionar Paciente</h5>
         										 <table class="table table-striped" id="tblGrid">
	           										
          												</table>
         												 </form>
      										</div>

      										<div class="modal-footer">
									        <button type="button" class="btn btn-warning btn-info btn-raised btn-sm" data-dismiss="modal"><i class="zmdi zmdi-close-circle"></i> Cerrar</button>
									        <button type="button" class="btn btn-success btn-info btn-raised btn-sm"> <i class="zmdi zmdi-check-circle"></i> Aceptar</button>
									      </div>

									    </div>

									  </div>








				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label >Fecha</label>
				    				<input  class="form-control" required="" id="datepicker" width="276" />
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label>Hora</label>
				    				<input  class="form-control" required="" id="timepicker" width="276" />
										</div>
				    				</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
				    </form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
        $('#timepicker').timepicker();
        $('#datepicker').datepicker();

		</script>

		<script type="text/javascript">
   function EnviarDatos(datos){
    d=datos.split('||');
    $('#nombre').val(d[0]);
    $('#apellido').val(d[1]);
    $('#codigo').val(d[3]);
    $(document).ready(function(){
    $('#exampleModal').modal('hide');
    })
   }
		</script>		