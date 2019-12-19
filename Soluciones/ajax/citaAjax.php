<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido /// -> [codigo del] de la function paginador paciente, en 
	//if ($privilegio==1) { $tabla.=
	if (isset($_POST['codigopaciente']) || isset($_POST['codigodoctor']) || isset($_POST['fecha']) || isset($_POST['codigocita'])) {
		require_once "../controladores/citaControlador.php";
		$inscita = new citaControlador();

		//para agregar
		if (isset($_POST['codigopaciente']) || isset($_POST['codigodoctor']) || isset($_POST['fecha'])) {
			echo $inscita->agregar_cita_controlador();
		}
		//para eliminar

		if (isset($_POST['codigocita']) ) {
				echo $inscita->eliminar_cita_controlador();
			}

		//para update

		if (isset($_POST['CodigoCita-up']) && isset($_POST['nombre-up'])){
			
			echo $inscita->actualizar_cita_controlador();
		}
		}else{
		session_start(['name'=>'SBM']);
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}