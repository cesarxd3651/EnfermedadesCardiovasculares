<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido
	if (isset($_POST['dni-reg'])) {
		require_once "../controladores/vistapruebaControlador.php";
		$insE = new vistapruebaControlador();

		if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg'])) {
			echo $insE->agregar_empresa_controlador();
			}
		
	}else{

		session_start(['name'=>'SBM']);
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}