<?php
	if ($_SESSION['tipo_sbm']!= "Administrador" || $_SESSION['privilegio_sbm']>2) {
		echo $lc->forzar_cierre_sesion_controlador();
	}
if (isset($_POST["cod"])) {
	$codigo=$_POST["cod"];
}
	

?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Usuarios <small>PACIENTES</small></h1>
			</div>
			<p class="lead">Cuestionario</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="#" class="btn btn-primary">
			  			<i class = "zmdi zmdi-file-text"> </i> &nbsp; Cuestionario para detectar enfermedad
			  		</a>
			  	</li>
			</ul>
		</div>

		<!-- Panel nuevo cliente -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class = "zmdi zmdi-file-text"> </i> &nbsp; Cuestionario</h3>
				</div>
				<div class="panel-title-body">
					<form action="<?php echo SERVERURL;?>insertpaciente" method="POST" >
					
				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>1. ¿Sufre de agitación en el pecho?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues1" id="cues1a" value="4.54" checked="">
														<input type="hidden" value="<?php echo $codigo ?>" name="cod">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues1" id="cues1b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues1" id="cues1c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    				
				    	</fieldset>
				   
				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>2.¿Tiene dificultad para respirar?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues2" id="cues2a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues2" id="cues2b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues2" id="cues2c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>
				    
				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>3. ¿Consume algun tipo de drogas?</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues3" id="cues3a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues3" id="cues3b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues3" id="cues3c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>

				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>4. ¿Sufre de sudoracion excesiva?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues4" id="cues4a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues4" id="cues4b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues4" id="cues4c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>

				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>5. ¿Usted es fumador?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues5" id="cues5a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues5" id="cues5b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues5" id="cues5c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>


				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>6. ¿Consume demasiado alcohol o cafeína?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues6" id="cues7a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues6" id="cues7b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues6" id="cues7c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>

				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>7. ¿Sufre de estrés ?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues7" id="cues9a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues7" id="cues9b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues7" id="cues9c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>

				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>8. ¿Presenta dificultad para respirar?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues8" id="cues10a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues8" id="cues10b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues8" id="cues10c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
												</div>
				    						</div>
										</div>
									</div>
				    	</fieldset>

				    	<fieldset>
				    	
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
								    		<span><b>9. ¿En este año ha sufrido cómo minimo un desmayo?.</span></b> 
										 		<div class="col-xs-12">
													<div class="form-group">
														<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues9" id="cues11a" value="4.54" checked="">
														<b> <i class="zmdi zmdi-check"></i> &nbsp; SI
														</label></b>
														</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues9" id="cues11b" value="0">
														<i class="zmdi zmdi-block-alt"></i> &nbsp; NO
														</label>
													</div>
													<div class="radio radio-primary">
														<label>
														<input type="radio" name="cues9" id="cues11c" value="2.27">
														<i class = "zmdi zmdi-plus "> <i class="zmdi zmdi-minus"></i></i> &nbsp; A VECES
														</label>
													</div>
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