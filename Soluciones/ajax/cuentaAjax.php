<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	//isset es para ver si viene definido
	if (isset($_POST['CodigoCuenta-up'])) {
		
		require_once "../controladores/cuentaControlador.php";
		$cuenta = new cuentaControlador();

		// si vienen llenos, si se puede actualizar, validamos los input requeridos del view correspondiente
		if (isset($_POST['CodigoCuenta-up']) && isset($_POST['tipoCuenta-up']) && isset($_POST['usuario-up'])){
			
			echo $cuenta->actualizar_cuenta_controlador();
		}
	}else{

		session_start(['name'=>'SBM']);
		session_destroy();

		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}