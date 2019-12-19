<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido /// -> [codigo del] de la function paginador paciente, en 
	//if ($privilegio==1) { $tabla.=
	if (isset($_POST['dni-reg']) || isset($_POST['codigo-del']) || isset($_POST['cuenta-up'])) {
		require_once "../controladores/pacienteControlador.php";
		$insPac = new pacienteControlador();

		//para agregar
		if (isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg'])) {
			echo $insPac->agregar_paciente_controlador();
		}
		//para eliminar
		if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insPac->eliminar_paciente_controlador();
		}
		// para actualizar
		if (isset($_POST['cuenta-up']) && isset($_POST['dni-up'])) {
			echo $insPac->actualizar_paciente_controlador();
		}
	}else{
		session_start(['name'=>'SBM']);
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}