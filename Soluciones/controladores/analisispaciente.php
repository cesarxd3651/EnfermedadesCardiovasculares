<?php
// si es peticiion ajax itenemos q regrsar una carpeta atras
// else simplemente incluimos el archivo en la carpeta
if ($peticionAjax) {
		require_once "../modelos/pacienteModelo.php";
	}else{
		require_once "./modelos/pacienteModelo.php";
	}

	class pacienteControlador extends pacienteModelo{
		public function agregar_paciente_controlador(){

			$dni=mainModel::limpiar_cadena($_POST['dni-reg']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
			$apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
			$ocupacion=mainModel::limpiar_cadena($_POST['ocupacion-reg']);
			$direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);

			$usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
			$password1=mainModel::limpiar_cadena($_POST['password1']);
			$password2=mainModel::limpiar_cadena($_POST['password2']);
			$email=mainModel::limpiar_cadena($_POST['email-reg']);
			$genero=mainModel::limpiar_cadena($_POST['optionsGenero']);
			$privilegio=4;

			if ($genero=="Masculino") {
				$foto="Male2Avatar.png" ;
			}else{
				$foto="Female2Avatar.png";
			}
			//validar que las contraseñas coincidan
			if ($password1!=$password2) {
				$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Algo salió mal",
						"Texto"=>"Las contraseñas no coinciden",
						"Tipo"=>"error"
						];
			}else{
				//validar si esta el dni registrado
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT ClienteDNI FROM cliente WHERE ClienteDNI='$dni'");
				if ($consulta1->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Algo salió mal",
						"Texto"=>"Ya existe dni registrado",
						"Tipo"=>"error"
						];
				}else{
					//validar si el email esta registrado
					if ($email!="") {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
						$ec=$consulta2->rowCount();
					}else{
						$ec=0;
					}
					if ($ec>=1) {

						$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Algo salió mal",
						"Texto"=>"Email ya esta registrado okis",
						"Tipo"=>"error"
						];
					}else{
						// validar si esta registrado el usuario
						$consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'");
						if ($consulta3->rowCount()>=1) {
								$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"eL USUARIO YA ESTA REGISTRADO :( ",
										"Tipo"=>"error"
									];
						}else{
 	
							$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta ");

							$numero=($consulta4->rowCount())+1;

							//generar codigo para cada cuenta
							$codigo=mainModel::generar_codigo_aleatorio("CC", 7 , $numero);
							$clave=mainModel::encryption($password1);

							$dataAc=[
										"Codigo"=>$codigo,
										"Privilegio"=>$privilegio,
										"Usuario"=>$usuario,
										"Clave"=>$clave,
										"Email"=>$email,
										"Estado"=>"Activo",
										"Tipo"=>"Cliente",
										"Genero"=>$genero,
										"Foto"=>$foto
									];
									$guardarCuenta=mainModel::agregar_cuenta($dataAc);
									if ($guardarCuenta->rowCount()>=1) {
										$dataCli=[
													"DNI"=>$dni,
													"Nombre"=>$nombre,
													"Apellido"=>$apellido,
													"Telefono"=>$telefono,
													"Ocupacion"=>$ocupacion,
													"Direccion"=>$direccion,
													"Codigo"=>$codigo
												 ];
										$guardarCliente=pacienteModelo::agregar_paciente_modelo($dataCli);	

										if ($guardarCliente->rowCount()>=1) {
											 	$alerta=[
														"Alerta"=>"limpiar",
														"Titulo"=>"Paciente registrado por fin csm",
														"Texto"=>"el paciente registrado en el sistema",
														"Tipo"=>"success"
													]; 
											 }else{
											 mainModel::eliminar_cuenta($codigo);
											 	$alerta=[
														"Alerta"=>"simple",
														"Titulo"=>"Algo salió mal",
														"Texto"=>"esto tambien puede salir csm ,NO PUDIMOS REGISTRAR EL PACIENTE ",
														"Tipo"=>"error"
													]; 
												}
									}else{
										$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"DE SEGURO VA SALIR ESTO CSM ,NO PUDIMOS REGISTRAR EL PACIENTE ",
										"Tipo"=>"error"
									];
								}
						}
					}
				}

			}
			return mainModel::sweet_alert($alerta);
		}


		public function paginador_paciente_controlador($pagina, $registros, $privilegio,$busqueda){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina=(isset($pagina) && $pagina>0 )? (int) $pagina : 1;
			$inicio=($pagina>0)?(($pagina*$registros)-$registros) : 0;

			if (isset($busqueda) && $busqueda!="") {
				# SQL_CALC_FOUND ROWS es para calcular los registros en la base de datos
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (ClienteDNI LIKE '%$busqueda%' OR ClienteNombre LIKE '%$busqueda%' OR ClienteApellido LIKE '%$busqueda%' OR ClienteTelefono LIKE '%$busqueda%' ) ORDER BY ClienteNombre ASC LIMIT $inicio,$registros ";
				$paginaurl="pacientesearch";
			}	else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente where ClienteDNI='$dni' ORDER BY ClienteNombre ASC LIMIT $inicio,$registros ";
				$paginaurl="pacientelist";
				}
			
			//falta comentar ver video de paginador de administrador
			$conexion =mainModel::conectar();
			$datos=$conexion->query($consulta);
			$datos=$datos->fetchAll();

			$total=$conexion->query("SELECT FOUND_ROWS()");
			$total=(int) $total->fetchColumn();
			$Npaginas=ceil($total/$registros);

			$tabla.='
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">DNI</th>
							<th class="text-center">NOMBRES</th>
							<th class="text-center">APELLIDOS</th>
							<th class="text-center">TELEFONO</th>
							<th class="text-center">A.REALIZADOS</th>';

						if ($privilegio<=2) {
							# SI EL PRIVILEGIO ES MENOR O IGUAL A DOS SI PUEDE ACTUALIZAR O ELIMINAR LOS DATOS DE LA CUENTA
							$tabla.='
									<th class="text-center">A.CUENTA</th>
									<th class="text-center">A.DATOS</th>
									';

						}
						if ($privilegio==1) {
							# ES ADMINISTRADOR Y PUEDE ELIMINAR- CONTROL TOTAL DEL SISTEMA
							$tabla.='
									<th class="text-center">ELIMINAR</th>
							<th class="text-center">ANALIZAR</th>
							';
						}
						$tabla.='</tr>
								 </thead>
								 <tbody>
								';
						if ($total>=1 && $pagina<=$Npaginas) {
							# code...
							$contador=$inicio+1;
							foreach ($datos as $rows) {
								# code...
								$tabla.='
										<td>'.$contador.'</td>
										<td>'.$rows['ClienteDNI'].'</td>
										<td>'.$rows['ClienteNombre'].'</td>
										<td>'.$rows['ClienteApellido'].'</td>
										<td>'.$rows['ClienteTelefono'].'</td>
													<td>
														<form method="POST" action='.SERVERURL.'analisislist/'.'> 

														<input type="hidden" name="cod" value='.
														($rows['CuentaCodigo']).' >
														<input type="hidden" name="privilegio" value='.
														$_SESSION['privilegio_sbm'].' >
														<input type="submit" value="Ver" class="btn btn-warning btn-raised btn-xs">


														</form>
													</td>';

										if ($privilegio<=2) {
											# code...
											$tabla.='
													<td>
														<a href="'.SERVERURL.'myaccount/user/'.
														mainModel::encryption($rows['CuentaCodigo']).'/"
														class="btn btn-success btn-raised btn-xs">
														<i class="zmdi zmdi-refresh"></i>
														</a>
													</td>
													<td>
														<a href="'.SERVERURL.'mydata/user/'.
														mainModel::encryption($rows['CuentaCodigo']).'/"
														class="btn btn-success btn-raised btn-xs">
														<i class="zmdi zmdi-refresh"></i>
														</a>
													</td>
												';

										}
										if ($privilegio==1) {
											# code...
											$tabla.='
													<td>
														<form action="'.SERVERURL.'ajax/pacienteAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">

														<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
														<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
														<button type="submit" class="btn btn-danger btn-raised btn-xs">
														<i class="zmdi zmdi-delete"></i></button>
														<div class="RespuestaAjax"></div>
													</form>
												</td>

												

												<td>
														<form method="POST" action='.SERVERURL.'analisis/'.'> 

														<input type="hidden" name="cod" value='.
														($rows['CuentaCodigo']).' >
														<input type="submit" value="Analizar" class="btn btn-primary btn-raised btn-xs">


														</form>
													</td>
													
											';

										}
									$tabla.='</tr>';
									$contador++;
							}
						}

							else{
								if ($total>=1) {
									# code...
									$tabla.='
											<tr>

												<td colspan="8"> 
													<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
														HAGA CLICK BBCITO PARA RECAARGAR LISTADO MASCOTA
													</a>
												</td>
											</tr>
										';
									}else{
										$tabla.='
												<tr>
													<td colspan="8">NO HAY REGISTROS VICUÑA XD</td>
												</tr>
											';

									}
								}
								$tabla.='</tbody></table></div>';
								//paginador
								if ($total>=1 && $pagina<=$Npaginas) {
									# code...
									$tabla.='<nav class="text-center"><ul class="pagination pagination-sm">';
									if ($pagina==1) {
										# code...
										$tabla.='<li class="disabled><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
									}else{
										$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
									}
									for ($i=1; $i<=$Npaginas ; $i++) { 
										# code...
										if ($pagina==$i) {
											# code...
											$tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
										}else{
											$tabla.='<li><a href="'.SERVERRURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
										}
									}
									if ($pagina==$Npaginas) {
										# code...
										$tabla.='<li class="disabled><a><i class="zmdi zmdi-arrow-rigtht"></i></a></li>';
									}else{
										$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
									}
									$tabla.='</ul></nav>';
					}
								return $tabla;
			}

				// a la funcion sin parametros, porque utilziamos el metodo post, porque la varibles son globales y podemos utilizar directamente dentro de esta funcion
		public function eliminar_paciente_controlador(){	

				$codigo=mainModel::decryption($_POST['codigo-del']);
				$privilegio=mainModel::decryption($_POST['privilegio-admin']);

				// 1 paso comprobar si el administrador que esta intentando eliminar al cliente
				//tiene los permisos necesarios
				if ($privilegio==1) {
					
					$DelPaciente=pacienteModelo::eliminar_paciente_modelo($codigo);
					mainModel::eliminar_bitacora($codigo);

					//Si, se ha eliminado el registro, es porque si se pudo eliminar el resgristo de la tabla paciente
					if ($DelPaciente->rowCount()==1) {
						
						// ahora despues de eliminar al paciente, eliminamos su cuenta
						$DelCuenta=mainModel::eliminar_cuenta($codigo);

						//comprobamos si s3e eliminó la cuenta, del paciente eliminado
						if ($DelCuenta->rowCount()==1) {
							$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Paciente eliminado",
									"Texto"=>"Se eliminó al paciente y su cuenta en su totalidad. Éxito. ",
									"Tipo"=>"success"
								];
						}else{
							$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Algo salió mal",
									"Texto"=>"No se pudo eliminar al paciente, porque la cuenta no se puede eliminar ",
									"Tipo"=>"error"
								];
						}

					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"No se puedo eliminar al paciente u_u ",
							"Tipo"=>"error"
								];
					}
				}else{
					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"Tú no tienes los permisos necesaros para realizar esta operacion ",
							"Tipo"=>"error"
								];
					}

				return mainModel::sweet_alert($alerta);
		}	

		public function datos_paciente_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return pacienteModelo::datos_paciente_modelo($tipo,$codigo);
		}	

		public function actualizar_paciente_controlador(){
			$cuenta=mainModel::decryption($_POST['cuenta-up']);
			$dni=mainModel::limpiar_cadena($_POST['dni-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
			$apellido=mainModel::limpiar_cadena($_POST['apellido-up']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
			$ocupacion=mainModel::limpiar_cadena($_POST['ocupacion-up']);
			$direccion=mainModel::limpiar_cadena($_POST['direccion-up']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE CuentaCodigo='$cuenta' ");
			$DatosPaciente=$query1->fetch();

			//comprobando dni
			if ($dni!=$DatosPaciente['ClienteDNI']) {
				
				//comprobando que si es igual, con una consulta a la bd
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT ClienteDNI FROM cliente WHERE ClienteDNI='$dni' ");
				//comprobamos si hay un registro afectado con ese dni, no se puede actualizar. se manda error
				if ($consulta1->rowCount()==1) {
					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"DNI QUE ACABA DE INGRESAR YA SE ENCUENTRA REGISTRADO DE UN PACIENTE",
							"Tipo"=>"error"
							];
						return mainModel::sweet_alert($alerta);
						exit();

				}
			}
			// aqui se sustituye los marcodres de la function del modelo
			$dataPa=[
						"DNI"=>$dni,
						"Nombre"=>$nombre,
						"Apellido"=>$apellido,
						"Telefono"=>$telefono,
						"Ocupacion"=>$ocupacion,
						"Direccion"=>$direccion,
						"Codigo"=>$cuenta
			];
			//pasar los datos al modelo
			if (pacienteModelo::actualizar_paciente_modelo($dataPa)) {
				$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Excelente",
						"Texto"=>"Datos Actualizados bbito",
						"Tipo"=>"success"
						];

		}else{
			$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Excelente",
						"Texto"=>"No se ha podido actualizar los datos",
						"Tipo"=>"error"
						];

		}
		return mainModel::sweet_alert($alerta);
		//despues de acabar la function, se tiene q programar el ajax
	}
}
		