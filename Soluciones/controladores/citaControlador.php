<?php  
if ($peticionAjax) {
		require_once "../modelos/citaModelo.php";
	}else{
		require_once "./modelos/citaModelo.php";
	}
	class citaControlador extends citaModelo {
		//function para agregar administrador

		public function agregar_cita_controlador(){
			//utilizando funcion del mainmodel para evitar inyeccion sql
			//CAPTURAR LOS DATOS DEL FORMULARIO EN VARIABLES $
			$ini = new DateTime($_POST['fecha']);
			$fechini= $ini->format('Y-m-d H:i');

			$fin = new DateTime($fechini);
			$fin->modify('+60 minutes');
			$fechfin= $fin->format('Y-m-d H:i');

			$codpac=mainModel::limpiar_cadena($_POST['codigopaciente']);
			$coddoc=mainModel::limpiar_cadena($_POST['codigodoctor']);
			$asuncita=mainModel::limpiar_cadena($_POST['asunto-cita']);
			$lugcita=mainModel::limpiar_cadena($_POST['lugar-cita']);

				
							// consulta4, para contar cuantos registros se tiene.
							$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cita ");
							//numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
							$numero=($consulta4->rowCount())+1;
 
							//generar codigo para cada cuenta
							$codigo=mainModel::generar_codigo_aleatorio("CI", 7 , $numero);

							$dataAC=[
								"citcod"=>$codigo,
								"codpac"=>$codpac,
								"coddoc"=>$coddoc,
								"fechini"=>$fechini,
								"fechfin"=>$fechfin,
								"estado"=>"1",
								"asuncita"=>$asuncita,
								"lugcita"=>$lugcita
						];


					$fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
					$fecha_entrada = strtotime($fechini);
				//rowcount devuelve numero de fila afectadas por la consulta
				// if, si hay un dni identico al q queremos registrar, mandamos un error
				if ($fecha_actual>$fecha_entrada) {
								$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"La fecha no puede ser menor a la fecha actual",
										"Tipo"=>"error"
									];
				}else{

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT FechaInicioCita FROM cita WHERE FechaInicioCita<='$fechini' and FechaFinCita>='$fechini'");
					$cantidadrows=$consulta1->rowCount();
					if ($cantidadrows>=1) {
						
								$alerta=["Alerta"=>"simple",
										"Titulo"=>"Fecha invalida",
										"Texto"=>"El doctor ya tiene cita en esa fecha",
										"Tipo"=>"error"
									];
					}else{

						$consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM cita WHERE DAY(FechaInicioCita) like DAY('$fechini')");
							$cantidadrowscita=$consulta2->rowCount();

						if ($cantidadrowscita>=20) {
							$alerta=["Alerta"=>"simple",
										"Titulo"=>"Limite de Citas",
										"Texto"=>"La clinica alcanzó el limite de citas el dia establecido",
										"Tipo"=>"error"
									];
						}else{


							  if ($codpac=="") {

							  	$alerta=["Alerta"=>"simple",
										"Titulo"=>"Sin Paciente",
										"Texto"=>"Por favor seleccionar paciente",
										"Tipo"=>"error"
									];
							  }elseif ($coddoc=="") {
							  	
							  	$alerta=["Alerta"=>"simple",
										"Titulo"=>"Sin Doctor",
										"Texto"=>"Por favor seleccionar doctor",
										"Tipo"=>"error"
									];
							  }else{
							// Registro
								$guardarCuenta=citaModelo::agregar_cita_modelo($dataAC);
							//comprobando si se pudo insertar los datos en el admin tabla
							if ($guardarCuenta->rowCount()>=1) {

									$alerta=[
											"Alerta"=>"limpiar",
											"Titulo"=>"Cita registrada",
											"Texto"=>"Exito al registrar Cita",
											"Tipo"=>"success"
										];

							}else{
								$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"No se pudo registrar el administrador. ¡Ups!2",
										"Tipo"=>"error"
									];
							}
						   }	
						  }
						}
					}

			return mainModel::sweet_alert($alerta);
		
				}
		
			// verificar contraseñas coinciden con swett alert de mainmodel
			
		
		
		public function contar_citas(){

		$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cita ");

		$numero=($consulta4->rowCount());

		return $numero;

		}




		//function para paginar
		public function paginador_cita_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigo=mainModel::limpiar_cadena($codigo);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina=(isset($pagina) && $pagina>0 )? (int) $pagina : 1;
			$inicio=($pagina>0)?(($pagina*$registros)-$registros) : 0;

			if (isset($busqueda) && $busqueda!="") {
				# SQL_CALC_FOUND ROWS es para calcular los registros en la base de datos
				$consulta="SELECT SQL_CALC_FOUND_ROWS CitaCodigo,AdminNombre ,AdminApellido,cli.ClienteNombre,cli.ClienteApellido,ci.FechaInicioCita, ci.FechaFinCita,ci.AsuntoCita,ci.LugarCita,ci.EstadoCita from cita ci inner join admin ad on ci.CodigoDoctor=ad.CuentaCodigo inner join cliente cli on ci.CodigoPaciente=cli.CuentaCodigo WHERE ((CitaCodigo!='$codigo') AND (AsuntoCita LIKE '%$busqueda%' OR AdminNombre LIKE '%$busqueda%')) ORDER BY FechaInicioCita ASC LIMIT $inicio,$registros ";
				$paginaurl="citasearch";
			}	else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS CitaCodigo,AdminNombre ,AdminApellido,cli.ClienteNombre,cli.ClienteApellido,ci.FechaInicioCita, ci.FechaFinCita,ci.AsuntoCita,ci.LugarCita,ci.EstadoCita from cita ci inner join admin ad on ci.CodigoDoctor=ad.CuentaCodigo inner join cliente cli on ci.CodigoPaciente=cli.CuentaCodigo ORDER BY FechaInicioCita ASC LIMIT $inicio,$registros ";
				$paginaurl="citalist";
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
							<th class="text-center">DOCTOR</th>
							<th class="text-center">PACIENTE</th>
							<th class="text-center">FECHA INICIO</th>
							<th class="text-center">FECHA FIN</th>
							<th class="text-center">ESTADO</th>
							<th class="text-center">ASUNTO</th>
							<th class="text-center">LUGAR</th>';

						if ($privilegio<=2) {
							# SI EL PRIVILEGIO ES MENOR O IGUAL A DOS SI PUEDE ACTUALIZAR O ELIMINAR LOS DATOS DE LA CUENTA
							$tabla.='
									<th class="text-center">EDITAR CITA</th>
									';

						}
						if ($privilegio==1) {
							# ES ADMINISTRADOR Y PUEDE ELIMINAR- CONTROL TOTAL DEL SISTEMA
							$tabla.='
									<th class="text-center">ELIMINAR</th>
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
										<td>'.$rows['AdminNombre'].' '.$rows['AdminApellido'].'</td>
										<td>'.$rows['ClienteNombre'].' '.$rows['ClienteApellido'].'</td>
										<td>'.$rows['FechaInicioCita'].'</td>
										<td>'.$rows['FechaFinCita'].'</td>
										<td>'.$rows['EstadoCita'].'</td>
										<td>'.$rows['AsuntoCita'].'</td>
										<td>'.$rows['LugarCita'].'</td>';

										if ($privilegio<=2) {
											# code...
											$tabla.=
													
											'<td>
											<a href="'.SERVERURL.'pruebacita/admin/'.mainModel::encryption($rows['CitaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
												</a>
											</td>
												';

										}
										if ($privilegio==1) {
											# code...
											$tabla.='
													<td>
														<form action="'.SERVERURL.'ajax/citaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">

														<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CitaCodigo']).'">
														<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
														<button type="submit" class="btn btn-danger btn-raised btn-xs">
														<i class="zmdi zmdi-delete"></i></button>
														<div class="RespuestaAjax"></div>
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
				if ($total>=1 && $pagina<=$Npaginas){
				$tabla.='
						<nav class="text-center">
						<ul class="pagination pagination-sm">

				';
				if ($pagina==1) {
				$tabla.='
						<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>
				';
				}else{
						$tabla.='
						<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/" ><i class="zmdi zmdi-arrow-left"></i></a></li>
				';	
				}

				

				if ($pagina==$Npaginas) {
				$tabla.='
						<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>
				';
				}else{
						$tabla.='
						<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/" ><i class="zmdi zmdi-arrow-right"></i></a></li>
				';	
				}
				//los li

				$tabla.='
						</ul>
						</nav>
				';
			}
        	return $tabla;
		}





		public function eliminar_cita_controlador(){
			$codigo=mainModel::decryption($_POST['codigocita']);

			$codigo=mainModel::limpiar_cadena($codigo);

			//si el administrador que quiere eliminar, tiene el privilegio o permiso para eliminar

					$DelAdmin=citaModelo::eliminar_cita_modelo($codigo);
					//comprobar si se eliminar el reg de la tabla admin
						
							$alerta=["Alerta"=>"recargar",
										"Titulo"=>"Éxito",
										"Texto"=>"SE ELIMINO EL cita Y SUS DATOS EN LAS OTRAS TABLAS	",
										"Tipo"=>"success"
										];
						
			return mainModel::sweet_alert($alerta);
		}


		public function datos_cita_controlador($codigo){
			$codigo=mainModel::decryption($codigo);
			//$tipo=mainModel::limpiar_cadena($tipo);
			

			return citaModelo::datos_cita_modelo($codigo);
		}





		public function eliminar_administrador_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			//si el administrador que quiere eliminar, tiene el privilegio o permiso para eliminar
			if ($adminPrivilegio==1) {
				$query1=mainModel::ejecutar_consulta_simple("SELECT id FROM admin WHERE CuentaCodigo='$codigo'");
				$datosAdmin=$query1->fetch();

				if ($datosAdmin['id']!=1) {
					$DelAdmin=administradorModelo::eliminar_administrador_modelo($codigo);
					mainModel::eliminar_bitacora($codigo);
					//comprobar si se eliminar el reg de la tabla admin
					if ($DelAdmin->rowCount()>=1) {
						
						$DelCuenta=mainModel::eliminar_cuenta($codigo);
						if ($DelCuenta->rowCount()==1) {
							$alerta=["Alerta"=>"recargar",
										"Titulo"=>"Éxito",
										"Texto"=>"SE ELIMINO EL ADMINNISTRADOS Y SUS DATOS EN LAS OTRAS TABLAS	",
										"Tipo"=>"success"
										];
						}else{
							$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"No se puede eliminar el administrador en este momento, porque no se elimino la cuenta primero",
										"Tipo"=>"error"
										];
						}
					}else{
						$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"No se puede eliminar el administrador en este momento",
										"Tipo"=>"error"
										];
					}
				}else{
					$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"No se puede eliminar el administrador principal",
										"Tipo"=>"error"
									];
				}
			}else{
				$alerta=["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"No se puede eliminar, porque no tienes los permisos o privilegios necesarios para dicha accion",
										"Tipo"=>"error"
									];
			}
			return mainModel::sweet_alert($alerta);
		}

		public function datos_administrador_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return administradorModelo::datos_administrador_modelo($tipo,$codigo);
		}

		public function actualizar_administrador_controlador(){
			$cuenta=mainModel::decryption($_POST['cuenta-up']);
			$dni=mainModel::limpiar_cadena($_POST['dni-up']);

			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
			$apellido=mainModel::limpiar_cadena($_POST['apellido-up']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
			$direccion=mainModel::limpiar_cadena($_POST['direccion-up']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM admin WHERE CuentaCodigo='$cuenta' ");
			$DatosAdmin=$query1->fetch();

			if ($dni!=$DatosAdmin['AdminDNI']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM admin WHERE AdminDNI='$dni' ");
				//si existe el dni 
				if ($consulta1->rowCount()>=1) {
					$alerta=
										["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"DNI QUE ACABA DE INGRESAR YA SE ENCUENTRA REGISTRADO",
										"Tipo"=>"error"
									];
									return mainModel::sweet_alert($alerta);
									exit();
			 	}
			}

			$dataAd=[
						"DNI"=>$dni,
						"Nombre"=>$nombre,
						"Apellido"=>$apellido,
						"Telefono"=>$telefono,
						"Direccion"=>$direccion,
						"Codigo"=>$cuenta
			];
			//pasar los datos al modelo
			if (administradorModelo::actualizar_administrador_modelo($dataAd)) {
				$alerta=
										["Alerta"=>"recargar",
										"Titulo"=>"Excelente",
										"Texto"=>"Datos Actualizados bbito",
										"Tipo"=>"success"
									];
			}else{

				$alerta=
										["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"NO SE HA PODIDO ACTUALIZAR LOS DATOS",
										"Tipo"=>"error"
									];
			}
			return mainModel::sweet_alert($alerta);
		}

	}