<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido
	if (isset($_GET['Token'])) {
		require_once "../controladores/loginControlador.php";
		$logout= new loginControlador();
		echo $logout->cerrar_sesion_controlador();
	}else{
		session_start(['name'=>'SBM']);
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'index/" </script>';
	}