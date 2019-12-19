<?php
if ($peticionAjax) {
		require_once "../modelos/loginModelo.php";
	}else{
		require_once "./modelos/loginModelo.php";
	}

	/**
	 * 
	 */
	class loginControlador extends loginModelo
	{
		
		public function iniciar_sesion_controlador(){

			$usuario=mainModel::limpiar_cadena($_POST['usuario']);
			$clave=mainModel::limpiar_cadena($_POST['clave']);

			$clave=mainModel::encryption($clave);

			//en el array datos login, se ponen los indices que utilizamos en comillas en el loginmodelo , y dicho indice lleva el valor que recuperamos del formulario . $usuario, $clave , lo de arriba
			$datosLogin=[
						"Usuario"=>$usuario,
						"Clave"=>$clave
			];

			//Guardar el valor de loginModelo e enviamos $datosLogin
			//
			$datosCuenta=loginModelo::iniciar_sesion_modelo($datosLogin);

			//para contar cuantas filas ah sido seleccionada, si nos trae un valor, igual a 1, es porque si existe un registro con los datos enviados
			if ($datosCuenta->rowCount()==1) {
				// fetch para poder hacer un array de los datos q hemos seleccionado de la bd
				$row=$datosCuenta->fetch();

				$fechaActual=date("Y-m-d");
				$yearActual=date("Y");
				$horaActual=date("h:i:s a");

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT id FROM bitacora");
				//ALMACENAR LOS REGISTROS CORRELATIVO
				$numero=($consulta1->rowCount())+1;
				$codigoB=mainModel::generar_codigo_aleatorio("CB", 7, $numero);

				//aray de datos de tabla bitacora
				//sustituimos los indices lo que esta dentro de los corchete [], no lo q esta 
				// a lado de los ":". y lo sustituimos por la variable de arriba
				$datosBitacora=[
								"Codigo"=>$codigoB,
								"Fecha"=>$fechaActual,
								"HoraInicio"=>$horaActual,
								"HoraFinal"=>"sin registro",
								//para obtener la tabla cuenta, solo el campo cuenta tipo, lo que
								//ya está registrado en la BD.
								"Tipo"=>$row['CuentaTipo'],
								"Year"=>$yearActual,
								"Cuenta"=>$row['CuentaCodigo']
								];

								$insertarBitacora=mainModel::guardar_bitacora($datosBitacora);

							if ($insertarBitacora->rowCount()>=1) {
							//$row trae todo los datos de la cuenta q acaba iniciar sesion
							if ($row['CuentaTipo']=="Administrador") {
								# code...
								$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM admin WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
							}else{
								$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
							}
							//comprobando si la consulta query1, ha seleccionado un registro en la bd, todo esta bien
							if ($query1->rowCount()==1) {
								# code...
								session_start(['name'=>'SBM']);
									$UserData=$query1->fetch();

									if ($row['CuentaTipo']=="Administrador") {
									// para q aparezca en ves del nombre de usuaruio de la tabla cuenta, si no el nombre de la tablaAdmin, datos personales
										$_SESSION['nombre_sbm']=$UserData['AdminNombre'];
										$_SESSION['apellido_sbm']=$UserData['AdminApellido'];
										$_SESSION['nombre_completo_sbm']=$_SESSION['nombre_sbm']." ".$_SESSION['apellido_sbm'];
									}else{
										$_SESSION['nombre_sbm']=$UserData['ClienteNombre'];
										$_SESSION['apellido_sbm']=$UserData['ClienteApellido'];
										$_SESSION['nombre_completo_sbm']=$_SESSION['nombre_sbm']." ".$_SESSION['apellido_sbm'];
									}
									// para obtener nombre usuario q ha iniciado session. cada variable va tomar el valor de los campos en los de la variable row de la bd de Cuenta.}

									$_SESSION['usuario_sbm']=$row['CuentaUsuario'];
									$_SESSION['tipo_sbm']=$row['CuentaTipo'];
									$_SESSION['privilegio_sbm']=$row['CuentaPrivilegio'];
									$_SESSION['foto_sbm']=$row['CuentaFoto'];

									//crear token
									$_SESSION['token_sbm']=md5(uniqid(mt_rand(),true));
									$_SESSION['codigo_cuenta_sbm']=$row['CuentaCodigo'];
									$_SESSION['codigo_bitacora_sbm']=$codigoB;

									// REDIRECCIONAR AL USUARIO, SEGUN EL TIPO DE CUENTA
									if ($row['CuentaTipo']=="Administrador") {
										$url=SERVERURL."home/";
									}else{
										$url=SERVERURL."catalog/";
									}
									return $urlLocation='<script> window.location="'.$url.'" </script>' ;

							}else{
								$alerta=
										["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"	No hemos podido iniciar la session, por problemas tecnicos uu",
										"Tipo"=>"error"
										];
								return mainModel::sweet_alert($alerta);
							}
							}else{
								$alerta=
										["Alerta"=>"simple",
										"Titulo"=>"Algo salió mal",
										"Texto"=>"	No hemos podido iniciar la session, por problemas tecnicos, intente nuevamente porfis oks",
										"Tipo"=>"error"
										];
								return mainModel::sweet_alert($alerta);
							}
				
			} else {
				$alerta=
						["Alerta"=>"simple",
						"Titulo"=>"Algo salió mal",
						"Texto"=>"	el nombre de usuario y contraseña, no son correctos o cuenta deshabilitada",
						"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
			}
		}

		public function cerrar_sesion_controlador(){
			session_start(['name'=>'SBM']);
			$token=mainModel::decryption($_GET['Token']);
			$hora=date("h:i:s a");
			//array para mandar a loginModelo en cerrar sesion modelo()
			$datos=[
					"Usuario"=>$_SESSION['usuario_sbm'],
					"Token_S"=>$_SESSION['token_sbm'],
					"Token"=>$token,
					"Codigo"=>$_SESSION['codigo_bitacora_sbm'],
					"Hora"=>$hora
			];
			return loginModelo::cerrar_sesion_modelo($datos);
		}
		public function forzar_cierre_sesion_controlador(){
			session_start(['name'=>'SBM']);
			session_destroy();
			//return header("Location: ".SERVERURL." ");
			$redirect='<script> window.location.href="'.SERVERURL.'index/" </script>';
			return $redirect;
		}
		public function redireccionar_usuario_controlador($tipo){
			if ($tipo=="Administrador") {
				$redirect='<script> window.location.href="'.SERVERURL.'home/" </script>';
			}else{
				$redirect='<script> window.location.href="'.SERVERURL.'catalog/" </script>';
			}
			return $redirect;
		}
	}