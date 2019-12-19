<?php  
if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	/**
	 * 
	 */
	class cuentaControlador extends mainModel{
		public function datos_cuenta_controlador($codigo,$tipo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			//"Admin" o "cliente" porque la funcion se usa dese la view myaccount
			//si el valor que viene en la url es admin, entonces $tipo trae el valor -> "Administrador" y si no "Cliente"
			if ($tipo=="admin") {
				$tipo="Administrador";
			}else{
				$tipo="Cliente";
			}
			return mainModel::datos_cuenta($codigo,$tipo);

		}

		public function actualizar_cuenta_controlador(){
			$CuentaCodigo=mainModel::decryption($_POST['CodigoCuenta-up']);
			$CuentaTipo=mainModel::decryption($_POST['tipoCuenta-up']);

			//comprobar q el nombre de usuario y contraseña son validos en el sistema para poder actualziar todo los datos de la cuenta
			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$CuentaCodigo'");

			// DatosCuenta tiene todo los datos de la cuenta q se quiere actualizar
			$DatosCuenta=$query1->fetch();

			//almacenar en variables recuperar lo q viene de los input del formulario del view
			$user=mainModel::limpiar_cadena($_POST['user-log']);
			$password=mainModel::limpiar_cadena($_POST['password-log']);
			//encriptando porque en la bd recibe encryptado
			$password=mainModel::encryption($password);

			//tanto usuario como contraseña viene definido.. el else es al contrario
			if ($user!="" && $password!="") {
				//comprobar que el usuario q quiere actualizar, comprobamos q no es el propietario de la cuenta, es otro admin con priviligeio 1, para hacerlo.

					if (isset($_POST['privilegio-up'])) {
					$login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password'");
					}else{
					// si no, la actulizcion es de su propia cuenta
					$login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password' AND CuentaCodigo='$CuentaCodigo'");

					}
				//comprobar q el usuario este registrado y los datos ingresados son correctos

				if ($login->rowCount()==0) {
					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio Error Inesperado",
							"Texto"=>"Nombre de usuario y clave, ingresados , no son correctos :( porque no coinciden con los datos de su cuenta",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}

				}else{
						$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio Error Inesperado",
								"Texto"=>"Para actualizar los datos de la cuenta, se debe ingresar tus credenciales como nombre de usuario y clave. Por favor Ingrese dichos datos pe mascota",
								"Tipo"=>"error"
						];
					return mainModel::sweet_alert($alerta);
					exit();
			}

			//verificando usuario
			$CuentaUsuario=mainModel::limpiar_cadena($_POST['usuario-up']);
			//para verificar que el nombre de usuario q quiere actualizar, no sea el mismo que uno existente
			if ($CuentaUsuario!=$DatosCuenta['CuentaUsuario']) {
				
				$query2=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$CuentaUsuario'");
				//si es afectado una fila, si es cierto, q ese nombre de usuario ya existe
				if ($query2->rowCount()>=1) {
					
					$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio Error Inesperado",
							"Texto"=>"El nombre de usuario, que intenta actualizar ya existe en el sistema",
							"Tipo"=>"error"
						];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}
			//	validando email
			//verificando usuario del form input
			$CuentaEmail=mainModel::limpiar_cadena($_POST['email-up']);
			if ($CuentaEmail!=$DatosCuenta['CuentaEmail']) {
				
				$query3=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$CuentaEmail'");
				//si es afectado una fila, si es cierto, q ese nombre de email ya existe
				if ($query3->rowCount()>=1) {
					
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio Error Inesperado",
						"Texto"=>"El email, que intenta actualizar ya existe en el sistema",
						"Tipo"=>"error"
						];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$CuentaGenero=mainModel::limpiar_cadena($_POST['optionsGenero-up']);
			//si viene definido el estado de la cuenta desde el formulario
			if (isset($_POST['optionsEstado-up'])) {
				
				$CuentaEstado=mainModel::limpiar_cadena($_POST['optionsEstado-up']);
			}else{
				//si no viene definido entonces simplemente mantenemos en la bd y lo almacenamos en la misma variable
				$CuentaEstado=$DatosCuenta['CuentaEstado'];
			}

			if ($CuentaTipo=="admin") {

				if (isset($_POST['optionsPrivilegio-up'])) {
					
					//almacenar el valor q viene desde el formulario
					$CuentaPrivilegio=mainModel::decryption($_POST['optionsPrivilegio-up']);

				}else{
					$CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
				}
				if ($CuentaGenero=="Masculino") {
					
					$CuentaFoto="Male3Avatar.png";
				}else{
					$CuentaFoto="Female3Avatar.png";
				}
			}else{
				$CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
				if ($CuentaGenero=="Masculino") {
					
					$CuentaFoto="Male2Avatar.png";
				}else{
					$CuentaFoto="Female2Avatar.png";
				}   
			}

			//verificar cambio clave

			$passwordN1=mainModel::limpiar_cadena($_POST['newPassword1-up']);
			$passwordN2=mainModel::limpiar_cadena($_POST['newPassword2-up']);

			if ($passwordN1!="" || $passwordN2!="") {
				
				if ($passwordN1==$passwordN2) {
					
					$CuentaClave=mainModel::encryption($passwordN2);

				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio Error Inesperado",
							"Texto"=>"Las nuevas contraseñas no coinciden, por favor verifique ambas contraseñas y luego intente",
							"Tipo"=>"error"
							];
						return mainModel::sweet_alert($alerta);
						exit(); 

					}
			}else{

				$CuentaClave=$DatosCuenta['CuentaClave'];
			}

			//enviando datos al modelo, reemplazando lso indices de la funcion actualizar cuenta
			$datosUpdate=[
				"CuentaPrivilegio"=>$CuentaPrivilegio,
				"CuentaCodigo"=>$CuentaCodigo,
				"CuentaUsuario"=>$CuentaUsuario,
				"CuentaClave"=>$CuentaClave,
				"CuentaEmail"=>$CuentaEmail,
				"CuentaEstado"=>$CuentaEstado,
				"CuentaGenero"=>$CuentaGenero,
				"CuentaFoto"=>$CuentaFoto

			];

			if (mainModel::actualizar_cuenta($datosUpdate)) {
				
				// CUANDO LA CUENTA NO ES MIA, ENTRA AL IF.
				if (!isset($_POST['privilegio-up'])) {
					
					session_start(['name'=>'SBM']);
					// EN ESE CASO MODIFICAMOS EL NOMBRE DEL USUARIO Y LA FOTO QUE SALE EN EL NAVLATERAL, DEPENDIENDO DE QUIEN SEA EL QUE HAYA INGRESADO, Y TAMBIEN SI SE ACTUALIZA LA CUENTA, TAMBIEN SE ACTUALIZA EN EL NAVLATERAL

					$_SESSION['usuario_sbm']=$CuentaUsuario;
					$_SESSION['foto_sbm']=$CuentaFoto;
				}

				$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"EXCELENTE",
							"Texto"=>"OJALA SALGO ESTO, LOS DATOS HA SIDO ACTUALIZADO",
							"Tipo"=>"success"
							];
						


			}else{
				$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio Error Inesperado",
							"Texto"=>"NO C PUDO ACTUALIZAR LA CUENTA TMR :C",
							"Tipo"=>"error"
							];
						
						

			}
			return mainModel::sweet_alert($alerta);
			
		}
		
	}	