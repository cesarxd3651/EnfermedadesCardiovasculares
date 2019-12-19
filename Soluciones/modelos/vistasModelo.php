<?php
	class vistasModelo{
		protected function obtener_vistas_modelo($vistas){
			$listaBlanca=["adminlist","adminsearch", "admin","catalog","categorylist","category","clientlist","clientsearch","client","companylist","company","companylist","home","login","myaccount","mydata","providerlist","provider","search","paciente","grafic","enfermedad","diagnostico","pacientelist" ,"pacientesearch", "enfermedadlist","email","bookinfo","cuestionario","vistaprueba","analisis","insertpaciente","modelo","vista","analisislist","detalleanalisis","cita","citalist","pruebacita"];
			if (in_array($vistas, $listaBlanca)) {
				if (is_file("./vistas/contenidos/".$vistas."-view.php" )) {
					$contenido="./vistas/contenidos/".$vistas."-view.php" ;
				}else{
					$contenido="login";
				}
			}elseif ($vistas=="login") {
				$contenido="login";
			}elseif ($vistas=="index") {
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}