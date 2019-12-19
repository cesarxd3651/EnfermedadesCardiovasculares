<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}
	class bitacoraControlador extends mainModel{
		// listar los ultimos usuarios q han iniciado sesión

		public function listado_bitacora_controlador($registros){
			// parametro que vamos a pasar al controlador
			$registros=mainModel::limpiar_cadena($registros);

			// datos de la bitacora
			$datos=mainModel::ejecutar_consulta_simple("SELECT * FROM bitacora ORDER BY id DESC LIMIT $registros");
			$conteo=1;
			//ciclo para ir mostrando los datos en la view bitacora
			while ( $rows=$datos->fetch()) {
				
				$datosC=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");

				// hacer array de datos de la consulta
				$datosC=$datosC->fetch();

				//datos segun usuario admin o cliente
				if ($rows['BitacoraTipo']=="Administrador") {
				//datos usuario admin
					$datosU=mainModel::ejecutar_consulta_simple("SELECT AdminNombre, AdminApellido FROM admin WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");

					$datosU=$datosU->fetch();
					//capturando los datos
					$NombreCompleto=$datosU['AdminNombre']." ".$datosU['AdminApellido'];

				}else{
					//datos usuario paciente
					$datosU=mainModel::ejecutar_consulta_simple("SELECT ClienteNombre, ClienteApellido FROM cliente WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");

					$datosU=$datosU->fetch();
					//capturando los datos
					$NombreCompleto=$datosU['ClienteNombre']." ".$datosU['ClienteApellido'];

				}
				echo '
						<div class="cd-timeline-block">
		                    <div class="cd-timeline-img">
		                        <img src="'.SERVERURL.'vistas/assets/avatars/'.$datosC['CuentaFoto'].'" alt="user-picture">
		                    </div>
		                    <div class="cd-timeline-content">
		                        <h4 class="text-center text-titles">'.$conteo.' - '.$NombreCompleto.' :  ('.$datosC['CuentaTipo'].')</h4>
		                        <p class="text-center">
		                            <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Hora de Entrada: <em>'.$rows['BitacoraHoraInicio'].'</em> &nbsp;&nbsp;&nbsp; 
		                            <i class="zmdi zmdi-time zmdi-hc-fw"></i> Hora de salida: <em>'.$rows['BitacoraHoraFinal'].'</em>
		                        </p>
		                        <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> '.date("d/m/Y", strtotime($rows['BitacoraFecha'])).'</span>
		                    </div>
		                </div> 

				';
				$conteo++;
			}
		}
	}