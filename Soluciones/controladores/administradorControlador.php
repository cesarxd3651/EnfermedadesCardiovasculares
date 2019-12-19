<?php  
if ($peticionAjax) {
		require_once "../modelos/administradorModelo.php";
	}else{
		require_once "./modelos/administradorModelo.php";
	}
	class administradorControlador extends administradorModelo {
		//function para agregar administrador

		public function agregar_administrador_controlador(){
			//utilizando funcion del mainmodel para evitar inyeccion sql
			//CAPTURAR LOS DATOS DEL FORMULARIO EN VARIABLES $
			$dni=mainModel::limpiar_cadena($_POST['dni-reg']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
			$apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
			$direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);

			$usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
			$password1=mainModel::limpiar_cadena($_POST['password1-reg']);
			$password2=mainModel::limpiar_cadena($_POST['password2-reg']);
			$email=mainModel::limpiar_cadena($_POST['email-reg']);
			$genero=mainModel::limpiar_cadena($_POST['optionsGenero']);
			$privilegio=mainModel::decryption($_POST['optionsPrivilegio']);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			if ($genero=='Masculino') {
				$foto="Male3Avatar.png";
			}else{
				$foto="Female3Avatar.png";
			}
			//
			if ($privilegio<1 || $privilegio>3) {
				
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"ERROR",
					"Texto"=>"NIVEL DE PRIVILEGIO NO EXISTE",
					"Tipo"=>"error"
				];
			}else{
				if ($password1!=$password2) {
				# code...
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Algo salió mal",
					"Texto"=>"Las contraseñas no coinciden",
					"Tipo"=>"error"
					];
			}else{
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM admin WHERE AdminDNI='$dni'");
				//rowcount devuelve numero de fila afectadas por la consulta
				// if, si hay un dni identico al q queremos registrar, mandamos un error
				if ($consulta1->rowCount()>=1) {
					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Algo salió mal",
							"Texto"=>"El dni ya está registrado",
							"Tipo"=>"error"
						];
				}else{
					if ($email!="") {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
						//guardar el total de registros afectados $ec -> emailcuenta abreviado
						$ec=$consulta2->rowCount();

					}else{
						// si $ec para identificar q no viene definido
						$ec=0;
					}
					// si ec es mayor o igual a 1, si hay un email registrado en la bd
					if ($ec>=1) {
						$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Algo salió mal",
								"Texto"=>"El email ya está registrado",
								"Tipo"=>"error"
							];
					}else{
						//si no, el email no esta registrado, validar usuario
						$consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'" );

						//si hay un registro en la bd con ese mismo usuario
						if ($consulta3->rowCount()>=1) {
							# mostramos error
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Algo salió mal",
								"Texto"=>"El usuario ya está registrado",
								"Tipo"=>"error"
								];
								// si pasa al else, seguimos validando
						}else{
							// consulta4, para contar cuantos registros se tiene.
							$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta ");
							//numero para guardar el total de registros que hay en la bd,  que lo contamos en la consulta 4
							$numero=($consulta4->rowCount())+1;

							//generar codigo para cada cuenta
							$codigo=mainModel::generar_codigo_aleatorio("AC", 7 , $numero);

							//encriptar la clave
							$clave=mainModel::encryption($password1);

							// indices tal cual del main model function agregar cuenta, en sustituir los marcadores , $datos ['tal cual a estos'] -> Y AL COSTADO LO DE ARRIBA 
							//LO DE AGREGAR ADMINISTRADOR CONTROLADOR. LO DE LO IZQUIERA ENTRE COMILLAS SON LOS INDICES DEL MODELO, Y LO DE LA DERECHA ES LO Q TOMA DE LOS INPUT DEL FORMULARIO
							$dataAC=[
								"Codigo"=>$codigo,
								"Privilegio"=>$privilegio,
								"Usuario"=>$usuario,
								"Clave"=>$clave,
								"Email"=>$email,
								"Estado"=>"Activo",
								"Tipo"=>"Administrador",
								"Genero"=>$genero,
								"Foto"=>$foto
						];

						$guardarCuenta=mainModel::agregar_cuenta($dataAC);
						// comprobamos si se ha registrado
						if ($guardarCuenta->rowCount()>=1) {
							//ndices tal cual function agregar administradormodelo.php, en sustituir los marcadores , $datos ['tal cual a estos'] => y esto $igual de la variable q recibe ese dato en el formulario en function agregar administrdor controlador()

							$dataAD=[
								"dni"=>$dni,
								"nom"=>$nombre,
								"ape"=>$apellido,
								"tel"=>$telefono,
								"direccion"=>$direccion,
								"codigo"=>$codigo
									];
										$guardarAdmin=administradorModelo::agregar_administrador_modelo($dataAD);
							//comprobando si se pudo insertar los datos en el admin tabla
							if ($guardarAdmin->rowCount()>=1) {

									$alerta=[
											"Alerta"=>"limpiar",
											"Titulo"=>"Admin registrado",
											"Texto"=>"Exito al registrar administrador",
											"Tipo"=>"success"
										];

									}else{
										mainModel::eliminar_cuenta($codigo);
										$alerta=[
											"Alerta"=>"simple",
											"Titulo"=>"Algo salió mal",
											"Texto"=>"No se pudo registrar el administrador. ¡Ups!1",
											"Tipo"=>"error"
									];
								}
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
		
			// verificar contraseñas coinciden con swett alert de mainmodel
			
			return mainModel::sweet_alert($alerta);
		}
	
}
		//function para paginar
		public function paginador_administrador_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){
        	
        	//evitar inyeccion SQL mediante la url
        	$pagina=mainModel::limpiar_cadena($pagina);
        	$registros=mainModel::limpiar_cadena($registros);
        	$privilegio=mainModel::limpiar_cadena($privilegio);
        	$codigo=mainModel::limpiar_cadena($codigo);
        	$busqueda=mainModel::limpiar_cadena($busqueda);

        	//esta no lo limpiamos, que se crea dentro de la funcion que permite retornar la tabla
        	$tabla="";
        	//comprob0amos si viene definida la variable $pagina y es mayor que 0, osea, si es un nùmero.
        	//para tomar enteros, si pone en la url decimales
        	$pagina=(isset($pagina) && $pagina>0) ? (int)$pagina:1 ;
        	//inicio-> desde donde va empezar a contar los registros en la bd
        	$inicio=($pagina>0) ? (($pagina*$registros)-$registros): 0;

        	if (isset($busqueda) && $busqueda!="") {
        		$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM admin WHERE ((CuentaCodigo!='$codigo'AND id!='1') AND (AdminNombre LIKE '%$busqueda%' OR AdminApellido LIKE '%$busqueda%' OR AdminDNI LIKE '%$busqueda%' OR AdminTelefono LIKE '%$busqueda%' ))  ORDER BY AdminNombre ASC LIMIT $inicio, $registros 
        		";
        		$paginaurl="adminsearch";
        	}else{
        		$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM admin WHERE CuentaCodigo!='$codigo'AND id!='1' ORDER BY AdminNombre ASC LIMIT $inicio, $registros 
        		";
        		$paginaurl="adminlist";
        	}
        	$conexion =mainModel::conectar();

        	//SQL_CALC_FOUND_ROWS, permite calcular cuantos registros hay en una tabla
        	$datos =$conexion->query($consulta);
        	//array de datos de la consulta
        	$datos=$datos->fetchAll();
        	//calcular total de los registros
        	$total=$conexion->query("SELECT FOUND_ROWS()");
        	$total=(int) $total->fetchColumn();
        	//calcular total de paginas del paginador
        	$Npaginas=ceil($total/$registros);

        	$tabla.='
        				<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">DNI</th>
									<th class="text-center">Nombre</th>
									<th class="text-center">Apellidos</th>
									<th class="text-center">Telefono</th>';
									if ($privilegio<=2) {
										$tabla.='
												';
									}
									if ( $privilegio==1) {
										$tabla.='
												<th class="text-center">A. Cuenta</th>
												<th class="text-center">A. Datos</th>
												<th class="text-center">ELIMINAR</th> 
												';
									}
									
									

			$tabla.='</tr>
							</thead>
							<tbody>
					';

					//aqui codigo para mostrar los datos de la bd
					if ($total>=1 && $pagina<=$Npaginas) {
						$contador=$inicio+1;

						foreach ($datos as $rows) {
							$tabla.='
							<tr>
									<td>'.$contador.'</td>
									<td>'.$rows['AdminDNI'].'</td>
									<td>'.$rows['AdminNombre'].'</td>
									<td>'.$rows['AdminApellido'].'</td>
									<td>'.$rows['AdminTelefono'].'</td>';
									if ($privilegio<=2) {
										$tabla.='
										';
									
									}
									if ($privilegio==1	) {
										$tabla.='<td>
											<a href="'.SERVERURL.'myaccount/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
												</a>
											</td>
										<td>
											<a href="'.SERVERURL.'mydata/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
											</a>
										</td>
												<td>
													<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
														<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'" >
														<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'" >
														<button type="submit" class="btn btn-danger btn-raised btn-xs">
														<i class="zmdi zmdi-delete"></i>
														</button>
														<div class="RespuestaAjax" ></div>
													</form>
												</td>
										';
									}
									
								$tabla.='
										</tr>
						';
						$contador++;
						}
					}else{
						if ($total>=1) {
							$tabla.='
							<tr>
								<td colspan="5">
									<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised ">
										Haga click aquí para recargar listado
									</a>
								</td>
							</tr>
						';
						}else{
							$tabla.='
							<tr>
								<td colspan="5">NO HAY REGISTROS BBCITO EN EL SISTEMA </td>
							</tr>
						';
						}
						
					}
			$tabla.='</tbody> </table> </div>';
			// para q no aparezca los numeros de paginador
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

		public function eliminar_administrador_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			//si el administrador que quiere eliminar, tiene el privilegio o permiso para eliminar
			if ($adminPrivilegio<=2) {
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