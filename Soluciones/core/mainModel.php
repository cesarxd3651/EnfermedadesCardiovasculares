<?php
	if ($peticionAjax) {
		require_once "../core/configApp.php";
	}else{
		require_once "./core/configApp.php";
	}
	class mainModel{

		protected function conectar(){

			$enlace= new PDO (SGBD,USER,PASS);
			return $enlace;
		}

		protected function ejecutar_consulta_simple($consulta){
			//instanciando conectar () con self
			$respuesta=self::conectar()->prepare($consulta);
			$respuesta->execute();
			return $respuesta;
		}
		protected function agregar_cuenta($datos){
			$sql=self::conectar()->prepare("INSERT INTO cuenta(CuentaCodigo,CuentaPrivilegio,CuentaUsuario,CuentaClave,CuentaEmail,CuentaEstado,CuentaTipo,CuentaGenero,CuentaFoto) VALUES (:Codigo,:Privilegio,:Usuario,:Clave,:Email,:Estado,:Tipo,:Genero,:Foto)");
			// En values el marcador ":" permite marcar una parte de la sentencia
			//sql para despues reemplazar por un valor

			//sustituir los marcadores
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Privilegio",$datos['Privilegio']);
			$sql->bindParam(":Usuario",$datos['Usuario']);		
			$sql->bindParam(":Clave",$datos['Clave']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Genero",$datos['Genero']);
			$sql->bindParam(":Foto",$datos['Foto']);
			$sql->execute();
			return $sql;
		}

		protected function eliminar_cuenta($codigo){
			$sql=self::conectar()->prepare("DELETE FROM  cuenta WHERE CuentaCodigo=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}


		protected function datos_cuenta($codigo,$tipo){
			$query=self::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCodigo=:Codigo AND CuentaTipo=:Tipo");
			$query->bindParam(":Codigo",$codigo);
			$query->bindParam(":Tipo",$tipo);
			$query->execute();
			return $query;

		}
		//modelo update cuenta
		protected function actualizar_cuenta($datos){
			$query=self::conectar()->prepare("UPDATE cuenta SET CuentaPrivilegio=:Privilegio,CuentaUsuario=:Usuario,CuentaClave=:Clave,CuentaEmail=:Email,CuentaEstado=:Estado,CuentaGenero=:Genero,CuentaFoto=:Foto WHERE CuentaCodigo=:Codigo");
			
			$query->bindParam(":Privilegio",$datos['CuentaPrivilegio']);
			$query->bindParam(":Usuario",$datos['CuentaUsuario']);		
			$query->bindParam(":Clave",$datos['CuentaClave']);
			$query->bindParam(":Email",$datos['CuentaEmail']);
			$query->bindParam(":Estado",$datos['CuentaEstado']);
			$query->bindParam(":Genero",$datos['CuentaGenero']);
			$query->bindParam(":Foto",$datos['CuentaFoto']);
			$query->bindParam(":Codigo",$datos['CuentaCodigo']);
			$query->execute();
			return $query;
		}

		// funcion para guardar bitacora, para registrar el inicio de sesion y el cierre de sesion
		protected function guardar_bitacora($datos){
			$sql=self::conectar()->prepare("INSERT INTO bitacora (BitacoraCodigo,BitacoraFecha,BitacoraHoraInicio,BitacoraHoraFinal,BitacoraTipo,BitacoraYear,CuentaCodigo ) VALUES(:Codigo,:Fecha,:HoraInicio,:HoraFinal,:Tipo,:Year,:Cuenta)");
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Fecha",$datos['Fecha']);
			$sql->bindParam(":HoraInicio",$datos['HoraInicio']);
			$sql->bindParam(":HoraFinal",$datos['HoraFinal']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Year",$datos['Year']);
			$sql->bindParam(":Cuenta",$datos['Cuenta']);
			$sql->execute();
			return $sql;
		}

		protected function actualizar_bitacora($codigo,$hora){
			$sql=self::conectar()->prepare("UPDATE bitacora SET BitacoraHoraFinal=:Hora WHERE BitacoraCodigo=:Codigo");
			$sql->bindParam(":Hora",$hora);
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}
		protected function eliminar_bitacora($codigo){
			$sql=self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256',SECRET_KEY);
			$iv=substr(hash('sha256',SECRET_IV),0,16);
			$output=openssl_encrypt($string, METHOD, $key,0,$iv);
			$output=base64_encode($output);
			return $output;
		}

		protected function decryption($string){
			$key=hash('sha256',SECRET_KEY);
			$iv=substr(hash('sha256',SECRET_IV),0,16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key,0,$iv);
			return $output;
		}

		//Generar codigos aleatorios para nuestras cuentas para poder 
		//identificar
		protected function generar_codigo_aleatorio($letra, $longitud, $num){
			for ($i=1; $i<=$longitud ; $i++) {		
				$numero= rand (0,9);
				$letra.=$numero;
			}
			return $letra.$num;
		}

		//limpiar cadenas de texto, de lass entradas
		protected function limpiar_cadena($cadena){
			//trim -> elimina los espacios en blanco ya sea al inicio 
			//o al final de cada entrada
			$cadena=trim($cadena);
			//stripslashes , quita las barras invertidas \
			$cadena=stripslashes($cadena);
			//stre_ireplace, toma una busqueda y reemplazar
			$cadena=str_ireplace("<script>", "", $cadena);
			$cadena=str_ireplace("</script>", "", $cadena);
			$cadena=str_ireplace("<script src>", "", $cadena);
			$cadena=str_ireplace("<script type=>", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE  FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			return $cadena;
		}

		//funcion para mostrar alertas
		protected function sweet_alert($datos){
			//valor 'alerta' para saber q tipo de alerta mostrar
			if ($datos['Alerta']=="simple") {
				$alerta="
				<script>
				swal(
				'".$datos['Titulo']."' ,
				'".$datos['Texto']."' ,
				'".$datos['Tipo']."' 
				);
				</script>
				";
				// para recargar la pagina
			}elseif($datos['Alerta']=="recargar"){
				$alerta="
					<script>
						swal({
						title: '".$datos['Titulo']."',
						text: '".$datos['Texto']."',
						type:'".$datos['Tipo']."',
						confirmButtonText:'Aceptar'
						}).then(function(){
							location.reload();
							});
				</script>
				";
			}
			//CONDICION PARA LIMPIAR
			elseif ($datos['Alerta']=="limpiar") {
				$alerta="
					<script>
						swal({
						title: '".$datos['Titulo']."',
						text: '".$datos['Texto']."',
						type:'".$datos['Tipo']."',
						confirmButtonText: 'Aceptar'
						}).then(function(){
							$('.FormularioAjax')[0].reset();
							});
				</script>
				";
			}
			return $alerta;
		}
	}